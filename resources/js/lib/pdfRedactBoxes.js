// Redact PDF's pure helpers, apart from pdfRedact.js so the tool can use them without loading
// pdf-lib until the redacted PDF is built.

/** Pure: the sorted, de-duplicated list of 0-based page indexes that have at least one box. */
export function pagesWithBoxes(boxes) {
    return [...new Set(boxes.map((b) => b.page))].sort((a, b) => a - b);
}
