import { PDFDocument, PDFName, StandardFonts } from 'pdf-lib';
import { describe, expect, it } from 'vitest';
import { opBelongsToRun, pageContents, removeRunsFromPage, replacementFor, streamBytes, textShowOps, tokenize } from './pdfContentEdit.js';

const bytesOf = (s) => new TextEncoder().encode(s);
const text = (u8) => new TextDecoder('latin1').decode(u8);

/** All the strings a page's content stream shows, decoded as Latin-1 (hex strings included). */
function shownStrings(doc, pageIndex = 0) {
    const parts = pageContents(doc.getPage(pageIndex), doc.context)
        .asArray()
        .map((ref) => streamBytes(doc.context.lookup(ref)));
    const tokens = parts.flatMap((p) => tokenize(p));
    return tokens.filter((t) => t.type === 'str').map((t) => text(t.value));
}

describe('tokenize', () => {
    it('reads literal strings with escapes and nested brackets, hex strings, names and numbers', () => {
        const tokens = tokenize(bytesOf('/F1 12 Tf (a\\(b\\) (c) \\101) Tj <48 69> Tj [(x) -250 (y)] TJ'));
        expect(tokens.map((t) => t.type)).toEqual(['name', 'num', 'op', 'str', 'op', 'str', 'op', '[', 'str', 'num', 'str', ']', 'op']);
        expect(text(tokens[3].value)).toBe('a(b) (c) A');
        expect(text(tokens[5].value)).toBe('Hi');
    });

    it('skips inline image data as one token', () => {
        const tokens = tokenize(bytesOf('q BI /W 1 /H 1 ID \u0000(ÿ) EI Q (after) Tj'));
        expect(tokens.map((t) => t.value ?? t.type)).toEqual(['q', 'BI', 'Q', expect.anything(), 'Tj']);
    });
});

describe('textShowOps and opBelongsToRun', () => {
    const widths = () => ({ bytesPerCode: 1, width: () => 500 }); // every glyph 500/1000 em

    it('follows Td/Tm/cm to the user-space start of each operator, and its advance', () => {
        const ops = textShowOps(tokenize(bytesOf('q 1 0 0 1 10 20 cm BT /F1 10 Tf 50 700 Td (Hello) Tj ( World) Tj ET Q')), widths);
        expect(ops).toHaveLength(2);
        expect(ops[0]).toMatchObject({ x: 60, y: 720, size: 10, advance: 25 });
        expect(ops[1].x).toBeCloseTo(85); // implicit start right after "Hello"
        const run = { x: 60, y: 720, size: 10, width: 25 };
        expect(opBelongsToRun(ops[0], run)).toBe(true);
        expect(opBelongsToRun(ops[1], run)).toBe(false);
    });

    it('replaces a removed operator with a move of the same width', () => {
        expect(replacementFor({ kind: 'Tj', advance: 25 }, 10)).toBe('[-2500] TJ');
        expect(replacementFor({ kind: "'", advance: 5 }, 10)).toBe('T* [-500] TJ');
    });
});

describe('removeRunsFromPage', () => {
    it('removes an edited line from the content but keeps the rest of the page', async () => {
        const doc = await PDFDocument.create();
        const font = await doc.embedFont(StandardFonts.Helvetica);
        const page = doc.addPage([400, 400]);
        page.drawText('Old price 100', { x: 50, y: 300, size: 12, font });
        page.drawText('Keep this line', { x: 50, y: 250, size: 12, font });
        const run = { id: '1-0', x: 50, y: 300, size: 12, width: font.widthOfTextAtSize('Old price 100', 12) };

        const removed = removeRunsFromPage(doc, 0, [run]);

        expect(removed).toEqual(new Set(['1-0']));
        const strings = shownStrings(doc);
        expect(strings).toContain('Keep this line');
        expect(strings).not.toContain('Old price 100');
    });

    it('keeps text that follows on the same line in place (the removed text becomes a pure move)', async () => {
        const doc = await PDFDocument.create();
        const page = doc.addPage([400, 400]);
        const fontDict = doc.context.obj({ Type: 'Font', Subtype: 'Type1', BaseFont: 'Helvetica', FirstChar: 32, LastChar: 126, Widths: Array(95).fill(500) });
        page.node.setFontDictionary(PDFName.of('F9'), doc.context.register(fontDict));
        const content = doc.context.flateStream('BT /F9 10 Tf 50 300 Td (Hello) Tj ( World) Tj ET');
        page.node.set(PDFName.of('Contents'), doc.context.register(content));

        const removed = removeRunsFromPage(doc, 0, [{ id: 'r', x: 50, y: 300, size: 10, width: 25 }]);

        expect(removed.has('r')).toBe(true);
        const shown = pageContents(page, doc.context)
            .asArray()
            .map((ref) => text(streamBytes(doc.context.lookup(ref))))
            .join(' ');
        const ops = textShowOps(tokenize(bytesOf(shown)), () => ({ bytesPerCode: 1, width: () => 500 }));
        expect(ops).toHaveLength(2);
        expect(ops[1].x).toBeCloseTo(75); // " World" still starts where it did
        expect(shownStrings(doc)).toEqual([' World']);
    });

    it('leaves the content alone when nothing on the page matches the run', async () => {
        const doc = await PDFDocument.create();
        const font = await doc.embedFont(StandardFonts.Helvetica);
        doc.addPage([400, 400]).drawText('Untouched', { x: 50, y: 300, size: 12, font });
        expect(removeRunsFromPage(doc, 0, [{ id: 'x', x: 200, y: 100, size: 12, width: 40 }]).size).toBe(0);
        expect(shownStrings(doc)).toContain('Untouched');
    });
});
