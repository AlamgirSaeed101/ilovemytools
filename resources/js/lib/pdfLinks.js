// Links in Edit PDF: reading the links a PDF already has (with pdf.js, which the editor has loaded
// anyway) and changing, removing or adding them (with pdf-lib, when the PDF is saved). A link can
// open a web address (/URI action) or jump to a page of the same document (/Dest).
import { PDFArray, PDFDict, PDFName, PDFNull, PDFRef, PDFString } from 'pdf-lib';

/** pdf.js's id of an annotation that is an indirect object ("12R", or "12R3" for generation 3). */
export function refId(ref) {
    return ref.generationNumber === 0 ? `${ref.objectNumber}R` : `${ref.objectNumber}R${ref.generationNumber}`;
}

/** [x1, y1, x2, y2] in any corner order -> {x, y, width, height} (bottom-left origin). */
export function normalizeRect([x1, y1, x2, y2]) {
    return { x: Math.min(x1, x2), y: Math.min(y1, y2), width: Math.abs(x2 - x1), height: Math.abs(y2 - y1) };
}

async function resolveDestPage(renderDoc, dest) {
    try {
        const explicit = typeof dest === 'string' ? await renderDoc.getDestination(dest) : dest;
        if (!Array.isArray(explicit) || explicit.length === 0) return null;
        const [target] = explicit;
        if (Number.isInteger(target)) return target;
        if (target && typeof target === 'object') return await renderDoc.getPageIndex(target);
    } catch {
        // A broken destination: the link is still listed, it just has no known target page.
    }
    return null;
}

/**
 * The links on page `pageNumber` (1-based) of a pdf.js document: [{ id, index, rect, url,
 * pageTarget, kind }]. `rect` is PDF space; `index` is the link's position among the page's link
 * annotations; `kind` is 'url' (opens `url`), 'page' (jumps to 0-based `pageTarget`) or 'other'
 * (a named action, a file launch... that the editor can replace or remove but not show).
 */
export async function readPageLinks(renderDoc, pageNumber) {
    const page = await renderDoc.getPage(pageNumber);
    const annotations = await page.getAnnotations({ intent: 'display' });
    const links = [];
    for (const annot of annotations) {
        if (annot.subtype !== 'Link' || !Array.isArray(annot.rect)) continue;
        const url = annot.url ?? annot.unsafeUrl ?? null;
        const pageTarget = url || annot.dest == null ? null : await resolveDestPage(renderDoc, annot.dest);
        links.push({
            id: annot.id ?? null,
            index: links.length,
            rect: normalizeRect(annot.rect),
            url,
            pageTarget,
            kind: url ? 'url' : pageTarget != null ? 'page' : 'other',
        });
    }
    return links;
}

/** A /Dest that shows `pageIndex` (0-based) of `doc` without changing the reader's zoom. */
function pageDest(doc, pageIndex) {
    const target = doc.getPage(Math.min(Math.max(0, pageIndex), doc.getPageCount() - 1));
    return doc.context.obj([target.ref, PDFName.of('XYZ'), PDFNull, PDFNull, PDFNull]);
}

/** Points `dict` (a link annotation) at a web address or a page, dropping whatever it pointed at before. */
function setLinkTarget(doc, dict, { url, pageTarget }) {
    dict.delete(PDFName.of('A'));
    dict.delete(PDFName.of('Dest'));
    dict.delete(PDFName.of('PA'));
    if (pageTarget != null) dict.set(PDFName.of('Dest'), pageDest(doc, pageTarget));
    else if (url) dict.set(PDFName.of('A'), doc.context.obj({ Type: 'Action', S: 'URI', URI: PDFString.of(url) }));
}

/**
 * Adds a new link over `rect` (PDF space) on `page` (a pdf-lib PDFPage) that opens `url`, or
 * jumps to page `pageTarget` (0-based) of the same document when that is given.
 */
export function addLinkAnnot(doc, page, { rect, url, pageTarget = null }) {
    const { x, y, width, height } = rect;
    const dict = doc.context.obj({ Type: 'Annot', Subtype: 'Link', Rect: [x, y, x + width, y + height], Border: [0, 0, 0] });
    setLinkTarget(doc, dict, { url, pageTarget });
    const ref = doc.context.register(dict);
    page.node.addAnnot(ref);
    return ref;
}

const near = (a, b) => Math.abs(a - b) < 0.5;

/** The position in `annots` of the link an edit is about: by object id first, then by its index and box. */
function findLink(doc, annots, edit) {
    const entries = annots.asArray().map((item, position) => {
        const dict = item instanceof PDFRef ? doc.context.lookup(item) : item;
        return { item, position, dict: dict instanceof PDFDict ? dict : null };
    });
    if (edit.annotId) {
        const byId = entries.find((e) => e.item instanceof PDFRef && refId(e.item) === edit.annotId);
        if (byId?.dict) return byId;
    }
    const links = entries.filter((e) => e.dict?.get(PDFName.of('Subtype'))?.toString() === '/Link');
    const sameBox = (e) => {
        const rect = e.dict.lookup(PDFName.of('Rect'), PDFArray)?.asArray().map((n) => n.asNumber?.() ?? 0);
        if (!rect || !edit.linkRect) return false;
        const r = normalizeRect(rect);
        return near(r.x, edit.linkRect.x) && near(r.y, edit.linkRect.y) && near(r.width, edit.linkRect.width) && near(r.height, edit.linkRect.height);
    };
    const byIndex = links[edit.annotIndex];
    if (byIndex && (!edit.linkRect || sameBox(byIndex))) return byIndex;
    return links.find(sameBox) ?? null;
}

/**
 * Applies the editor's changes to links the PDF already had. `edits`: [{ page (0-based),
 * annotId, annotIndex, linkRect, url?, pageTarget?, remove? }] - each finds its link (see
 * readPageLinks) and either removes it from the page's /Annots or points it somewhere new.
 * Returns how many edits found their link.
 */
export function applyLinkEdits(doc, edits) {
    let applied = 0;
    const byPage = new Map();
    for (const edit of edits ?? []) {
        if (!byPage.has(edit.page)) byPage.set(edit.page, []);
        byPage.get(edit.page).push(edit);
    }
    for (const [pageIndex, pageEdits] of byPage) {
        if (pageIndex < 0 || pageIndex >= doc.getPageCount()) continue;
        const page = doc.getPage(pageIndex);
        const annots = page.node.Annots();
        if (!annots) continue;
        // Find every target first: removing one shifts the positions of the ones after it.
        const targets = pageEdits.map((edit) => ({ edit, found: findLink(doc, annots, edit) })).filter((t) => t.found);
        for (const { edit, found } of targets) {
            applied++;
            if (edit.remove) continue;
            setLinkTarget(doc, found.dict, edit);
        }
        const removed = new Set(targets.filter((t) => t.edit.remove).map((t) => t.found.item));
        if (removed.size) {
            const keep = annots.asArray().filter((item) => !removed.has(item));
            while (annots.size() > 0) annots.remove(0);
            for (const item of keep) annots.push(item);
        }
    }
    return applied;
}
