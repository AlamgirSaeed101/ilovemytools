import { useEffect, useRef } from 'react';
import PdfPageCanvas from '../PdfPageCanvas.jsx';

/** A white page of `size` (PDF points) at `scale`: a blank page, or a page whose PDF is still loading. */
function BlankCanvas({ size, scale, className, onReady }) {
    const ref = useRef(null);
    const width = Math.max(1, Math.round(size.width * scale));
    const height = Math.max(1, Math.round(size.height * scale));

    useEffect(() => {
        const canvas = ref.current;
        if (!canvas) return;
        canvas.width = width;
        canvas.height = height;
        const ctx = canvas.getContext('2d');
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, width, height);
        onReady?.({ width, height });
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [width, height]);

    return <canvas ref={ref} className={className} />;
}

/**
 * Shows one entry of Edit PDF's page map (see pdfPageOps.js): a page of the open PDF or of an
 * inserted PDF (rendered with pdf.js from `renderDoc`), or a blank page.
 */
export default function MappedPageCanvas({ entry, renderDoc, size, scale, className, onReady }) {
    if (!entry || entry.blank || !renderDoc) {
        return <BlankCanvas key="blank" size={size} scale={scale} className={className} onReady={onReady} />;
    }
    return <PdfPageCanvas key="page" renderDoc={renderDoc} pageNumber={entry.source + 1} scale={scale} className={className} onReady={onReady} />;
}
