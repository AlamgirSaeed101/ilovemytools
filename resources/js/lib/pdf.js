import { t } from './i18n.js';
// PDF helpers built on pdf-lib (runs fully in the browser).
import { degrees, PDFDocument } from 'pdf-lib';
import { drawScaled, imageTypeOf, loadImage } from './image.js';

export const MAX_PDF_BYTES = 200 * 1024 * 1024;

export const MM_TO_PT = 72 / 25.4;
export const PDF_PAGE_SIZES = {
    a4: { width: 210 * MM_TO_PT, height: 297 * MM_TO_PT },
    letter: { width: 8.5 * 72, height: 11 * 72 },
};

export function isPdf(file) {
    return file.type === 'application/pdf' || /\.pdf$/i.test(file.name);
}

export async function loadPdf(file) {
    if (file.size > MAX_PDF_BYTES) throw new Error(t('"{name}" is larger than 200 MB.', { name: file.name }));
    const bytes = await file.arrayBuffer();
    try {
        const doc = await PDFDocument.load(bytes, { updateMetadata: false });
        const pageCount = doc.getPageCount();
        if (pageCount === 0) {
            // Flagged (not matched by text) so the check still works when translated.
            const empty = new Error(t('"{name}" has no pages.', { name: file.name }));
            empty.noPages = true;
            throw empty;
        }
        return { doc, pageCount };
    } catch (e) {
        const msg = String(e?.message || e);
        if (/encrypt/i.test(msg)) {
            const err = new Error(t('"{name}" is password-protected. Remove the password first (open it with the password and save a copy), then try again.', { name: file.name }));
            err.isEncrypted = true;
            throw err;
        }
        if (e?.noPages) throw e;
        throw new Error(t('"{name}" could not be read. It may be damaged or not a real PDF.', { name: file.name }));
    }
}

/** Build a new PDF from [{ doc, indexes }] parts, in order. */
export async function buildPdf(parts) {
    const out = await PDFDocument.create();
    for (const { doc, indexes } of parts) {
        const pages = await out.copyPages(doc, indexes ?? doc.getPageIndices());
        pages.forEach((page) => out.addPage(page));
    }
    const bytes = await out.save();
    return new Blob([bytes], { type: 'application/pdf' });
}

/**
 * Pure geometry for placing one image on a PDF page (no pdf-lib, no DOM - unit testable).
 * pageSize: 'a4' | 'letter' | 'fit'. orientation: 'auto' | 'portrait' | 'landscape' (ignored when pageSize is 'fit').
 * Returns the page size and the position/size to draw the image centred with the given margin.
 */
export function computeImagePageLayout({ pageSize = 'a4', orientation = 'auto', marginMm = 10, imageWidth, imageHeight }) {
    const margin = Math.max(0, marginMm) * MM_TO_PT;
    let pageWidth;
    let pageHeight;
    if (pageSize === 'fit') {
        pageWidth = imageWidth + margin * 2;
        pageHeight = imageHeight + margin * 2;
    } else {
        const base = PDF_PAGE_SIZES[pageSize] || PDF_PAGE_SIZES.a4;
        let { width, height } = base;
        const landscape = orientation === 'landscape' || (orientation === 'auto' && imageWidth > imageHeight);
        if (landscape) [width, height] = [height, width];
        pageWidth = width;
        pageHeight = height;
    }
    const availWidth = Math.max(1, pageWidth - margin * 2);
    const availHeight = Math.max(1, pageHeight - margin * 2);
    const scale = pageSize === 'fit' ? 1 : Math.min(availWidth / imageWidth, availHeight / imageHeight);
    const drawWidth = imageWidth * scale;
    const drawHeight = imageHeight * scale;
    return {
        pageWidth,
        pageHeight,
        drawWidth,
        drawHeight,
        x: (pageWidth - drawWidth) / 2,
        y: (pageHeight - drawHeight) / 2,
    };
}

/** Embed one image file into `pdfDoc`. JPG/PNG are embedded directly; anything else (WebP) is re-encoded with canvas. */
export async function embedImageForPdf(pdfDoc, file) {
    const type = imageTypeOf(file);
    const unreadable = () => new Error(t('"{name}" could not be added. It may be damaged or not a real image.', { name: file.name }));
    if (type === 'image/jpeg' || type === 'image/png') {
        try {
            const bytes = await file.arrayBuffer();
            return type === 'image/png' ? await pdfDoc.embedPng(bytes) : await pdfDoc.embedJpg(bytes);
        } catch {
            throw unreadable();
        }
    }

    let img;
    let url;
    try {
        ({ img, url } = await loadImage(file));
    } catch {
        throw unreadable();
    }
    try {
        const canvas = drawScaled(img, img.naturalWidth, img.naturalHeight);
        const blob = await new Promise((resolve, reject) => {
            canvas.toBlob((b) => (b ? resolve(b) : reject(unreadable())), 'image/png');
        });
        return await pdfDoc.embedPng(await blob.arrayBuffer());
    } catch {
        throw unreadable();
    } finally {
        URL.revokeObjectURL(url);
    }
}

/** Normalise a rotation in degrees to 0/90/180/270, wrapping negative deltas. */
export function addRotation(base, delta) {
    return (((base + delta) % 360) + 360) % 360;
}

/** Set each page's absolute rotation (degrees, one entry per page index) and save. */
export async function buildRotatedPdf(doc, targetRotations) {
    doc.getPages().forEach((page, i) => {
        if (targetRotations[i] != null) page.setRotation(degrees(targetRotations[i]));
    });
    const bytes = await doc.save();
    return new Blob([bytes], { type: 'application/pdf' });
}

/** Build a PDF with one image per page from a list of image Files. */
export async function buildImagePdf(files, options = {}) {
    const pdfDoc = await PDFDocument.create();
    for (const file of files) {
        const image = await embedImageForPdf(pdfDoc, file);
        const layout = computeImagePageLayout({ ...options, imageWidth: image.width, imageHeight: image.height });
        const page = pdfDoc.addPage([layout.pageWidth, layout.pageHeight]);
        page.drawImage(image, { x: layout.x, y: layout.y, width: layout.drawWidth, height: layout.drawHeight });
    }
    const bytes = await pdfDoc.save();
    return new Blob([bytes], { type: 'application/pdf' });
}
