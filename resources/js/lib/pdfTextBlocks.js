// Paragraph blocks for Edit PDF's in-place text editing. pdf.js gives one run per line (see
// pdfTextRuns.mergeTextItems); lines that sit under each other in the same font, size and left edge
// (or centre / right edge) form one block, so clicking a paragraph edits it as a whole. The same
// line-breaking (wrapLines) lays the text out on screen and in the saved PDF, so they match.
// Pure geometry and text only: no pdf-lib, no DOM.
import { coverRect } from './pdfTextRuns.js';
import { pdfRectToCanvasRect } from './pdfOverlay.js';

export const DEFAULT_LINE_HEIGHT = 1.2;
const DEFAULT_ASCENT = 0.9;
const DEFAULT_DESCENT = -0.25;

const left = (run) => run.x;
const right = (run) => run.x + run.width;
const centre = (run) => run.x + run.width / 2;

/** Runs that share their baseline with another run close by: a line mixing fonts (a bold word, a link). */
function crowdedRuns(runs) {
    const crowded = new Set();
    for (const a of runs) {
        for (const b of runs) {
            if (a === b || Math.abs(a.y - b.y) > a.size * 0.2) continue;
            const gap = Math.max(b.x - right(a), a.x - right(b));
            if (gap < a.size * 3) crowded.add(a);
        }
    }
    return crowded;
}

function canJoin(block, run) {
    const last = block.runs[block.runs.length - 1];
    const size = last.size;
    if (block.closed || last.fontName !== run.fontName || Math.abs(last.size - run.size) > size * 0.05) return false;
    const gap = last.y - run.y;
    if (gap < size * 0.9 || gap > size * 2.2) return false;
    if (block.runs.length >= 2) {
        const first = block.runs[0].y - block.runs[1].y;
        if (Math.abs(gap - first) > size * 0.15) return false;
    }
    const tol = size * 0.6;
    return Math.abs(left(last) - left(run)) <= tol || Math.abs(right(last) - right(run)) <= tol || Math.abs(centre(last) - centre(run)) <= tol;
}

function blockAlign(runs) {
    if (runs.length < 2) return 'left';
    const tol = runs[0].size * 0.5;
    const same = (fn) => runs.every((run) => Math.abs(fn(run) - fn(runs[0])) <= tol);
    if (same(left)) return 'left';
    if (same(right)) return 'right';
    if (same(centre)) return 'center';
    return 'left';
}

/**
 * The block's text: lines that were wrapped only because the next word didn't fit join with a
 * space (so an edit re-wraps them); lines that end early (an address, a list) keep a line break.
 */
function blockText(runs, width) {
    let text = runs[0].str;
    for (let i = 1; i < runs.length; i++) {
        const prev = runs[i - 1];
        const next = runs[i].str.trimStart();
        const nextWord = next.split(/\s+/)[0] ?? '';
        const charWidth = prev.width / Math.max(1, prev.str.length);
        const soft = prev.width + charWidth * (1 + nextWord.length) > width + prev.size * 0.1;
        if (!soft) text += '\n' + next;
        else if (/[A-Za-zÀ-ɏ]-$/.test(prev.str)) text += next; // a word hyphenated across the lines
        else text += ' ' + next;
    }
    return text;
}

/**
 * Groups runs (pdfTextRuns.extractPageRuns) into paragraph blocks:
 * { id, runs, text, x, y (first baseline), width, size, lineHeight, align, ...the first run's font fields }.
 * Every run ends up in exactly one block; a run alone is a one-line block.
 */
export function groupRunsIntoBlocks(runs) {
    const crowded = crowdedRuns(runs);
    const sorted = [...runs].sort((a, b) => b.y - a.y || a.x - b.x);
    const blocks = [];
    for (const run of sorted) {
        if (crowded.has(run)) {
            blocks.push({ runs: [run], closed: true });
            continue;
        }
        const candidates = blocks.filter((block) => canJoin(block, run));
        const target = candidates.sort((a, b) => a.runs[a.runs.length - 1].y - b.runs[b.runs.length - 1].y)[0];
        if (target) target.runs.push(run);
        else blocks.push({ runs: [run] });
    }
    return blocks.map(({ runs: lines }) => {
        const first = lines[0];
        const x = Math.min(...lines.map(left));
        const width = Math.max(...lines.map(right)) - x;
        const lineHeight = lines.length > 1 ? (first.y - lines[lines.length - 1].y) / (lines.length - 1) / first.size : null;
        const text = blockText(lines, width);
        return {
            ...first,
            id: first.id,
            runs: lines,
            text,
            str: text,
            x,
            y: first.y,
            width,
            lineHeight,
            align: blockAlign(lines),
        };
    });
}

/**
 * Breaks `text` into lines no wider than `maxWidth`. `font` is a pdf-lib font (measured with
 * widthOfTextAtSize(…, size)) or a function (str) => width. Line breaks in the text are kept; a
 * missing or infinite `maxWidth` only splits on them. Words wider than a line are split.
 */
export function wrapLines(text, font, size, maxWidth) {
    const measure = typeof font === 'function' ? font : (s) => font.widthOfTextAtSize(s, size);
    const paragraphs = String(text ?? '').split(/\r?\n/);
    if (!maxWidth || !Number.isFinite(maxWidth)) return paragraphs;
    const fits = (s) => measure(s) <= maxWidth + 0.01;
    const lines = [];
    for (const paragraph of paragraphs) {
        let line = '';
        const words = paragraph.split(' ');
        for (let i = 0; i < words.length; i++) {
            let word = words[i];
            const candidate = i === 0 ? word : `${line} ${word}`;
            if (fits(candidate)) {
                line = candidate;
                continue;
            }
            // Break after a hyphen inside the word when its first part still fits on this line.
            let cut = line ? word.lastIndexOf('-', word.length - 2) : -1;
            while (cut > 0 && !fits(`${line} ${word.slice(0, cut + 1)}`)) cut = word.lastIndexOf('-', cut - 1);
            if (cut > 0) {
                lines.push(`${line} ${word.slice(0, cut + 1)}`);
                word = word.slice(cut + 1);
            } else if (line) {
                lines.push(line);
            }
            line = '';
            // A word longer than a whole line is split letter by letter.
            while (word && !fits(word)) {
                let n = 1;
                while (n < word.length && fits(word.slice(0, n + 1))) n++;
                lines.push(word.slice(0, n));
                word = word.slice(n);
            }
            line = word;
        }
        lines.push(line);
    }
    return lines;
}

/** One PDF-space cover rect per line of the block, so its old wording can be hidden line by line. */
export function blockCoverRects(block) {
    return (block.runs ?? [block]).map((run) => coverRect(run, run.ascent ?? DEFAULT_ASCENT, run.descent ?? DEFAULT_DESCENT));
}

/** The canvas-space (px) box around every line of a block: the click target that opens it for editing. */
export function blockCanvasRect(block, scale, pageHeight) {
    const rects = blockCoverRects(block).map((rect) => pdfRectToCanvasRect(rect, scale, pageHeight));
    const x = Math.min(...rects.map((r) => r.x));
    const y = Math.min(...rects.map((r) => r.y));
    return { x, y, width: Math.max(...rects.map((r) => r.x + r.width)) - x, height: Math.max(...rects.map((r) => r.y + r.height)) - y };
}

/**
 * How far below the box top the first baseline sits, as a fraction of the font size. It matches
 * CSS: a line box of `lineHeight` puts half of the spare room above the font's ascent.
 */
export function baselineOffset(lineHeight = DEFAULT_LINE_HEIGHT, ascent = DEFAULT_ASCENT, descent = DEFAULT_DESCENT) {
    return (lineHeight - (ascent - descent)) / 2 + ascent;
}

/** Ascent/descent of a text element's font (the run's own for an edit, defaults for added text). */
function metrics(el) {
    return { ascent: el.run?.ascent ?? DEFAULT_ASCENT, descent: el.run?.descent ?? DEFAULT_DESCENT };
}

/**
 * The fields of a 'textedit' element (canvas px, top-left origin) that edits `block` in place.
 * One-line blocks grow as you type (maxWidth null); paragraphs wrap at their original width.
 */
export function textEditElement(block, { scale, pageHeight, colors = {} }) {
    const lineHeight = block.lineHeight ?? DEFAULT_LINE_HEIGHT;
    const { ascent = DEFAULT_ASCENT, descent = DEFAULT_DESCENT } = block;
    const top = block.y + baselineOffset(lineHeight, ascent, descent) * block.size;
    const lines = block.runs?.length ?? 1;
    const width = block.width * scale;
    return {
        type: 'textedit',
        run: block.runs?.[0] ?? block,
        runs: block.runs ?? [block],
        text: block.text ?? block.str,
        size: block.size,
        color: colors.color ?? '#000000',
        background: colors.background ?? '#ffffff',
        family: block.fontData ? 'original' : block.family ?? 'sans',
        bold: Boolean(block.bold),
        italic: Boolean(block.italic),
        align: block.align ?? 'left',
        lineHeight,
        maxWidth: lines > 1 ? width : null,
        covers: blockCoverRects(block).map((rect) => pdfRectToCanvasRect(rect, scale, pageHeight)),
        x: block.x * scale,
        y: (pageHeight - top) * scale,
        width,
        height: lines * lineHeight * block.size * scale,
    };
}

/** Whether an edit is drawn in the PDF's own font (not changed away from it, and the font is available). */
export function usesOwnFont(el) {
    if (el.type !== 'textedit' || !el.run?.fontData || el.fallback) return false;
    if ((el.family ?? 'original') !== 'original') return false;
    return (el.bold ?? Boolean(el.run.bold)) === Boolean(el.run.bold) && (el.italic ?? Boolean(el.run.italic)) === Boolean(el.run.italic);
}

/** Whether bold/italic were switched away from the original font's own style (so a similar font is used). */
export function styleChangedFromOriginal(el) {
    if (el.type !== 'textedit' || (el.family ?? 'original') !== 'original') return false;
    return (el.bold ?? Boolean(el.run.bold)) !== Boolean(el.run.bold) || (el.italic ?? Boolean(el.run.italic)) !== Boolean(el.run.italic);
}

/**
 * A 'text' or 'textedit' element (canvas px) as buildEditedPdf() takes it (PDF points):
 * x = left edge, y = first baseline, maxWidth = wrap width (null: no wrapping), box = the text box.
 */
export function textElementToPdf(el, scale, pageHeight) {
    const lineHeight = el.lineHeight ?? DEFAULT_LINE_HEIGHT;
    const base = {
        type: el.type,
        page: el.page,
        text: el.text,
        size: el.size,
        color: el.color,
        family: el.family ?? (el.type === 'text' ? 'sans' : 'original'),
        bold: el.bold ?? (el.type === 'textedit' ? Boolean(el.run?.bold) : false),
        italic: el.italic ?? (el.type === 'textedit' ? Boolean(el.run?.italic) : false),
        align: el.align ?? 'left',
        lineHeight,
        rotation: el.rotation ?? 0,
    };
    if (el.type === 'textedit') {
        Object.assign(base, { run: el.run, runs: el.runs ?? [el.run], background: el.background });
        // Saved before blocks existed: one line, drawn on the run's own baseline.
        if (!el.runs) return { ...base, x: el.run.x, y: el.run.y, maxWidth: null, box: null };
    }
    const { ascent, descent } = metrics(el);
    const top = pageHeight - el.y / scale;
    const width = el.width / scale;
    const height = el.height / scale;
    return {
        ...base,
        x: el.x / scale,
        y: top - baselineOffset(lineHeight, ascent, descent) * el.size,
        maxWidth: el.maxWidth ? el.maxWidth / scale : null,
        box: { x: el.x / scale, y: top - height, width, height },
    };
}

/**
 * Where each line of a laid-out text goes (PDF points): [{ text, x, y }] with alignment inside the
 * wrap width (or the widest line when the text doesn't wrap). `measure(str)` returns a line's width.
 */
export function layoutTextLines({ text, x, y, size, maxWidth, align = 'left', lineHeight = DEFAULT_LINE_HEIGHT }, measure) {
    const lines = wrapLines(text, measure, size, maxWidth);
    const widths = lines.map((line) => measure(line));
    const boxWidth = maxWidth && Number.isFinite(maxWidth) ? maxWidth : Math.max(0, ...widths);
    return lines.map((line, i) => {
        const free = Math.max(0, boxWidth - widths[i]);
        const dx = align === 'center' ? free / 2 : align === 'right' ? free : 0;
        return { text: line, x: x + dx, y: y - i * lineHeight * size, width: widths[i] };
    });
}
