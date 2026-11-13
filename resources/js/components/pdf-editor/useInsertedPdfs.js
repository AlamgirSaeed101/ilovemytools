import { useEffect, useRef, useState } from 'react';
import { loadPdf } from '../../lib/pdf.js';
import { loadRenderDoc, renderThumbnail } from '../../lib/pdfRender.js';

/**
 * The other PDFs whose pages were inserted into the document open in Edit PDF. Each is read in
 * the browser (never uploaded) into a pdf-lib document (to copy its pages on save) and a pdf.js
 * document (to show its pages and thumbnails). Keyed 'x1', 'x2'...: the key is what a page map
 * entry's `from` points at.
 */
export default function useInsertedPdfs() {
    const [docs, setDocs] = useState({});
    const renderDocs = useRef({});
    const counter = useRef(0);
    const generation = useRef(0);

    function destroyAll() {
        for (const renderDoc of Object.values(renderDocs.current)) renderDoc.destroy?.();
        renderDocs.current = {};
    }

    useEffect(() => () => destroyAll(), []);

    async function open(key, name, bytes, doc) {
        const gen = generation.current;
        const renderDoc = await loadRenderDoc(new Uint8Array(bytes.slice(0)));
        if (gen !== generation.current) {
            renderDoc.destroy?.();
            throw new Error('cancelled');
        }
        renderDocs.current[key] = renderDoc;
        const pageCount = doc.getPageCount();
        setDocs((all) => ({ ...all, [key]: { key, name, bytes, doc, renderDoc, pageCount, thumbs: new Array(pageCount).fill(null) } }));

        // Thumbnails fill in one by one, like the open document's own.
        (async () => {
            for (let i = 0; i < pageCount; i++) {
                if (gen !== generation.current) return;
                let thumb;
                try {
                    thumb = await renderThumbnail(renderDoc, i + 1);
                } catch {
                    thumb = { url: '', width: 0, height: 0, rotation: 0 };
                }
                if (gen !== generation.current) return;
                setDocs((all) => {
                    const entry = all[key];
                    if (!entry) return all;
                    const thumbs = [...entry.thumbs];
                    thumbs[i] = thumb;
                    return { ...all, [key]: { ...entry, thumbs } };
                });
            }
        })();
        return { key, pageCount };
    }

    /** Reads `file` and returns { key, pageCount }. Throws a readable error for a damaged or locked PDF. */
    async function add(file) {
        const { doc } = await loadPdf(file);
        const bytes = await file.arrayBuffer();
        counter.current += 1;
        return open(`x${counter.current}`, file.name, bytes, doc);
    }

    /** Re-opens the inserted PDFs of a saved session ([{ key, name, bytes }]). */
    async function restore(list = []) {
        const { PDFDocument } = await import('pdf-lib');
        for (const { key, name, bytes } of list) {
            const number = Number(String(key).slice(1));
            if (number > counter.current) counter.current = number;
            try {
                const doc = await PDFDocument.load(bytes, { updateMetadata: false });
                await open(key, name, bytes, doc);
            } catch {
                // A file that can't be re-read just shows blank pages; saving reports it.
            }
        }
    }

    /** Forgets every inserted PDF (a new file was opened). */
    function reset() {
        generation.current += 1;
        destroyAll();
        setDocs({});
    }

    return { docs, add, restore, reset };
}
