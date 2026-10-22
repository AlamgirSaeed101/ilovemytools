import { PDFDocument } from 'pdf-lib';
import { describe, expect, it } from 'vitest';
import {
    buildWatermarkedPdf,
    contentStreamRefs,
    imageWatermarkSize,
    moveNewContentToBack,
    rotatedDrawOrigin,
    watermarkCenters,
    watermarkPageIndexes,
} from './pdfWatermark.js';

describe('watermarkPageIndexes', () => {
    it('returns every page for "all"', () => {
        expect(watermarkPageIndexes(4, 'all')).toEqual([0, 1, 2, 3]);
    });

    it('returns only odd or even page numbers (1-based) for "odd"/"even"', () => {
        expect(watermarkPageIndexes(5, 'odd')).toEqual([0, 2, 4]);
        expect(watermarkPageIndexes(5, 'even')).toEqual([1, 3]);
    });

    it('skips the first page for "skip-first"', () => {
        expect(watermarkPageIndexes(3, 'skip-first')).toEqual([1, 2]);
    });

    it('parses a page range for "range"', () => {
        expect(watermarkPageIndexes(10, 'range', '2-3, 5')).toEqual([1, 2, 4]);
    });

    it('rejects an invalid range the same way Split/Delete PDF Pages do', () => {
        expect(() => watermarkPageIndexes(5, 'range', '9')).toThrow(/only has/);
    });

    it('throws for an unknown scope', () => {
        expect(() => watermarkPageIndexes(5, 'nonsense')).toThrow();
    });
});

describe('watermarkCenters', () => {
    const pageWidth = 600;
    const pageHeight = 800;

    it('places a single centre point in the middle of the page', () => {
        expect(watermarkCenters(pageWidth, pageHeight, 100, 40, 'center')).toEqual([{ cx: 300, cy: 400 }]);
    });

    it('places each corner inset by the margin plus half the box size', () => {
        expect(watermarkCenters(pageWidth, pageHeight, 100, 40, 'top-left', 20)).toEqual([{ cx: 70, cy: 760 }]);
        expect(watermarkCenters(pageWidth, pageHeight, 100, 40, 'bottom-right', 20)).toEqual([{ cx: 530, cy: 40 }]);
    });

    it('tiles a grid of centre points across the page', () => {
        const centers = watermarkCenters(200, 200, 40, 40, 'tile', 20);
        expect(centers.length).toBeGreaterThan(1);
        for (const { cx, cy } of centers) {
            expect(cx).toBeGreaterThanOrEqual(0);
            expect(cx).toBeLessThanOrEqual(200);
            expect(cy).toBeGreaterThanOrEqual(0);
            expect(cy).toBeLessThanOrEqual(200);
        }
    });

    it('falls back to the page centre for an unknown position', () => {
        expect(watermarkCenters(pageWidth, pageHeight, 100, 40, 'nonsense')).toEqual([{ cx: 300, cy: 400 }]);
    });
});

describe('rotatedDrawOrigin', () => {
    it('is the box bottom-left corner with no rotation', () => {
        expect(rotatedDrawOrigin(100, 100, 50, 20, 0)).toEqual({ x: 50, y: 80 });
    });

    it('rotates the offset vector 90 degrees counter-clockwise', () => {
        const { x, y } = rotatedDrawOrigin(100, 100, 10, 0, 90);
        expect(x).toBeCloseTo(100, 5);
        expect(y).toBeCloseTo(90, 5);
    });
});

describe('imageWatermarkSize', () => {
    it('scales to the requested percentage of the page width, keeping aspect ratio', () => {
        expect(imageWatermarkSize(600, 400, 200, 30)).toEqual({ width: 180, height: 90 });
    });

    it('clamps the percentage to a sane 5-90 range', () => {
        expect(imageWatermarkSize(600, 400, 400, 1)).toEqual({ width: 30, height: 30 });
        expect(imageWatermarkSize(600, 400, 400, 500)).toEqual({ width: 540, height: 540 });
    });
});

describe('background (behind the content) watermark', () => {
    // A 1x1 transparent PNG.
    const PNG = Uint8Array.from(atob('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII='), (c) => c.charCodeAt(0));
    const options = (layer) => ({ pageIndexes: [0], position: 'center', opacity: 0.3, rotation: 0, layer, content: { kind: 'image', bytes: PNG, width: 20, height: 20 } });

    async function pageWithContent() {
        const doc = await PDFDocument.create();
        const page = doc.addPage([200, 200]);
        page.drawRectangle({ x: 10, y: 10, width: 50, height: 50 }); // the page's "own" content
        return { doc, page, original: contentStreamRefs(page) };
    }

    it('draws the watermark first, so the page content stays on top', async () => {
        const { doc, page, original } = await pageWithContent();
        await buildWatermarkedPdf(doc, options('under'));
        const refs = contentStreamRefs(page);
        expect(original.includes(refs[0])).toBe(false);
        expect(refs.slice(-original.length)).toEqual(original);
    });

    it('leaves the page content first when placed on top (the watermark is appended after it)', async () => {
        const { doc, page, original } = await pageWithContent();
        await buildWatermarkedPdf(doc, options('over'));
        expect(contentStreamRefs(page).slice(0, original.length)).toEqual(original);
    });

    it('moveNewContentToBack keeps the order of the moved streams', async () => {
        const { doc, page, original } = await pageWithContent();
        const a = doc.context.register(doc.context.stream(''));
        const b = doc.context.register(doc.context.stream(''));
        page.node.addContentStream(a);
        page.node.addContentStream(b);
        moveNewContentToBack(page, original);
        expect(contentStreamRefs(page)).toEqual([a, b, ...original]);
    });
});
