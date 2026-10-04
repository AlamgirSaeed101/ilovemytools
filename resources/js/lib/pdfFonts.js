import { t } from './i18n.js';

// pdf-lib's built-in fonts (Helvetica etc.) can only draw WinAnsi (Latin-1) text, which is
// missing Polish diacritics and most other scripts. DejaVu Sans (Bitstream Vera license - free
// to embed and redistribute) covers Latin Extended, so real text can be drawn for any
// Latin-script document. It is served from our own /public (not a third-party CDN) and fetched
// lazily - only Word/Excel/HTML to PDF ever download it.
const FILES = {
    regular: '/fonts/dejavu/DejaVuSans.ttf',
    bold: '/fonts/dejavu/DejaVuSans-Bold.ttf',
    italic: '/fonts/dejavu/DejaVuSans-Oblique.ttf',
    boldItalic: '/fonts/dejavu/DejaVuSans-BoldOblique.ttf',
};

/** Registers fontkit and embeds the four DejaVu Sans styles into `pdfDoc`. */
export async function embedDocumentFonts(pdfDoc) {
    const { default: fontkit } = await import('@pdf-lib/fontkit');
    pdfDoc.registerFontkit(fontkit);
    const pairs = await Promise.all(
        Object.entries(FILES).map(async ([key, url]) => {
            const res = await fetch(url);
            if (!res.ok) throw new Error(t('Could not load the fonts needed to build this PDF. Check your connection and try again.'));
            const bytes = await res.arrayBuffer();
            return [key, await pdfDoc.embedFont(bytes, { subset: true })];
        })
    );
    return Object.fromEntries(pairs);
}

/** Pick the right embedded style for a text run. */
export function pickFont(fonts, { bold, italic } = {}) {
    if (bold && italic) return fonts.boldItalic;
    if (bold) return fonts.bold;
    if (italic) return fonts.italic;
    return fonts.regular;
}
