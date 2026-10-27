// Edit PDF's pure geometry and input helpers. Kept apart from pdfEdit.js so the editor can use
// them while drawing the screen without loading pdf-lib (~165 KB) until a PDF is actually saved.

/** Canvas-space {x,y} points of a freehand stroke -> PDF-space points (points, bottom-left origin). */
export function pointsToPdf(points, scale, pageHeight) {
    return points.map(({ x, y }) => ({ x: x / scale, y: pageHeight - y / scale }));
}

/** Pure: removes the most recently added element (undo is just "drop the last one"). */
export function undoLast(elements) {
    return elements.slice(0, -1);
}

/** Canvas-space bounding box of a freehand stroke's points, used to place its drag handle and remove button. */
export function strokeBoundingBox(points) {
    if (points.length === 0) return { x: 0, y: 0, width: 1, height: 1 };
    const xs = points.map((p) => p.x);
    const ys = points.map((p) => p.y);
    const x = Math.min(...xs);
    const y = Math.min(...ys);
    return { x, y, width: Math.max(1, Math.max(...xs) - x), height: Math.max(1, Math.max(...ys) - y) };
}

/**
 * A link address people typed -> an absolute http(s) or mailto URL, or null when it isn't one.
 * "example.com/page" gets https:// added; other schemes (javascript:, file:...) are refused.
 */
export function normalizeLinkUrl(input) {
    const value = String(input ?? '').trim();
    if (!value || /\s/.test(value)) return null;
    if (/^mailto:[^@\s]+@[^@\s]+\.[^@\s]+$/i.test(value)) return value;
    const withScheme = /^[a-z][a-z0-9+.-]*:/i.test(value) ? value : `https://${value}`;
    try {
        const url = new URL(withScheme);
        return ['http:', 'https:'].includes(url.protocol) && url.hostname.includes('.') ? url.href : null;
    } catch {
        return null;
    }
}

/** The two short lines of an arrowhead at `end`, pointing away from `start` (any coordinate space). */
export function arrowHeadLines(start, end, size) {
    const angle = Math.atan2(end.y - start.y, end.x - start.x);
    const spread = Math.PI / 7;
    return [angle + Math.PI - spread, angle + Math.PI + spread].map((a) => ({
        start: end,
        end: { x: end.x + size * Math.cos(a), y: end.y + size * Math.sin(a) },
    }));
}

/** Y (PDF space) of an underline or strikethrough across a text box whose bottom is `y` and height `height`. */
export function markupLineY(kind, y, height) {
    return kind === 'strike' ? y + height * 0.45 : y + height * 0.08;
}

/**
 * The clockwise angle (0-359, screen degrees) from `center` up to `point`, for a rotate handle
 * that starts directly above the element: dragging it to `point` rotates the element to match.
 */
export function angleFromCenter(center, point) {
    const deg = (Math.atan2(point.x - center.x, center.y - point.y) * 180) / Math.PI;
    return ((deg % 360) + 360) % 360;
}

/**
 * The bottom-left `x, y` (and matching pdf-lib `rotate` degrees) to pass to a corner-anchored
 * pdf-lib draw call (drawRectangle, drawImage, drawText) so a `width` x `height` box rotates
 * around its own centre (`cx`, `cy`) instead of around that corner. `rotationDeg` is the
 * on-screen clockwise angle (as CSS `rotate()` uses it); pdf-lib's rotation is counter-clockwise
 * in PDF's bottom-left, y-up space, so the sign is flipped before use.
 */
export function rotatedBoxOrigin(cx, cy, width, height, rotationDeg) {
    const rotateDeg = rotationDeg ? -rotationDeg : 0;
    const rad = (rotateDeg * Math.PI) / 180;
    const cos = Math.cos(rad);
    const sin = Math.sin(rad);
    const hw = width / 2;
    const hh = height / 2;
    return { x: cx - (hw * cos - hh * sin), y: cy - (hw * sin + hh * cos), rotateDeg };
}
