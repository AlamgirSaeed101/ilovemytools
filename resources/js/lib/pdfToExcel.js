import { t } from './i18n.js';
import { loadRenderDoc, pageTextItems } from './pdfRender.js';

// Best-effort PDF -> spreadsheet: a PDF has no real rows/columns, so this clusters text items
// that share a Y position into a row, then clusters the X positions items start at across every
// row on the page into shared column boundaries. It works well for simple, already-tabular PDFs
// (invoices, exported reports) and poorly for free-flowing text or merged cells - stated on the
// tool page. Each PDF page becomes one sheet.

export function groupItemsIntoRows(items, yTolerance = 2) {
    const usable = items.filter((it) => it.str && it.str.trim());
    const rows = [];
    for (const item of usable) {
        let row = rows.find((r) => Math.abs(r.y - item.y) <= yTolerance);
        if (!row) {
            row = { y: item.y, items: [] };
            rows.push(row);
        }
        row.items.push(item);
    }
    rows.sort((a, b) => b.y - a.y);
    rows.forEach((row) => row.items.sort((a, b) => a.x - b.x));
    return rows;
}

/** Shared column start-positions, clustering every item's X so nearby starts count as one column. */
export function detectColumnBoundaries(rows, gapThreshold = 8) {
    const starts = [];
    for (const row of rows) for (const item of row.items) starts.push(item.x);
    starts.sort((a, b) => a - b);
    const boundaries = [];
    for (const x of starts) {
        if (boundaries.length === 0 || x - boundaries[boundaries.length - 1] > gapThreshold) boundaries.push(x);
    }
    return boundaries;
}

/** Place each row's items into the detected columns, joining items that land in the same cell. */
export function rowsToTable(rows, boundaries) {
    if (boundaries.length === 0) return rows.map(() => ['']);
    return rows.map((row) => {
        const cells = new Array(boundaries.length).fill('');
        for (const item of row.items) {
            let col = 0;
            for (let i = boundaries.length - 1; i >= 0; i--) {
                if (item.x >= boundaries[i] - 0.01) {
                    col = i;
                    break;
                }
            }
            cells[col] = cells[col] ? `${cells[col]} ${item.str}` : item.str;
        }
        return cells.map((c) => c.trim());
    });
}

/** Full per-page extraction: text items -> a table of strings. */
export function pageItemsToTable(items) {
    const rows = groupItemsIntoRows(items);
    const boundaries = detectColumnBoundaries(rows);
    return rowsToTable(rows, boundaries);
}

export async function extractPdfTables(bytes) {
    const renderDoc = await loadRenderDoc(bytes);
    try {
        const sheets = [];
        for (let i = 1; i <= renderDoc.numPages; i++) {
            const items = await pageTextItems(renderDoc, i);
            sheets.push({ name: t('Page {number}', { number: i }), rows: pageItemsToTable(items) });
        }
        return sheets;
    } finally {
        renderDoc.destroy();
    }
}

export async function sheetsToXlsxBlob(sheets) {
    const XLSX = await import('xlsx');
    const workbook = XLSX.utils.book_new();
    for (const sheet of sheets) {
        const rows = sheet.rows.length > 0 ? sheet.rows : [['']];
        const worksheet = XLSX.utils.aoa_to_sheet(rows);
        XLSX.utils.book_append_sheet(workbook, worksheet, sheet.name.slice(0, 31));
    }
    const out = XLSX.write(workbook, { type: 'array', bookType: 'xlsx' });
    return new Blob([out], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
}

/** Full pipeline: a PDF's bytes -> an .xlsx Blob, one sheet per page. */
export async function pdfToXlsxBlob(bytes) {
    const sheets = await extractPdfTables(bytes);
    const hasContent = sheets.some((sheet) => sheet.rows.some((row) => row.some((cell) => cell)));
    if (!hasContent) throw new Error(t('No text was found in this PDF. Scanned pages without selectable text cannot be converted.'));
    return sheetsToXlsxBlob(sheets);
}
