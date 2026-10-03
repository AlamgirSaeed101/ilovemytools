// Pure naming/format helpers for the PDF to JPG / PDF to PNG tools (shared PdfToImage.jsx).

export const DPI_OPTIONS = [72, 150, 300];

export function mimeType(format) {
    return format === 'jpeg' ? 'image/jpeg' : 'image/png';
}

export function fileExtension(format) {
    return format === 'jpeg' ? 'jpg' : 'png';
}

/** One page's output filename; no "-page-N" suffix when there is only one page. */
export function pageFilename(base, pageNumber, totalPages, format) {
    const ext = fileExtension(format);
    return totalPages === 1 ? `${base}.${ext}` : `${base}-page-${pageNumber}.${ext}`;
}
