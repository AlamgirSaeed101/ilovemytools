// Pure geometry for Edit PDF's annotations (no pdf-lib), so the editor can snap highlights to
// text and smooth freehand strokes while drawing, before pdf-lib is loaded to save.

/**
 * The QuadPoints of a text markup made by dragging the box `rect` (PDF space: x, y = bottom-left,
 * width, height) across a page whose text runs are `runs` (from extractPageRuns: PDF-space baseline
 * x/y, width, size, ascent, descent, str). Each run the box covers by at least a third of its height
 * gives a quad from the first to the last letter inside the box (letters are estimated as equal
 * widths), spanning the run's full ascent-descent height; touching quads on one line are merged.
 * Returns [[xUL, yUL, xUR, yUR, xLL, yLL, xLR, yLR], ...] from top to bottom, left to right;
 * empty when the box covers no text (a scanned page) so the caller can fall back to a plain box.
 */
export function quadsForRuns(runs, rect) {
    const left = rect.x;
    const right = rect.x + rect.width;
    const bottom = rect.y;
    const top = rect.y + rect.height;
    const boxes = [];
    for (const run of runs ?? []) {
        const len = Math.max(1, (run.str ?? '').length);
        const runTop = run.y + (run.ascent ?? 0.9) * run.size;
        const runBottom = run.y + (run.descent ?? -0.25) * run.size;
        const vertical = Math.min(top, runTop) - Math.max(bottom, runBottom);
        if (vertical < (runTop - runBottom) / 3) continue;
        const lo = Math.max(left, run.x);
        const hi = Math.min(right, run.x + run.width);
        if (hi <= lo) continue;
        const cw = run.width / len;
        const start = run.x + Math.max(0, Math.floor((lo - run.x) / cw + 0.35)) * cw;
        const end = run.x + Math.min(len, Math.ceil((hi - run.x) / cw - 0.35)) * cw;
        if (end - start < cw * 0.5) continue;
        boxes.push({ x0: start, x1: end, y0: runBottom, y1: runTop, size: run.size });
    }
    boxes.sort((a, b) => b.y1 - a.y1 || a.x0 - b.x0);
    const merged = [];
    for (const box of boxes) {
        const prev = merged[merged.length - 1];
        const sameLine = prev && Math.abs(prev.y0 - box.y0) < box.size * 0.3 && Math.abs(prev.y1 - box.y1) < box.size * 0.3;
        if (sameLine && box.x0 - prev.x1 < box.size * 0.8 && box.x1 - prev.x0 > 0) {
            prev.x0 = Math.min(prev.x0, box.x0);
            prev.x1 = Math.max(prev.x1, box.x1);
            prev.y0 = Math.min(prev.y0, box.y0);
            prev.y1 = Math.max(prev.y1, box.y1);
        } else {
            merged.push({ ...box });
        }
    }
    return merged.map(({ x0, x1, y0, y1 }) => [x0, y1, x1, y1, x0, y0, x1, y0]);
}

/** The PDF-space box {x, y, width, height} around a list of quads. */
export function quadsBounds(quads) {
    const xs = quads.flatMap((q) => [q[0], q[2], q[4], q[6]]);
    const ys = quads.flatMap((q) => [q[1], q[3], q[5], q[7]]);
    const x = Math.min(...xs);
    const y = Math.min(...ys);
    return { x, y, width: Math.max(...xs) - x, height: Math.max(...ys) - y };
}

/**
 * A freehand stroke with the jitter taken out: points closer than `minDistance` to the last kept
 * one are dropped, then Chaikin corner-cutting (`iterations` passes) rounds the corners. The first
 * and last points never move, so the line still starts and ends where the pen did.
 */
export function smoothStroke(points, { iterations = 2, minDistance = 1.5 } = {}) {
    if (!points?.length) return [];
    const kept = [points[0]];
    for (let i = 1; i < points.length; i++) {
        const last = kept[kept.length - 1];
        if (Math.hypot(points[i].x - last.x, points[i].y - last.y) >= minDistance || i === points.length - 1) kept.push(points[i]);
    }
    let out = kept.map(({ x, y }) => ({ x, y }));
    for (let n = 0; n < iterations && out.length > 2; n++) {
        const next = [out[0]];
        for (let i = 0; i < out.length - 1; i++) {
            const p = out[i];
            const q = out[i + 1];
            next.push({ x: 0.75 * p.x + 0.25 * q.x, y: 0.75 * p.y + 0.25 * q.y }, { x: 0.25 * p.x + 0.75 * q.x, y: 0.25 * p.y + 0.75 * q.y });
        }
        next.push(out[out.length - 1]);
        out = next;
    }
    return out;
}

/**
 * The segments of a smooth line through `points`: it curves through the midpoints between the
 * samples, so a polyline of pointer samples draws as one smooth stroke. Each segment is
 * { op: 'M' | 'C' | 'L', pts: [{x, y}, ...] } (C has two control points and an end point).
 */
export function strokeSegments(points) {
    if (!points?.length) return [];
    const [first] = points;
    if (points.length <= 2) return [{ op: 'M', pts: [first] }, { op: 'L', pts: [points[points.length - 1]] }];
    const segments = [{ op: 'M', pts: [first] }];
    let current = first;
    for (let i = 1; i < points.length - 1; i++) {
        const ctrl = points[i];
        const end = { x: (ctrl.x + points[i + 1].x) / 2, y: (ctrl.y + points[i + 1].y) / 2 };
        const c1 = { x: current.x + (2 / 3) * (ctrl.x - current.x), y: current.y + (2 / 3) * (ctrl.y - current.y) };
        const c2 = { x: end.x + (2 / 3) * (ctrl.x - end.x), y: end.y + (2 / 3) * (ctrl.y - end.y) };
        segments.push({ op: 'C', pts: [c1, c2, end] });
        current = end;
    }
    segments.push({ op: 'L', pts: [points[points.length - 1]] });
    return segments;
}

const PDF_OPS = { M: 'm', C: 'c', L: 'l' };

/** PDF path operators (m / c / l) for strokeSegments(points); `fmt` formats each number. */
export function strokeToPath(points, fmt = String) {
    return strokeSegments(points)
        .map(({ op, pts }) => `${pts.map((p) => `${fmt(p.x)} ${fmt(p.y)}`).join(' ')} ${PDF_OPS[op]}`)
        .join(' ');
}

/** The same smooth line as an SVG `d` attribute (screen space), to preview a stroke. */
export function strokeToSvgPath(points) {
    const r = (v) => Math.round(v * 10) / 10;
    return strokeSegments(points)
        .map(({ op, pts }) => `${op}${pts.map((p) => `${r(p.x)} ${r(p.y)}`).join(' ')}`)
        .join(' ');
}
