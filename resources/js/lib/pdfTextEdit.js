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
    sans: [StandardFonts.Helvetica, StandardFonts.HelveticaBold, StandardFonts.HelveticaOblique, StandardFonts.HelveticaBoldOblique],
    serif: [StandardFonts.TimesRoman, StandardFonts.TimesRomanBold, StandardFonts.TimesRomanItalic, StandardFonts.TimesRomanBoldItalic],
    mono: [StandardFonts.Courier, StandardFonts.CourierBold, StandardFonts.CourierOblique, StandardFonts.CourierBoldOblique],
};

/**
 * The pdf-lib font to draw an edited run with: the PDF's own font when it has every letter,
 * otherwise the closest standard one (Helvetica / Times / Courier for Latin-1 text, DejaVu Sans
 * for the rest). `overrides` ({ family: 'original'|'sans'|'serif'|'mono', bold, italic }) are the
 * choices made in the text properties bar: a family other than 'original', or bold/italic switched
 * away from the run's own style, always uses the matching standard (or DejaVu) face.
 * `cache` (a Map) avoids embedding the same font twice in one save.
 */
export async function fontForEdit(doc, run, rawText, cache, overrides = {}) {
    const text = String(rawText ?? '').replace(/[\r\n\t]+/g, ' '); // line breaks are laid out, never drawn
    const family = overrides.family ?? 'original';
    const bold = overrides.bold ?? Boolean(run.bold);
    const italic = overrides.italic ?? Boolean(run.italic);
    const sameStyle = bold === Boolean(run.bold) && italic === Boolean(run.italic);
    if (family === 'original' && sameStyle && run.fontData && (await missingGlyphs(run.fontData, text)).length === 0) {
        const key = `own:${run.fontName}`;
        if (!cache.has(key)) {
            const { default: fontkit } = await import('@pdf-lib/fontkit');
            doc.registerFontkit(fontkit);
            cache.set(key, await doc.embedFont(run.fontData, { subset: false }).catch(() => null));
        }
        if (cache.get(key)) return cache.get(key);
    }
    const fallbackFamily = family === 'original' ? run.family ?? 'sans' : family;
    const style = (bold ? 1 : 0) + (italic ? 2 : 0);
    if (STANDARD[fallbackFamily]) {
        const name = STANDARD[fallbackFamily][style];
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
    return pickFont(cache.get('dejavu'), { bold, italic });
}
