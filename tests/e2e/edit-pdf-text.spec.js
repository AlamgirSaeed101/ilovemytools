import { expect, test } from '@playwright/test';
import { PDFDocument, PDFName, StandardFonts } from 'pdf-lib';
import { extractPdfText, openTool, readDownload, trackErrors } from './helpers.js';

let errors;
test.beforeEach(({ page }) => {
    errors = trackErrors(page);
});
test.afterEach(() => errors.assertNone());

const PARAGRAPH = ['The quick brown fox jumps', 'over the lazy dog near', 'the old river bank.'];

/** A one-page PDF with a 3-line paragraph (Helvetica 12 pt, 14 pt apart) and a heading above it. */
async function makeParagraphPdf() {
    const doc = await PDFDocument.create();
    const font = await doc.embedFont(StandardFonts.Helvetica);
    const page = doc.addPage([400, 400]);
    page.drawText('Heading', { x: 40, y: 340, size: 20, font });
    PARAGRAPH.forEach((line, i) => page.drawText(line, { x: 40, y: 300 - i * 14, size: 12, font }));
    return Buffer.from(await doc.save());
}

async function baseFonts(bytes) {
    const doc = await PDFDocument.load(bytes);
    return doc.context
        .enumerateIndirectObjects()
        .map(([, obj]) => obj?.get?.(PDFName.of('BaseFont'))?.toString())
        .filter(Boolean);
}

async function save(page) {
    await page.getByRole('button', { name: 'Save PDF', exact: true }).click();
    const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
    return readDownload(file);
}

test.describe('Edit PDF - text editing', () => {
    // Each test edits, saves and then reads the saved PDF back with pdf.js, so give it more time.
    test.describe.configure({ timeout: 180_000 });

    test('a 3-line paragraph opens as one block, re-wraps, turns bold, moves, and replaces the old text in the saved PDF', async ({ page }) => {
        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'letter.pdf', mimeType: 'application/pdf', buffer: await makeParagraphPdf() });

        const block = page.getByRole('button', { name: `Edit text: ${PARAGRAPH.join(' ')}` });
        await expect(block).toBeVisible();
        await block.click();
        const editor = page.getByLabel('Edit this text');
        // All three lines are in the one editor. A line that ends before the next word would have
        // to wrap keeps its line break (it may be an address), so compare ignoring the kind of break.
        await expect.poll(async () => (await editor.inputValue()).replace(/\s+/g, ' ')).toBe(PARAGRAPH.join(' '));

        await editor.fill('The swift brown fox jumps over the lazy dog near the old river bank.');
        await page.getByRole('button', { name: 'Bold' }).click();
        await expect(page.getByRole('button', { name: 'Bold' })).toHaveAttribute('aria-pressed', 'true');
        await page.getByRole('button', { name: 'Done' }).click();

        // The edited block can be dragged to a new spot; its old spot stays covered.
        const box = page.locator('.pdf-editor__textbox--edit');
        await box.scrollIntoViewIfNeeded();
        const before = await box.boundingBox();
        await page.mouse.move(before.x + before.width / 2, before.y + before.height / 2);
        await page.mouse.down();
        await page.mouse.move(before.x + before.width / 2 + 20, before.y + before.height / 2 + 60, { steps: 6 });
        await page.mouse.up();
        const after = await box.boundingBox();
        expect(after.y).toBeGreaterThan(before.y + 30);
        await expect(page.locator('.pdf-editor__textcover')).toHaveCount(3);

        const bytes = await save(page);
        const text = await extractPdfText(page, bytes);
        expect(text).toContain('Heading');
        expect(text).toContain('swift');
        expect(text).not.toContain('quick');
        expect(text).toContain('river bank.');
        // Every old line is gone, not just covered: "fox jumps" appears once (the new text only).
        expect(text.split('fox').length - 1).toBe(1);
        expect(await baseFonts(bytes)).toContain('/Helvetica-Bold');
    });

    test('added text is placed with a click, typed on the page, re-edited, styled, wrapped by width and saved', async ({ page }) => {
        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'blank.pdf', mimeType: 'application/pdf', buffer: await makeParagraphPdf() });
        await page.getByRole('tab', { name: 'Add text' }).click();
        await expect.poll(async () => (await page.locator('.pdf-editor__canvas').boundingBox())?.height ?? 0).toBeGreaterThan(100);

        // Click an empty part of the page: a text box opens right there, ready to type into.
        const stage = page.locator('.pdf-editor__stage');
        await stage.scrollIntoViewIfNeeded();
        const stageBox = await stage.boundingBox();
        await page.mouse.click(stageBox.x + 60, stageBox.y + stageBox.height - 120);
        const editor = page.getByLabel('Edit this text');
        await expect(editor).toBeFocused();
        await page.keyboard.type('Typed right on the page');
        await page.getByLabel('Font', { exact: true }).selectOption({ label: 'Serif' });
        await page.getByRole('button', { name: 'Italic' }).click();
        await page.getByRole('button', { name: 'Done' }).click();
        await expect(editor).toHaveCount(0);

        // Click it again to keep typing.
        const textbox = page.locator('.pdf-editor__overlay.pdf-editor__textbox');
        await expect(textbox).toHaveCount(1);
        await textbox.click();
        await expect(page.getByLabel('Edit this text')).toHaveValue('Typed right on the page');
        await page.keyboard.press('End');
        await page.keyboard.type(' and more');

        // Narrow it with the width handle: the text wraps onto more lines.
        const oneLine = await textbox.boundingBox();
        const handle = page.locator('.pdf-editor__textwidth');
        const h = await handle.boundingBox();
        await page.mouse.move(h.x + h.width / 2, h.y + h.height / 2);
        await page.mouse.down();
        await page.mouse.move(h.x - oneLine.width * 0.55, h.y + h.height / 2, { steps: 6 });
        await page.mouse.up();
        const wrapped = await textbox.boundingBox();
        expect(wrapped.width).toBeLessThan(oneLine.width * 0.7);
        expect(wrapped.height).toBeGreaterThan(oneLine.height * 1.5);
        await page.getByRole('button', { name: 'Done' }).click();

        // Clicking empty page with nothing selected adds another box; leaving it empty drops it again.
        await page.locator('.pdf-editor__canvas').evaluate((el) => el.scrollIntoView({ block: 'end' }));
        const pageBox = await page.locator('.pdf-editor__canvas').boundingBox();
        await page.mouse.click(pageBox.x + pageBox.width * 0.7, pageBox.y + pageBox.height * 0.9);
        await expect(page.getByLabel('Edit this text')).toBeFocused();
        await page.getByRole('button', { name: 'Done' }).click();
        await expect(textbox).toHaveCount(1);

        const bytes = await save(page);
        const text = await extractPdfText(page, bytes);
        expect(text).toContain('Typed right');
        expect(text).toContain('more');
        expect(await baseFonts(bytes)).toContain('/Times-Italic');
    });
});
