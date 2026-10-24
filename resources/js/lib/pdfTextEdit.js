// Editing the text that is already in a PDF (Edit PDF's "Edit text" mode). pdf.js extracts each
// text run with its position, size and the font the PDF embeds; an edit covers the old run with
// the colour behind it and draws the new wording at the same baseline. The new text reuses the
// PDF's own font whenever that font contains every letter needed (PDFs usually embed only the
// letters they use); otherwise it falls back to the closest standard font and says why.
import { StandardFonts } from 'pdf-lib';
import { embedDocumentFonts, pickFont } from './pdfFonts.js';
import { mergeTextItems, classifyFont, coverRect, sampleRunColors, colorsFromCanvas, extractPageRuns, missingGlyphs } from './pdfTextRuns.js';

export { mergeTextItems, classifyFont, coverRect, sampleRunColors, colorsFromCanvas, extractPageRuns, missingGlyphs };

const STANDARD = {
    serif: [StandardFonts.TimesRoman, StandardFonts.TimesRomanBold, StandardFonts.TimesRomanItalic, StandardFonts.TimesRomanBoldItalic],
    mono: [StandardFonts.Courier, StandardFonts.CourierBold, StandardFonts.CourierOblique, StandardFonts.CourierBoldOblique],
};

/**
 * The pdf-lib font to draw an edited run with: the PDF's own font when it has every letter,
 * otherwise the closest standard one (Times / Courier for Latin-1 text, DejaVu Sans for the rest).
 * `cache` (a Map) avoids embedding the same font twice in one save.
 */
export async function fontForEdit(doc, run, text, cache) {
    if (run.fontData && (await missingGlyphs(run.fontData, text)).length === 0) {
        const key = `own:${run.fontName}`;
        if (!cache.has(key)) {
            const { default: fontkit } = await import('@pdf-lib/fontkit');
            doc.registerFontkit(fontkit);
            cache.set(key, await doc.embedFont(run.fontData, { subset: false }).catch(() => null));
        }
        if (cache.get(key)) return cache.get(key);
    }
    const style = (run.bold ? 1 : 0) + (run.italic ? 2 : 0);
    if (STANDARD[run.family]) {
        const name = STANDARD[run.family][style];
        if (!cache.has(name)) cache.set(name, await doc.embedFont(name));
        const font = cache.get(name);
        try {
            font.encodeText(text); // throws for letters outside Latin-1
            return font;
        } catch {
            // fall through to DejaVu Sans, which covers far more scripts
        }
    }
    if (!cache.has('dejavu')) cache.set('dejavu', await embedDocumentFonts(doc));
    return pickFont(cache.get('dejavu'), run);
}
