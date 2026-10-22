import fs from 'node:fs';
import path from 'node:path';
import { PDFDocument } from 'pdf-lib';
import { describe, expect, it } from 'vitest';
import { classifyFont, coverRect, fontForEdit, mergeTextItems, missingGlyphs, sampleRunColors } from './pdfTextEdit.js';

const item = (str, x, y = 700, size = 12, fontName = 'f1', width = str.length * size * 0.5) => ({ str, transform: [size, 0, 0, size, x, y], width, fontName });

describe('mergeTextItems', () => {
    it('joins words pdf.js split on one line, adding the space between them', () => {
        const runs = mergeTextItems([item('Invoice', 50), item('total', 50 + 7 * 6 + 3)]);
        expect(runs).toHaveLength(1);
        expect(runs[0].str).toBe('Invoice total');
        expect(runs[0].x).toBe(50);
        expect(runs[0].width).toBeCloseTo(7 * 6 + 3 + 5 * 6);
    });

    it('keeps separate lines, fonts and far-apart columns apart', () => {
        const runs = mergeTextItems([item('Name', 50), item('Line two', 50, 680), item('Bold', 80, 700, 12, 'f2'), item('Price', 400)]);
        expect(runs.map((r) => r.str)).toEqual(['Name', 'Line two', 'Bold', 'Price']);
    });

    it('skips rotated text and empty items', () => {
        const rotated = { str: 'Vertical', transform: [0, 12, -12, 0, 30, 300], width: 40, fontName: 'f1' };
        expect(mergeTextItems([rotated, item('  ', 10), item('Kept', 100)]).map((r) => r.str)).toEqual(['Kept']);
    });
});

describe('classifyFont', () => {
    it('reads family, weight and slant from the font name (ignoring the subset tag)', () => {
        expect(classifyFont('ABCDEF+TimesNewRomanPS-BoldItalicMT')).toEqual({ family: 'serif', bold: true, italic: true });
        expect(classifyFont('Arial-BoldMT')).toEqual({ family: 'sans', bold: true, italic: false });
        expect(classifyFont('CourierNewPSMT')).toEqual({ family: 'mono', bold: false, italic: false });
        expect(classifyFont('NotoSans-Regular').family).toBe('sans');
        expect(classifyFont('Foo', { italic: true }).italic).toBe(true);
    });
});

describe('coverRect', () => {
    it('covers from below the baseline (descent) to above the cap height, with a small margin', () => {
        const r = coverRect({ x: 100, y: 500, size: 10, width: 60 }, 0.9, -0.25);
        expect(r.x).toBeCloseTo(99.2);
        expect(r.y).toBeCloseTo(500 - 2.5 - 0.8);
        expect(r.width).toBeCloseTo(61.6);
        expect(r.height).toBeCloseTo(11.5 + 1.6);
    });
});

describe('sampleRunColors', () => {
    it('takes the background from the edge and the text colour from the strongest inner pixels', () => {
        const white = [255, 255, 255];
        const navy = [20, 30, 120];
        const inside = [...Array(80).fill(white), ...Array(20).fill(navy)];
        expect(sampleRunColors(Array(40).fill(white), inside)).toEqual({ background: '#ffffff', color: '#141e78' });
    });

    it('works on a coloured background and defaults the text to black when there is none', () => {
        const yellow = [250, 230, 120];
        expect(sampleRunColors(Array(40).fill(yellow), Array(10).fill(yellow))).toEqual({ background: '#f8e878', color: '#000000' });
    });
});

describe('fonts for edited text', () => {
    const dejavu = new Uint8Array(fs.readFileSync(path.resolve(import.meta.dirname, '../../../public/fonts/dejavu/DejaVuSans.ttf')));

    it('lists the letters a font cannot draw', async () => {
        expect(await missingGlyphs(dejavu, 'Hello world')).toEqual([]);
        expect(await missingGlyphs(null, 'ab a')).toEqual(['a', 'b']);
    });

    it("reuses the PDF's own font when it has every letter", async () => {
        const doc = await PDFDocument.create();
        const font = await fontForEdit(doc, { fontName: 'f1', fontData: dejavu, family: 'sans' }, 'Total 99', new Map());
        expect(font.name).toMatch(/DejaVu/);
    });

    it('falls back to the matching standard font (Times Bold for a bold serif run)', async () => {
        const doc = await PDFDocument.create();
        const font = await fontForEdit(doc, { fontName: 'f2', fontData: null, family: 'serif', bold: true, italic: false }, 'Rechnung', new Map());
        expect(font.name).toBe('Times-Bold');
    });
});
