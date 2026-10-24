import { LineCapStyle, PDFString, rgb } from 'pdf-lib';
import { embedDocumentFonts } from './pdfFonts.js';
import { hexToRgb01 } from './pdfOverlay.js';
import { removeRunsFromPage } from './pdfContentEdit.js';
import { coverRect, fontForEdit } from './pdfTextEdit.js';
import { pointsToPdf, undoLast, strokeBoundingBox, normalizeLinkUrl, arrowHeadLines, markupLineY } from './pdfEditShapes.js';

export { pointsToPdf, undoLast, strokeBoundingBox, normalizeLinkUrl, arrowHeadLines, markupLineY };

/**
 * Draws every added element onto `doc` with pdf-lib and returns the finished PDF as a Blob.
 * Elements are plain new content laid on top of the page - this never touches or reflows any
 * existing text, so it can add to a PDF but not edit text that was already there (a whiteout box
 * covers it instead). `elements`: [{ type: 'text'|'image'|'highlight'|'stroke'|'whiteout'|'shape'|
 * 'markup'|'link'|'textedit', page, ...PDF-space fields }]. A 'textedit' replaces a run of the PDF's
 * own text: { run, text, size, color, background } (see pdfTextEdit.js).
 */
export async function buildEditedPdf(doc, elements) {
    let fonts = null;
    const editFonts = new Map();
    // Edits of existing text go first, so anything added on top of the page stays on top of them.
    const ordered = [...elements.filter((el) => el.type === 'textedit'), ...elements.filter((el) => el.type !== 'textedit')];
    // Take the edited runs' original text out of each page's content, so it is really gone. Runs that
    // can't be removed safely (text inside a form object, unusual fonts) are covered instead.
    const removed = new Set();
    for (const pageIndex of new Set(ordered.filter((el) => el.type === 'textedit').map((el) => el.page))) {
        const runs = ordered.filter((el) => el.type === 'textedit' && el.page === pageIndex).map((el) => el.run);
        try {
            for (const id of removeRunsFromPage(doc, pageIndex, runs)) removed.add(`${pageIndex}:${id}`);
        } catch {
            // Unreadable content stream: every run on this page is covered instead.
        }
    }
    for (const el of ordered) {
        const page = doc.getPage(el.page);
        const { r, g, b } = hexToRgb01(el.color);
        if (el.type === 'textedit') {
            if (!removed.has(`${el.page}:${el.run.id}`)) {
                const bg = hexToRgb01(el.background);
                page.drawRectangle({ ...coverRect(el.run, el.run.ascent, el.run.descent), color: rgb(bg.r, bg.g, bg.b) });
            }
            if (el.text.trim()) {
                const font = await fontForEdit(doc, el.run, el.text, editFonts);
                page.drawText(el.text, { x: el.run.x, y: el.run.y, size: el.size, font, color: rgb(r, g, b) });
            }
        } else if (el.type === 'whiteout') {
            page.drawRectangle({ ...el.rectPdf, color: rgb(1, 1, 1) });
        } else if (el.type === 'shape' && (el.shape === 'rect' || el.shape === 'ellipse')) {
            const { x, y, width, height } = el.rectPdf;
            const style = { borderColor: rgb(r, g, b), borderWidth: el.thickness, color: el.fill ? rgb(r, g, b) : undefined };
            if (el.shape === 'rect') page.drawRectangle({ x, y, width, height, ...style });
            else page.drawEllipse({ x: x + width / 2, y: y + height / 2, xScale: width / 2, yScale: height / 2, ...style });
        } else if (el.type === 'shape') {
            const [start, end] = el.points;
            const lines = [{ start, end }, ...(el.shape === 'arrow' ? arrowHeadLines(start, end, Math.max(8, el.thickness * 4)) : [])];
            for (const line of lines) page.drawLine({ ...line, thickness: el.thickness, color: rgb(r, g, b), lineCap: LineCapStyle.Round });
        } else if (el.type === 'markup') {
            const { x, y, width, height } = el.rectPdf;
            const lineY = markupLineY(el.kind, y, height);
            page.drawLine({ start: { x, y: lineY }, end: { x: x + width, y: lineY }, thickness: Math.max(0.8, height * 0.07), color: rgb(r, g, b) });
        } else if (el.type === 'link') {
            const { x, y, width, height } = el.rectPdf;
            const annot = doc.context.register(
                doc.context.obj({
                    Type: 'Annot',
                    Subtype: 'Link',
                    Rect: [x, y, x + width, y + height],
                    Border: [0, 0, 0],
                    A: { Type: 'Action', S: 'URI', URI: PDFString.of(el.url) },
                })
            );
            page.node.addAnnot(annot);
        } else if (el.type === 'text') {
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
