import { PDFDocument, StandardFonts } from 'pdf-lib';
import { describe, expect, it } from 'vitest';
import { baselineOffset, blockCoverRects, groupRunsIntoBlocks, layoutTextLines, styleChangedFromOriginal, textEditElement, textElementToPdf, usesOwnFont, wrapLines } from './pdfTextBlocks.js';

// A run as extractPageRuns() returns it; width is 6 units per character at size 12.
let nextId = 0;
const run = (str, x, y, { size = 12, fontName = 'f1', width = str.length * size * 0.5 } = {}) => ({ id: `1-${nextId++}`, str, x, y, size, width, fontName, ascent: 0.9, descent: -0.25, family: 'sans' });
// A fake monospace font: every character is 0.5 em wide.
const mono = { widthOfTextAtSize: (s, size) => s.length * size * 0.5 };

describe('groupRunsIntoBlocks', () => {
    it('joins three lines of one paragraph (same font, size, left edge, steady spacing) into one block', () => {
        const lines = [run('The quick brown fox', 50, 700), run('jumps over the lazy', 50, 686), run('dog.', 50, 672)];
        const blocks = groupRunsIntoBlocks([lines[2], lines[0], lines[1]]);
        expect(blocks).toHaveLength(1);
        expect(blocks[0].runs.map((r) => r.str)).toEqual(['The quick brown fox', 'jumps over the lazy', 'dog.']);
        expect(blocks[0].text).toBe('The quick brown fox jumps over the lazy dog.');
        expect(blocks[0].y).toBe(700);
        expect(blocks[0].x).toBe(50);
        expect(blocks[0].width).toBe(19 * 6);
        expect(blocks[0].lineHeight).toBeCloseTo(14 / 12);
        expect(blocks[0].align).toBe('left');
        expect(blocks[0].id).toBe(lines[0].id);
    });

    it('keeps lines that end early (an address) as line breaks, so re-wrapping gives the same lines', () => {
        const blocks = groupRunsIntoBlocks([run('Jane Smith', 50, 700), run('12 High Street, Leeds', 50, 686), run('UK', 50, 672)]);
        expect(blocks).toHaveLength(1);
        expect(blocks[0].text).toBe('Jane Smith\n12 High Street, Leeds UK');
        expect(wrapLines(blocks[0].text, mono, 12, blocks[0].width)).toEqual(['Jane Smith', '12 High Street, Leeds', 'UK']);
    });

    it('joins a word hyphenated across two lines without a space, so it can break there again', () => {
        const blocks = groupRunsIntoBlocks([run('A really long exam-', 50, 700), run('ple of text', 50, 686)]);
        expect(blocks[0].text).toBe('A really long exam-ple of text');
        expect(wrapLines(blocks[0].text, mono, 12, blocks[0].width)).toEqual(['A really long exam-', 'ple of text']);
    });

    it('keeps different fonts, sizes, columns and far-apart lines in separate blocks', () => {
        const blocks = groupRunsIntoBlocks([
            run('Heading', 50, 740, { size: 20 }),
            run('Body text one', 50, 700),
            run('Body text two', 50, 686),
            run('Bold line', 50, 672, { fontName: 'f2' }),
            run('Right column', 320, 700),
            run('Far below', 50, 600),
        ]);
        expect(blocks.map((b) => b.runs.map((r) => r.str))).toEqual([['Heading'], ['Body text one', 'Body text two'], ['Right column'], ['Bold line'], ['Far below']]);
    });

    it('detects centred and right-aligned paragraphs', () => {
        const centred = groupRunsIntoBlocks([run('A centred title line', 100, 700), run('short', 145, 686)]);
        expect(centred).toHaveLength(1);
        expect(centred[0].align).toBe('center');
        const right = groupRunsIntoBlocks([run('Right aligned line', 100, 700), run('end', 190, 686)]);
        expect(right).toHaveLength(1);
        expect(right[0].align).toBe('right');
    });

    it('stops a paragraph when the line spacing changes', () => {
        const blocks = groupRunsIntoBlocks([run('Line one here', 50, 700), run('Line two here', 50, 686), run('Next paragraph', 50, 660)]);
        expect(blocks.map((b) => b.runs.length)).toEqual([2, 1]);
    });

    it('leaves runs that share a line with another font as one-line blocks', () => {
        const blocks = groupRunsIntoBlocks([run('Some text with a', 50, 700), run('bold', 150, 700, { fontName: 'f2' }), run('word in it here', 50, 686)]);
        expect(blocks.find((b) => b.runs[0].str === 'Some text with a').runs).toHaveLength(1);
    });
});

describe('wrapLines', () => {
    it('breaks at spaces so no line is wider than the width', () => {
        // 10 characters = 60 units at size 12.
        expect(wrapLines('The quick brown fox jumps over', mono, 12, 60)).toEqual(['The quick', 'brown fox', 'jumps over']);
    });

    it('keeps line breaks and empty lines, and does not wrap without a width', () => {
        expect(wrapLines('One\n\nTwo three', mono, 12, null)).toEqual(['One', '', 'Two three']);
        expect(wrapLines('One two\nthree', mono, 12, 1000)).toEqual(['One two', 'three']);
    });

    it('splits a word longer than a line, and breaks after a hyphen when that fits', () => {
        expect(wrapLines('abcdefghijklmn', mono, 12, 30)).toEqual(['abcde', 'fghij', 'klmn']);
        expect(wrapLines('a well-known fact', mono, 12, 48)).toEqual(['a well-', 'known', 'fact']);
    });

    it('accepts a measuring function instead of a pdf-lib font', () => {
        expect(wrapLines('aa bb cc', (s) => s.length * 10, 0, 50)).toEqual(['aa bb', 'cc']);
    });

    it('wraps with a real pdf-lib font the same way it is drawn', async () => {
        const doc = await PDFDocument.create();
        const font = await doc.embedFont(StandardFonts.Helvetica);
        const lines = wrapLines('Lorem ipsum dolor sit amet, consectetur adipiscing elit', font, 12, 120);
        expect(lines.length).toBeGreaterThan(1);
        for (const line of lines) expect(font.widthOfTextAtSize(line, 12)).toBeLessThanOrEqual(120.01);
        expect(lines.join(' ')).toBe('Lorem ipsum dolor sit amet, consectetur adipiscing elit');
    });
});

describe('blockCoverRects', () => {
    it('returns one cover rect per line', () => {
        const [block] = groupRunsIntoBlocks([run('First line of it', 50, 700), run('second line', 50, 686), run('third', 50, 672)]);
        const rects = blockCoverRects(block);
        expect(rects).toHaveLength(3);
        expect(rects[1].y).toBeLessThan(rects[0].y);
        expect(rects[0].x).toBeLessThan(50);
        expect(rects[0].width).toBeGreaterThan(16 * 6);
    });
});

describe('text element layout', () => {
    const [block] = groupRunsIntoBlocks([run('The quick brown fox', 50, 700), run('jumps over the lazy', 50, 686), run('dog.', 50, 672)]);

    it('builds an edit element that wraps a paragraph at its width, and saves back to the same baseline', () => {
        const el = textEditElement(block, { scale: 1.5, pageHeight: 800, colors: { color: '#112233', background: '#ffffff' } });
        expect(el.runs).toHaveLength(3);
        expect(el.run).toBe(block.runs[0]);
        expect(el.maxWidth).toBeCloseTo(block.width * 1.5);
        expect(el.covers).toHaveLength(3);
        expect(el.color).toBe('#112233');
        const pdf = textElementToPdf({ ...el, id: 1, page: 0 }, 1.5, 800);
        expect(pdf.x).toBeCloseTo(50);
        expect(pdf.y).toBeCloseTo(700);
        expect(pdf.maxWidth).toBeCloseTo(block.width);
        expect(pdf.runs).toHaveLength(3);
    });

    it('lets a one-line edit grow instead of wrapping', () => {
        const [single] = groupRunsIntoBlocks([run('Total', 50, 500)]);
        expect(textEditElement(single, { scale: 1, pageHeight: 800 }).maxWidth).toBeNull();
    });

    it('moves the saved text with the element', () => {
        const el = textEditElement(block, { scale: 1, pageHeight: 800 });
        const pdf = textElementToPdf({ ...el, x: el.x + 30, y: el.y + 40 }, 1, 800);
        expect(pdf.x).toBeCloseTo(80);
        expect(pdf.y).toBeCloseTo(660);
    });

    it('places the first baseline the way CSS does inside a line box', () => {
        expect(baselineOffset(1.15, 0.9, -0.25)).toBeCloseTo(0.9);
        expect(baselineOffset(2, 0.9, -0.25)).toBeCloseTo(0.9 + 0.425);
    });

    it('lays lines out with alignment and line height', () => {
        const lines = layoutTextLines({ text: 'aaaa bb', x: 10, y: 100, size: 10, maxWidth: 20, align: 'right', lineHeight: 1.5 }, (s) => s.length * 5);
        expect(lines).toEqual([
            { text: 'aaaa', x: 10, y: 100, width: 20 },
            { text: 'bb', x: 20, y: 85, width: 10 },
        ]);
        const centred = layoutTextLines({ text: 'aaaa\nbb', x: 0, y: 0, size: 10, maxWidth: null, align: 'center' }, (s) => s.length * 5);
        expect(centred[1].x).toBe(5);
    });
});

describe('original font use', () => {
    const base = { type: 'textedit', run: { fontData: new Uint8Array(1), bold: false, italic: false }, family: 'original', bold: false, italic: false };

    it('uses the own font until bold/italic or the family changes', () => {
        expect(usesOwnFont(base)).toBe(true);
        expect(usesOwnFont({ ...base, bold: true })).toBe(false);
        expect(usesOwnFont({ ...base, family: 'serif' })).toBe(false);
        expect(usesOwnFont({ ...base, fallback: true })).toBe(false);
        expect(styleChangedFromOriginal({ ...base, italic: true })).toBe(true);
        expect(styleChangedFromOriginal({ ...base, family: 'mono', italic: true })).toBe(false);
    });
});
