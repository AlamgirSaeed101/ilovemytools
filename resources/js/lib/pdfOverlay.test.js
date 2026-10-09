import { describe, expect, it } from 'vitest';
import { canvasRectToPdfRect, clampRect, computeDisplayScale, hexToRgb01, pdfRectToCanvasRect, rectFromPoints } from './pdfOverlay.js';

describe('computeDisplayScale', () => {
    it('fits a portrait A4 page inside the default box', () => {
        expect(computeDisplayScale(595, 842)).toBeCloseTo(900 / 842, 5);
    });

    it('fits a landscape page by width', () => {
        expect(computeDisplayScale(842, 595, 700, 900)).toBeCloseTo(700 / 842, 5);
    });

    it('never scales above 2x', () => {
        expect(computeDisplayScale(50, 50, 700, 900)).toBe(2);
    });
});

describe('canvasRectToPdfRect / pdfRectToCanvasRect', () => {
    it('round-trips a rect through canvas and PDF space', () => {
        const scale = 1.5;
        const pageHeight = 842;
        const canvasRect = { x: 40, y: 60, width: 200, height: 80 };
        const pdfRect = canvasRectToPdfRect(canvasRect, scale, pageHeight);
        expect(pdfRect.x).toBeCloseTo(40 / 1.5, 5);
        expect(pdfRect.width).toBeCloseTo(200 / 1.5, 5);
        const back = pdfRectToCanvasRect(pdfRect, scale, pageHeight);
        expect(back.x).toBeCloseTo(canvasRect.x, 5);
        expect(back.y).toBeCloseTo(canvasRect.y, 5);
        expect(back.width).toBeCloseTo(canvasRect.width, 5);
        expect(back.height).toBeCloseTo(canvasRect.height, 5);
    });

    it('flips the y axis (a box near the canvas top is near the PDF page top, i.e. high y)', () => {
        const pdfRect = canvasRectToPdfRect({ x: 0, y: 0, width: 10, height: 10 }, 1, 842);
        expect(pdfRect.y).toBeCloseTo(832, 5);
    });
});

describe('clampRect', () => {
    it('keeps a rect inside the container', () => {
        expect(clampRect({ x: -10, y: -10, width: 50, height: 50 }, 200, 200)).toEqual({ x: 0, y: 0, width: 50, height: 50 });
        expect(clampRect({ x: 190, y: 190, width: 50, height: 50 }, 200, 200)).toEqual({ x: 150, y: 150, width: 50, height: 50 });
    });

    it('enforces a minimum size and never exceeds the container', () => {
        expect(clampRect({ x: 0, y: 0, width: 2, height: 2 }, 200, 200, 16)).toEqual({ x: 0, y: 0, width: 16, height: 16 });
        expect(clampRect({ x: 0, y: 0, width: 5000, height: 5000 }, 200, 200)).toEqual({ x: 0, y: 0, width: 200, height: 200 });
    });
});

describe('rectFromPoints', () => {
    it('normalises two points dragged in any direction', () => {
        expect(rectFromPoints(50, 60, 10, 20)).toEqual({ x: 10, y: 20, width: 40, height: 40 });
        expect(rectFromPoints(10, 20, 50, 60)).toEqual({ x: 10, y: 20, width: 40, height: 40 });
    });
});

describe('hexToRgb01', () => {
    it('converts a hex colour to 0-1 components', () => {
        expect(hexToRgb01('#ff0000')).toEqual({ r: 1, g: 0, b: 0 });
        expect(hexToRgb01('#000000')).toEqual({ r: 0, g: 0, b: 0 });
        expect(hexToRgb01('0000ff')).toEqual({ r: 0, g: 0, b: 1 });
    });

    it('falls back to black for invalid input', () => {
        expect(hexToRgb01('not-a-color')).toEqual({ r: 0, g: 0, b: 0 });
        expect(hexToRgb01('')).toEqual({ r: 0, g: 0, b: 0 });
    });
});
