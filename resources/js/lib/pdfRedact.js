import { PDFDocument } from 'pdf-lib';
import { pdfRectToCanvasRect } from './pdfOverlay.js';
import { canvasToBlob, renderPageToCanvas } from './pdfRender.js';

/** CSS/canvas pixels per PDF point used when rasterising a redacted page (about 216 DPI). */
export const REDACT_RASTER_SCALE = 3;

/** Pure: the sorted, de-duplicated list of 0-based page indexes that have at least one box. */
export function pagesWithBoxes(boxes) {
    return [...new Set(boxes.map((b) => b.page))].sort((a, b) => a - b);
}

/**
 * True redaction: every page with at least one box is rendered to a raster image with the boxes
 * burned in black, and that image replaces the page entirely - the original text and vector
 * content for that page are never copied into the output, so they cannot be extracted or
 * selected afterwards. Pages with no box are copied unchanged (still real, selectable text).
 */
export async function buildRedactedPdf(doc, renderDoc, boxes, { rasterScale = REDACT_RASTER_SCALE } = {}) {
    const out = await PDFDocument.create();
    const pageCount = doc.getPageCount();
    for (let i = 0; i < pageCount; i++) {
        const pageBoxes = boxes.filter((b) => b.page === i);
        if (pageBoxes.length === 0) {
            const [copied] = await out.copyPages(doc, [i]);
            out.addPage(copied);
            continue;
        }

        const { width: pageWidthPt, height: pageHeightPt } = doc.getPage(i).getSize();
        const canvas = await renderPageToCanvas(renderDoc, i + 1, { scale: rasterScale, background: '#ffffff' });
        const ctx = canvas.getContext('2d');
        ctx.fillStyle = '#000000';
        for (const box of pageBoxes) {
            const rect = pdfRectToCanvasRect(box.rectPdf, rasterScale, pageHeightPt);
            ctx.fillRect(rect.x, rect.y, rect.width, rect.height);
        }
        const blob = await canvasToBlob(canvas, 'image/png');
        const bytes = new Uint8Array(await blob.arrayBuffer());
        const image = await out.embedPng(bytes);
        const page = out.addPage([pageWidthPt, pageHeightPt]);
        page.drawImage(image, { x: 0, y: 0, width: pageWidthPt, height: pageHeightPt });
    }
    const bytes = await out.save();
    return new Blob([bytes], { type: 'application/pdf' });
}
