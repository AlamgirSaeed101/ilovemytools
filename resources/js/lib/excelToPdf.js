import { t } from './i18n.js';
import { MM_TO_PT, PDF_PAGE_SIZES } from './pdf.js';
import { embedDocumentFonts, pickFont } from './pdfFonts.js';

// Each sheet becomes one or more landscape/portrait PDF pages of a plain bordered table (header
// row repeated on every page). Column widths are sized to fit the content and shrunk to the
// page if needed; a cell that still doesn't fit is truncated with an ellipsis. Cell colours,
// formulas, merged cells and charts are not preserved - a readable table is the goal here.

const FONT_SIZE = 9;
const ROW_HEIGHT = 16;
const CELL_PADDING = 4;
const MIN_COL_WIDTH = 36;

export function cellText(value) {
    if (value === null || value === undefined) return '';
    return String(value);
}

/** Column widths that fit the widest cell in each column, scaled down to fit `maxWidth` if needed. */
export function computeColumnWidths(rows, maxWidth, measure) {
    const colCount = rows.reduce((max, row) => Math.max(max, row.length), 0);
    const widths = new Array(colCount).fill(MIN_COL_WIDTH);
    for (const row of rows) {
        row.forEach((cell, i) => {
            widths[i] = Math.max(widths[i], measure(cellText(cell), FONT_SIZE) + CELL_PADDING * 2);
        });
    }
    const total = widths.reduce((a, b) => a + b, 0);
    if (total <= maxWidth) return widths;
    const scale = Math.max(0.2, maxWidth / total);
    return widths.map((w) => Math.max(MIN_COL_WIDTH * scale, w * scale));
}

/** Truncate text with an ellipsis so it fits inside `maxWidth`; returns the text unchanged if it already fits. */
export function truncateToWidth(text, maxWidth, measure) {
    if (measure(text, FONT_SIZE) <= maxWidth) return text;
    let end = text.length;
    while (end > 0 && measure(`${text.slice(0, end)}…`, FONT_SIZE) > maxWidth) end -= 1;
    return end > 0 ? `${text.slice(0, end)}…` : '…';
}

export function paginateRows(rows, rowsPerPage) {
    if (rows.length === 0) return [[]];
    const pages = [];
    for (let i = 0; i < rows.length; i += rowsPerPage) pages.push(rows.slice(i, i + rowsPerPage));
    return pages;
}

/** Lay out one sheet's rows into pages of {columnWidths, header, rows}. */
export function layoutSheetToPages(rows, { maxWidth, maxBodyHeight, measure, rowHeight = ROW_HEIGHT }) {
    if (rows.length === 0) return [];
    const columnWidths = computeColumnWidths(rows, maxWidth, measure);
    const rowsPerPage = Math.max(1, Math.floor(maxBodyHeight / rowHeight) - 1);
    const [header, ...body] = rows;
    return paginateRows(body, rowsPerPage).map((chunk) => ({ columnWidths, header, rows: chunk, rowHeight }));
}

export function pageGeometry(pageSize = 'a4', orientation = 'portrait') {
    const base = PDF_PAGE_SIZES[pageSize] || PDF_PAGE_SIZES.a4;
    const landscape = orientation === 'landscape';
    const pageWidth = landscape ? base.height : base.width;
    const pageHeight = landscape ? base.width : base.height;
    return { pageWidth, pageHeight, marginPt: 15 * MM_TO_PT };
}

/** Read an .xlsx/.xls/.csv workbook into [{name, rows: [[cell,...]]}] (SheetJS, Apache-2.0). */
export async function readWorkbook(bytes) {
    const XLSX = await import('xlsx');
    let workbook;
    try {
        workbook = XLSX.read(bytes, { type: 'array' });
    } catch {
        throw new Error(t('This file could not be read. It may be damaged or not a real spreadsheet.'));
    }
    return workbook.SheetNames.map((name) => ({
        name,
        rows: XLSX.utils.sheet_to_json(workbook.Sheets[name], { header: 1, raw: false, defval: '' }),
    }));
}

function drawTablePage(page, { columnWidths, header, rows, rowHeight }, fonts, borderColor, startY, marginPt) {
    const allRows = [{ cells: header, bold: true }, ...rows.map((r) => ({ cells: r, bold: false }))];
    let y = startY;

    for (const row of allRows) {
        let x = marginPt;
        const font = pickFont(fonts, { bold: row.bold });
        columnWidths.forEach((width, i) => {
            const text = truncateToWidth(cellText(row.cells[i]), width - CELL_PADDING * 2, (t2, size) => font.widthOfTextAtSize(t2, size));
            page.drawText(text, { x: x + CELL_PADDING, y: y - rowHeight * 0.68, size: FONT_SIZE, font });
            page.drawRectangle({ x, y: y - rowHeight, width, height: rowHeight, borderColor, borderWidth: 0.5 });
            x += width;
        });
        y -= rowHeight;
    }
}

/** Full pipeline: workbook bytes -> a finished PDF Blob, one or more pages per sheet. */
export async function excelToPdfBlob(bytes, { pageSize = 'a4', orientation = 'portrait' } = {}) {
    const sheets = await readWorkbook(bytes);
    const nonEmpty = sheets.filter((s) => s.rows.length > 0);
    if (nonEmpty.length === 0) throw new Error(t('This spreadsheet has no data to convert.'));

    const { PDFDocument, rgb } = await import('pdf-lib');
    const doc = await PDFDocument.create();
    const fonts = await embedDocumentFonts(doc);
    const geometry = pageGeometry(pageSize, orientation);
    const measure = (text, size) => fonts.regular.widthOfTextAtSize(text || '', size);
    const titleHeight = 20;

    for (const sheet of nonEmpty) {
        const maxBodyHeight = geometry.pageHeight - geometry.marginPt * 2 - titleHeight;
        const pages = layoutSheetToPages(sheet.rows, { maxWidth: geometry.pageWidth - geometry.marginPt * 2, maxBodyHeight, measure });
        pages.forEach((pageLayout, i) => {
            const page = doc.addPage([geometry.pageWidth, geometry.pageHeight]);
            const top = geometry.pageHeight - geometry.marginPt;
            page.drawText(i === 0 ? sheet.name : `${sheet.name} (${t('continued')})`, {
                x: geometry.marginPt,
                y: top - 12,
                size: 12,
                font: fonts.bold,
                color: rgb(0.1, 0.1, 0.1),
            });
            drawTablePage(page, pageLayout, fonts, rgb(0.8, 0.8, 0.8), top - titleHeight, geometry.marginPt);
        });
    }
    const bytesOut = await doc.save();
    return new Blob([bytesOut], { type: 'application/pdf' });
}
