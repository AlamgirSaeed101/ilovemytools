// How Edit PDF shows a page that the page panel rotated: the stage keeps its unrotated layout
// (so every element stays in the page's own coordinates, exactly as it will be drawn into the
// PDF) and is turned with a CSS transform. These pure helpers size the box around it and map a
// pointer back from the screen to the page's own coordinates.

const quarterTurns = (rotation) => ((((rotation || 0) % 360) + 360) % 360) / 90;

/** Whether a rotation turns the page on its side (90 or 270 degrees). */
export function isSideways(rotation) {
    return quarterTurns(rotation) % 2 === 1;
}

/** The on-screen size of a `width` x `height` page after `rotation` and `zoom`. */
export function viewSize(width, height, rotation = 0, zoom = 1) {
    return isSideways(rotation) ? { width: height * zoom, height: width * zoom } : { width: width * zoom, height: height * zoom };
}

/**
 * The CSS transform (with transform-origin top left) that zooms and rotates a `width` x `height`
 * stage so it exactly fills its viewSize() box. Undefined when there is nothing to transform.
 */
export function stageTransform(width, height, rotation = 0, zoom = 1) {
    const turns = quarterTurns(rotation);
    if (!turns) return zoom !== 1 ? `scale(${zoom})` : undefined;
    const box = viewSize(width, height, rotation, zoom);
    return `translate(${box.width / 2}px, ${box.height / 2}px) rotate(${turns * 90}deg) scale(${zoom}) translate(${-width / 2}px, ${-height / 2}px)`;
}

/**
 * Maps a pointer at (`clientX`, `clientY`) to the page's own (unrotated, unzoomed) coordinates.
 * `rect` is the stage's getBoundingClientRect() (already rotated and zoomed), `natural` its
 * unzoomed { width, height }, `rotation` the extra clockwise rotation it is shown at.
 */
export function pointerToPage(clientX, clientY, rect, natural, rotation = 0) {
    const sideways = isSideways(rotation);
    const zoom = rect.width / (sideways ? natural.height : natural.width) || 1;
    const vx = clientX - (rect.left + rect.width / 2);
    const vy = clientY - (rect.top + rect.height / 2);
    const rad = (quarterTurns(rotation) * Math.PI) / 2;
    const cos = Math.round(Math.cos(rad));
    const sin = Math.round(Math.sin(rad));
    // Undo the clockwise screen rotation (y points down), then the zoom.
    const x = (vx * cos + vy * sin) / zoom;
    const y = (-vx * sin + vy * cos) / zoom;
    return { x: natural.width / 2 + x, y: natural.height / 2 + y };
}
