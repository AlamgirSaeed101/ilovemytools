import { useEffect, useState } from 'react';
import { applyPageMap, entrySize, followPage, initialPageMap, insertPages, isPageMapChanged, remapElements } from '../../lib/pdfPageOps.js';
import useInsertedPdfs from './useInsertedPdfs.js';

const UNDO_LIMIT = 30;

/**
 * The page panel's state for Edit PDF: the page map (order, rotation, deleted, duplicated,
 * blank and inserted pages - see pdfPageOps.js), the PDFs inserted from other files, and an undo
 * list of page changes. Every change carries the editor's elements to their page's new position
 * (dropping those of a deleted page), and undo restores both the pages and those elements.
 *
 * `elements`/`setElements` and `nextId` (a ref) are the editor's; `onEdit` runs after any change
 * (the editor clears its redo list and finished download there).
 */
export default function usePageMap({ doc, renderDoc, pageCount, thumbs, elements, setElements, nextId, currentPage, setCurrentPage, onEdit }) {
    const [rawMap, setRawMap] = useState(null);
    const [undoList, setUndoList] = useState([]);
    const inserted = useInsertedPdfs();

    // A newly loaded document starts with its own pages in order, unless a resumed session already set the map.
    useEffect(() => {
        if (!doc || !pageCount) return;
        setRawMap((current) => (current && current.every((e) => e.blank || e.from != null || e.source < pageCount) ? current : initialPageMap(pageCount)));
    }, [doc, pageCount]);

    const map = rawMap ?? (pageCount ? initialPageMap(pageCount) : []);
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
        setUndoList((list) => [...list.slice(-(UNDO_LIMIT - 1)), { map, elements, currentPage }]);
        setElements(remapElements(elements, map, next, { nextId: () => nextId.current++ }));
        setRawMap(next);
        setCurrentPage(followPage(map, next, currentPage));
        onEdit?.();
    }

    function undo() {
        const last = undoList[undoList.length - 1];
        if (!last) return;
        setUndoList((list) => list.slice(0, -1));
        setRawMap(last.map);
        setElements(last.elements);
        setCurrentPage(Math.min(last.currentPage, last.map.length - 1));
        onEdit?.();
    }

    /** Reads another PDF (in the browser) and inserts all of its pages so the first lands at `position`. */
    async function insertPdf(file, position) {
        const { key, pageCount: count } = await inserted.add(file);
        change(insertPages(map, position, key, count));
        setCurrentPage(Math.min(position, map.length + count - 1));
    }

    function reset() {
        setRawMap(null);
        setUndoList([]);
        inserted.reset();
    }

    /** Restores the pages of a saved session (see sessionFields). */
    function restore(session) {
        setRawMap(Array.isArray(session?.pageMap) ? session.pageMap : null);
        setUndoList([]);
        if (session?.extraFiles?.length) inserted.restore(session.extraFiles);
    }

    const changed = isPageMapChanged(rawMap, pageCount);
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
        thumbFor,
        /** Whether the page's existing text can be edited (it is a page of the open PDF). */
        isOwnPage: (index) => Boolean(map[index] && !map[index].blank && map[index].from == null),
        change,
        undo,
        canUndo: undoList.length > 0,
        insertPdf,
        reset,
        restore,
        /** A new PDFDocument with the pages in map order (or `source` itself when nothing changed). */
        build: (source) => applyPageMap(source, map, { extraDocs }),
        /** What a saved session needs to bring the pages back. */
        sessionFields: () => ({
            pageMap: rawMap,
            extraFiles: Object.values(inserted.docs).map(({ key, name, bytes }) => ({ key, name, bytes })),
        }),
    };
}
