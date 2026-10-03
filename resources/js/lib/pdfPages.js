import { useEffect, useRef, useState } from 'react';
import { loadPdf } from './pdf.js';
import { loadRenderDoc, renderThumbnail } from './pdfRender.js';

/**
 * Loads one PDF file and renders a thumbnail for every page. Shared by the tools that show a
 * page grid (Rotate / Delete / Organize PDF). `doc` is the pdf-lib document used to build the
 * edited output; thumbnails are rendered separately with pdfjs-dist from the same bytes.
 */
export function usePdfPageThumbnails(file) {
    const [state, setState] = useState({ status: 'idle', doc: null, renderDoc: null, pageCount: 0, thumbs: [], error: '' });
    const renderDocRef = useRef(null);

    useEffect(() => {
        renderDocRef.current?.destroy();
        renderDocRef.current = null;
        if (!file) {
            setState({ status: 'idle', doc: null, renderDoc: null, pageCount: 0, thumbs: [], error: '' });
            return;
        }

        let cancelled = false;
        setState({ status: 'loading', doc: null, renderDoc: null, pageCount: 0, thumbs: [], error: '' });

        (async () => {
            const { doc, pageCount } = await loadPdf(file);
            const bytes = await file.arrayBuffer();
            const renderDoc = await loadRenderDoc(new Uint8Array(bytes));
            if (cancelled) {
                renderDoc.destroy();
                return;
            }
            renderDocRef.current = renderDoc;
            const thumbs = new Array(pageCount).fill(null);
            setState({ status: 'ready', doc, renderDoc, pageCount, thumbs: [...thumbs], error: '' });

            for (let i = 0; i < pageCount; i++) {
                if (cancelled) return;
                try {
                    thumbs[i] = await renderThumbnail(renderDoc, i + 1);
                } catch {
                    thumbs[i] = { url: '', width: 0, height: 0, rotation: 0 };
                }
                if (!cancelled) setState((s) => ({ ...s, thumbs: [...thumbs] }));
            }
        })().catch((e) => {
            if (!cancelled) setState({ status: 'error', doc: null, renderDoc: null, pageCount: 0, thumbs: [], error: e.message });
        });

        return () => {
            cancelled = true;
        };
    }, [file]);

    useEffect(() => () => renderDocRef.current?.destroy(), []);

    return state;
}
