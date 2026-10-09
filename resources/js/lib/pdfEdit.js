import { rgb } from 'pdf-lib';
import { embedDocumentFonts } from './pdfFonts.js';
import { hexToRgb01 } from './pdfOverlay.js';

/** Canvas-space {x,y} points of a freehand stroke -> PDF-space points (points, bottom-left origin). */
export function pointsToPdf(points, scale, pageHeight) {
    return points.map(({ x, y }) => ({ x: x / scale, y: pageHeight - y / scale }));
}

/** Pure: removes the most recently added element (undo is just "drop the last one"). */
export function undoLast(elements) {
    return elements.slice(0, -1);
}

/** Canvas-space bounding box of a freehand stroke's points, used to place its drag handle and remove button. */
export function strokeBoundingBox(points) {
    if (points.length === 0) return { x: 0, y: 0, width: 1, height: 1 };
    const xs = points.map((p) => p.x);
    const ys = points.map((p) => p.y);
    const x = Math.min(...xs);
    const y = Math.min(...ys);
    return { x, y, width: Math.max(1, Math.max(...xs) - x), height: Math.max(1, Math.max(...ys) - y) };
}

/**
 * Draws every added element onto `doc` with pdf-lib and returns the finished PDF as a Blob.
 * Elements are plain new content laid on top of the page - this never touches or reflows any
 * existing text, so it can add to a PDF but not edit text that was already there.
 * `elements`: [{ type: 'text'|'image'|'highlight'|'stroke', page, ...PDF-space fields }].
 */
export async function buildEditedPdf(doc, elements) {
    let fonts = null;
    for (const el of elements) {
        const page = doc.getPage(el.page);
        const { r, g, b } = hexToRgb01(el.color);
        if (el.type === 'text') {
            fonts ??= await embedDocumentFonts(doc);
            page.drawText(el.text, { x: el.x, y: el.y, size: el.size, font: fonts.regular, color: rgb(r, g, b) });
        } else if (el.type === 'image') {
            const image = el.format === 'jpg' ? await doc.embedJpg(el.bytes) : await doc.embedPng(el.bytes);
            page.drawImage(image, el.rectPdf);
        } else if (el.type === 'highlight') {
            page.drawRectangle({ ...el.rectPdf, color: rgb(r, g, b), opacity: 0.4 });
        } else if (el.type === 'stroke') {
            for (let i = 1; i < el.points.length; i++) {
                page.drawLine({ start: el.points[i - 1], end: el.points[i], thickness: el.thickness, color: rgb(r, g, b) });
            }
        }
    }
    const bytes = await doc.save();
    return new Blob([bytes], { type: 'application/pdf' });
}
