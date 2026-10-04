import { t } from './i18n.js';

export const MAX_DOCX_BYTES = 50 * 1024 * 1024;

export function isDocx(file) {
    return file.type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || /\.docx$/i.test(file.name);
}

/**
 * DOCX -> HTML with mammoth (BSD-2-Clause), lazy-loaded via its standalone browser build so this
 * tool never pulls in Node-only code. Images are kept inline as base64 data URLs by default.
 */
export async function docxToHtml(file) {
    if (file.size > MAX_DOCX_BYTES) throw new Error(t('"{name}" is larger than 50 MB.', { name: file.name }));
    const arrayBuffer = await file.arrayBuffer();
    const imported = await import('mammoth/mammoth.browser.min.js');
    const mammoth = imported.default ?? imported;
    try {
        const result = await mammoth.convertToHtml({ arrayBuffer });
        return result.value;
    } catch {
        throw new Error(t('"{name}" could not be read. It may be damaged or not a real Word (.docx) document.', { name: file.name }));
    }
}
