// Pure helpers for the PDF editor's selection model: the box of an element, moving (nudging),
// duplicating and re-stacking elements, and the page cursor for each tool. All coordinates are
// stage (canvas) pixels; nothing here touches the DOM or pdf-lib.
import { strokeBoundingBox } from './pdfEditShapes.js';

export const DUPLICATE_OFFSET = 12;

const hasPoints = (el) => Array.isArray(el.points);

/** The element's bounding box in stage pixels (lines and strokes from their points). */
export function elementBox(el) {
    if (!el) return null;
    if (hasPoints(el)) return strokeBoundingBox(el.points);
    return { x: el.x, y: el.y, width: el.width, height: el.height };
}

/** How far the element can move by (dx, dy) and stay on a page of `bounds` size. */
function clampDelta(el, dx, dy, bounds) {
    if (!bounds?.width || !bounds?.height) return { dx, dy };
    const box = elementBox(el);
    const clamp = (d, start, size, max) => Math.min(Math.max(d, -start), Math.max(-start, max - size - start));
    return { dx: clamp(dx, box.x, box.width, bounds.width), dy: clamp(dy, box.y, box.height, bounds.height) };
}

/** The element moved by (dx, dy), kept inside the page. */
export function moveElement(el, dx, dy, bounds) {
    const d = clampDelta(el, dx, dy, bounds);
    if (hasPoints(el)) return { ...el, points: el.points.map((p) => ({ x: p.x + d.dx, y: p.y + d.dy })) };
    return { ...el, x: el.x + d.dx, y: el.y + d.dy };
}

/** A copy of `el` with a new id, shifted a little down and right so it doesn't hide the original. */
export function duplicateElement(el, id, bounds) {
    const copy = { ...el, id, ...(hasPoints(el) ? { points: el.points.map((p) => ({ ...p })) } : null) };
    return moveElement(copy, DUPLICATE_OFFSET, DUPLICATE_OFFSET, bounds);
}

/** Index of the next element on the same page in `direction` ('forward' = drawn later, on top). */
function neighbourIndex(list, index, direction) {
    const page = list[index].page;
    const step = direction === 'forward' ? 1 : -1;
    for (let i = index + step; i >= 0 && i < list.length; i += step) {
        if (list[i].page === page) return i;
    }
    return -1;
}

export function canReorder(list, id, direction) {
    const index = list.findIndex((el) => el.id === id);
    return index !== -1 && neighbourIndex(list, index, direction) !== -1;
}

/** Swaps the element with its neighbour on the same page; later in the list is drawn on top. */
export function reorderElement(list, id, direction) {
    const index = list.findIndex((el) => el.id === id);
    if (index === -1) return list;
    const other = neighbourIndex(list, index, direction);
    if (other === -1) return list;
    const next = [...list];
    [next[index], next[other]] = [next[other], next[index]];
    return next;
}

const CURSORS = {
    select: 'default',
    edittext: 'default',
    text: 'text',
    image: 'copy',
    sign: 'copy',
    highlight: 'copy',
    note: 'copy',
    draw: 'crosshair',
    whiteout: 'crosshair',
    shape: 'crosshair',
    underline: 'crosshair',
    strike: 'crosshair',
    link: 'crosshair',
};

/** The page cursor while a tool is active, so it is clear what clicking the page will do. */
export function cursorForMode(mode) {
    return CURSORS[mode] ?? 'default';
}
