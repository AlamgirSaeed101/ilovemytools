import { describe, expect, it } from 'vitest';
import { pointsToPdf, strokeBoundingBox, undoLast } from './pdfEdit.js';

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
