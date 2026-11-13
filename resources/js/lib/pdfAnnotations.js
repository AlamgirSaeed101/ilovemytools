// Real PDF annotations for Edit PDF: text markup (/Highlight, /Underline, /StrikeOut), sticky
// notes (/Text) and freehand ink (/Ink). Unlike content drawn onto the page, these show up as
// comments in other PDF readers (Acrobat's comment list, Preview, browsers' viewers) and can be
// edited or deleted there. Each one carries its own appearance stream so every viewer draws it
// the same way. The geometry helpers (quadsForRuns, smoothStroke...) are pure and don't need
// pdf-lib, so the editor can use them while drawing without loading it.
import { PDFHexString, PDFName, PDFString } from 'pdf-lib';
import { hexToRgb01 } from './pdfOverlay.js';
import { quadsBounds, quadsForRuns, smoothStroke, strokeToPath } from './pdfAnnotationGeometry.js';

export { quadsBounds, quadsForRuns, smoothStroke, strokeToPath };

const SUBTYPES = { highlight: 'Highlight', underline: 'Underline', strike: 'StrikeOut' };
export const NOTE_ICONS = ['Comment', 'Note', 'Help', 'Key', 'Insert', 'Paragraph', 'NewParagraph'];
const NOTE_SIZE = 20;

const num = (v) => (Math.round(v * 1000) / 1000).toString();
const colorArray = (hex) => {
    const { r, g, b } = hexToRgb01(hex);
    return [r, g, b];
};

/** The common entries of every annotation this file writes: when, by whom, a unique name, printable. */
function baseEntries({ author, contents } = {}) {
    const entries = {
        F: 4, // Print: the annotation appears when the PDF is printed, like it does on screen.
        M: PDFString.fromDate(new Date()),
        NM: PDFHexString.fromText(`ilmt-${Date.now().toString(36)}-${Math.random().toString(36).slice(2, 8)}`),
    };
    if (author) entries.T = PDFHexString.fromText(author);
    if (contents) entries.Contents = PDFHexString.fromText(contents);
    return entries;
}

/** A Form XObject used as an annotation's normal appearance (/AP /N), drawn in page space over `bbox`. */
function appearance(doc, content, bbox, { opacity = 1, multiply = false } = {}) {
    const gs = { Type: 'ExtGState', CA: opacity, ca: opacity };
    if (multiply) gs.BM = 'Multiply';
    const stream = doc.context.stream(content, {
        Type: 'XObject',
        Subtype: 'Form',
        FormType: 1,
        BBox: bbox,
        Resources: { ExtGState: { GS0: gs } },
    });
    return doc.context.register(stream);
}

function registerAnnot(doc, page, dict) {
    const ref = doc.context.register(doc.context.obj(dict));
    page.node.addAnnot(ref);
    return ref;
}

const padRect = ({ x, y, width, height }, pad) => [x - pad, y - pad, x + width + pad, y + height + pad];

/**
 * Adds a text-markup annotation to `page` (a pdf-lib PDFPage). `kind`: 'highlight' | 'underline'
 * | 'strike'; `quads`: [[xUL, yUL, xUR, yUR, xLL, yLL, xLR, yLR], ...] in PDF space (one per line
 * of text, as quadsForRuns returns them). Returns the annotation's reference.
 */
export function addMarkupAnnot(doc, page, { kind, quads, color = '#fde047', opacity, author, contents }) {
    const subtype = SUBTYPES[kind];
    if (!subtype) throw new Error(`Unknown markup kind: ${kind}`);
    if (!quads?.length) throw new Error('A text markup needs at least one quad.');
    const bounds = quadsBounds(quads);
    const rect = padRect(bounds, 1);
    const [r, g, b] = colorArray(color);
    const alpha = opacity ?? 1;
    let content = `/GS0 gs\n`;
    if (kind === 'highlight') {
        content += `${num(r)} ${num(g)} ${num(b)} rg\n`;
        for (const q of quads) {
            content += `${num(q[0])} ${num(q[1])} m ${num(q[2])} ${num(q[3])} l ${num(q[6])} ${num(q[7])} l ${num(q[4])} ${num(q[5])} l h f\n`;
        }
    } else {
        content += `${num(r)} ${num(g)} ${num(b)} RG\n`;
        for (const q of quads) {
            const height = Math.abs(q[1] - q[5]);
            const width = Math.max(0.6, height * 0.07);
            // Underline sits just above the bottom of the box (the descender area), strike through the middle.
            const t = kind === 'strike' ? 0.45 : 0.12;
            const y0 = q[5] + (q[1] - q[5]) * t;
            const y1 = q[7] + (q[3] - q[7]) * t;
            content += `${num(width)} w ${num(q[4])} ${num(y0)} m ${num(q[6])} ${num(y1)} l S\n`;
        }
    }
    const ap = appearance(doc, content, rect, { opacity: alpha, multiply: kind === 'highlight' });
    return registerAnnot(doc, page, {
        Type: 'Annot',
        Subtype: subtype,
        Rect: rect,
        QuadPoints: quads.flat(),
        C: [r, g, b],
        CA: alpha,
        AP: { N: ap },
        ...baseEntries({ author, contents }),
    });
}

/** The stroked outline of a note icon (a speech bubble with three lines of text) inside `rect`. */
function noteIconContent(rect, color) {
    const [x0, y0, x1, y1] = rect;
    const w = x1 - x0;
    const h = y1 - y0;
    const [r, g, b] = colorArray(color);
    const px = (fx) => num(x0 + w * fx);
    const py = (fy) => num(y0 + h * fy);
    return [
        '/GS0 gs',
        `${num(r)} ${num(g)} ${num(b)} rg 0.25 0.25 0.25 RG 0.8 w 1 j`,
        `${px(0.08)} ${py(0.92)} m ${px(0.92)} ${py(0.92)} l ${px(0.92)} ${py(0.3)} l ${px(0.5)} ${py(0.3)} l ${px(0.25)} ${py(0.08)} l ${px(0.3)} ${py(0.3)} l ${px(0.08)} ${py(0.3)} l h B`,
        `${px(0.2)} ${py(0.76)} m ${px(0.8)} ${py(0.76)} l ${px(0.2)} ${py(0.61)} m ${px(0.8)} ${py(0.61)} l ${px(0.2)} ${py(0.46)} m ${px(0.62)} ${py(0.46)} l S`,
    ].join('\n');
}

/**
 * Adds a sticky note (/Text annotation) whose icon's top-left corner is at PDF point (`x`, `y`).
 * The note's `contents` and `author` show in other readers' comment lists; `icon` is one of
 * NOTE_ICONS. A closed /Popup is attached so viewers have a place to show the text.
 */
export function addNoteAnnot(doc, page, { x, y, contents = '', author, color = '#facc15', icon = 'Comment', open = false }) {
    const rect = [x, y - NOTE_SIZE, x + NOTE_SIZE, y];
    const ap = appearance(doc, noteIconContent(rect, color), rect);
    const noteRef = registerAnnot(doc, page, {
        Type: 'Annot',
        Subtype: 'Text',
        Rect: rect,
        Name: NOTE_ICONS.includes(icon) ? icon : 'Comment',
        Open: open,
        C: colorArray(color),
        AP: { N: ap },
        ...baseEntries({ author, contents }),
        F: 4 | 8 | 16, // Print, NoZoom, NoRotate: an icon keeps its size like in every PDF reader.
    });
    const { width: pageWidth } = page.getSize();
    const popupX = Math.min(x + NOTE_SIZE + 4, Math.max(0, pageWidth - 180));
    const popupRef = registerAnnot(doc, page, {
        Type: 'Annot',
        Subtype: 'Popup',
        Rect: [popupX, y - 120, popupX + 180, y],
        Parent: noteRef,
        Open: false,
        F: 4,
    });
    doc.context.lookup(noteRef).set(PDFName.of('Popup'), popupRef);
    return noteRef;
}

/**
 * Adds a freehand /Ink annotation. `strokes`: [[{x, y}, ...], ...] in PDF space (already smoothed);
 * `thickness` in points. The appearance draws each stroke as smooth curves.
 */
export function addInkAnnot(doc, page, { strokes, color = '#dc2626', thickness = 2, opacity = 1, author, contents }) {
    const usable = strokes.filter((s) => s.length > 0);
    if (!usable.length) throw new Error('An ink annotation needs at least one point.');
    const all = usable.flat();
    const xs = all.map((p) => p.x);
    const ys = all.map((p) => p.y);
    const bounds = { x: Math.min(...xs), y: Math.min(...ys), width: Math.max(...xs) - Math.min(...xs), height: Math.max(...ys) - Math.min(...ys) };
    const rect = padRect(bounds, thickness / 2 + 1);
    const [r, g, b] = colorArray(color);
    const body = usable.map((s) => strokeToPath(s, num)).join('\n');
    const content = `/GS0 gs\n${num(r)} ${num(g)} ${num(b)} RG ${num(thickness)} w 1 J 1 j\n${body}\nS`;
    const ap = appearance(doc, content, rect, { opacity });
    return registerAnnot(doc, page, {
        Type: 'Annot',
        Subtype: 'Ink',
        Rect: rect,
        InkList: usable.map((s) => s.flatMap((p) => [p.x, p.y])),
        BS: { Type: 'Border', W: thickness, S: 'S' },
        C: [r, g, b],
        CA: opacity,
        AP: { N: ap },
        ...baseEntries({ author, contents }),
    });
}
