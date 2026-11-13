import { PDFDocument } from 'pdf-lib';
import { beforeAll, describe, expect, it } from 'vitest';
import { addInkAnnot, addMarkupAnnot, addNoteAnnot, quadsBounds, quadsForRuns, smoothStroke, strokeToPath } from './pdfAnnotations.js';
import { strokeToSvgPath } from './pdfAnnotationGeometry.js';
import { buildEditedPdf } from './pdfEdit.js';

// pdf.js takes a few seconds to load the first time, more when the whole suite runs at once.
beforeAll(() => import('pdfjs-dist/legacy/build/pdf.mjs'), 60000);

async function annotationsOf(bytes, pageNumber = 1) {
    const pdfjs = await import('pdfjs-dist/legacy/build/pdf.mjs');
    const doc = await pdfjs.getDocument({ data: new Uint8Array(bytes) }).promise;
    const page = await doc.getPage(pageNumber);
    const annotations = await page.getAnnotations();
    await doc.destroy();
    return annotations;
}

// Two lines of 10 letters, 100 points wide, 10 points tall text.
const RUNS = [
    { str: 'abcdefghij', x: 100, y: 700, width: 100, size: 10, ascent: 0.9, descent: -0.25 },
    { str: 'klmnopqrst', x: 100, y: 680, width: 100, size: 10, ascent: 0.9, descent: -0.25 },
];

describe('quadsForRuns', () => {
    it('gives one quad per covered line, spanning ascent to descent', () => {
        const quads = quadsForRuns(RUNS, { x: 90, y: 675, width: 130, height: 40 });
        expect(quads).toHaveLength(2);
        const [first, second] = quads;
        expect(first).toEqual([100, 709, 200, 709, 100, 697.5, 200, 697.5]);
        expect(second[1]).toBeCloseTo(689);
        expect(second[5]).toBeCloseTo(677.5);
    });

    it('snaps to whole letters when the box covers part of a run', () => {
        const [quad] = quadsForRuns(RUNS, { x: 121, y: 698, width: 38, height: 10 });
        // Letters are 10 points wide: 121-159 covers letters 3 to 6 (x 120-160).
        expect(quad[0]).toBeCloseTo(120);
        expect(quad[2]).toBeCloseTo(160);
    });

    it('ignores a line the box only grazes', () => {
        // The box reaches 1 point into the second line's top (689): not a third of its height.
        const quads = quadsForRuns(RUNS, { x: 90, y: 688, width: 130, height: 20 });
        expect(quads).toHaveLength(1);
    });

    it('is empty when the box covers no text (a scanned page)', () => {
        expect(quadsForRuns(RUNS, { x: 300, y: 100, width: 50, height: 50 })).toEqual([]);
        expect(quadsForRuns([], { x: 0, y: 0, width: 500, height: 500 })).toEqual([]);
    });

    it('merges neighbouring runs on the same line into one quad', () => {
        const runs = [
            { str: 'Hello', x: 100, y: 500, width: 50, size: 10 },
            { str: 'world', x: 153, y: 500, width: 50, size: 10 },
        ];
        const quads = quadsForRuns(runs, { x: 90, y: 495, width: 130, height: 15 });
        expect(quads).toHaveLength(1);
        expect(quads[0][0]).toBe(100);
        expect(quads[0][2]).toBe(203);
    });

    it('quadsBounds is the box around every quad', () => {
        const quads = quadsForRuns(RUNS, { x: 90, y: 675, width: 130, height: 40 });
        const b = quadsBounds(quads);
        expect(b.x).toBe(100);
        expect(b.width).toBe(100);
        expect(b.y).toBeCloseTo(677.5);
        expect(b.y + b.height).toBeCloseTo(709);
    });
});

describe('smoothStroke', () => {
    it('keeps the first and last points where the pen was', () => {
        const points = [{ x: 0, y: 0 }, { x: 10, y: 10 }, { x: 20, y: 0 }, { x: 30, y: 10 }];
        const out = smoothStroke(points);
        expect(out[0]).toEqual({ x: 0, y: 0 });
        expect(out[out.length - 1]).toEqual({ x: 30, y: 10 });
    });

    it('cuts the corners (the zig-zag peaks get lower)', () => {
        const points = [{ x: 0, y: 0 }, { x: 10, y: 10 }, { x: 20, y: 0 }, { x: 30, y: 10 }, { x: 40, y: 0 }];
        const out = smoothStroke(points, { iterations: 2 });
        expect(out.length).toBeGreaterThan(points.length);
        const inner = out.slice(1, -1);
        expect(Math.max(...inner.map((p) => p.y))).toBeLessThan(10);
        expect(Math.min(...inner.map((p) => p.y))).toBeGreaterThan(0);
    });

    it('drops jitter points that are too close together', () => {
        const points = [{ x: 0, y: 0 }, { x: 0.2, y: 0.1 }, { x: 0.4, y: 0 }, { x: 10, y: 0 }];
        expect(smoothStroke(points, { iterations: 0 })).toEqual([{ x: 0, y: 0 }, { x: 10, y: 0 }]);
    });

    it('handles empty and single-point strokes', () => {
        expect(smoothStroke([])).toEqual([]);
        expect(smoothStroke([{ x: 3, y: 4 }])).toEqual([{ x: 3, y: 4 }]);
    });

    it('turns a stroke into one smooth PDF path and SVG path', () => {
        const points = [{ x: 0, y: 0 }, { x: 10, y: 10 }, { x: 20, y: 0 }];
        expect(strokeToPath(points)).toMatch(/^0 0 m .* c 20 0 l$/);
        expect(strokeToSvgPath(points)).toMatch(/^M0 0 C.* L20 0$/);
    });
});

describe('PDF annotations', () => {
    it('writes a highlight that pdf.js lists with its quad points', async () => {
        const doc = await PDFDocument.create();
        const page = doc.addPage([612, 792]);
        const quads = quadsForRuns(RUNS, { x: 90, y: 675, width: 130, height: 40 });
        addMarkupAnnot(doc, page, { kind: 'highlight', quads, color: '#fde047', author: 'Ana' });
        addMarkupAnnot(doc, page, { kind: 'underline', quads: [quads[0]], color: '#dc2626' });
        addMarkupAnnot(doc, page, { kind: 'strike', quads: [quads[1]], color: '#dc2626' });
        const annots = await annotationsOf(await doc.save());
        expect(annots.map((a) => a.subtype)).toEqual(['Highlight', 'Underline', 'StrikeOut']);
        expect(annots[0].quadPoints).toBeTruthy();
        expect(annots[0].titleObj?.str).toBe('Ana');
        expect(annots[0].hasAppearance).toBe(true);
    });

    it('refuses an unknown markup kind or no quads', async () => {
        const doc = await PDFDocument.create();
        const page = doc.addPage();
        expect(() => addMarkupAnnot(doc, page, { kind: 'squiggle', quads: [[0, 1, 1, 1, 0, 0, 1, 0]] })).toThrow();
        expect(() => addMarkupAnnot(doc, page, { kind: 'highlight', quads: [] })).toThrow();
    });

    it('writes a sticky note with its text and author', async () => {
        const doc = await PDFDocument.create();
        const page = doc.addPage([612, 792]);
        addNoteAnnot(doc, page, { x: 50, y: 700, contents: 'Check this number – ¿ok?', author: 'Lee', color: '#facc15', icon: 'Note' });
        const annots = await annotationsOf(await doc.save());
        const note = annots.find((a) => a.subtype === 'Text');
        expect(note.contentsObj.str).toBe('Check this number – ¿ok?');
        expect(note.titleObj.str).toBe('Lee');
        expect(note.hasAppearance).toBe(true); // pdf.js then draws our icon (and reports name 'NoIcon')
        expect(note.rect).toEqual([50, 680, 70, 700]);
    });

    it('writes a freehand ink annotation', async () => {
        const doc = await PDFDocument.create();
        const page = doc.addPage([612, 792]);
        addInkAnnot(doc, page, { strokes: [smoothStroke([{ x: 10, y: 10 }, { x: 50, y: 60 }, { x: 90, y: 10 }])], color: '#2563eb', thickness: 3 });
        const annots = await annotationsOf(await doc.save());
        expect(annots[0].subtype).toBe('Ink');
        expect(annots[0].inkLists.length).toBe(1);
    });
});

describe('buildEditedPdf with annotations', () => {
    it('saves quad highlights, markup, notes and ink as annotations, and moves dragged quads', async () => {
        const doc = await PDFDocument.create();
        doc.addPage([612, 792]);
        const quads = [[100, 709, 200, 709, 100, 697.5, 200, 697.5]];
        const quadsBox = { x: 100, y: 697.5, width: 100, height: 11.5 };
        const elements = [
            { type: 'highlight', page: 0, color: '#fde047', quads, quadsBox, rectPdf: { ...quadsBox, x: 110 } },
            { type: 'markup', kind: 'underline', page: 0, color: '#dc2626', quads, quadsBox, rectPdf: quadsBox },
            { type: 'note', page: 0, color: '#facc15', contents: 'Hello', author: 'Me', icon: 'Comment', rectPdf: { x: 20, y: 700, width: 20, height: 20 } },
            { type: 'stroke', ink: true, page: 0, color: '#000000', thickness: 2, points: [{ x: 1, y: 1 }, { x: 30, y: 40 }] },
            { type: 'stroke', page: 0, color: '#000000', thickness: 2, points: [{ x: 1, y: 1 }, { x: 30, y: 40 }] },
        ];
        const blob = await buildEditedPdf(doc, elements);
        const annots = await annotationsOf(await blob.arrayBuffer());
        const subtypes = annots.map((a) => a.subtype);
        expect(subtypes).toEqual(expect.arrayContaining(['Highlight', 'Underline', 'Text', 'Ink']));
        expect(subtypes).not.toContain('Square');
        const highlight = annots.find((a) => a.subtype === 'Highlight');
        expect(highlight.rect[0]).toBeCloseTo(109); // the 10-point drag right, minus the 1-point pad
        expect(annots.find((a) => a.subtype === 'Text').contentsObj.str).toBe('Hello');
    });

    it('saves shapes with separate stroke and fill colours, opacity and a dash, and still accepts old shapes', async () => {
        const doc = await PDFDocument.create();
        doc.addPage([400, 400]);
        const rectPdf = { x: 50, y: 50, width: 100, height: 60 };
        const elements = [
            { type: 'shape', shape: 'rect', page: 0, strokeColor: '#dc2626', fillColor: '#2563eb', opacity: 0.5, dash: 'dashed', thickness: 2, rectPdf },
            { type: 'shape', shape: 'ellipse', page: 0, strokeColor: '#111111', fillColor: null, opacity: 1, dash: 'dotted', thickness: 2, rectPdf },
            { type: 'shape', shape: 'arrow', page: 0, strokeColor: '#16a34a', opacity: 0.7, dash: 'dashed', thickness: 2, points: [{ x: 10, y: 10 }, { x: 200, y: 200 }] },
            { type: 'shape', shape: 'rect', page: 0, color: '#dc2626', thickness: 2, fill: true, rectPdf },
        ];
        const blob = await buildEditedPdf(doc, elements);
        const pdfjs = await import('pdfjs-dist/legacy/build/pdf.mjs');
        const rendered = await pdfjs.getDocument({ data: new Uint8Array(await blob.arrayBuffer()) }).promise;
        const ops = await (await rendered.getPage(1)).getOperatorList();
        await rendered.destroy();
        const args = (fn) => ops.fnArray.flatMap((f, i) => (f === fn ? [ops.argsArray[i]] : []));
        const colors = (fn) => args(fn).map((a) => (typeof a[0] === 'string' ? a[0] : Array.from(a[0] ?? a).join(',')));
        // pdf.js reports colours as #rrggbb.
        expect(colors(pdfjs.OPS.setStrokeRGBColor)).toEqual(expect.arrayContaining(['#dc2626', '#111111', '#16a34a']));
        expect(colors(pdfjs.OPS.setFillRGBColor)).toEqual(expect.arrayContaining(['#2563eb']));
        expect(args(pdfjs.OPS.setDash).some(([pattern]) => pattern.length === 2 && pattern[0] === 8)).toBe(true);
        expect(args(pdfjs.OPS.setGState).length).toBeGreaterThan(0);
    });
});
