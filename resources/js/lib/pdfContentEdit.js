// Removes the original text of an edited run from a page's content stream, so the old wording is
// really gone (not just covered): it can't be found, selected or copied afterwards. The stream is
// tokenized, the text state (CTM, text matrix, font, spacing) is followed operator by operator, and
// every text-showing operator that starts on the run's baseline inside its span is replaced by a
// pure move of the same width ("[n] TJ"), so text drawn after it on the line stays where it was.
import { decodePDFRawStream, PDFArray, PDFDict, PDFName, PDFRawStream, PDFRef } from 'pdf-lib';

const WHITE = new Set([0, 9, 10, 12, 13, 32]);
const DELIM = new Set([40, 41, 60, 62, 91, 93, 123, 125, 47, 37]);
const isRegular = (c) => !WHITE.has(c) && !DELIM.has(c);

/**
 * Tokenizes a content stream: { type: 'num'|'name'|'str'|'[', ']'|'<<'|'>>'|'op'|'bool'|'null', value, start, end }.
 * Inline images (BI ... ID <binary> EI) are skipped as one 'op' token so their bytes are never parsed.
 */
export function tokenize(bytes) {
    const tokens = [];
    let i = 0;
    const n = bytes.length;
    while (i < n) {
        const c = bytes[i];
        if (WHITE.has(c)) {
            i++;
        } else if (c === 37) {
            while (i < n && bytes[i] !== 10 && bytes[i] !== 13) i++;
        } else if (c === 40) {
            const start = i;
            const out = [];
            let depth = 1;
            i++;
            while (i < n && depth > 0) {
                const ch = bytes[i];
                if (ch === 92) {
                    const next = bytes[i + 1];
                    const map = { 110: 10, 114: 13, 116: 9, 98: 8, 102: 12, 40: 40, 41: 41, 92: 92 };
                    if (next in map) {
                        out.push(map[next]);
                        i += 2;
                    } else if (next >= 48 && next <= 55) {
                        let oct = 0;
                        let k = 0;
                        i++;
                        while (k < 3 && bytes[i] >= 48 && bytes[i] <= 55) {
                            oct = oct * 8 + (bytes[i] - 48);
                            i++;
                            k++;
                        }
                        out.push(oct & 255);
                    } else if (next === 13 || next === 10) {
                        i += next === 13 && bytes[i + 2] === 10 ? 3 : 2;
                    } else {
                        i++;
                    }
                } else {
                    if (ch === 40) depth++;
                    if (ch === 41) depth--;
                    if (depth > 0) out.push(ch);
                    i++;
                }
            }
            tokens.push({ type: 'str', value: Uint8Array.from(out), start, end: i });
        } else if (c === 60 && bytes[i + 1] === 60) {
            tokens.push({ type: '<<', start: i, end: i + 2 });
            i += 2;
        } else if (c === 62 && bytes[i + 1] === 62) {
            tokens.push({ type: '>>', start: i, end: i + 2 });
            i += 2;
        } else if (c === 60) {
            const start = i;
            let hex = '';
            i++;
            while (i < n && bytes[i] !== 62) {
                if (!WHITE.has(bytes[i])) hex += String.fromCharCode(bytes[i]);
                i++;
            }
            i++;
            if (hex.length % 2) hex += '0';
            tokens.push({ type: 'str', value: Uint8Array.from(hex.match(/../g) ?? [], (h) => parseInt(h, 16)), start, end: i });
        } else if (c === 91 || c === 93) {
            tokens.push({ type: c === 91 ? '[' : ']', start: i, end: i + 1 });
            i++;
        } else if (c === 47) {
            const start = i;
            i++;
            while (i < n && isRegular(bytes[i])) i++;
            tokens.push({ type: 'name', value: new TextDecoder('latin1').decode(bytes.subarray(start + 1, i)), start, end: i });
        } else {
            const start = i;
            while (i < n && isRegular(bytes[i])) i++;
            if (i === start) {
                i++; // a stray delimiter ({, }, ) ...): skip it
                continue;
            }
            const word = new TextDecoder('latin1').decode(bytes.subarray(start, i));
            if (/^[+-]?(\d+\.?\d*|\.\d+)$/.test(word)) tokens.push({ type: 'num', value: Number(word), start, end: i });
            else if (word === 'true' || word === 'false') tokens.push({ type: 'bool', value: word === 'true', start, end: i });
            else if (word === 'null') tokens.push({ type: 'null', start, end: i });
            else if (word === 'BI') {
                // Inline image: skip to "EI" that follows whitespace and is followed by whitespace or the end.
                let j = i;
                while (j < n && !(bytes[j - 1] !== undefined && WHITE.has(bytes[j - 1]) && bytes[j] === 69 && bytes[j + 1] === 73 && (j + 2 >= n || WHITE.has(bytes[j + 2]) || DELIM.has(bytes[j + 2])))) j++;
                i = Math.min(n, j + 2);
                tokens.push({ type: 'op', value: 'BI', start, end: i });
            } else tokens.push({ type: 'op', value: word, start, end: i });
        }
    }
    return tokens;
}

const mul = (a, b) => [
    a[0] * b[0] + a[1] * b[2],
    a[0] * b[1] + a[1] * b[3],
    a[2] * b[0] + a[3] * b[2],
    a[2] * b[1] + a[3] * b[3],
    a[4] * b[0] + a[5] * b[2] + b[4],
    a[4] * b[1] + a[5] * b[3] + b[5],
];
const IDENTITY = [1, 0, 0, 1, 0, 0];

/** Glyph widths (1/1000 text space) of a page font from its PDF dictionary; null when unknown. */
export function fontWidths(fontDict, context) {
    const get = (dict, key) => {
        const v = dict.get(PDFName.of(key));
        return v instanceof PDFRef ? context.lookup(v) : v;
    };
    const subtype = get(fontDict, 'Subtype')?.toString();
    if (subtype === '/Type0') {
        const encoding = get(fontDict, 'Encoding')?.toString();
        if (encoding !== '/Identity-H' && encoding !== '/Identity-V') return null;
        const descendant = get(fontDict, 'DescendantFonts');
        const cid = descendant instanceof PDFArray ? context.lookup(descendant.get(0)) : null;
        if (!(cid instanceof PDFDict)) return null;
        const dw = get(cid, 'DW')?.asNumber?.() ?? 1000;
        const table = new Map();
        const w = get(cid, 'W');
        if (w instanceof PDFArray) {
            const items = w.asArray().map((x) => (x instanceof PDFRef ? context.lookup(x) : x));
            for (let k = 0; k < items.length; ) {
                const first = items[k].asNumber();
                const next = items[k + 1];
                if (next instanceof PDFArray) {
                    next.asArray().forEach((width, j) => table.set(first + j, (width instanceof PDFRef ? context.lookup(width) : width).asNumber()));
                    k += 2;
                } else {
                    const last = next.asNumber();
                    const width = items[k + 2].asNumber();
                    for (let code = first; code <= last; code++) table.set(code, width);
                    k += 3;
                }
            }
        }
        return { bytesPerCode: 2, width: (code) => table.get(code) ?? dw };
    }
    const widths = get(fontDict, 'Widths');
    if (!(widths instanceof PDFArray)) return null;
    const firstChar = get(fontDict, 'FirstChar')?.asNumber?.() ?? 0;
    const list = widths.asArray().map((x) => (x instanceof PDFRef ? context.lookup(x) : x).asNumber());
    const descriptor = get(fontDict, 'FontDescriptor');
    const missing = descriptor instanceof PDFDict ? get(descriptor, 'MissingWidth')?.asNumber?.() ?? 0 : 0;
    return { bytesPerCode: 1, width: (code) => list[code - firstChar] ?? missing };
}

/**
 * Walks the tokens and returns every text-showing operator with its user-space start point,
 * the font resource and size in effect, and (when the font's widths are known) its advance.
 */
export function textShowOps(tokens, fontInfo) {
    const ops = [];
    const stack = [];
    let ctm = IDENTITY;
    let tm = IDENTITY;
    let tlm = IDENTITY;
    let font = null;
    let size = 0;
    let tc = 0;
    let tw = 0;
    let th = 1;
    let tl = 0;
    let rise = 0;
    let operands = [];
    let operandStart = null;
    const containers = [];

    const advance = (bytes) => {
        const info = fontInfo(font);
        if (!info) return null;
        let total = 0;
        for (let k = 0; k + info.bytesPerCode <= bytes.length; k += info.bytesPerCode) {
            const code = info.bytesPerCode === 2 ? (bytes[k] << 8) | bytes[k + 1] : bytes[k];
            total += (info.width(code) / 1000) * size + tc + (info.bytesPerCode === 1 && code === 32 ? tw : 0);
        }
        return total * th;
    };
    const show = (opStart, opEnd, parts, kind) => {
        const trm = mul([size * th, 0, 0, size, 0, rise], mul(tm, ctm));
        let tx = 0;
        let known = true;
        for (const part of parts) {
            if (typeof part === 'number') tx += (-part / 1000) * size * th;
            else {
                const a = advance(part);
                if (a === null) known = false;
                else tx += a;
            }
        }
        const userWidth = known ? tx * Math.hypot(...mul(tm, ctm).slice(0, 2)) : null;
        ops.push({ start: opStart, end: opEnd, kind, x: trm[4], y: trm[5], font, size, advance: known ? tx : null, userWidth, inBT: true });
        if (known) tm = mul([1, 0, 0, 1, tx, 0], tm);
        else tm = null; // position unknown until the next explicit Td/Tm
    };

    for (let i = 0; i < tokens.length; i++) {
        const t = tokens[i];
        if (t.type !== 'op') {
            if (operandStart === null) operandStart = t.start;
            if (t.type === '[' || t.type === '<<') containers.push([]);
            else if (t.type === ']' || t.type === '>>') {
                const done = containers.pop() ?? [];
                (containers.length ? containers[containers.length - 1] : operands).push(done);
            } else {
                const v = t.type === 'num' || t.type === 'str' || t.type === 'name' ? t.value : null;
                (containers.length ? containers[containers.length - 1] : operands).push(v);
            }
            continue;
        }
        const op = t.value;
        const args = operands;
        const opStart = operandStart ?? t.start;
        operands = [];
        operandStart = null;
        containers.length = 0;
        switch (op) {
            case 'q':
                stack.push(ctm);
                break;
            case 'Q':
                ctm = stack.pop() ?? IDENTITY;
                break;
            case 'cm':
                if (args.length === 6) ctm = mul(args, ctm);
                break;
            case 'BT':
                tm = tlm = IDENTITY;
                break;
            case 'Tf':
                font = args[0];
                size = args[1];
                break;
            case 'Tc':
                tc = args[0];
                break;
            case 'Tw':
                tw = args[0];
                break;
            case 'Tz':
                th = args[0] / 100;
                break;
            case 'TL':
                tl = args[0];
                break;
            case 'Ts':
                rise = args[0];
                break;
            case 'Td':
            case 'TD':
                if (op === 'TD') tl = -args[1];
                tlm = mul([1, 0, 0, 1, args[0], args[1]], tlm ?? IDENTITY);
                tm = tlm;
                break;
            case 'Tm':
                tm = tlm = args.slice(0, 6);
                break;
            case 'T*':
                tlm = mul([1, 0, 0, 1, 0, -tl], tlm ?? IDENTITY);
                tm = tlm;
                break;
            case 'Tj':
            case 'TJ':
                if (tm) show(opStart, t.end, op === 'Tj' ? [args[0]] : Array.isArray(args[0]) ? args[0] : [], op);
                else ops.push({ start: opStart, end: t.end, kind: op, x: null, y: null, advance: null, userWidth: null });
                break;
            case "'":
            case '"':
                if (op === '"') {
                    tw = args[0];
                    tc = args[1];
                }
                tlm = mul([1, 0, 0, 1, 0, -tl], tlm ?? IDENTITY);
                tm = tlm;
                show(opStart, t.end, [args[args.length - 1]], op);
                break;
            default:
                break;
        }
    }
    return ops;
}

/** Whether a text operator lies on `run`'s baseline and entirely inside its span (user space). */
export function opBelongsToRun(op, run) {
    const tol = run.size * 0.35;
    if (Math.abs(op.y - run.y) > tol) return false;
    if (op.x < run.x - tol || op.x > run.x + run.width) return false;
    return op.userWidth === null || op.x + op.userWidth <= run.x + run.width + tol;
}

/** The bytes that replace a removed text operator: the same move, with nothing drawn. */
export function replacementFor(op, size, th = 1) {
    const move = op.advance && size ? Number(((-op.advance * 1000) / (size * th)).toFixed(3)) : 0;
    const tj = `[${move}] TJ`;
    return op.kind === "'" ? `T* ${tj}` : op.kind === '"' ? `T* ${tj}` : tj;
}

/**
 * Removes the text drawn by `runs` (pdf.js runs on page `pageIndex`) from that page's content.
 * Returns the ids of the runs whose every operator was removed; the others should be covered instead.
 */
/** The page's content streams as an array (a single stream is wrapped in one). */
export function pageContents(page, context) {
    let contents = page.node.Contents();
    if (!(contents instanceof PDFArray)) {
        contents = context.obj([page.node.get(PDFName.of('Contents'))]);
        page.node.set(PDFName.of('Contents'), contents);
    }
    return contents;
}

/** Decoded bytes of one content stream: a stream read from the file, or one pdf-lib created. */
export function streamBytes(stream) {
    if (stream instanceof PDFRawStream) return decodePDFRawStream(stream).decode();
    return typeof stream?.getUnencodedContents === 'function' ? stream.getUnencodedContents() : null;
}

export function removeRunsFromPage(doc, pageIndex, runs) {
    const page = doc.getPage(pageIndex);
    const context = doc.context;
    page.node.normalizedEntries(); // let pdf-lib add its q/Q wrapper streams first, as it would when drawing
    const contents = pageContents(page, context);
    const chunks = [];
    for (const ref of contents.asArray()) {
        const bytes = streamBytes(context.lookup(ref));
        if (!bytes) return new Set();
        chunks.push(bytes);
    }
    const total = chunks.reduce((sum, c) => sum + c.length + 1, 0);
    const bytes = new Uint8Array(total);
    let offset = 0;
    for (const c of chunks) {
        bytes.set(c, offset);
        bytes[offset + c.length] = 10; // streams are concatenated with whitespace between them
        offset += c.length + 1;
    }

    const fonts = page.node.Resources()?.lookup(PDFName.of('Font'));
    const cache = new Map();
    const fontInfo = (name) => {
        if (!cache.has(name)) {
            const dict = fonts instanceof PDFDict ? fonts.lookup(PDFName.of(name)) : null;
            cache.set(name, dict instanceof PDFDict ? fontWidths(dict, context) : null);
        }
        return cache.get(name);
    };

    const ops = textShowOps(tokenize(bytes), fontInfo);
    // Text drawn at a position that couldn't be followed: removing anything could leave part of an
    // edited line behind, so the page falls back to covering.
    if (ops.some((op) => op.x === null)) return new Set();
    const edits = [];
    const removed = new Set();
    for (const run of runs) {
        const mine = ops.filter((op) => opBelongsToRun(op, run));
        if (mine.length === 0) continue;
        // Without a known advance, removing an operator would shift whatever follows it on the line.
        if (mine.some((op) => op.advance === null && ops.indexOf(op) < ops.length - 1 && ops[ops.indexOf(op) + 1].y === op.y)) continue;
        for (const op of mine) edits.push({ start: op.start, end: op.end, text: replacementFor(op, op.size) });
        removed.add(run.id);
    }
    if (edits.length === 0) return removed;

    edits.sort((a, b) => b.start - a.start);
    let out = bytes;
    for (const edit of edits) {
        const insert = new TextEncoder().encode(edit.text);
        const next = new Uint8Array(out.length - (edit.end - edit.start) + insert.length);
        next.set(out.subarray(0, edit.start), 0);
        next.set(insert, edit.start);
        next.set(out.subarray(edit.end), edit.start + insert.length);
        out = next;
    }
    const newRef = context.register(context.flateStream(out));
    while (contents.size() > 0) contents.remove(0);
    contents.push(newRef);
    return removed;
}

