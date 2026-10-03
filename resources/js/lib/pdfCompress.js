// Compress PDF: pdf-lib already restructures the file with object streams on save() (its default).
// "Recommended" additionally re-encodes embedded JPEG images at a lower quality/resolution, leaving
// text and vector content untouched (so text stays selectable). "Strong" rasterises every page to a
// JPEG at a chosen DPI, trading away selectable text for the smallest possible file.
import { PDFDocument, PDFName, PDFNumber, PDFRawStream } from 'pdf-lib';
import { canvasToBlob, dpiToScale, renderPageToCanvas } from './pdfRender.js';

export const RECOMMENDED_QUALITY = 0.6;
export const RECOMMENDED_MAX_DIMENSION = 1600;
export const STRONG_QUALITY = 0.75;
export const STRONG_DPI_OPTIONS = [72, 100, 150, 200];
export const STRONG_DEFAULT_DPI = 100;

const RECOMPRESSIBLE_COLOR_SPACES = ['DeviceRGB', 'DeviceGray'];

function nameOf(pdfName) {
    const s = pdfName?.toString();
    return s?.startsWith('/') ? s.slice(1) : s;
}

/** Pure decision, independent of pdf-lib's object model, so it is easy to unit test. */
export function isRecompressibleImageInfo({ subtype, filter, colorSpace, hasSMask }) {
    if (subtype !== 'Image') return false;
    if (filter !== 'DCTDecode') return false; // only plain JPEG streams - re-encoding anything else would need a full image decoder
    if (colorSpace && !RECOMPRESSIBLE_COLOR_SPACES.includes(colorSpace)) return false; // CMYK/Indexed/ICC JPEGs decode unreliably in a browser canvas
    if (hasSMask) return false; // keep images with a transparency mask untouched rather than risk breaking it
    return true;
}

/** True when `obj` is a JPEG image stream this tool can safely decode and re-encode. */
export function isRecompressibleImage(obj) {
    if (!(obj instanceof PDFRawStream)) return false;
    const dict = obj.dict;
    return isRecompressibleImageInfo({
        subtype: nameOf(dict.get(PDFName.of('Subtype'))),
        filter: nameOf(dict.get(PDFName.of('Filter'))),
        colorSpace: nameOf(dict.get(PDFName.of('ColorSpace'))),
        hasSMask: !!dict.get(PDFName.of('SMask')),
    });
}

/** Every recompressible image stream in a pdf-lib document's context, as `{ obj }` entries. */
export function listRecompressibleImages(context) {
    const found = [];
    for (const [, obj] of context.enumerateIndirectObjects()) {
        if (isRecompressibleImage(obj)) found.push({ obj });
    }
    return found;
}

/** Target pixel size for a downscale, keeping aspect ratio, capped at `maxDimension` on the longer side. */
export function scaledDimensions(width, height, maxDimension) {
    const longest = Math.max(width, height);
    if (!(longest > maxDimension)) return { width, height };
    const scale = maxDimension / longest;
    return { width: Math.max(1, Math.round(width * scale)), height: Math.max(1, Math.round(height * scale)) };
}

/** Re-encode every eligible embedded JPEG at a lower quality/resolution. Text and vector content are untouched. */
export async function compressPdfRecommended(bytes, { quality = RECOMMENDED_QUALITY, maxDimension = RECOMMENDED_MAX_DIMENSION } = {}) {
    const doc = await PDFDocument.load(bytes, { updateMetadata: false });
    const images = listRecompressibleImages(doc.context);
    let recompressed = 0;

    for (const { obj } of images) {
        try {
            const bitmap = await createImageBitmap(new Blob([obj.contents], { type: 'image/jpeg' }));
            const target = scaledDimensions(bitmap.width, bitmap.height, maxDimension);
            const canvas = document.createElement('canvas');
            canvas.width = target.width;
            canvas.height = target.height;
            const ctx = canvas.getContext('2d');
            ctx.imageSmoothingQuality = 'high';
            ctx.drawImage(bitmap, 0, 0, target.width, target.height);
            bitmap.close?.();
            const outBlob = await canvasToBlob(canvas, 'image/jpeg', quality);
            const newBytes = new Uint8Array(await outBlob.arrayBuffer());
            if (newBytes.length < obj.contents.length) {
                obj.contents = newBytes;
                obj.dict.set(PDFName.of('Length'), PDFNumber.of(newBytes.length));
                obj.dict.set(PDFName.of('Width'), PDFNumber.of(target.width));
                obj.dict.set(PDFName.of('Height'), PDFNumber.of(target.height));
                recompressed++;
            }
        } catch {
            // Leave this one image untouched if it turns out not to be a browser-decodable JPEG.
        }
    }

    const out = await doc.save();
    return { bytes: out, recompressed, imageCount: images.length };
}

/** Render every page to a JPEG at `dpi` and rebuild the PDF from those images. Text is no longer selectable. */
export async function compressPdfStrong(renderDoc, pageCount, { dpi = STRONG_DEFAULT_DPI, quality = STRONG_QUALITY, onProgress } = {}) {
    const out = await PDFDocument.create();
    const scale = dpiToScale(dpi);
    for (let i = 1; i <= pageCount; i++) {
        const page = await renderDoc.getPage(i);
        const pageSize = page.getViewport({ scale: 1 });
        const canvas = await renderPageToCanvas(renderDoc, i, { scale, background: '#ffffff' });
        const blob = await canvasToBlob(canvas, 'image/jpeg', quality);
        const image = await out.embedJpg(new Uint8Array(await blob.arrayBuffer()));
        const pdfPage = out.addPage([pageSize.width, pageSize.height]);
        pdfPage.drawImage(image, { x: 0, y: 0, width: pageSize.width, height: pageSize.height });
        onProgress?.(i);
    }
    return out.save();
}
