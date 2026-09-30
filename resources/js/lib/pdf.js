import { t } from './i18n.js';
// PDF helpers built on pdf-lib (runs fully in the browser).
import { PDFDocument } from 'pdf-lib';

export const MAX_PDF_BYTES = 200 * 1024 * 1024;

export function isPdf(file) {
    return file.type === 'application/pdf' || /\.pdf$/i.test(file.name);
}

export async function loadPdf(file) {
    if (file.size > MAX_PDF_BYTES) throw new Error(t('"{name}" is larger than 200 MB.', { name: file.name }));
    const bytes = await file.arrayBuffer();
    try {
        const doc = await PDFDocument.load(bytes, { updateMetadata: false });
        const pageCount = doc.getPageCount();
        if (pageCount === 0) {
            // Flagged (not matched by text) so the check still works when translated.
            const empty = new Error(t('"{name}" has no pages.', { name: file.name }));
            empty.noPages = true;
            throw empty;
        }
        return { doc, pageCount };
    } catch (e) {
        const msg = String(e?.message || e);
        if (/encrypt/i.test(msg)) {
            throw new Error(t('"{name}" is password-protected. Remove the password first (open it with the password and save a copy), then try again.', { name: file.name }));
        }
        if (e?.noPages) throw e;
        throw new Error(t('"{name}" could not be read. It may be damaged or not a real PDF.', { name: file.name }));
    }
}

/** Build a new PDF from [{ doc, indexes }] parts, in order. */
export async function buildPdf(parts) {
    const out = await PDFDocument.create();
    for (const { doc, indexes } of parts) {
        const pages = await out.copyPages(doc, indexes ?? doc.getPageIndices());
        pages.forEach((page) => out.addPage(page));
    }
    const bytes = await out.save();
    return new Blob([bytes], { type: 'application/pdf' });
}
