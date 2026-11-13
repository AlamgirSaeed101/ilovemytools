import { applyPageMap, entrySize, followPage, initialPageMap, insertPages, isPageMapChanged, remapElements } from '../../lib/pdfPageOps.js';
import useInsertedPdfs from './useInsertedPdfs.js';

/**
 * The page panel's state for Edit PDF: the page map (order, rotation, deleted, duplicated,
 * blank and inserted pages - see pdfPageOps.js) and the PDFs inserted from other files. Every
 * change carries the editor's elements to their page's new position (dropping those of a deleted
 * page) in the same step, so the editor's one undo/redo history covers page changes too.
 *
 * `rawMap` is the map held in the editor's history (null = the document's own pages, unchanged).
 * `commit(nextElements, nextMap)` records both as one undo step. `elements` and `nextId` (a ref)
 * are the editor's; `onEdit` runs after any change (the editor clears its finished download there).
 */
export default function usePageMap({ doc, renderDoc, pageCount, thumbs, rawMap, elements, commit, nextId, currentPage, setCurrentPage, onEdit }) {
    const inserted = useInsertedPdfs();

    // A map restored from a session that doesn't fit the document is ignored.
    const valid = Boolean(rawMap) && pageCount > 0 && rawMap.every((e) => e.blank || e.from != null || e.source < pageCount);
    const map = valid ? rawMap : pageCount ? initialPageMap(pageCount) : [];
    const docs = { main: doc };
    for (const [key, value] of Object.entries(inserted.docs)) docs[key] = value.doc;

    const entry = (index) => map[index] ?? null;

    function renderDocFor(item) {
        if (!item || item.blank) return null;
        return item.from != null ? inserted.docs[item.from]?.renderDoc ?? null : renderDoc;
    }

    function thumbFor(item) {
        if (!item || item.blank) return null;
        return (item.from != null ? inserted.docs[item.from]?.thumbs?.[item.source] : thumbs?.[item.source]) ?? null;
    }

    function change(next) {
        if (next === map) return;
        commit(remapElements(elements, map, next, { nextId: () => nextId.current++ }), next);
        setCurrentPage(followPage(map, next, currentPage));
        onEdit?.();
    }

    /** Reads another PDF (in the browser) and inserts all of its pages so the first lands at `position`. */
    async function insertPdf(file, position) {
        const { key, pageCount: count } = await inserted.add(file);
        change(insertPages(map, position, key, count));
        setCurrentPage(Math.min(position, map.length + count - 1));
    }

    function reset() {
        inserted.reset();
    }

    /** Re-reads the inserted PDFs of a saved session (its page map comes back with the editor's history). */
    function restore(session) {
        if (session?.extraFiles?.length) inserted.restore(session.extraFiles);
    }

    const changed = valid && isPageMapChanged(rawMap, pageCount);
    const extraDocs = Object.fromEntries(Object.entries(inserted.docs).map(([key, value]) => [key, value.doc]));

    return {
        map,
        count: map.length,
        changed,
        entry,
        /** The page's own (unrotated) size in PDF points. */
        size: (index) => entrySize(map[index], docs),
        rotation: (index) => map[index]?.rotation || 0,
        renderDocFor,
        /** The pdf-lib document a (non-blank) entry's page comes from: the open PDF or an inserted one. */
        docFor: (item) => (item?.from != null ? docs[item.from] ?? null : doc),
        thumbFor,
        /** Where page `source` (0-based) of the open PDF now is in the map (its first use), or null when it was deleted. */
        positionOfSource: (source) => {
            const index = map.findIndex((item) => !item.blank && item.from == null && item.source === source);
            return index >= 0 ? index : null;
        },
        /** Whether the page's existing text can be edited (it is a page of the open PDF). */
        isOwnPage: (index) => Boolean(map[index] && !map[index].blank && map[index].from == null),
        change,
        insertPdf,
        reset,
        restore,
        /** A new PDFDocument with the pages in map order (or `source` itself when nothing changed). */
        build: (source) => applyPageMap(source, map, { extraDocs }),
        /** What a saved session needs to bring the pages back. */
        sessionFields: () => ({
            pageMap: valid ? rawMap : null,
            extraFiles: Object.values(inserted.docs).map(({ key, name, bytes }) => ({ key, name, bytes })),
        }),
    };
}
