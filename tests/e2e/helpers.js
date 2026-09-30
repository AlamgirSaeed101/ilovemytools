import { expect } from '@playwright/test';
import { PDFDocument, StandardFonts } from 'pdf-lib';
import fs from 'node:fs/promises';

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

export async function pdfPageCount(buffer) {
    return (await PDFDocument.load(buffer)).getPageCount();
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

/** Fail the test on any uncaught page error or console error. */
export function trackErrors(page) {
    const errors = [];
    page.on('pageerror', (e) => errors.push(`pageerror: ${e.message}`));
    page.on('console', (msg) => {
        if (msg.type() === 'error') errors.push(`console: ${msg.text()}`);
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
