import { describe, expect, it } from 'vitest';
import { DUPLICATE_OFFSET, canReorder, cursorForMode, duplicateElement, elementBox, moveElement, reorderElement } from './editorSelection.js';

const page = { width: 600, height: 800 };
const box = (id, extra = {}) => ({ id, page: 0, type: 'shape', x: 100, y: 100, width: 50, height: 40, ...extra });

describe('elementBox', () => {
    it('uses x/y/width/height for boxes and the points for lines', () => {
        expect(elementBox(box(1))).toEqual({ x: 100, y: 100, width: 50, height: 40 });
        expect(elementBox({ type: 'stroke', points: [{ x: 10, y: 50 }, { x: 40, y: 20 }] })).toEqual({ x: 10, y: 20, width: 30, height: 30 });
        expect(elementBox(null)).toBeNull();
    });
});

describe('moveElement', () => {
    it('moves a box and keeps it on the page', () => {
        expect(moveElement(box(1), 5, -3, page)).toMatchObject({ x: 105, y: 97 });
        expect(moveElement(box(1), -500, 0, page)).toMatchObject({ x: 0 });
        expect(moveElement(box(1), 1000, 1000, page)).toMatchObject({ x: 550, y: 760 });
    });

    it('moves every point of a line', () => {
        const line = { type: 'shape', shape: 'line', points: [{ x: 10, y: 10 }, { x: 30, y: 40 }] };
        expect(moveElement(line, 10, 10, page).points).toEqual([{ x: 20, y: 20 }, { x: 40, y: 50 }]);
        expect(moveElement(line, -50, 0, page).points[0].x).toBe(0);
    });
});

describe('duplicateElement', () => {
    it('copies with a new id, offset a little', () => {
        const copy = duplicateElement(box(1, { color: '#f00' }), 9, page);
        expect(copy).toMatchObject({ id: 9, x: 100 + DUPLICATE_OFFSET, y: 100 + DUPLICATE_OFFSET, color: '#f00', page: 0 });
    });

    it('does not share the points array with the original', () => {
        const stroke = { id: 1, type: 'stroke', points: [{ x: 1, y: 1 }, { x: 5, y: 5 }] };
        const copy = duplicateElement(stroke, 2, page);
        expect(copy.points).not.toBe(stroke.points);
        expect(stroke.points[0]).toEqual({ x: 1, y: 1 });
    });
});

describe('reorderElement', () => {
    const list = [box(1), box(2, { page: 1 }), box(3), box(4)];

    it('swaps with the next element on the same page', () => {
        expect(reorderElement(list, 1, 'forward').map((el) => el.id)).toEqual([3, 2, 1, 4]);
        expect(reorderElement(list, 4, 'backward').map((el) => el.id)).toEqual([1, 2, 4, 3]);
    });

    it('leaves the list alone at the ends', () => {
        expect(reorderElement(list, 4, 'forward')).toBe(list);
        expect(reorderElement(list, 1, 'backward')).toBe(list);
        expect(reorderElement(list, 99, 'forward')).toBe(list);
        expect(canReorder(list, 1, 'backward')).toBe(false);
        expect(canReorder(list, 1, 'forward')).toBe(true);
        expect(canReorder(list, 2, 'forward')).toBe(false);
    });
});

describe('cursorForMode', () => {
    it('shows what clicking the page will do', () => {
        expect(cursorForMode('select')).toBe('default');
        expect(cursorForMode('text')).toBe('text');
        expect(cursorForMode('whiteout')).toBe('crosshair');
        expect(cursorForMode('unknown')).toBe('default');
    });
});
