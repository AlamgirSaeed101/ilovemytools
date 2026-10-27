import { PDFDocument, PDFName } from 'pdf-lib';
import { describe, expect, it } from 'vitest';
import { angleFromCenter, arrowHeadLines, buildEditedPdf, markupLineY, normalizeLinkUrl, pointsToPdf, rotatedBoxOrigin, strokeBoundingBox, undoLast } from './pdfEdit.js';

describe('pointsToPdf', () => {
    it('converts canvas-space points to PDF-space, flipping the y axis', () => {
        const points = [{ x: 0, y: 0 }, { x: 20, y: 10 }];
        const result = pointsToPdf(points, 2, 400);
        expect(result).toEqual([
            { x: 0, y: 400 },
            { x: 10, y: 395 },
        ]);
    });

    it('returns an empty array for an empty stroke', () => {
        expect(pointsToPdf([], 1, 400)).toEqual([]);
    });
});

describe('undoLast', () => {
    it('drops the most recently added element', () => {
        expect(undoLast([1, 2, 3])).toEqual([1, 2]);
    });

    it('does nothing on an empty list', () => {
        expect(undoLast([])).toEqual([]);
    });
});

describe('strokeBoundingBox', () => {
    it('computes the min/max box around a set of points', () => {
        expect(strokeBoundingBox([{ x: 10, y: 40 }, { x: 30, y: 10 }, { x: 20, y: 25 }])).toEqual({ x: 10, y: 10, width: 20, height: 30 });
    });

    it('gives a 1x1 box for a single point (a tap, not a drag)', () => {
        expect(strokeBoundingBox([{ x: 5, y: 5 }])).toEqual({ x: 5, y: 5, width: 1, height: 1 });
    });

    it('falls back to a default box for an empty stroke', () => {
        expect(strokeBoundingBox([])).toEqual({ x: 0, y: 0, width: 1, height: 1 });
    });
});

describe('normalizeLinkUrl', () => {
    it('adds https:// to a bare domain and keeps http(s) and mailto links', () => {
        expect(normalizeLinkUrl('example.com/page')).toBe('https://example.com/page');
        expect(normalizeLinkUrl(' http://example.org ')).toBe('http://example.org/');
        expect(normalizeLinkUrl('mailto:hello@example.com')).toBe('mailto:hello@example.com');
    });

    it('refuses anything that is not a web or email link', () => {
        for (const bad of ['', 'javascript:alert(1)', 'file:///etc/passwd', 'not a url', 'localhost', 'ftp://example.com']) {
            expect(normalizeLinkUrl(bad)).toBeNull();
        }
    });
});

describe('arrowHeadLines', () => {
    it('draws two equal head lines back from the tip, either side of the shaft', () => {
        const [a, b] = arrowHeadLines({ x: 0, y: 0 }, { x: 100, y: 0 }, 10);
        expect(a.start).toEqual({ x: 100, y: 0 });
        expect(a.end.x).toBeLessThan(100);
        expect(b.end.x).toBeCloseTo(a.end.x);
        expect(b.end.y).toBeCloseTo(-a.end.y);
        expect(Math.hypot(a.end.x - 100, a.end.y)).toBeCloseTo(10);
    });
});

describe('markupLineY', () => {
    it('puts a strikethrough through the middle and an underline near the bottom', () => {
        expect(markupLineY('strike', 100, 20)).toBeCloseTo(109);
        expect(markupLineY('underline', 100, 20)).toBeCloseTo(101.6);
    });
});

describe('buildEditedPdf', () => {
    it('adds whiteout, shapes, markup and a clickable link annotation', async () => {
        const doc = await PDFDocument.create();
        doc.addPage([300, 300]);
        const rectPdf = { x: 20, y: 20, width: 100, height: 30 };
        const blob = await buildEditedPdf(doc, [
            { type: 'whiteout', page: 0, rectPdf },
            { type: 'shape', shape: 'ellipse', page: 0, color: '#dc2626', thickness: 2, fill: false, rectPdf },
            { type: 'shape', shape: 'arrow', page: 0, color: '#dc2626', thickness: 2, points: [{ x: 10, y: 10 }, { x: 200, y: 200 }] },
            { type: 'markup', kind: 'strike', page: 0, color: '#000000', rectPdf },
            { type: 'link', page: 0, url: 'https://ilovemytools.store/', rectPdf },
        ]);
        const saved = await PDFDocument.load(new Uint8Array(await blob.arrayBuffer()));
        const annots = saved.getPage(0).node.Annots().asArray().map((ref) => saved.context.lookup(ref));
        expect(annots).toHaveLength(1);
        expect(annots[0].get(PDFName.of('Subtype')).toString()).toBe('/Link');
        const action = saved.context.lookup(annots[0].get(PDFName.of('A')));
        expect(action.get(PDFName.of('URI')).decodeText()).toBe('https://ilovemytools.store/');
    });

    it('rotates a shape and a highlight around their own centre without throwing', async () => {
        const doc = await PDFDocument.create();
        doc.addPage([300, 300]);
        const rectPdf = { x: 50, y: 50, width: 80, height: 40 };
        const blob = await buildEditedPdf(doc, [
            { type: 'shape', shape: 'rect', page: 0, color: '#dc2626', thickness: 2, fill: true, rotation: 30, rectPdf },
            { type: 'shape', shape: 'ellipse', page: 0, color: '#2563eb', thickness: 2, fill: false, rotation: 45, rectPdf },
            { type: 'highlight', page: 0, color: '#fde047', rotation: 15, rectPdf },
        ]);
        const saved = await PDFDocument.load(new Uint8Array(await blob.arrayBuffer()));
        expect(saved.getPageCount()).toBe(1);
    });
});

describe('angleFromCenter', () => {
    const center = { x: 100, y: 100 };
    it('is 0 directly above the centre and increases clockwise', () => {
        expect(angleFromCenter(center, { x: 100, y: 40 })).toBeCloseTo(0);
        expect(angleFromCenter(center, { x: 160, y: 100 })).toBeCloseTo(90);
        expect(angleFromCenter(center, { x: 100, y: 160 })).toBeCloseTo(180);
        expect(angleFromCenter(center, { x: 40, y: 100 })).toBeCloseTo(270);
    });
});

describe('rotatedBoxOrigin', () => {
    it('keeps the box centred: rotating the local centre by the same transform lands back on cx, cy', () => {
        const width = 80;
        const height = 40;
        const cx = 150;
        const cy = 200;
        for (const screenDeg of [0, 30, 90, 180, 227]) {
            const { x, y, rotateDeg } = rotatedBoxOrigin(cx, cy, width, height, screenDeg);
            const rad = (rotateDeg * Math.PI) / 180;
            const cos = Math.cos(rad);
            const sin = Math.sin(rad);
            // pdf-lib's CTM: pageP = R * localP + (x, y), R = [[cos, -sin], [sin, cos]] applied to (width/2, height/2).
            const pageX = width / 2 * cos - height / 2 * sin + x;
            const pageY = width / 2 * sin + height / 2 * cos + y;
            expect(pageX).toBeCloseTo(cx);
            expect(pageY).toBeCloseTo(cy);
        }
    });

    it('returns the unrotated corner and no rotation when rotationDeg is 0', () => {
        expect(rotatedBoxOrigin(100, 100, 80, 40, 0)).toEqual({ x: 60, y: 80, rotateDeg: 0 });
    });
});
