import { addRotation } from './pdf.js';

// pdf-lib (~165 KB) only loads when the page order/rotation/inserts are actually saved, not with
// the page or while the user is still moving thumbnails around.
let pdfLibPromise;
function pdfLib() {
    return pdfLibPromise ?? (pdfLibPromise = import('pdf-lib'));
}

const A4_POINTS = [595.28, 841.89];

// ---------------------------------------------------------------------------------------------
// Page map: the page panel of Edit PDF (thumbnail sidebar + continuous view).
//
// A page map is the editor's list of output pages, in order. Each entry is one of
//   { id, source, rotation }            a page of the open PDF (`source` = its 0-based index)
//   { id, source, rotation, from }      a page of a PDF inserted from another file (`from` = its key)
//   { id, blank: true, size, rotation } a new blank page, `size` = [width, height] in PDF points
// `rotation` is the extra clockwise rotation (0/90/180/270) added to the page's own /Rotate.
// `id` stays with an entry through moves, so elements (whose `page` is a position in the map)
// can be carried to the page's new position. Every helper returns a new map; none mutate.
// ---------------------------------------------------------------------------------------------

const nextEntryId = (map) => 1 + map.reduce((max, entry) => Math.max(max, entry.id), -1);

/** The unchanged map of a freshly opened PDF with `count` pages. */
export function initialPageMap(count) {
    return Array.from({ length: count }, (_, i) => ({ id: i, source: i, rotation: 0 }));
}

/** Whether `map` is anything other than the original pages in their original order, unrotated. */
export function isPageMapChanged(map, pageCount) {
    if (!map) return false;
    if (map.length !== pageCount) return true;
    return map.some((entry, i) => entry.blank || entry.from != null || entry.source !== i || Boolean(entry.rotation));
}

/** Moves the page at position `from` to position `to`. */
export function movePage(map, from, to) {
    if (from === to || from < 0 || from >= map.length || to < 0 || to >= map.length) return map;
    const next = [...map];
    const [moved] = next.splice(from, 1);
    next.splice(to, 0, moved);
    return next;
}

/** Removes the page at `index`. A document always keeps at least one page. */
export function deletePage(map, index) {
    if (map.length <= 1 || index < 0 || index >= map.length) return map;
    return map.filter((_, i) => i !== index);
}

/** Rotates the page at `index` by `delta` degrees (a multiple of 90, negative = anticlockwise). */
export function rotatePage(map, index, delta) {
    return map.map((entry, i) => (i === index ? { ...entry, rotation: addRotation(entry.rotation || 0, delta) } : entry));
}

/** Inserts a blank page of `size` ([width, height] in points) so it ends up at `position`. */
export function insertBlank(map, position, size = A4_POINTS) {
    const next = [...map];
    next.splice(Math.max(0, Math.min(position, map.length)), 0, { id: nextEntryId(map), blank: true, size: [...size], rotation: 0 });
    return next;
}

/** Inserts a copy of the page at `index` right after it. `copyOf` lets remapElements copy its elements too. */
export function duplicatePage(map, index) {
    if (index < 0 || index >= map.length) return map;
    // eslint-disable-next-line no-unused-vars
    const { copyOf, ...entry } = map[index];
    const next = [...map];
    next.splice(index + 1, 0, { ...entry, id: nextEntryId(map), copyOf: map[index].id });
    return next;
}

/** Inserts `count` pages of another PDF (`from` = its key) so the first one ends up at `position`. */
export function insertPages(map, position, from, count) {
    const firstId = nextEntryId(map);
    const added = Array.from({ length: count }, (_, i) => ({ id: firstId + i, source: i, rotation: 0, from }));
    const next = [...map];
    next.splice(Math.max(0, Math.min(position, map.length)), 0, ...added);
    return next;
}

/**
 * Carries `elements` (each with `page` = a position in `oldMap`) over to `newMap`: an element
 * follows its page to wherever it moved, and is dropped when its page was deleted. A link to a
 * page (`pageTarget`, also a position in the map) keeps pointing at the same page, or the nearest
 * one when that page was deleted. When `nextId` is given, a page added by duplicatePage gets its
 * own copy of the original's elements (each with a fresh id from `nextId()`); a new form field
 * copied this way gets a name of its own (form field names must be unique).
 */
export function remapElements(elements, oldMap, newMap, { nextId } = {}) {
    const newIndexById = new Map(newMap.map((entry, i) => [entry.id, i]));
    const retarget = (el) => (el.pageTarget == null || !oldMap[el.pageTarget] ? el : { ...el, pageTarget: followPage(oldMap, newMap, el.pageTarget) });
    const result = [];
    for (const el of elements) {
        const entry = oldMap[el.page];
        const index = entry ? newIndexById.get(entry.id) : undefined;
        if (index === undefined) continue;
        const moved = retarget(el);
        result.push(index === el.page && moved === el ? el : { ...moved, page: index });
    }
    if (nextId) {
        const oldIndexById = new Map(oldMap.map((entry, i) => [entry.id, i]));
        const usedNames = new Set(elements.filter((el) => el.type === 'formfield' && el.name).map((el) => el.name));
        newMap.forEach((entry, i) => {
            if (oldIndexById.has(entry.id) || entry.copyOf == null || !oldIndexById.has(entry.copyOf)) return;
            const original = oldIndexById.get(entry.copyOf);
            // Radio buttons of one group on the page stay one group on the copy, under one new name.
            const renamed = new Map();
            for (const el of elements) {
                if (el.page !== original) continue;
                const copy = { ...retarget(el), id: nextId(), page: i };
                if (el.type === 'formfield' && el.name) {
                    if (!renamed.has(el.name)) {
                        const name = uniqueName(`${el.name} copy`, usedNames);
                        usedNames.add(name);
                        renamed.set(el.name, name);
                    }
                    copy.name = renamed.get(el.name);
                }
                result.push(copy);
            }
        });
    }
    return result;
}

/** `base`, or `base 2`, `base 3`... - the first one not in `used`. */
function uniqueName(base, used) {
    if (!used.has(base)) return base;
    let n = 2;
    while (used.has(`${base} ${n}`)) n += 1;
    return `${base} ${n}`;
}

/** Where the page shown at `current` in `oldMap` is in `newMap` (or the nearest page when it was deleted). */
export function followPage(oldMap, newMap, current) {
    const entry = oldMap[current];
    const index = entry ? newMap.findIndex((e) => e.id === entry.id) : -1;
    if (index >= 0) return index;
    return Math.max(0, Math.min(current, newMap.length - 1));
}

/** The page's own (unrotated) size in points. `docs` = { main: PDFDocument, [key]: PDFDocument of an inserted PDF }. */
export function entrySize(entry, docs) {
    const fallback = { width: A4_POINTS[0], height: A4_POINTS[1] };
    if (!entry) return fallback;
    if (entry.blank) return { width: entry.size[0], height: entry.size[1] };
    const doc = entry.from != null ? docs[entry.from] : docs.main;
    return doc ? doc.getPage(entry.source).getSize() : fallback;
}

/**
 * Builds a new PDFDocument whose pages follow `map`: a copy of `doc` with its pages put in map
 * order, pages of the inserted PDFs in `extraDocs` ({ key: PDFDocument }) copied in, each entry's
 * rotation added to the page's /Rotate, and blank pages added. Working on a copy of `doc` (rather
 * than copying its pages into an empty file) keeps its form fields, outline and metadata; fields
 * whose widgets were all on deleted pages are dropped. A repeated page (a duplicate) gets its own
 * copy of the content, so editing one never changes the other. When the map is unchanged, `doc`
 * itself is returned.
 */
export async function applyPageMap(doc, map, { extraDocs = {} } = {}) {
    if (!map || !isPageMapChanged(map, doc.getPageCount())) return doc;
    const { PDFDocument, degrees } = await pdfLib();
    const sourceDoc = (entry) => {
        const src = extraDocs[entry.from];
        if (!src) throw new Error('An inserted PDF is no longer available.');
        return src;
    };
    const out = await PDFDocument.load(await doc.save(), { updateMetadata: false });
    const own = out.getPages();

    // Pages of each inserted PDF are copied in one batch (shared fonts and images are copied once).
    const inserted = new Map();
    const byDoc = new Map();
    map.forEach((entry, i) => {
        if (entry.blank || entry.from == null) return;
        if (!byDoc.has(entry.from)) byDoc.set(entry.from, []);
        byDoc.get(entry.from).push(i);
    });
    for (const [key, positions] of byDoc) {
        const copies = await out.copyPages(sourceDoc({ from: key }), positions.map((i) => map[i].source));
        positions.forEach((pos, k) => inserted.set(pos, copies[k]));
    }

    // The first use of one of the document's own pages moves that page; later uses are copies.
    const used = new Set();
    const pages = [];
    const copies = [];
    for (let i = 0; i < map.length; i++) {
        const entry = map[i];
        if (entry.blank) pages.push(null);
        else if (entry.from != null) pages.push(inserted.get(i));
        else if (!used.has(entry.source)) {
            used.add(entry.source);
            pages.push(own[entry.source]);
        } else {
            const [copy] = await out.copyPages(out, [entry.source]);
            pages.push(copy);
            copies.push(copy);
        }
    }

    for (let i = out.getPageCount() - 1; i >= 0; i--) out.removePage(i);
    map.forEach((entry, i) => {
        const page = pages[i] ? out.addPage(pages[i]) : out.addPage(entry.size);
        if (entry.rotation) page.setRotation(degrees(addRotation(page.getRotation().angle, entry.rotation)));
    });
    for (const copy of copies) await adoptCopiedFields(out, copy);
    await dropOrphanFields(out);
    // pdf-lib keeps the objects of removed pages in the file; a deleted page must really be gone.
    await dropUnreachableObjects(out);
    return out;
}

/**
 * A duplicated page's annotations and form fields. copyPages copies each widget with its own copy of the field
 * above it, which no form lists (so it can't be filled or flattened). Each copied field is pruned
 * to the widgets on this page, renamed ("Name copy", "Name copy 2"...) and added to the form, so
 * the copy is a real field of its own with the value the original had.
 */
async function adoptCopiedFields(doc, page) {
    const { PDFArray, PDFDict, PDFName, PDFRef, PDFString } = await pdfLib();
    const annots = page.node.Annots();
    if (!annots) return;
    // copyPages gives the copy's annotations a /P of their own (a stray second copy of the page): point them at the copy.
    for (let i = 0; i < annots.size(); i++) {
        const annot = annots.get(i) instanceof PDFRef ? doc.context.lookup(annots.get(i)) : null;
        if (annot instanceof PDFDict && annot.has(PDFName.of('P'))) annot.set(PDFName.of('P'), page.ref);
    }
    if (!doc.catalog.has(PDFName.of('AcroForm'))) return;
    const Kids = PDFName.of('Kids');
    const Parent = PDFName.of('Parent');
    const T = PDFName.of('T');
    const form = doc.getForm();
    const fields = form.acroForm.dict.lookupMaybe(PDFName.of('Fields'), PDFArray);
    if (!fields) return;
    const listed = new Set(fields.asArray().map((ref) => ref.toString()));
    const names = new Set(form.getFields().map((field) => field.getName()));

    // Every object from this page's widgets up to the top of their field trees, and those tops.
    const keep = new Set();
    const tops = new Map();
    for (let i = 0; i < annots.size(); i++) {
        let ref = annots.get(i);
        if (!(ref instanceof PDFRef)) continue;
        const widget = doc.context.lookup(ref);
        if (!(widget instanceof PDFDict) || widget.get(PDFName.of('Subtype'))?.toString() !== '/Widget') continue;
        let dict = widget;
        for (let depth = 0; depth < 32; depth++) {
            keep.add(ref.toString());
            const up = dict.get(Parent);
            if (!(up instanceof PDFRef)) break;
            ref = up;
            dict = doc.context.lookup(up);
            if (!(dict instanceof PDFDict)) break;
        }
        // A widget that is its own field, or whose top is already in the form (not a copy), is left alone.
        if (dict instanceof PDFDict && dict.get(T) && !listed.has(ref.toString())) tops.set(ref.toString(), { ref, dict });
    }

    const prune = (dict) => {
        const kids = dict.lookupMaybe(Kids, PDFArray);
        if (!kids) return;
        for (let i = kids.size() - 1; i >= 0; i--) {
            const kid = kids.get(i);
            if (!(kid instanceof PDFRef) || !keep.has(kid.toString())) kids.remove(i);
            else {
                const child = doc.context.lookup(kid);
                if (child instanceof PDFDict) prune(child);
            }
        }
    };
    for (const { ref, dict } of tops.values()) {
        prune(dict);
        const base = `${dict.lookup(T)?.decodeText?.() ?? 'Field'} copy`;
        let name = base;
        for (let n = 2; names.has(name); n++) name = `${base} ${n}`;
        names.add(name);
        dict.set(T, PDFString.of(name));
        fields.push(ref);
    }
}

/**
 * Deletes every object the saved file would no longer use (pdf-lib writes all objects it ever
 * read, so a removed page's text and images would otherwise still be inside the file). Walks from
 * the document catalog and info dictionary; a removed page that something still points at (a
 * link or bookmark to it) is not followed, so it goes too and that pointer leads nowhere.
 */
async function dropUnreachableObjects(doc) {
    const { PDFArray, PDFDict, PDFName, PDFRef, PDFStream } = await pdfLib();
    const { context } = doc;
    const livePages = new Set(doc.getPages().map((page) => page.ref.toString()));
    const isPage = (obj) => obj instanceof PDFDict && obj.get(PDFName.of('Type'))?.toString() === '/Page';
    const reached = new Set();
    const stack = [];
    const visit = (obj) => {
        if (obj instanceof PDFRef) {
            const tag = obj.toString();
            if (reached.has(tag)) return;
            const target = context.lookup(obj);
            if (isPage(target) && !livePages.has(tag)) return;
            reached.add(tag);
            if (target) stack.push(target);
        } else if (obj instanceof PDFDict) {
            for (const [, value] of obj.entries()) visit(value);
        } else if (obj instanceof PDFArray) {
            for (const value of obj.asArray()) visit(value);
        } else if (obj instanceof PDFStream) {
            visit(obj.dict);
        }
    };
    const { Root, Info, Encrypt } = context.trailerInfo;
    // An encrypted file's objects can't be told apart safely: leave it as it is.
    if (Encrypt) return;
    for (const start of [Root, Info]) if (start) visit(start);
    while (stack.length) visit(stack.pop());
    for (const [ref] of context.enumerateIndirectObjects()) {
        if (!reached.has(ref.toString())) context.delete(ref);
    }
}

/** Removes form widgets that are no longer on any page (their page was deleted), and fields left with none. */
async function dropOrphanFields(doc) {
    const { PDFName, PDFRef } = await pdfLib();
    if (!doc.catalog.has(PDFName.of('AcroForm'))) return;
    const onPage = new Set();
    for (const page of doc.getPages()) {
        const annots = page.node.Annots();
        for (let i = 0; annots && i < annots.size(); i++) {
            const ref = annots.get(i);
            if (ref instanceof PDFRef) onPage.add(ref.toString());
        }
    }
    const form = doc.getForm();
    for (const field of form.getFields()) {
        try {
            const kids = field.acroField.Kids();
            if (kids) {
                for (let i = kids.size() - 1; i >= 0; i--) {
                    const ref = kids.get(i);
                    if (ref instanceof PDFRef && !onPage.has(ref.toString())) kids.remove(i);
                }
                if (kids.size() === 0) form.acroForm.removeField(field.acroField);
            } else if (!onPage.has(field.ref.toString())) {
                form.acroForm.removeField(field.acroField);
            }
        } catch {
            // An unusual field tree: leave it as it is.
        }
    }
}
