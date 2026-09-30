import { t, tn } from './i18n.js';
// Page range parsing for the Split PDF tool.
// "1-3, 5, 8-" with 10 pages -> [[1,3],[5,5],[8,10]]

export function parseRanges(input, pageCount) {
    const text = String(input || '').trim();
    if (text === '') throw new Error(t('Enter the pages you want, for example 1-3, 5.'));
    if (!Number.isInteger(pageCount) || pageCount < 1) throw new Error(t('The PDF has no pages.'));

    const ranges = [];
    for (const rawPart of text.split(/[,;]+/)) {
        const part = rawPart.trim().toLowerCase();
        if (part === '') continue;

        let start;
        let end;
        let m;
        if ((m = /^(\d+)$/.exec(part))) {
            start = end = Number(m[1]);
        } else if ((m = /^(\d+)\s*[-–—]\s*(\d+|end)?$/.exec(part))) {
            start = Number(m[1]);
            end = m[2] === undefined || m[2] === 'end' ? pageCount : Number(m[2]);
        } else if ((m = /^[-–—]\s*(\d+)$/.exec(part))) {
            start = 1;
            end = Number(m[1]);
        } else {
            throw new Error(t('"{part}" is not a valid page or range. Use numbers like 3 or 1-5.', { part: rawPart.trim() }));
        }

        if (start < 1 || end < 1) throw new Error(t('Page numbers start at 1.'));
        if (start > pageCount || end > pageCount) {
            throw new Error(tn('This PDF only has {count} page. "{part}" is out of range.', 'This PDF only has {count} pages. "{part}" is out of range.', pageCount, { part: rawPart.trim() }));
        }
        if (start > end) throw new Error(t('"{part}" is backwards. Write the smaller page number first, like {end}-{start}.', { part: rawPart.trim(), start, end }));

        ranges.push([start, end]);
    }

    if (ranges.length === 0) throw new Error(t('Enter the pages you want, for example 1-3, 5.'));
    return ranges;
}

/** Flatten ranges to zero-based page indexes, keeping order and removing duplicates. */
export function rangesToIndexes(ranges) {
    const seen = new Set();
    const out = [];
    for (const [start, end] of ranges) {
        for (let p = start; p <= end; p++) {
            if (!seen.has(p)) {
                seen.add(p);
                out.push(p - 1);
            }
        }
    }
    return out;
}

export function rangeLabel([start, end]) {
    return start === end ? `${start}` : `${start}-${end}`;
}
