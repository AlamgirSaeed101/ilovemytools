import { addRotation } from './pdf.js';

// pdf-lib (~165 KB) only loads when the page order/rotation/inserts are actually saved, not with
// the page or while the user is still moving thumbnails around.
let pdfLibPromise;
function pdfLib() {
    return pdfLibPromise ?? (pdfLibPromise = import('pdf-lib'));
}

/** The default, unchanged order for a freshly opened PDF: one entry per original page, no rotation. */
export function defaultPageOps(pageCount) {
    return Array.from({ length: pageCount }, (_, index) => ({ type: 'page', index, rotate: 0 }));
}

/** Whether `ops` describes anything other than the original, unrotated page order. */
export function isPageOpsChanged(ops, pageCount) {
    if (!ops) return false;
    if (ops.length !== pageCount) return true;
    return ops.some((op, i) => op.type !== 'page' || op.index !== i || op.rotate);
}

/** Moves the page at `from` to `to` (position-based, like Organize PDF's move buttons). */
export function movePageOp(ops, from, to) {
    if (to < 0 || to >= ops.length || from === to) return ops;
    const next = [...ops];
    const [moved] = next.splice(from, 1);
    next.splice(to, 0, moved);
    return next;
}

/** Removes the page at `position`. A document always keeps at least one page. */
export function deletePageOp(ops, position) {
    if (ops.length <= 1) return ops;
    return ops.filter((_, i) => i !== position);
}

/** Inserts a new blank page right after `position`. */
export function insertBlankPageOp(ops, position) {
    const next = [...ops];
    next.splice(position + 1, 0, { type: 'blank' });
    return next;
}

/** Rotates the page at `position` by `delta` degrees (±90), added to any rotation already queued. Blank pages are never rotated. */
export function rotatePageOp(ops, position, delta) {
    return ops.map((op, i) => (i === position && op.type === 'page' ? { ...op, rotate: addRotation(op.rotate, delta) } : op));
}

/**
 * Re-pages `elements` (each keyed by its original page index) to the positions `ops` puts them
 * at. An element whose original page was deleted is dropped.
 */
export function remapElementsForPageOps(elements, ops) {
    const newIndexByOriginal = new Map();
    ops.forEach((op, i) => {
        if (op.type === 'page') newIndexByOriginal.set(op.index, i);
    });
    return elements.filter((el) => newIndexByOriginal.has(el.page)).map((el) => ({ ...el, page: newIndexByOriginal.get(el.page) }));
}

const A4_POINTS = [595.28, 841.89];

/**
 * Rebuilds a document's pages to match `ops` (deletions, reordering, rotation and blank-page
 * inserts) and returns a new PDFDocument; `doc` itself is left untouched so the live editor can
 * keep using it if the user carries on editing afterwards. Inserted blank pages match the size of
 * the document's first page (A4 if the whole document is new and has none).
 */
export async function applyPageOps(doc, ops) {
    const { PDFDocument, degrees } = await pdfLib();
    const bytes = await doc.save();
    const work = await PDFDocument.load(bytes, { updateMetadata: false });
    const originalPages = work.getPages();
    const blankSize = originalPages[0] ? [originalPages[0].getWidth(), originalPages[0].getHeight()] : A4_POINTS;
    for (let i = originalPages.length - 1; i >= 0; i--) work.removePage(i);
    ops.forEach((op, index) => {
        if (op.type === 'blank') {
            work.insertPage(index, blankSize);
            return;
        }
        const page = originalPages[op.index];
        if (op.rotate) page.setRotation(degrees(addRotation(page.getRotation().angle, op.rotate)));
        work.insertPage(index, page);
    });
    return work;
}
