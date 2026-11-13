import { degrees, LineCapStyle, rgb } from 'pdf-lib';
import { hexToRgb01 } from './pdfOverlay.js';
import { removeRunsFromPage } from './pdfContentEdit.js';
import { coverRect, fontForEdit } from './pdfTextEdit.js';
import { layoutTextLines } from './pdfTextBlocks.js';
import { angleFromCenter, pointsToPdf, undoLast, strokeBoundingBox, normalizeLinkUrl, arrowHeadLines, markupLineY, rotatedBoxOrigin, shapeStyleOf, dashPattern } from './pdfEditShapes.js';
import { addInkAnnot, addMarkupAnnot, addNoteAnnot } from './pdfAnnotations.js';
import { addLinkAnnot, applyLinkEdits } from './pdfLinks.js';

export { angleFromCenter, pointsToPdf, undoLast, strokeBoundingBox, normalizeLinkUrl, arrowHeadLines, markupLineY, rotatedBoxOrigin };

/** A corner-anchored rect (pdf-lib x/y/width/height) rotated around its own centre by `rotationDeg` (on-screen clockwise degrees), or the rect unchanged when there is no rotation. */
function rotatedRect({ x, y, width, height }, rotationDeg) {
    if (!rotationDeg) return { x, y, width, height, rotate: undefined };
    const { x: rx, y: ry, rotateDeg } = rotatedBoxOrigin(x + width / 2, y + height / 2, width, height, rotationDeg);
    return { x: rx, y: ry, width, height, rotate: degrees(rotateDeg) };
}

/** A markup's quads (PDF space, from when it was made) moved along with the element if it was dragged since. */
function movedQuads(el) {
    if (!el.quadsBox || !el.rectPdf) return el.quads;
    const dx = el.rectPdf.x - el.quadsBox.x;
    const dy = el.rectPdf.y + el.rectPdf.height - (el.quadsBox.y + el.quadsBox.height);
    return el.quads.map((q) => q.map((v, i) => v + (i % 2 === 0 ? dx : dy)));
}

/**
 * Draws a laid-out text element ('text' or 'textedit' from pdfTextBlocks.textElementToPdf): wrapped at
 * `maxWidth`, aligned, `lineHeight` apart, and spun around its box centre when it is rotated.
 */
function drawTextElement(page, el, font, color) {
    const lines = layoutTextLines(el, (line) => font.widthOfTextAtSize(line, el.size));
    const rotation = el.rotation && el.box ? -el.rotation : 0;
    const rad = (rotation * Math.PI) / 180;
    const cx = el.box ? el.box.x + el.box.width / 2 : 0;
    const cy = el.box ? el.box.y + el.box.height / 2 : 0;
    for (const line of lines) {
        if (!line.text.trim()) continue;
        let { x, y } = line;
        if (rotation) {
            const dx = x - cx;
            const dy = y - cy;
            x = cx + dx * Math.cos(rad) - dy * Math.sin(rad);
            y = cy + dx * Math.sin(rad) + dy * Math.cos(rad);
        }
        page.drawText(line.text, { x, y, size: el.size, font, color, rotate: rotation ? degrees(rotation) : undefined });
    }
}

/**
 * Draws every added element onto `doc` with pdf-lib and returns the finished PDF as a Blob.
 * Elements are plain new content laid on top of the page - this never touches or reflows any
 * existing text, so it can add to a PDF but not edit text that was already there (a whiteout box
 * covers it instead). `elements`: [{ type: 'text'|'image'|'highlight'|'stroke'|'whiteout'|'shape'|
 * 'markup'|'link'|'textedit', page, ...PDF-space fields }]. A 'textedit' replaces a run of the PDF's
 * own text: { run, runs, text, size, color, background, family, bold, italic, align, lineHeight, x, y,
 * maxWidth } - every run of the block is removed (or covered) and the new text is wrapped and drawn
 * at x / first baseline y. A 'text' element takes the same layout fields (see pdfTextBlocks.js).
 * `beforeSave(doc)`, when given, runs after the elements are drawn and before saving (Edit PDF's
 * form values and new fields).
 * Annotations: a 'highlight' or 'markup' with `quads` becomes a real /Highlight, /Underline or
 * /StrikeOut annotation; 'note' a sticky note; a 'stroke' with `ink` an /Ink annotation; a
 * 'linkedit' { annotId, annotIndex, linkRect, url | pageTarget | remove } changes a link the
 * PDF already had (see pdfLinks.js). Shapes use shapeStyleOf() (stroke/fill colours, opacity, dash).
 */
export async function buildEditedPdf(doc, elements, { beforeSave } = {}) {
    const editFonts = new Map();
    // Edits of existing text go first, so anything added on top of the page stays on top of them.
    const ordered = [...elements.filter((el) => el.type === 'textedit'), ...elements.filter((el) => el.type !== 'textedit')];
    // Take the edited runs' original text out of each page's content, so it is really gone. Runs that
    // can't be removed safely (text inside a form object, unusual fonts) are covered instead.
    // Links the PDF already had are changed before anything new is added to the pages' /Annots.
    applyLinkEdits(doc, elements.filter((el) => el.type === 'linkedit'));
    const removed = new Set();
    for (const pageIndex of new Set(ordered.filter((el) => el.type === 'textedit').map((el) => el.page))) {
        const runs = ordered.filter((el) => el.type === 'textedit' && el.page === pageIndex).flatMap((el) => el.runs ?? [el.run]);
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
            for (const run of el.runs ?? [el.run]) {
                if (removed.has(`${el.page}:${run.id}`)) continue;
                const bg = hexToRgb01(el.background);
                page.drawRectangle({ ...coverRect(run, run.ascent, run.descent), color: rgb(bg.r, bg.g, bg.b) });
            }
            if (el.text.trim()) {
                const font = await fontForEdit(doc, el.run, el.text, editFonts, { family: el.family, bold: el.bold, italic: el.italic });
                drawTextElement(page, { x: el.run.x, y: el.run.y, ...el }, font, rgb(r, g, b));
            }
        } else if (el.type === 'whiteout') {
            page.drawRectangle({ ...el.rectPdf, color: rgb(1, 1, 1) });
        } else if (el.type === 'linkedit') {
            // Already applied above.
        } else if (el.type === 'note') {
            const { x, y, height } = el.rectPdf;
            addNoteAnnot(doc, page, { x, y: y + height, contents: el.contents, author: el.author, color: el.color, icon: el.icon });
        } else if ((el.type === 'markup' || el.type === 'highlight') && el.quads?.length) {
            addMarkupAnnot(doc, page, { kind: el.type === 'highlight' ? 'highlight' : el.kind, quads: movedQuads(el), color: el.color, author: el.author });
        } else if (el.type === 'shape' && (el.shape === 'rect' || el.shape === 'ellipse')) {
            const { x, y, width, height } = el.rectPdf;
            const look = shapeStyleOf(el);
            const stroke = hexToRgb01(look.strokeColor);
            const fill = look.fillColor ? hexToRgb01(look.fillColor) : null;
            const style = {
                borderColor: el.thickness > 0 ? rgb(stroke.r, stroke.g, stroke.b) : undefined,
                borderWidth: el.thickness,
                borderOpacity: look.opacity,
                borderDashArray: dashPattern(look.dash, el.thickness) ?? undefined,
                color: fill ? rgb(fill.r, fill.g, fill.b) : undefined,
                opacity: look.opacity,
            };
            if (el.shape === 'rect') page.drawRectangle({ ...rotatedRect({ x, y, width, height }, el.rotation), ...style });
            else page.drawEllipse({ x: x + width / 2, y: y + height / 2, xScale: width / 2, yScale: height / 2, ...style, rotate: el.rotation ? degrees(-el.rotation) : undefined });
        } else if (el.type === 'shape') {
            const [start, end] = el.points;
            const lines = [{ start, end }, ...(el.shape === 'arrow' ? arrowHeadLines(start, end, Math.max(8, el.thickness * 4)) : [])];
            const look = shapeStyleOf(el);
            const stroke = hexToRgb01(look.strokeColor);
            const dashArray = dashPattern(look.dash, el.thickness);
            for (const [i, line] of lines.entries()) {
                // The arrowhead is always solid, so a dashed arrow still has a clear point.
                page.drawLine({ ...line, thickness: el.thickness, color: rgb(stroke.r, stroke.g, stroke.b), opacity: look.opacity, lineCap: dashArray ? undefined : LineCapStyle.Round, dashArray: i === 0 && dashArray ? dashArray : undefined });
            }
        } else if (el.type === 'markup') {
            const { x, y, width, height } = el.rectPdf;
            const lineY = markupLineY(el.kind, y, height);
            page.drawLine({ start: { x, y: lineY }, end: { x: x + width, y: lineY }, thickness: Math.max(0.8, height * 0.07), color: rgb(r, g, b) });
        } else if (el.type === 'link') {
            addLinkAnnot(doc, page, { rect: el.rectPdf, url: el.url, pageTarget: el.pageTarget ?? null });
        } else if (el.type === 'text') {
            if (!el.text.trim()) continue;
            const style = { family: el.family ?? 'sans', bold: Boolean(el.bold), italic: Boolean(el.italic) };
            const font = await fontForEdit(doc, style, el.text, editFonts, style);
            // Saved before text boxes had a layout: one line with its baseline on the box's bottom edge.
            const laid = el.box || el.lineHeight ? el : { ...el, box: { x: el.x, y: el.y, width: el.width, height: el.height } };
            drawTextElement(page, laid, font, rgb(r, g, b));
        } else if (el.type === 'image') {
            const image = el.format === 'jpg' ? await doc.embedJpg(el.bytes) : await doc.embedPng(el.bytes);
            page.drawImage(image, { ...rotatedRect(el.rectPdf, el.rotation), opacity: el.opacity ?? 1 });
            if (el.dateText) {
                // A signature's optional date stamp, just under it.
                const dateStyle = { family: 'sans', bold: false, italic: false };
                const dateFont = await fontForEdit(doc, dateStyle, el.dateText, editFonts, dateStyle);
                const size = Math.max(8, Math.min(12, el.rectPdf.height * 0.22));
                page.drawText(el.dateText, { x: el.rectPdf.x, y: el.rectPdf.y - size - 4, size, font: dateFont, color: rgb(0, 0, 0) });
            }
        } else if (el.type === 'highlight') {
            page.drawRectangle({ ...rotatedRect(el.rectPdf, el.rotation), color: rgb(r, g, b), opacity: 0.4 });
        } else if (el.type === 'stroke' && el.ink) {
            addInkAnnot(doc, page, { strokes: [el.points], color: el.color, thickness: el.thickness });
        } else if (el.type === 'stroke') {
            for (let i = 1; i < el.points.length; i++) {
                page.drawLine({ start: el.points[i - 1], end: el.points[i], thickness: el.thickness, color: rgb(r, g, b), lineCap: LineCapStyle.Round });
            }
        }
    }
    if (beforeSave) await beforeSave(doc);
    const bytes = await doc.save();
    return new Blob([bytes], { type: 'application/pdf' });
}
