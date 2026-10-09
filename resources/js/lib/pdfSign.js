import { embedDocumentFonts } from './pdfFonts.js';

/** Default signature box size (PDF points) when a signature is first dropped onto a page. */
export const DEFAULT_SIGNATURE_WIDTH_PT = 160;

/** Width/height a signature keeps when placed, scaled from the source image's own aspect ratio. */
export function signatureBoxSize(imageWidth, imageHeight, targetWidth = DEFAULT_SIGNATURE_WIDTH_PT) {
    const ratio = imageHeight / imageWidth || 0.4;
    return { width: targetWidth, height: targetWidth * ratio };
}

/**
 * Draws every placed signature (and its optional date stamp) onto `doc` with pdf-lib and returns
 * the finished PDF as a Blob. `placements`: [{ page, rectPdf: {x,y,width,height}, pngBytes, dateText? }].
 */
export async function buildSignedPdf(doc, placements) {
    let fonts = null;
    for (const placement of placements) {
        const page = doc.getPage(placement.page);
        const image = await doc.embedPng(placement.pngBytes);
        page.drawImage(image, placement.rectPdf);
        if (placement.dateText) {
            fonts ??= await embedDocumentFonts(doc);
            const size = Math.max(8, Math.min(12, placement.rectPdf.height * 0.22));
            page.drawText(placement.dateText, {
                x: placement.rectPdf.x,
                y: placement.rectPdf.y - size - 4,
                size,
                font: fonts.regular,
            });
        }
    }
    const bytes = await doc.save();
    return new Blob([bytes], { type: 'application/pdf' });
}

/** Localised "signed on" date stamp placed under a signature. */
export function formatSignatureDate(locale, date = new Date()) {
    try {
        return new Intl.DateTimeFormat(locale, { year: 'numeric', month: '2-digit', day: '2-digit' }).format(date);
    } catch {
        return date.toISOString().slice(0, 10);
    }
}
