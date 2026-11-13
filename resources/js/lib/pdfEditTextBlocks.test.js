import { PDFDocument, PDFName, StandardFonts } from 'pdf-lib';
import { describe, expect, it } from 'vitest';
import { buildEditedPdf } from './pdfEdit.js';
import { pageContents, streamBytes } from './pdfContentEdit.js';
import { groupRunsIntoBlocks, textEditElement, textElementToPdf } from './pdfTextBlocks.js';

const LINES = ['The quick brown fox jumps', 'over the lazy dog near', 'the old river bank.'];

async function paragraphPdf() {
    const doc = await PDFDocument.create();
    const font = await doc.embedFont(StandardFonts.Helvetica);
    const page = doc.addPage([400, 400]);
    LINES.forEach((line, i) => page.drawText(line, { x: 40, y: 300 - i * 14, size: 12, font }));
    const runs = LINES.map((str, i) => ({ id: `1-${i}`, str, x: 40, y: 300 - i * 14, size: 12, width: font.widthOfTextAtSize(str, 12), fontName: 'g1', ascent: 0.9, descent: -0.25, family: 'sans', bold: false, italic: false, fontData: null }));
    return { bytes: await doc.save(), runs, font };
}

/** Every string shown on page 1 of `bytes` as hex (how pdf-lib writes standard-font text). */
async function shownHex(bytes) {
    const doc = await PDFDocument.load(bytes);
    const contents = pageContents(doc.getPage(0), doc.context);
    const text = contents.asArray().map((ref) => new TextDecoder('latin1').decode(streamBytes(doc.context.lookup(ref)))).join('\n');
    return [...text.matchAll(/<([0-9A-Fa-f]+)>\s*Tj/g)].map((m) => Buffer.from(m[1], 'hex').toString('latin1'));
}

describe('buildEditedPdf with paragraph blocks', () => {
    it('removes every line of an edited paragraph and draws the new text wrapped at its width', async () => {
        const { bytes, runs, font } = await paragraphPdf();
        const [block] = groupRunsIntoBlocks(runs);
        expect(block.runs).toHaveLength(3);
        const el = { id: 1, page: 0, ...textEditElement(block, { scale: 1, pageHeight: 400 }) };
        el.text = el.text.replace('quick', 'fast');
        const doc = await PDFDocument.load(bytes);
        const blob = await buildEditedPdf(doc, [textElementToPdf(el, 1, 400)]);
        const shown = await shownHex(new Uint8Array(await blob.arrayBuffer()));
        expect(shown.join(' ')).not.toContain('quick');
        // One drawn line per wrapped line, none wider than the paragraph; nothing else of the old text is left.
        expect(shown.length).toBeGreaterThanOrEqual(3);
        expect(shown.join(' ')).toBe('The fast brown fox jumps over the lazy dog near the old river bank.');
        for (const line of shown) expect(font.widthOfTextAtSize(line, 12)).toBeLessThanOrEqual(block.width + 0.01);
    });

    it('draws added text in the chosen family and style, one line per wrapped line', async () => {
        const { bytes } = await paragraphPdf();
        const doc = await PDFDocument.load(bytes);
        const el = { id: 2, page: 0, type: 'text', text: 'Hello there\nsecond line', size: 12, color: '#000000', family: 'serif', bold: true, italic: false, align: 'left', lineHeight: 1.2, maxWidth: null, rotation: 0, x: 20, y: 20, width: 120, height: 30 };
        const blob = await buildEditedPdf(doc, [textElementToPdf(el, 1, 400)]);
        const out = new Uint8Array(await blob.arrayBuffer());
        const saved = await PDFDocument.load(out);
        const baseFonts = saved.context
            .enumerateIndirectObjects()
            .map(([, obj]) => obj?.get?.(PDFName.of('BaseFont'))?.toString())
            .filter(Boolean);
        expect(baseFonts).toContain('/Times-Bold');
        expect(await shownHex(out)).toEqual(expect.arrayContaining(['Hello there', 'second line']));
    });
});
