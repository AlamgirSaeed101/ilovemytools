// Reading the text that is already in a PDF: runs, fonts and colours (pdf.js data and canvas
// pixels only). Kept apart from pdfTextEdit.js so Edit PDF can show and measure text without
// loading pdf-lib until the edited PDF is saved.

/**
 * Joins pdf.js text items that sit on the same baseline in the same font into editable runs (pdf.js
 * often splits a line into words or chunks). Rotated or skewed text is left out: it can't be
 * replaced in place yet. Items: { str, transform: [a, b, c, d, e, f], width, fontName }.
 */
export function mergeTextItems(items) {
    const runs = [];
    for (const item of items) {
        const [a, b, c, d, x, y] = item.transform;
        if (!item.str || Math.abs(b) > 0.01 || Math.abs(c) > 0.01 || a <= 0 || d <= 0) continue;
        const size = Math.abs(d);
        const prev = runs[runs.length - 1];
        const gap = prev ? x - (prev.x + prev.width) : Infinity;
        if (prev && prev.fontName === item.fontName && Math.abs(prev.y - y) < size * 0.1 && Math.abs(prev.size - size) < 0.1 && gap > -size * 0.3 && gap < size * 0.8) {
            const space = gap > size * 0.15 && !prev.str.endsWith(' ') && !item.str.startsWith(' ') ? ' ' : '';
            prev.str += space + item.str;
            prev.width = x + item.width - prev.x;
        } else {
            runs.push({ str: item.str, x, y, size, width: item.width, fontName: item.fontName });
        }
    }
    return runs.filter((run) => run.str.trim() !== '').map((run) => ({ ...run, str: run.str.replace(/\s+$/, '') }));
}

/** Font style from the PDF font's name (and pdf.js flags): which fallback family, bold, italic. */
export function classifyFont(name = '', { bold, italic } = {}) {
    const n = name.replace(/^[A-Z]{6}\+/, ''); // drop the subset tag, e.g. "ABCDEF+Arial-BoldMT"
    const family = /courier|mono|consol|menlo|code/i.test(n) ? 'mono' : /times|serif|georgia|garamond|cambria|book|minion|palatino|roman/i.test(n) && !/sans/i.test(n) ? 'serif' : 'sans';
    return {
        family,
        bold: Boolean(bold) || /bold|black|heavy|semibold|demi/i.test(n),
        italic: Boolean(italic) || /italic|oblique/i.test(n),
    };
}

/** The PDF-space box (points, bottom-left origin) to cover so the old wording disappears completely. */
export function coverRect(run, ascent = 0.9, descent = -0.25) {
    const pad = run.size * 0.08;
    return {
        x: run.x - pad,
        y: run.y + descent * run.size - pad,
        width: run.width + pad * 2,
        height: (ascent - descent) * run.size + pad * 2,
    };
}

const toHex = ([r, g, b]) => `#${[r, g, b].map((v) => v.toString(16).padStart(2, '0')).join('')}`;
const distance = (p, q) => Math.abs(p[0] - q[0]) + Math.abs(p[1] - q[1]) + Math.abs(p[2] - q[2]);

/**
 * Background and text colour of a run from the rendered pixels: the most common colour along the
 * box's edge is the background, and the colour of the pixels that differ most from it inside the
 * box is the text. `edge` and `inside` are arrays of [r, g, b].
 */
export function sampleRunColors(edge, inside) {
    const counts = new Map();
    for (const px of edge) {
        const key = px.map((v) => Math.round(v / 8) * 8).join(',');
        counts.set(key, (counts.get(key) ?? 0) + 1);
    }
    const bgKey = [...counts.entries()].sort((p, q) => q[1] - p[1])[0]?.[0] ?? '255,255,255';
    const bg = bgKey.split(',').map((v) => Math.min(255, Number(v)));
    const ink = inside.map((px) => ({ px, d: distance(px, bg) })).sort((p, q) => q.d - p.d);
    const top = ink.slice(0, Math.max(1, Math.ceil(ink.length * 0.1))).filter((p) => p.d > 60);
    const color = top.length ? [0, 1, 2].map((i) => Math.round(top.reduce((sum, p) => sum + p.px[i], 0) / top.length)) : [0, 0, 0];
    return { background: toHex(bg), color: toHex(color) };
}

/** Reads the edge and inner pixels of a canvas-space rect and returns sampleRunColors() of them. */
export function colorsFromCanvas(canvas, rect) {
    const ctx = canvas.getContext('2d', { willReadFrequently: true });
    const x = Math.max(0, Math.floor(rect.x));
    const y = Math.max(0, Math.floor(rect.y));
    const w = Math.max(1, Math.min(canvas.width - x, Math.ceil(rect.width)));
    const h = Math.max(1, Math.min(canvas.height - y, Math.ceil(rect.height)));
    const data = ctx.getImageData(x, y, w, h).data;
    const edge = [];
    const inside = [];
    for (let row = 0; row < h; row++) {
        for (let col = 0; col < w; col++) {
            const i = (row * w + col) * 4;
            const px = [data[i], data[i + 1], data[i + 2]];
            (row === 0 || col === 0 || row === h - 1 || col === w - 1 ? edge : inside).push(px);
        }
    }
    return sampleRunColors(edge, inside.length ? inside : edge);
}

/**
 * Every editable text run on a page (1-based `pageNumber`), with its font. The render doc must be
 * loaded with `fontExtraProperties` so the embedded font file stays available for re-use.
 */
export async function extractPageRuns(renderDoc, pageNumber) {
    const page = await renderDoc.getPage(pageNumber);
    await page.getOperatorList(); // loads the page's fonts into commonObjs
    const content = await page.getTextContent();
    return mergeTextItems(content.items).map((run, i) => {
        const font = page.commonObjs.has(run.fontName) ? page.commonObjs.get(run.fontName) : null;
        const style = content.styles[run.fontName] ?? {};
        return {
            ...run,
            id: `${pageNumber}-${i}`,
            ascent: style.ascent || 0.9,
            descent: style.descent || -0.25,
            cssFamily: font?.loadedName ? `"${font.loadedName}", ${style.fontFamily || 'sans-serif'}` : style.fontFamily || 'sans-serif',
            fontData: font?.data ?? null,
            ...classifyFont(font?.name ?? '', { bold: font?.bold, italic: font?.italic }),
        };
    });
}

/** Letters of `text` that a font file can't draw (spaces never count). */
export async function missingGlyphs(fontData, text) {
    if (!fontData) return [...new Set([...text].filter((c) => c.trim()))];
    const { default: fontkit } = await import('@pdf-lib/fontkit');
    let font;
    try {
        font = fontkit.create(fontData instanceof Uint8Array ? fontData : new Uint8Array(fontData));
    } catch {
        return [...new Set([...text].filter((c) => c.trim()))];
    }
    return [...new Set([...text].filter((c) => c.trim() && !font.hasGlyphForCodePoint(c.codePointAt(0))))];
}
