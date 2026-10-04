// Rendering PDF pages to canvas with pdfjs-dist (Apache-2.0). Lazy-loaded: the ~1 MB
// library and its worker are only downloaded by tools that actually render pages
// (Rotate/Delete/Organize PDF thumbnails, PDF to JPG/PNG).
let pdfjsPromise = null;

async function loadPdfjs() {
    pdfjsPromise ??= (async () => {
        const [pdfjsLib, workerUrl] = await Promise.all([
            import('pdfjs-dist'),
            import('pdfjs-dist/build/pdf.worker.min.mjs?url').then((m) => m.default),
        ]);
        pdfjsLib.GlobalWorkerOptions.workerSrc = workerUrl;
        return pdfjsLib;
    })();
    return pdfjsPromise;
}

/**
 * Load a PDF's bytes into a pdfjs document for rendering (separate from the pdf-lib doc used
 * for editing). pdfjs only exposes `destroy()` on the loading task, not on the resolved document,
 * so it's attached here to make the returned document disposable on its own.
 */
export async function loadRenderDoc(bytes) {
    const pdfjsLib = await loadPdfjs();
    const loadingTask = pdfjsLib.getDocument({ data: bytes });
    const doc = await loadingTask.promise;
    doc.destroy = () => loadingTask.destroy();
    return doc;
}

/** PDF.js viewport scale 1 renders at 72 DPI (1 CSS pixel per PDF point). */
export function dpiToScale(dpi) {
    return dpi / 72;
}

/** Render one page (1-based pageNumber) of a loaded render doc onto a new canvas. */
export async function renderPageToCanvas(renderDoc, pageNumber, { scale = 1, background = null } = {}) {
    const page = await renderDoc.getPage(pageNumber);
    const viewport = page.getViewport({ scale });
    const canvas = document.createElement('canvas');
    canvas.width = Math.max(1, Math.round(viewport.width));
    canvas.height = Math.max(1, Math.round(viewport.height));
    const ctx = canvas.getContext('2d');
    if (background) {
        ctx.fillStyle = background;
        ctx.fillRect(0, 0, canvas.width, canvas.height);
    }
    await page.render({ canvasContext: ctx, viewport }).promise;
    return canvas;
}

/** A small thumbnail (data URL) of one page, sized to `maxWidth` CSS pixels wide. */
export async function renderThumbnail(renderDoc, pageNumber, { maxWidth = 150 } = {}) {
    const page = await renderDoc.getPage(pageNumber);
    const base = page.getViewport({ scale: 1 });
    const scale = maxWidth / base.width;
    const canvas = await renderPageToCanvas(renderDoc, pageNumber, { scale, background: '#ffffff' });
    const url = canvas.toDataURL('image/png');
    return { url, width: canvas.width, height: canvas.height, rotation: base.rotation };
}

/** {str, x, y, height, width} items (in PDF points) for one page, used by the PDF-to-Word/Excel extractors. */
export async function pageTextItems(renderDoc, pageNumber) {
    const page = await renderDoc.getPage(pageNumber);
    const content = await page.getTextContent();
    return content.items
        .filter((it) => typeof it.str === 'string')
        .map((it) => ({
            str: it.str,
            x: it.transform[4],
            y: it.transform[5],
            height: Math.abs(it.transform[3]) || Math.abs(it.transform[0]) || 10,
            width: it.width,
        }));
}

export function canvasToBlob(canvas, type, quality) {
    return new Promise((resolve, reject) => {
        canvas.toBlob((blob) => (blob ? resolve(blob) : reject(new Error('Could not render the page.'))), type, quality);
    });
}
