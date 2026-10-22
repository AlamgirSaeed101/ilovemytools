import { expect } from '@playwright/test';
import { PDFDocument, StandardFonts } from 'pdf-lib';
import fs from 'node:fs/promises';
import { Document, HeadingLevel, Packer, Paragraph, TextRun } from 'docx';
import * as XLSX from 'xlsx';
import mammoth from 'mammoth';

/** A real .docx file with a heading and a paragraph containing a bold word. */
export async function makeDocx({ heading = 'Test Heading', plain = 'Hello ', bold = 'world' } = {}) {
    const doc = new Document({
        sections: [{
            children: [
                new Paragraph({ text: heading, heading: HeadingLevel.HEADING_1 }),
                new Paragraph({ children: [new TextRun(plain), new TextRun({ text: bold, bold: true })] }),
            ],
        }],
    });
    return Buffer.from(await Packer.toBuffer(doc));
}

/** A real .xlsx workbook with one sheet built from `rows` (array of arrays). */
export function makeXlsx(rows) {
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, XLSX.utils.aoa_to_sheet(rows), 'Sheet1');
    return Buffer.from(XLSX.write(workbook, { type: 'buffer', bookType: 'xlsx' }));
}

/** Reads back an .xlsx workbook's first sheet as an array of arrays. */
export function readXlsx(buffer) {
    const workbook = XLSX.read(buffer, { type: 'buffer' });
    const sheet = workbook.Sheets[workbook.SheetNames[0]];
    return XLSX.utils.sheet_to_json(sheet, { header: 1, raw: false, defval: '' });
}

/** Plain text of a .docx file, read with the real `mammoth` package. */
export async function readDocxText(buffer) {
    return (await mammoth.extractRawText({ buffer })).value;
}

/** A single-page PDF with `rows` of cells drawn at fixed grid positions (for row/column extraction tests). */
export async function makeTabularPdf(rows, { x0 = 40, colWidth = 100, y0 = 350, rowHeight = 24 } = {}) {
    const doc = await PDFDocument.create();
    const font = await doc.embedFont(StandardFonts.Helvetica);
    const page = doc.addPage([500, 400]);
    rows.forEach((row, r) => {
        row.forEach((cell, c) => {
            page.drawText(String(cell), { x: x0 + c * colWidth, y: y0 - r * rowHeight, size: 12, font });
        });
    });
    return Buffer.from(await doc.save());
}

/** A real PDF with `pages` numbered pages. */
export async function makePdf(pages, label = 'Doc') {
    const doc = await PDFDocument.create();
    const font = await doc.embedFont(StandardFonts.Helvetica);
    for (let i = 1; i <= pages; i++) {
        const page = doc.addPage([300, 400]);
        page.drawText(`${label} page ${i}`, { x: 40, y: 200, size: 20, font });
    }
    return Buffer.from(await doc.save());
}

/** A real PDF with one page containing an embedded JPEG image (for compression tests). */
export async function makePdfWithImage(jpegBytes, { width = 400, height = 300 } = {}) {
    const doc = await PDFDocument.create();
    const img = await doc.embedJpg(jpegBytes);
    const page = doc.addPage([width, height]);
    page.drawImage(img, { x: 0, y: 0, width, height });
    return Buffer.from(await doc.save());
}

export async function pdfPageCount(buffer) {
    return (await PDFDocument.load(buffer)).getPageCount();
}

export async function pdfPageRotations(buffer) {
    const doc = await PDFDocument.load(buffer);
    return doc.getPages().map((p) => p.getRotation().angle);
}

/** A colourful test image made by the browser's canvas (so it is a real, decodable file). */
export async function makeImage(page, { width = 800, height = 600, type = 'image/png', quality = 0.95 } = {}) {
    const dataUrl = await page.evaluate(
        ({ width, height, type, quality }) => {
            const canvas = document.createElement('canvas');
            canvas.width = width;
            canvas.height = height;
            const ctx = canvas.getContext('2d');
            const g = ctx.createLinearGradient(0, 0, width, height);
            g.addColorStop(0, '#4f46e5');
            g.addColorStop(0.5, '#db2777');
            g.addColorStop(1, '#f59e0b');
            ctx.fillStyle = g;
            ctx.fillRect(0, 0, width, height);
            // Noise so compression has real work to do.
            for (let i = 0; i < 4000; i++) {
                ctx.fillStyle = `hsl(${(i * 37) % 360} 80% 60%)`;
                ctx.fillRect((i * 97) % width, (i * 57) % height, 6, 6);
            }
            return canvas.toDataURL(type, quality);
        },
        { width, height, type, quality },
    );
    return Buffer.from(dataUrl.split(',')[1], 'base64');
}

export async function readDownload(download) {
    return fs.readFile(await download.path());
}

/** Third-party files the app does not depend on (sandboxes and proxies often block them). */
const IGNORED_SOURCES = /^https:\/\/fonts\.(googleapis|gstatic)\.com\//;

/** Fail the test on any uncaught page error or console error. */
export function trackErrors(page) {
    const errors = [];
    page.on('pageerror', (e) => errors.push(`pageerror: ${e.message}`));
    page.on('console', (msg) => {
        if (msg.type() !== 'error' || IGNORED_SOURCES.test(msg.location()?.url || '')) return;
        errors.push(`console: ${msg.text()}`);
    });
    return {
        errors,
        assertNone: () => expect(errors, errors.join('\n')).toEqual([]),
    };
}

/** Open a tool page and wait until the React tool has rendered. */
export async function openTool(page, slug) {
    await page.goto(`/${slug}`);
    await expect(page.locator('.tool-panel .tool-loading')).toHaveCount(0);
    await expect(page.locator('.tool-panel')).toBeVisible();
}

/** Serve the qpdf-wasm binary from node_modules instead of jsDelivr, so Protect/Unlock PDF tests never depend on the CDN. */
export async function mockQpdfCdn(page) {
    await page.route(/cdn\.jsdelivr\.net\/npm\/@neslinesli93\/qpdf-wasm@[^/]+\/dist\/qpdf\.wasm/, async (route) => {
        route.fulfill({
            body: await fs.readFile('node_modules/@neslinesli93/qpdf-wasm/dist/qpdf.wasm'),
            contentType: 'application/wasm',
            headers: { 'Access-Control-Allow-Origin': '*' },
        });
    });
}

const PDFJS_MJS_URL = 'https://pdfjs.e2e-test.invalid/pdf.mjs';
const PDFJS_WORKER_URL = 'https://pdfjs.e2e-test.invalid/pdf.worker.mjs';

/**
 * Checks whether `bytes` opens in a real pdf.js instance without a password, and with `password`.
 * Routes pdfjs-dist from node_modules through a fake origin instead of a CDN or the app's own bundle,
 * so this works independently of what the page currently has loaded.
 */
export async function checkPdfPassword(page, bytes, password) {
    await page.route(PDFJS_MJS_URL, async (route) => {
        route.fulfill({
            body: await fs.readFile('node_modules/pdfjs-dist/legacy/build/pdf.mjs'),
            contentType: 'text/javascript',
            headers: { 'Access-Control-Allow-Origin': '*' },
        });
    });
    await page.route(PDFJS_WORKER_URL, async (route) => {
        route.fulfill({
            body: await fs.readFile('node_modules/pdfjs-dist/legacy/build/pdf.worker.mjs'),
            contentType: 'text/javascript',
            headers: { 'Access-Control-Allow-Origin': '*' },
        });
    });

    return page.evaluate(
        async ({ bytesB64, password, pdfjsUrl, workerUrl }) => {
            const pdfjsLib = await import(pdfjsUrl);
            pdfjsLib.GlobalWorkerOptions.workerSrc = workerUrl;
            const toBytes = () => Uint8Array.from(atob(bytesB64), (c) => c.charCodeAt(0));

            const tryOpen = async (opts) => {
                try {
                    const doc = await pdfjsLib.getDocument(opts).promise;
                    return doc.numPages > 0;
                } catch {
                    return false;
                }
            };

            return {
                openedWithoutPassword: await tryOpen({ data: toBytes() }),
                openedWithPassword: await tryOpen({ data: toBytes(), password }),
            };
        },
        { bytesB64: Buffer.from(bytes).toString('base64'), password, pdfjsUrl: PDFJS_MJS_URL, workerUrl: PDFJS_WORKER_URL },
    );
}

/** Routes pdfjs-dist from node_modules through a fake origin, same as checkPdfPassword. */
export async function routePdfJs(page) {
    await page.route(PDFJS_MJS_URL, async (route) => {
        route.fulfill({
            body: await fs.readFile('node_modules/pdfjs-dist/legacy/build/pdf.mjs'),
            contentType: 'text/javascript',
            headers: { 'Access-Control-Allow-Origin': '*' },
        });
    });
    await page.route(PDFJS_WORKER_URL, async (route) => {
        route.fulfill({
            body: await fs.readFile('node_modules/pdfjs-dist/legacy/build/pdf.worker.mjs'),
            contentType: 'text/javascript',
            headers: { 'Access-Control-Allow-Origin': '*' },
        });
    });
}

/** All of a real PDF's text content (every page joined with a space), read with a real pdf.js instance. */
export async function extractPdfText(page, bytes) {
    await routePdfJs(page);
    return page.evaluate(
        async ({ bytesB64, pdfjsUrl, workerUrl }) => {
            const pdfjsLib = await import(pdfjsUrl);
            pdfjsLib.GlobalWorkerOptions.workerSrc = workerUrl;
            const data = Uint8Array.from(atob(bytesB64), (c) => c.charCodeAt(0));
            const doc = await pdfjsLib.getDocument({ data }).promise;
            let text = '';
            for (let i = 1; i <= doc.numPages; i++) {
                const page = await doc.getPage(i);
                const content = await page.getTextContent();
                text += content.items.map((it) => it.str).join(' ') + ' ';
            }
            return text.replace(/\s+/g, ' ').trim();
        },
        { bytesB64: Buffer.from(bytes).toString('base64'), pdfjsUrl: PDFJS_MJS_URL, workerUrl: PDFJS_WORKER_URL },
    );
}

/** A real PDF's text content per page (one string per page, in order), read with a real pdf.js instance. */
export async function pdfPageTexts(page, bytes) {
    await routePdfJs(page);
    return page.evaluate(
        async ({ bytesB64, pdfjsUrl, workerUrl }) => {
            const pdfjsLib = await import(pdfjsUrl);
            pdfjsLib.GlobalWorkerOptions.workerSrc = workerUrl;
            const data = Uint8Array.from(atob(bytesB64), (c) => c.charCodeAt(0));
            const doc = await pdfjsLib.getDocument({ data }).promise;
            const texts = [];
            for (let i = 1; i <= doc.numPages; i++) {
                const page = await doc.getPage(i);
                const content = await page.getTextContent();
                texts.push(content.items.map((it) => it.str).join(' ').replace(/\s+/g, ' ').trim());
            }
            return texts;
        },
        { bytesB64: Buffer.from(bytes).toString('base64'), pdfjsUrl: PDFJS_MJS_URL, workerUrl: PDFJS_WORKER_URL },
    );
}
