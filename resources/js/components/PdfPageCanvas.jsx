import { useEffect, useRef } from 'react';
import { renderPageToCanvas } from '../lib/pdfRender.js';

/**
 * Renders one pdf.js page (1-based `pageNumber`) into a canvas at `scale` CSS pixels per PDF
 * point. Shared by the tools that overlay something on top of a single full-size page preview
 * (Sign / Redact / Edit PDF). Re-renders whenever the page or scale changes.
 */
export default function PdfPageCanvas({ renderDoc, pageNumber, scale, className, onReady }) {
    const canvasRef = useRef(null);

    useEffect(() => {
        let cancelled = false;
        (async () => {
            const rendered = await renderPageToCanvas(renderDoc, pageNumber, { scale, background: '#ffffff' });
            if (cancelled || !canvasRef.current) return;
            canvasRef.current.width = rendered.width;
            canvasRef.current.height = rendered.height;
            canvasRef.current.getContext('2d').drawImage(rendered, 0, 0);
            onReady?.({ width: rendered.width, height: rendered.height });
        })();
        return () => {
            cancelled = true;
        };
    }, [renderDoc, pageNumber, scale]);

    return <canvas ref={canvasRef} className={className} />;
}
