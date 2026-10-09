// Pure geometry shared by the PDF tools that let visitors place or draw things on top of a
// pdf.js page preview (Sign / Redact / Edit PDF). The preview renders a page at `scale` CSS
// pixels per PDF point, top-left origin; PDF coordinates are points, bottom-left origin.

/** Scale (CSS px per PDF point) that fits a page inside a container, capped at 2x. */
export function computeDisplayScale(pageWidth, pageHeight, maxWidth = 700, maxHeight = 900) {
    if (pageWidth <= 0 || pageHeight <= 0) return 1;
    return Math.min(maxWidth / pageWidth, maxHeight / pageHeight, 2);
}

/** A canvas-space rect {x, y, width, height} (top-left origin, px) -> a PDF-space rect (points, bottom-left origin). */
export function canvasRectToPdfRect(rect, scale, pageHeight) {
    const width = rect.width / scale;
    const height = rect.height / scale;
    const x = rect.x / scale;
    const y = pageHeight - rect.y / scale - height;
    return { x, y, width, height };
}

/** The inverse of canvasRectToPdfRect. */
export function pdfRectToCanvasRect(rect, scale, pageHeight) {
    const width = rect.width * scale;
    const height = rect.height * scale;
    const x = rect.x * scale;
    const y = (pageHeight - rect.y - rect.height) * scale;
    return { x, y, width, height };
}

/** Keeps a rect fully inside a `containerWidth` x `containerHeight` box, with a minimum size. */
export function clampRect(rect, containerWidth, containerHeight, minSize = 16) {
    const width = Math.min(Math.max(minSize, rect.width), containerWidth);
    const height = Math.min(Math.max(minSize, rect.height), containerHeight);
    const x = Math.min(Math.max(0, rect.x), Math.max(0, containerWidth - width));
    const y = Math.min(Math.max(0, rect.y), Math.max(0, containerHeight - height));
    return { x, y, width, height };
}

/** Turns two drag points (in the same space) into a normalised rect with non-negative width/height. */
export function rectFromPoints(x0, y0, x1, y1) {
    return { x: Math.min(x0, x1), y: Math.min(y0, y1), width: Math.abs(x1 - x0), height: Math.abs(y1 - y0) };
}

/** '#rrggbb' -> {r, g, b} each 0-1, for pdf-lib's rgb(). Invalid input falls back to black. */
export function hexToRgb01(hex) {
    const m = /^#?([0-9a-f]{6})$/i.exec(hex || '');
    const int = parseInt(m ? m[1] : '000000', 16);
    return { r: ((int >> 16) & 255) / 255, g: ((int >> 8) & 255) / 255, b: (int & 255) / 255 };
}
