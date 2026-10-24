import { degrees, PDFDocument, rgb } from 'pdf-lib';
import { embedDocumentFonts, pickFont } from './pdfFonts.js';
import { hexToRgb01 } from './pdfOverlay.js';
import { canvasToBlob, dpiToScale, loadRenderDoc, renderPageToCanvas } from './pdfRender.js';
import { watermarkPageIndexes, watermarkCenters, rotatedDrawOrigin, imageWatermarkSize } from './pdfWatermarkLayout.js';

export { watermarkPageIndexes, watermarkCenters, rotatedDrawOrigin, imageWatermarkSize };

/** The page's content stream references, in drawing order. */
export function contentStreamRefs(page) {
    return page.node.normalizedEntries().Contents.asArray();
}

/**
 * Moves the content streams added to `page` since `before` (a contentStreamRefs() snapshot) to the
 * front of its content list, keeping their order, so whatever they draw is painted first and the
 * page's own text and images sit on top of it. pdf-lib wraps each of its drawings in q/Q, so moving
 * them can't change how the original content looks.
 */
export function moveNewContentToBack(page, before) {
    const known = new Set(before);
    const contents = page.node.normalizedEntries().Contents;
    const added = contents.asArray().filter((ref) => !known.has(ref));
    for (const ref of added) contents.remove(contents.indexOf(ref));
    added.forEach((ref, i) => contents.insert(i, ref));
}

/**
 * Draws a text or image watermark onto every page in `pageIndexes` and returns the finished PDF
 * as a Blob. `content`: { kind: 'text', text, size, bold, color } | { kind: 'image', bytes, width, height }
 * (an image's `width`/`height` are already in PDF points). `layer` 'under' puts the watermark
 * behind the page's content (a background watermark); 'over' stamps it on top.
 */
export async function buildWatermarkedPdf(doc, { pageIndexes, position, opacity, rotation, margin = 36, layer = 'over', content }) {
    let font = null;
    let image = null;
    for (const pageIndex of pageIndexes) {
        const page = doc.getPage(pageIndex);
        const before = layer === 'under' ? contentStreamRefs(page) : null;
        // A fresh content stream for the watermark, so it can be moved on its own (pdf-lib otherwise
        // keeps appending to a stream it already added to this page).
        if (before) page.getContentStream(false);
        const { width: pageWidth, height: pageHeight } = page.getSize();
        if (content.kind === 'text') {
            if (!font) {
                const fonts = await embedDocumentFonts(doc);
                font = pickFont(fonts, { bold: content.bold });
            }
            const textWidth = font.widthOfTextAtSize(content.text, content.size);
            const { r, g, b } = hexToRgb01(content.color);
            for (const { cx, cy } of watermarkCenters(pageWidth, pageHeight, textWidth, content.size, position, margin)) {
                const origin = rotatedDrawOrigin(cx, cy, textWidth / 2, content.size * 0.33, rotation);
                page.drawText(content.text, { x: origin.x, y: origin.y, size: content.size, font, color: rgb(r, g, b), rotate: degrees(rotation), opacity });
            }
        } else {
            image ??= await doc.embedPng(content.bytes);
            for (const { cx, cy } of watermarkCenters(pageWidth, pageHeight, content.width, content.height, position, margin)) {
                const origin = rotatedDrawOrigin(cx, cy, content.width / 2, content.height / 2, rotation);
                page.drawImage(image, { x: origin.x, y: origin.y, width: content.width, height: content.height, rotate: degrees(rotation), opacity });
            }
        }
        if (before) moveNewContentToBack(page, before);
    }
    const bytes = await doc.save();
    return new Blob([bytes], { type: 'application/pdf' });
}

/**
 * Flattens a PDF: every page becomes one JPEG image at `dpi`, so a watermark can no longer be
 * deleted or edited (and text is no longer selectable). Page sizes stay the same. Browser only.
 */
export async function flattenPdf(bytes, { dpi = 150, quality = 0.88, onProgress } = {}) {
    const renderDoc = await loadRenderDoc(bytes);
    try {
        const out = await PDFDocument.create();
        for (let n = 1; n <= renderDoc.numPages; n++) {
            onProgress?.(n, renderDoc.numPages);
            const size = (await renderDoc.getPage(n)).getViewport({ scale: 1 });
            const canvas = await renderPageToCanvas(renderDoc, n, { scale: dpiToScale(dpi), background: '#ffffff' });
            const jpeg = await out.embedJpg(await (await canvasToBlob(canvas, 'image/jpeg', quality)).arrayBuffer());
            out.addPage([size.width, size.height]).drawImage(jpeg, { x: 0, y: 0, width: size.width, height: size.height });
            canvas.width = canvas.height = 0; // free the pixels before the next page
        }
        return new Blob([await out.save()], { type: 'application/pdf' });
    } finally {
        renderDoc.destroy();
    }
}
