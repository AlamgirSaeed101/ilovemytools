import { expect, test } from '@playwright/test';
import JSZip from 'jszip';
import { PDFDocument, PDFName } from 'pdf-lib';
import {
    checkPdfPassword, extractPdfText, makeDocx, makeImage, makePdf, makePdfWithFormFields, makePdfWithImage, makeTabularPdf, makeXlsx,
    mockQpdfCdn, openTool, pdfPageCount, pdfPageRotations, pdfPageTexts, readDocxText, readDownload, readXlsx, trackErrors,
} from './helpers.js';

let errors;
test.beforeEach(({ page }) => {
    errors = trackErrors(page);
});
test.afterEach(() => errors.assertNone());

const stat = (page, label) =>
    page.locator('.stat').filter({ has: page.locator('.stat__label', { hasText: new RegExp(`^${label}$`) }) }).locator('.stat__value');

const pngSize = (buf) => ({ width: buf.readUInt32BE(16), height: buf.readUInt32BE(20) });

// Edit PDF toolbar: grouped tools sit in a menu under their group button.
const TOOL_MENUS = {
    'Edit existing text': 'Text',
    'Add new text': 'Text',
    Highlight: 'Annotate',
    Underline: 'Annotate',
    Strikethrough: 'Annotate',
    Draw: 'Annotate',
    Rectangle: 'Shapes',
    Ellipse: 'Shapes',
    Line: 'Shapes',
    Arrow: 'Shapes',
    'Sticky note': 'Annotate',
};
const toolButton = (page, name) => page.getByRole('toolbar', { name: 'PDF editing tools' }).getByRole('button', { name, exact: true });
async function pickTool(page, name) {
    const group = TOOL_MENUS[name];
    if (!group) return toolButton(page, name).click();
    await toolButton(page, group).click();
    await page.getByRole('menuitemradio', { name, exact: true }).click();
}
async function expectTool(page, name) {
    const group = TOOL_MENUS[name];
    if (group) await expect(toolButton(page, group)).toHaveAttribute('title', `${group}: ${name}`);
    else await expect(toolButton(page, name)).toHaveAttribute('aria-pressed', 'true');
}

test.describe('Text tools', () => {
    test('word counter counts words, sentences, paragraphs and keywords', async ({ page }) => {
        await openTool(page, 'word-counter');
        await page.getByLabel('Your text').fill("Gardens grow. Gardens bloom! Don't don't stop.\n\nNew paragraph here");
        await expect(stat(page, 'Words')).toHaveText('10');
        await expect(stat(page, 'Sentences')).toHaveText('4');
        await expect(stat(page, 'Paragraphs')).toHaveText('2');
        const keywords = page.locator('.keyword-list');
        await expect(keywords).toContainText('gardens 2');
        await expect(keywords).not.toContainText("don't"); // stop word (regression)

        await page.getByRole('button', { name: 'Clear' }).click();
        await expect(stat(page, 'Words')).toHaveText('0');
    });

    test('case converter converts between cases and downloads', async ({ page }) => {
        await openTool(page, 'case-converter');
        const box = page.getByLabel('Your text');
        await box.fill('the quick brown fox of the forest');
        await page.getByRole('button', { name: 'Title Case' }).click();
        await expect(box).toHaveValue('The Quick Brown Fox of the Forest');
        await page.getByRole('button', { name: 'snake_case' }).click();
        await expect(box).toHaveValue('the_quick_brown_fox_of_the_forest');
        await page.getByRole('button', { name: 'camelCase' }).click();
        await expect(box).toHaveValue('theQuickBrownFoxOfTheForest');
        await page.getByRole('button', { name: 'UPPERCASE' }).click();
        await expect(box).toHaveValue('THEQUICKBROWNFOXOFTHEFOREST');

        const [download] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download .txt' }).click()]);
        expect(download.suggestedFilename()).toBe('converted-text.txt');
        expect((await readDownload(download)).toString()).toBe('THEQUICKBROWNFOXOFTHEFOREST');

        // A finished tool suggests a next step instead of ending the visit.
        const next = page.getByRole('region', { name: 'Done! What would you like to do next?' });
        await expect(next).toBeVisible();
        await expect(next.getByRole('link')).not.toHaveCount(0);
    });
});

test.describe('Generators', () => {
    test('password generator respects length and character options', async ({ page }) => {
        await openTool(page, 'password-generator');
        const output = page.locator('#pw-output');
        await expect(output).toHaveValue(/^.{16}$/);

        await page.getByLabel('Password length').fill('40');
        await expect(output).toHaveValue(/^.{40}$/);

        await page.getByLabel('Symbols (!@#$…)').uncheck();
        await page.getByLabel('Uppercase (A-Z)').uncheck();
        await page.getByLabel('Lowercase (a-z)').uncheck();
        await expect(output).toHaveValue(/^[0-9]{40}$/);
        await page.getByLabel('Exclude similar (l, 1, O, 0)').check();
        await expect(output).toHaveValue(/^[2-9]{40}$/);

        const before = await output.inputValue();
        await page.getByRole('button', { name: 'Generate password' }).click();
        await expect(output).not.toHaveValue(before);

        await page.getByLabel('Numbers (0-9)').uncheck();
        await expect(page.getByRole('button', { name: 'Generate password' })).toBeDisabled();
        await expect(page.locator('#pw-strength')).toContainText('—');
    });

    test('QR code generator renders and downloads PNG and SVG', async ({ page }) => {
        await openTool(page, 'qr-code-generator');
        await expect(page.getByText('Enter a website address.')).toBeVisible();
        await page.getByLabel('Website URL').fill('example.com/hello');
        const canvas = page.getByRole('img', { name: 'QR code preview' });
        await expect(canvas).toBeVisible();

        const [png] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PNG' }).click()]);
        const pngBuf = await readDownload(png);
        expect(pngBuf.subarray(1, 4).toString()).toBe('PNG');
        expect(pngSize(pngBuf)).toEqual({ width: 512, height: 512 });

        const [svg] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download SVG' }).click()]);
        expect((await readDownload(svg)).toString()).toContain('<svg');

        // Wi-Fi validation and generation.
        await page.getByRole('tab', { name: 'Wi-Fi' }).click();
        await page.getByLabel('Network name (SSID)').fill('Home;Net');
        await expect(page.getByText('Enter the Wi-Fi password')).toBeVisible();
        await page.getByLabel('Password').fill('secret');
        await expect(canvas).toBeVisible();

        // Too much data for one QR code shows a friendly error.
        await page.getByRole('tab', { name: 'Text' }).click();
        await page.getByLabel('Text').fill('x'.repeat(3500));
        await expect(page.getByText('too much data for one QR code')).toBeVisible();
        await expect(page.getByRole('button', { name: 'Download PNG' })).toBeDisabled();
    });
});

test.describe('Image tools', () => {
    test('image compressor compresses several images and zips them', async ({ page }) => {
        await openTool(page, 'image-compressor');
        const jpg = await makeImage(page, { width: 1600, height: 1200, type: 'image/jpeg', quality: 0.98 });
        const png = await makeImage(page, { width: 900, height: 700, type: 'image/png' });

        await page.getByTestId('file-input').setInputFiles([
            { name: 'photo.jpg', mimeType: 'image/jpeg', buffer: jpg },
            // No MIME type, as some systems report (regression): detected from the extension.
            { name: 'graphic.png', mimeType: '', buffer: png },
        ]);

        const items = page.locator('.file-item');
        await expect(items).toHaveCount(2);
        await expect(items.getByRole('button', { name: 'Download' })).toHaveCount(2, { timeout: 30_000 });
        await expect(items.first()).toContainText('−'); // smaller than the original

        const [one] = await Promise.all([page.waitForEvent('download'), items.first().getByRole('button', { name: 'Download' }).click()]);
        expect(one.suggestedFilename()).toBe('photo-compressed.jpg');
        expect((await readDownload(one)).length).toBeLessThan(jpg.length);

        const [zip] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download all (ZIP)' }).click()]);
        const archive = await JSZip.loadAsync(await readDownload(zip));
        expect(Object.keys(archive.files).sort()).toEqual(['graphic-compressed.png', 'photo-compressed.jpg']);
    });

    test('image compressor hits a target file size', async ({ page }) => {
        await openTool(page, 'image-compressor');
        await page.getByRole('tab', { name: /Target size/ }).click();
        await page.getByLabel('Maximum file size (KB)').fill('40');
        await page.getByLabel('Output format').selectOption('image/webp');
        const jpg = await makeImage(page, { width: 1600, height: 1200, type: 'image/jpeg', quality: 1 });
        await page.getByTestId('file-input').setInputFiles({ name: 'big.jpg', mimeType: 'image/jpeg', buffer: jpg });

        const download = page.locator('.file-item').getByRole('button', { name: 'Download' });
        await expect(download).toBeVisible({ timeout: 30_000 });
        const [file] = await Promise.all([page.waitForEvent('download'), download.click()]);
        expect(file.suggestedFilename()).toBe('big-compressed.webp');
        expect((await readDownload(file)).length).toBeLessThanOrEqual(40 * 1024);

        // Rejects non-images.
        await page.getByTestId('file-input').setInputFiles({ name: 'notes.txt', mimeType: 'text/plain', buffer: Buffer.from('hi') });
        await expect(page.getByText('only JPG, PNG and WebP images are supported')).toBeVisible();
    });

    test('format converters: WebP to PNG, PNG to JPG and JPG to PNG in batches', async ({ page }) => {
        const isPng = (buf) => buf[0] === 0x89 && buf.subarray(1, 4).toString() === 'PNG';
        const isJpg = (buf) => buf[0] === 0xff && buf[1] === 0xd8;

        // WebP -> PNG, two files, ZIP download.
        await openTool(page, 'webp-to-png');
        await expect(page.getByRole('heading', { level: 1 })).toHaveText('WebP to PNG Converter');
        const webp = await makeImage(page, { width: 320, height: 200, type: 'image/webp' });
        await page.getByTestId('file-input').setInputFiles([
            { name: 'first.webp', mimeType: 'image/webp', buffer: webp },
            { name: 'second.webp', mimeType: 'image/webp', buffer: webp },
        ]);
        const items = page.locator('.file-item');
        await expect(items.getByRole('button', { name: 'Download' })).toHaveCount(2, { timeout: 30_000 });
        await expect(page.getByText('2 images converted to PNG')).toBeVisible();
        const [one] = await Promise.all([page.waitForEvent('download'), items.first().getByRole('button', { name: 'Download' }).click()]);
        expect(one.suggestedFilename()).toBe('first.png');
        expect(isPng(await readDownload(one))).toBe(true);
        const [zip] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download all (ZIP)' }).click()]);
        expect(zip.suggestedFilename()).toBe('converted-to-png.zip');
        const archive = await JSZip.loadAsync(await readDownload(zip));
        expect(Object.keys(archive.files).sort()).toEqual(['first.png', 'second.png']);

        // PNG -> JPG with a quality setting and the transparency notice.
        await openTool(page, 'png-to-jpg');
        await page.getByLabel(/Quality/).fill('80');
        const png = await makeImage(page, { width: 400, height: 300, type: 'image/png' });
        await page.getByTestId('file-input').setInputFiles({ name: 'logo.png', mimeType: 'image/png', buffer: png });
        await expect(page.getByRole('status').filter({ hasText: 'JPG has no transparency' })).toBeVisible();
        const jpgButton = page.locator('.file-item').getByRole('button', { name: 'Download' });
        await expect(jpgButton).toBeVisible({ timeout: 30_000 });
        const [jpgFile] = await Promise.all([page.waitForEvent('download'), jpgButton.click()]);
        expect(jpgFile.suggestedFilename()).toBe('logo.jpg');
        expect(isJpg(await readDownload(jpgFile))).toBe(true);

        // JPG -> PNG, and non-images are rejected.
        await openTool(page, 'jpg-to-png');
        const jpg = await makeImage(page, { width: 300, height: 300, type: 'image/jpeg' });
        await page.getByTestId('file-input').setInputFiles({ name: 'photo.jpeg', mimeType: 'image/jpeg', buffer: jpg });
        const pngButton = page.locator('.file-item').getByRole('button', { name: 'Download' });
        await expect(pngButton).toBeVisible({ timeout: 30_000 });
        const [pngFile] = await Promise.all([page.waitForEvent('download'), pngButton.click()]);
        expect(pngFile.suggestedFilename()).toBe('photo.png');
        expect(isPng(await readDownload(pngFile))).toBe(true);
        await page.getByTestId('file-input').setInputFiles({ name: 'notes.txt', mimeType: 'text/plain', buffer: Buffer.from('hi') });
        await expect(page.getByText('please choose JPG, PNG, WebP, AVIF, GIF or BMP images')).toBeVisible();
    });

    test('image resizer keeps aspect ratio and outputs the exact size', async ({ page }) => {
        await openTool(page, 'image-resizer');
        const png = await makeImage(page, { width: 800, height: 600, type: 'image/png' });
        await page.getByTestId('file-input').setInputFiles({ name: 'pic.png', mimeType: 'image/png', buffer: png });

        const width = page.getByLabel('Width (px)');
        const height = page.getByLabel('Height (px)');
        await expect(width).toHaveValue('800');
        await width.fill('400');
        await expect(height).toHaveValue('300');

        // Regression: re-ticking the lock recalculates the height.
        await page.getByLabel('Lock aspect ratio').uncheck();
        await height.fill('100');
        await page.getByLabel('Lock aspect ratio').check();
        await expect(height).toHaveValue('300');

        await page.getByRole('button', { name: 'Resize to 400 × 300px' }).click();
        await expect(page.getByText('Resized to')).toContainText('400 × 300px');
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download image' }).click()]);
        expect(file.suggestedFilename()).toBe('pic-400x300.png');
        expect(pngSize(await readDownload(file))).toEqual({ width: 400, height: 300 });

        // Percentage mode + convert to JPG.
        await page.getByRole('tab', { name: 'By percentage' }).click();
        await page.getByLabel('Save as').selectOption('image/jpeg');
        await page.getByRole('button', { name: 'Resize to 400 × 300px' }).click();
        const [jpg] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download image' }).click()]);
        const buf = await readDownload(jpg);
        expect(jpg.suggestedFilename()).toBe('pic-400x300.jpg');
        expect(buf[0]).toBe(0xff);
        expect(buf[1]).toBe(0xd8);
    });
});

test.describe('PDF tools', () => {
    test('merge PDF combines files in the chosen order', async ({ page }) => {
        await openTool(page, 'merge-pdf');
        await page.getByTestId('file-input').setInputFiles([
            { name: 'a.pdf', mimeType: 'application/pdf', buffer: await makePdf(2, 'A') },
            { name: 'b.pdf', mimeType: 'application/pdf', buffer: await makePdf(3, 'B') },
        ]);
        await expect(page.getByText('2 files · 5 pages in total')).toBeVisible();
        await page.getByRole('button', { name: 'Move a.pdf down' }).click();
        await expect(page.locator('.file-item__name').first()).toHaveText('b.pdf');

        await page.getByRole('button', { name: 'Merge PDF', exact: true }).click();
        await expect(page.getByText('Your merged PDF has')).toContainText('5 pages');
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download merged PDF' }).click()]);
        expect(file.suggestedFilename()).toBe('merged.pdf');
        expect(await pdfPageCount(await readDownload(file))).toBe(5);

        // A damaged file is reported and blocks merging until removed.
        await page.getByTestId('file-input').setInputFiles({ name: 'broken.pdf', mimeType: 'application/pdf', buffer: Buffer.from('not a pdf') });
        await expect(page.getByText('"broken.pdf" could not be read')).toBeVisible();
        await expect(page.getByRole('button', { name: 'Merge PDF', exact: true })).toBeDisabled();
        await page.getByRole('button', { name: 'Remove broken.pdf' }).click();
        await expect(page.getByRole('button', { name: 'Merge PDF', exact: true })).toBeEnabled();
    });

    test('split PDF extracts pages and splits every page into a ZIP', async ({ page }) => {
        await openTool(page, 'split-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'report.pdf', mimeType: 'application/pdf', buffer: await makePdf(5) });
        await expect(page.getByText('report.pdf')).toBeVisible();

        const ranges = page.getByLabel('Pages to extract');
        await ranges.fill('9');
        await expect(page.getByText('This PDF only has 5 pages')).toBeVisible();
        await ranges.fill('1, 3-4');
        await page.getByRole('button', { name: 'Split PDF' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(file.suggestedFilename()).toBe('report-pages-1_3-4.pdf');
        expect(await pdfPageCount(await readDownload(file))).toBe(3);

        await page.getByRole('tab', { name: 'Split every page' }).click();
        await page.getByRole('button', { name: 'Split PDF' }).click();
        const [zip] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download ZIP' }).click()]);
        const archive = await JSZip.loadAsync(await readDownload(zip));
        expect(Object.keys(archive.files)).toHaveLength(5);
        expect(await pdfPageCount(await archive.file('report-page-2.pdf').async('nodebuffer'))).toBe(1);
    });

    test('JPG to PDF combines images into one PDF', async ({ page }) => {
        await openTool(page, 'jpg-to-pdf');
        const jpg = await makeImage(page, { width: 300, height: 200, type: 'image/jpeg', quality: 0.9 });
        const png = await makeImage(page, { width: 200, height: 300, type: 'image/png' });

        await page.getByTestId('file-input').setInputFiles([
            { name: 'photo.jpg', mimeType: 'image/jpeg', buffer: jpg },
            { name: 'portrait.png', mimeType: 'image/png', buffer: png },
        ]);
        await expect(page.locator('.file-item')).toHaveCount(2);
        await expect(page.getByText('2 images')).toBeVisible();

        await page.getByLabel('Page size').selectOption('fit');
        await expect(page.getByLabel('Orientation')).toBeDisabled();

        await page.getByRole('button', { name: 'Convert to PDF' }).click();
        await expect(page.getByText('Your PDF has')).toContainText('2 pages');
        const [zipFile] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(zipFile.suggestedFilename()).toBe('images.pdf');
        expect(await pdfPageCount(await readDownload(zipFile))).toBe(2);

        // Removing an image clears the result and a single image downloads under its own name.
        await page.getByRole('button', { name: 'Remove portrait.png' }).click();
        await expect(page.locator('.file-item')).toHaveCount(1);
        await page.getByRole('button', { name: 'Convert to PDF' }).click();
        const [singleFile] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(singleFile.suggestedFilename()).toBe('photo.pdf');
        expect(await pdfPageCount(await readDownload(singleFile))).toBe(1);

        // Rejects non-images.
        await page.getByTestId('file-input').setInputFiles({ name: 'notes.txt', mimeType: 'text/plain', buffer: Buffer.from('hi') });
        await expect(page.getByText('only JPG, PNG and WebP images are supported')).toBeVisible();
    });

    test('rotate PDF turns selected pages, or every page when none is selected', async ({ page }) => {
        await openTool(page, 'rotate-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'doc.pdf', mimeType: 'application/pdf', buffer: await makePdf(3) });
        await expect(page.locator('.page-card')).toHaveCount(3);

        // Rotating just the selected page leaves the others untouched.
        await expect(page.getByRole('button', { name: 'Rotate PDF' })).toBeDisabled();
        await page.getByLabel('Select page 2').check();
        await page.getByRole('button', { name: 'Rotate right 90 degrees' }).click();
        await expect(page.getByRole('button', { name: 'Rotate PDF' })).toBeEnabled();
        await page.getByRole('button', { name: 'Rotate PDF' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(file.suggestedFilename()).toBe('doc-rotated.pdf');
        expect(await pdfPageRotations(await readDownload(file))).toEqual([0, 90, 0]);

        // Starting over with no page selected rotates every page.
        await page.getByRole('button', { name: 'Choose another PDF' }).click();
        await page.getByTestId('file-input').setInputFiles({ name: 'doc2.pdf', mimeType: 'application/pdf', buffer: await makePdf(2) });
        await expect(page.locator('.page-card')).toHaveCount(2);
        await page.getByRole('button', { name: 'Rotate 180 degrees' }).click();
        await page.getByRole('button', { name: 'Rotate PDF' }).click();
        const [file2] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(await pdfPageRotations(await readDownload(file2))).toEqual([180, 180]);
    });

    test('delete PDF pages removes the marked pages, by ranges or by thumbnail', async ({ page }) => {
        await openTool(page, 'delete-pdf-pages');
        await page.getByTestId('file-input').setInputFiles({ name: 'doc.pdf', mimeType: 'application/pdf', buffer: await makePdf(4) });
        await expect(page.locator('.page-card')).toHaveCount(4);

        await page.getByRole('tab', { name: 'Page ranges' }).click();
        await page.getByLabel('Pages to delete').fill('2, 4');
        await expect(page.getByText('2 pages marked for deletion')).toBeVisible();
        await page.getByRole('button', { name: 'Delete pages' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(file.suggestedFilename()).toBe('doc-pages-deleted.pdf');
        expect(await pdfPageCount(await readDownload(file))).toBe(2);

        // Deleting every page is blocked, whichever way pages are picked.
        await page.getByRole('button', { name: 'Choose another PDF' }).click();
        await page.getByTestId('file-input').setInputFiles({ name: 'two.pdf', mimeType: 'application/pdf', buffer: await makePdf(2) });
        await expect(page.locator('.page-card')).toHaveCount(2);
        await page.getByLabel('Delete page 1').check();
        await page.getByLabel('Delete page 2').check();
        await expect(page.getByText("You can't delete every page")).toBeVisible();
        await expect(page.getByRole('button', { name: 'Delete pages' })).toBeDisabled();
    });

    test('organize PDF reorders pages with the move buttons', async ({ page }) => {
        await openTool(page, 'organize-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'doc.pdf', mimeType: 'application/pdf', buffer: await makePdf(3, 'Doc') });
        await expect(page.locator('.page-card')).toHaveCount(3);
        await expect(page.getByRole('button', { name: 'Save new order' })).toBeDisabled();

        // Move page 1 later twice: new order is 2, 3, 1.
        await page.getByRole('button', { name: 'Move page 1 later' }).click();
        await page.getByRole('button', { name: 'Move page 1 later' }).click();
        const labels = await page.locator('.page-card').evaluateAll((els) => els.map((el) => el.getAttribute('aria-label')));
        expect(labels).toEqual(['Page 2', 'Page 3', 'Page 1']);
        await expect(page.locator('.page-card__number')).toHaveText(['1', '2', '3']);
        await expect(page.getByRole('button', { name: 'Save new order' })).toBeEnabled();

        await page.getByRole('button', { name: 'Save new order' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(file.suggestedFilename()).toBe('doc-organized.pdf');
        expect(await pdfPageCount(await readDownload(file))).toBe(3);
    });

    test('PDF to JPG renders a single page as one image and several pages as a ZIP', async ({ page }) => {
        await openTool(page, 'pdf-to-jpg');
        await page.getByTestId('file-input').setInputFiles({ name: 'doc.pdf', mimeType: 'application/pdf', buffer: await makePdf(1) });
        await expect(page.locator('.page-card')).toHaveCount(1);
        await page.getByLabel('Image quality (DPI)').selectOption('72');

        await page.getByRole('button', { name: 'Convert', exact: true }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download image' }).click()]);
        expect(file.suggestedFilename()).toBe('doc.jpg');
        const buf = await readDownload(file);
        expect(buf[0]).toBe(0xff);
        expect(buf[1]).toBe(0xd8);

        await page.getByRole('button', { name: 'Choose another PDF' }).click();
        await page.getByTestId('file-input').setInputFiles({ name: 'multi.pdf', mimeType: 'application/pdf', buffer: await makePdf(2) });
        await expect(page.locator('.page-card')).toHaveCount(2);
        await page.getByRole('button', { name: 'Convert', exact: true }).click();
        const [zip] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download ZIP' }).click()]);
        expect(zip.suggestedFilename()).toBe('multi.zip');
        const archive = await JSZip.loadAsync(await readDownload(zip));
        expect(Object.keys(archive.files).sort()).toEqual(['multi-page-1.jpg', 'multi-page-2.jpg']);
    });

    test('PDF to PNG renders pages as lossless PNG images', async ({ page }) => {
        await openTool(page, 'pdf-to-png');
        await page.getByTestId('file-input').setInputFiles({ name: 'doc.pdf', mimeType: 'application/pdf', buffer: await makePdf(1) });
        await expect(page.locator('.page-card')).toHaveCount(1);

        await page.getByRole('button', { name: 'Convert', exact: true }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download image' }).click()]);
        expect(file.suggestedFilename()).toBe('doc.png');
        const buf = await readDownload(file);
        expect(buf.subarray(0, 8)).toEqual(Buffer.from([0x89, 0x50, 0x4e, 0x47, 0x0d, 0x0a, 0x1a, 0x0a]));
    });

    test('compress PDF shrinks an image-heavy PDF in both modes and keeps the original if it cannot shrink', async ({ page }) => {
        await openTool(page, 'compress-pdf');
        const jpeg = await makeImage(page, { width: 900, height: 600, type: 'image/jpeg', quality: 0.95 });
        const original = await makePdfWithImage(jpeg, { width: 450, height: 300 });
        await page.getByTestId('file-input').setInputFiles({ name: 'photos.pdf', mimeType: 'application/pdf', buffer: original });
        await expect(page.getByText('photos.pdf')).toBeVisible();

        // Recommended mode re-encodes the embedded JPEG at a lower quality - the file gets smaller.
        await page.getByRole('button', { name: 'Compress PDF' }).click();
        const [recommended] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(recommended.suggestedFilename()).toBe('photos-compressed.pdf');
        const recommendedBuf = await readDownload(recommended);
        expect(recommendedBuf.length).toBeLessThan(original.length);
        expect(await pdfPageCount(recommendedBuf)).toBe(1);

        // Strong mode rasterises the page to a JPEG at the chosen DPI - still one valid page.
        await page.getByRole('tab', { name: 'Strong' }).click();
        await page.getByLabel('Image quality (DPI)').selectOption('72');
        await page.getByRole('button', { name: 'Compress PDF' }).click();
        const [strong] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(await pdfPageCount(await readDownload(strong))).toBe(1);

        // A text-only PDF has nothing left to recompress, so the original is kept.
        await page.getByRole('button', { name: 'Choose another PDF' }).click();
        const textOnly = await makePdf(1);
        await page.getByTestId('file-input').setInputFiles({ name: 'text.pdf', mimeType: 'application/pdf', buffer: textOnly });
        await page.getByRole('tab', { name: 'Recommended' }).click();
        await page.getByRole('button', { name: 'Compress PDF' }).click();
        await expect(page.getByText('could not be made smaller')).toBeVisible();
        const [kept] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect((await readDownload(kept)).length).toBe(textOnly.length);
    });

    test('protect PDF adds a real AES password and unlock PDF removes it', async ({ page }) => {
        await mockQpdfCdn(page);
        const password = 'correct-horse-9';

        await openTool(page, 'protect-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'secret.pdf', mimeType: 'application/pdf', buffer: await makePdf(2) });
        await expect(page.getByText('secret.pdf')).toBeVisible();
        await page.getByLabel('Choose a password').fill(password);
        await page.getByLabel('Confirm password').fill('does-not-match');
        await expect(page.getByText('Passwords do not match.')).toBeVisible();
        await expect(page.getByRole('button', { name: 'Protect PDF' })).toBeDisabled();
        await page.getByLabel('Confirm password').fill(password);

        await page.getByRole('button', { name: 'Protect PDF' }).click();
        const [protectedFile] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download protected PDF' }).click()]);
        expect(protectedFile.suggestedFilename()).toBe('secret-protected.pdf');
        const protectedBytes = await readDownload(protectedFile);

        const check = await checkPdfPassword(page, protectedBytes, password);
        expect(check.openedWithoutPassword).toBe(false);
        expect(check.openedWithPassword).toBe(true);

        await openTool(page, 'unlock-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'secret-protected.pdf', mimeType: 'application/pdf', buffer: protectedBytes });
        await expect(page.getByLabel('PDF password')).toBeVisible();

        await page.getByLabel('PDF password').fill('wrong-password');
        await page.getByRole('button', { name: 'Unlock PDF' }).click();
        await expect(page.getByText('Incorrect password. Please try again.')).toBeVisible();
        // qpdf-wasm itself logs this expected "invalid password" message to the console (it has no
        // configurable stderr hook); our own error handling already surfaced the friendly message above.
        errors.errors.splice(0, errors.errors.length, ...errors.errors.filter((e) => !e.includes('invalid password')));

        await page.getByLabel('PDF password').fill(password);
        await page.getByRole('button', { name: 'Unlock PDF' }).click();
        const [unlockedFile] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download unlocked PDF' }).click()]);
        expect(unlockedFile.suggestedFilename()).toBe('secret-protected-unlocked.pdf');
        const unlockedBytes = await readDownload(unlockedFile);
        expect(await pdfPageCount(unlockedBytes)).toBe(2);
        expect((await checkPdfPassword(page, unlockedBytes, password)).openedWithoutPassword).toBe(true);

        // A PDF with no password at all has nothing to unlock.
        await openTool(page, 'unlock-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'plain.pdf', mimeType: 'application/pdf', buffer: await makePdf(1) });
        await expect(page.getByText('does not have a password')).toBeVisible();
    });

    test('HTML to PDF converts pasted HTML with headings, bold text and lists', async ({ page }) => {
        await openTool(page, 'html-to-pdf');
        await page.getByLabel('HTML or plain text').fill('<h1>Report Title</h1><p>Hello <b>World</b></p><ul><li>First item</li><li>Second item</li></ul>');
        await page.getByRole('button', { name: 'Convert to PDF' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(file.suggestedFilename()).toBe('document.pdf');
        const text = await extractPdfText(page, await readDownload(file));
        expect(text).toContain('Report Title');
        expect(text).toContain('World');
        expect(text).toContain('First item');
        expect(text).toContain('Second item');
    });

    test('Word to PDF keeps headings and bold text from a real .docx file', async ({ page }) => {
        await openTool(page, 'word-to-pdf');
        const docx = await makeDocx({ heading: 'Report Title', plain: 'Hello ', bold: 'World' });
        await page.getByTestId('file-input').setInputFiles({
            name: 'report.docx',
            mimeType: 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            buffer: docx,
        });
        await expect(page.getByText('report.docx', { exact: true })).toBeVisible();
        await page.getByRole('button', { name: 'Convert to PDF' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(file.suggestedFilename()).toBe('report.pdf');
        const text = await extractPdfText(page, await readDownload(file));
        expect(text).toContain('Report Title');
        expect(text).toContain('World');
    });

    test('PDF to Word extracts text into a real, editable .docx file', async ({ page }) => {
        await openTool(page, 'pdf-to-word');
        await page.getByTestId('file-input').setInputFiles({ name: 'report.pdf', mimeType: 'application/pdf', buffer: await makePdf(1, 'Report') });
        await expect(page.getByText('report.pdf', { exact: true })).toBeVisible();
        await page.getByRole('button', { name: 'Convert to Word' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download Word document' }).click()]);
        expect(file.suggestedFilename()).toBe('report.docx');
        const text = await readDocxText(await readDownload(file));
        expect(text).toContain('Report page 1');
    });

    test('Excel to PDF turns a spreadsheet into a paginated PDF table', async ({ page }) => {
        await openTool(page, 'excel-to-pdf');
        const xlsx = makeXlsx([['Name', 'Age'], ['Alice', '30'], ['Bob', '25']]);
        await page.getByTestId('file-input').setInputFiles({
            name: 'people.xlsx',
            mimeType: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            buffer: xlsx,
        });
        await expect(page.getByText('people.xlsx', { exact: true })).toBeVisible();
        await page.getByRole('button', { name: 'Convert to PDF' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(file.suggestedFilename()).toBe('people.pdf');
        const text = await extractPdfText(page, await readDownload(file));
        expect(text).toContain('Alice');
        expect(text).toContain('Bob');
    });

    test('PDF to Excel groups text into rows and columns of a real .xlsx file', async ({ page }) => {
        await openTool(page, 'pdf-to-excel');
        const pdf = await makeTabularPdf([['Name', 'Age'], ['Alice', '30'], ['Bob', '25']]);
        await page.getByTestId('file-input').setInputFiles({ name: 'table.pdf', mimeType: 'application/pdf', buffer: pdf });
        await expect(page.getByText('table.pdf', { exact: true })).toBeVisible();
        await page.getByRole('button', { name: 'Convert to Excel' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download spreadsheet' }).click()]);
        expect(file.suggestedFilename()).toBe('table.xlsx');
        const rows = readXlsx(await readDownload(file));
        expect(rows[0]).toEqual(['Name', 'Age']);
        expect(rows[1][0]).toBe('Alice');
        expect(rows[2][0]).toBe('Bob');
    });

    test('signature lives inside Edit PDF as its own tab: draws a signature, places it on the page and signs the file', async ({ page }) => {
        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'contract.pdf', mimeType: 'application/pdf', buffer: await makePdf(2) });
        await expect(page.getByText('contract.pdf', { exact: true })).toBeVisible();
        await pickTool(page, 'Sign');

        // Draw a signature on the pad, then use it.
        const pad = page.locator('.signature-pad');
        await pad.scrollIntoViewIfNeeded();
        const box = await pad.boundingBox();
        await page.mouse.move(box.x + 20, box.y + box.height / 2);
        await page.mouse.down();
        await page.mouse.move(box.x + box.width - 20, box.y + box.height / 2 - 20, { steps: 5 });
        await page.mouse.up();
        await expect(page.getByRole('button', { name: 'Use this signature' })).toBeEnabled();
        await page.getByRole('button', { name: 'Use this signature' }).click();
        await expect(page.getByText('Signature ready.')).toBeVisible();

        // Add a date, place the signature, then drag it to a new position.
        await page.getByLabel("Add today's date under the signature").check();
        await page.getByRole('button', { name: 'Add signature to this page' }).click();
        const overlay = page.locator('.pdf-editor__overlay');
        await expect(overlay).toHaveCount(1);
        await expect(page.locator('.pdf-editor__date')).toBeVisible();
        await overlay.scrollIntoViewIfNeeded();

        const before = await overlay.boundingBox();
        await page.mouse.move(before.x + before.width / 2, before.y + before.height / 2);
        await page.mouse.down();
        await page.mouse.move(before.x + 60, before.y + 40, { steps: 5 });
        await page.mouse.up();
        const after = await overlay.boundingBox();
        expect(after.x).not.toBeCloseTo(before.x, 0);

        // Sign and download; the file keeps its page count and grows (the signature image was embedded).
        const originalBytes = await makePdf(2);
        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(file.suggestedFilename()).toBe('contract-signed.pdf');
        const signedBytes = await readDownload(file);
        expect(await pdfPageCount(signedBytes)).toBe(2);
        expect(signedBytes.length).toBeGreaterThan(originalBytes.length);

        // Switching to another tab leaves the placed signature in place; switching back still shows it.
        await pickTool(page, 'Edit existing text');
        await pickTool(page, 'Sign');
        await expect(overlay).toHaveCount(1);
    });

    test('sign-pdf opens Edit PDF with the Signature tab preselected, and the full editor stays reachable', async ({ page }) => {
        await openTool(page, 'sign-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'contract.pdf', mimeType: 'application/pdf', buffer: await makePdf(1) });
        await expectTool(page, 'Sign');
        await expect(page.getByText('Create your signature')).toBeVisible();

        // The one editor is still underneath: every other tab is reachable from this page too.
        await expect(toolButton(page, 'Text')).toBeVisible();
        await expect(toolButton(page, 'Watermark')).toBeVisible();
    });

    test('signature: a typed signature saved on the device survives a reload, is placed where you click, and can be deleted', async ({ page }) => {
        // Nothing about the signature is ever uploaded: no request carries a body.
        const bodies = [];
        page.on('request', (req) => {
            if (req.postData()) bodies.push(req.url());
        });

        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'contract.pdf', mimeType: 'application/pdf', buffer: await makePdf(1) });
        await pickTool(page, 'Sign');
        await page.getByRole('tab', { name: 'Type' }).click();
        await page.getByLabel('Type your name').fill('Jane Doe');
        await page.getByLabel('Remember on this device').check();
        await page.getByRole('button', { name: 'Use this signature' }).click();
        await expect(page.getByText('Signature ready.')).toBeVisible();
        await expect(page.getByRole('button', { name: 'Use saved signature 1' })).toBeVisible();

        // A click on the page places the picked signature centred on the pointer.
        const stage = page.locator('.pdf-editor__stage');
        await stage.scrollIntoViewIfNeeded();
        const box = await stage.boundingBox();
        await page.mouse.click(box.x + box.width * 0.3, box.y + box.height * 0.4);
        const overlay = page.locator('.pdf-editor__overlay');
        await expect(overlay).toHaveCount(1);
        // Measured against the stage again: the signature's controls can appear above the page and move it down.
        const placed = await overlay.boundingBox();
        const after = await stage.boundingBox();
        expect(placed.x + placed.width / 2 - after.x).toBeCloseTo(box.width * 0.3, -1);
        expect(placed.y + placed.height / 2 - after.y).toBeCloseTo(box.height * 0.4, -1);

        // After a reload the saved signature is still offered, and placing it again works.
        await page.reload();
        await page.getByTestId('file-input').setInputFiles({ name: 'contract.pdf', mimeType: 'application/pdf', buffer: await makePdf(1) });
        await pickTool(page, 'Sign');
        await page.getByRole('button', { name: 'Use saved signature 1' }).click();
        await expect(page.getByText('Signature ready.')).toBeVisible();
        await page.getByRole('button', { name: 'Add signature to this page' }).click();
        await expect(page.locator('.pdf-editor__overlay')).toHaveCount(1);
        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(file.suggestedFilename()).toBe('contract-signed.pdf');

        // Deleting it removes it from the device.
        page.once('dialog', (dialog) => dialog.accept());
        await page.getByRole('button', { name: 'Delete saved signature 1' }).click();
        await expect(page.getByRole('button', { name: 'Use saved signature 1' })).toHaveCount(0);
        await page.reload();
        await page.getByTestId('file-input').setInputFiles({ name: 'contract.pdf', mimeType: 'application/pdf', buffer: await makePdf(1) });
        await pickTool(page, 'Sign');
        await expect(page.getByText('1. Create your signature')).toBeVisible();
        await expect(page.getByRole('button', { name: 'Use saved signature 1' })).toHaveCount(0);
        expect(bodies).toEqual([]);
    });

    test('edit PDF: a JPEG image is placed with a click, stays JPEG in the saved PDF and keeps its opacity', async ({ page }) => {
        await openTool(page, 'edit-pdf');
        const jpeg = await makeImage(page, { width: 400, height: 200, type: 'image/jpeg', quality: 0.8 });
        await page.getByTestId('file-input').setInputFiles({ name: 'photo.pdf', mimeType: 'application/pdf', buffer: await makePdf(1) });
        await pickTool(page, 'Images');
        await page.getByTestId('file-input').setInputFiles({ name: 'photo.jpg', mimeType: 'image/jpeg', buffer: jpeg });
        await expect(page.getByRole('button', { name: 'Add image to page' })).toBeEnabled();

        const stage = page.locator('.pdf-editor__stage');
        await stage.scrollIntoViewIfNeeded();
        const box = await stage.boundingBox();
        await page.mouse.click(box.x + box.width / 2, box.y + box.height / 2);
        await expect(page.locator('.pdf-editor__overlay')).toHaveCount(1);

        const opacity = page.locator('input[type="range"]');
        await opacity.focus();
        for (let i = 0; i < 10; i++) await opacity.press('ArrowLeft');
        await expect(page.getByText('Opacity: 50%')).toBeVisible();
        await expect(page.locator('.pdf-editor__overlay img')).toHaveCSS('opacity', '0.5');

        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        const saved = await PDFDocument.load(await readDownload(file));
        const objects = saved.context.enumerateIndirectObjects().map(([, obj]) => obj);
        const images = objects.filter((obj) => obj.dict?.get(PDFName.of('Subtype'))?.toString() === '/Image');
        expect(images).toHaveLength(1);
        expect(images[0].dict.get(PDFName.of('Filter')).toString()).toBe('/DCTDecode');
        const extG = saved.getPage(0).node.Resources().lookup(PDFName.of('ExtGState'));
        const states = [...objects, ...(extG ? extG.entries().map(([, v]) => saved.context.lookup(v)) : [])];
        expect(states.some((gs) => gs?.get?.(PDFName.of('ca'))?.asNumber?.() === 0.5)).toBe(true);
    });

    test('redact PDF burns a box into the page so the covered text can no longer be extracted', async ({ page }) => {
        await openTool(page, 'redact-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'secret.pdf', mimeType: 'application/pdf', buffer: await makePdf(2, 'Secret') });
        await expect(page.getByText('secret.pdf', { exact: true })).toBeVisible();
        await expect(page.getByRole('button', { name: 'Redact PDF', exact: true })).toBeDisabled();

        // Draw a box, remove it, then draw it again (exercises the remove button too).
        const stage = page.locator('.pdf-editor__stage');
        await stage.scrollIntoViewIfNeeded();
        const box = await stage.boundingBox();
        const draw = async () => {
            await page.mouse.move(box.x + 30, box.y + 30);
            await page.mouse.down();
            await page.mouse.move(box.x + 150, box.y + 90, { steps: 5 });
            await page.mouse.up();
        };
        await draw();
        await expect(page.locator('.pdf-editor__overlay')).toHaveCount(1);
        await expect(page.getByText('1 page(s) will become images')).toBeVisible();
        await page.getByRole('button', { name: 'Remove this box' }).click();
        await expect(page.locator('.pdf-editor__overlay')).toHaveCount(0);
        await expect(page.getByRole('button', { name: 'Redact PDF', exact: true })).toBeDisabled();
        await draw();
        await expect(page.locator('.pdf-editor__overlay')).toHaveCount(1);

        await page.getByRole('button', { name: 'Redact PDF', exact: true }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(file.suggestedFilename()).toBe('secret-redacted.pdf');
        const redactedBytes = await readDownload(file);
        expect(await pdfPageCount(redactedBytes)).toBe(2);

        // The redacted page's text is really gone (rendered to an image), not just hidden; the untouched page keeps real text.
        const text = await extractPdfText(page, redactedBytes);
        expect(text).not.toContain('Secret page 1');
        expect(text).toContain('Secret page 2');
    });

    test('edit PDF adds text, a highlight and a drawing, supports undo, and saves real selectable text', async ({ page }) => {
        await openTool(page, 'edit-pdf');
        const originalBytes = await makePdf(1);
        await page.getByTestId('file-input').setInputFiles({ name: 'notes.pdf', mimeType: 'application/pdf', buffer: originalBytes });
        await expect(page.getByText('notes.pdf', { exact: true })).toBeVisible();
        await expect(page.getByRole('button', { name: 'Apply changes' })).toBeDisabled();

        // Add text (Edit text is the default tab now), then drag it.
        await pickTool(page, 'Add new text');
        await page.getByLabel('Text to add').fill('Hello World');
        await page.getByRole('button', { name: 'Add text to page' }).click();
        const overlay = page.locator('.pdf-editor__overlay');
        await expect(overlay).toHaveCount(1);
        await overlay.first().scrollIntoViewIfNeeded();
        const before = await overlay.first().boundingBox();
        await page.mouse.move(before.x + before.width / 2, before.y + before.height / 2);
        await page.mouse.down();
        await page.mouse.move(before.x + 40, before.y + 30, { steps: 5 });
        await page.mouse.up();
        const after = await overlay.first().boundingBox();
        expect(after.x).not.toBeCloseTo(before.x, 0);

        // Add a highlight.
        await pickTool(page, 'Highlight');
        await page.getByRole('button', { name: 'Add highlight to page' }).click();
        await expect(overlay).toHaveCount(2);

        // Draw a freehand stroke directly on the page, then undo it.
        await pickTool(page, 'Draw');
        const stage = page.locator('.pdf-editor__stage');
        await stage.scrollIntoViewIfNeeded();
        const stageBox = await stage.boundingBox();
        await page.mouse.move(stageBox.x + 20, stageBox.y + 150);
        await page.mouse.down();
        await page.mouse.move(stageBox.x + 80, stageBox.y + 190, { steps: 5 });
        await page.mouse.up();
        await expect(overlay).toHaveCount(3);
        await expect(page.getByRole('button', { name: 'Redo' })).toBeDisabled();
        await page.getByRole('button', { name: 'Undo', exact: true }).click();
        await expect(overlay).toHaveCount(2);

        // Redo brings the drawing back; undo removes it again before saving.
        await page.getByRole('button', { name: 'Redo' }).click();
        await expect(overlay).toHaveCount(3);
        await page.getByRole('button', { name: 'Undo', exact: true }).click();
        await expect(overlay).toHaveCount(2);
        await expect(page.getByRole('button', { name: 'Redo' })).toBeEnabled();

        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(file.suggestedFilename()).toBe('notes-edited.pdf');
        const editedBytes = await readDownload(file);
        expect(await pdfPageCount(editedBytes)).toBe(1);
        expect(editedBytes.length).toBeGreaterThan(originalBytes.length);

        // The added text is real, selectable text (drawn with pdf-lib), not a picture.
        const text = await extractPdfText(page, editedBytes);
        expect(text).toContain('Hello World');
    });

    test('edit PDF changes existing text in place, and find and replace works across pages', async ({ page }) => {
        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'contract.pdf', mimeType: 'application/pdf', buffer: await makePdf(2) });
        await expectTool(page, 'Edit existing text');

        // Every line of the PDF's own text can be clicked and retyped.
        await page.getByRole('button', { name: 'Edit text: Doc page 1' }).click();
        const input = page.getByLabel('Edit this text');
        await expect(input).toHaveValue('Doc page 1');
        await input.fill('Signed page 1');
        await page.getByRole('button', { name: 'Done' }).click();

        // Find and replace reaches page 2 as well.
        await toolButton(page, 'Find & replace').click();
        await page.getByLabel('Find', { exact: true }).fill('Doc');
        await page.getByLabel('Replace with').fill('Report');
        await page.getByRole('button', { name: 'Replace all' }).click();
        await expect(page.getByText('Replaced 1 time.')).toBeVisible();

        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        const texts = await pdfPageTexts(page, await readDownload(file));
        // The old wording is removed from the file, not just covered: it can't be found any more.
        expect(texts[0]).toContain('Signed page 1');
        expect(texts[0]).not.toContain('Doc page 1');
        expect(texts[1]).toContain('Report page 2');
        expect(texts[1]).not.toContain('Doc page 2');
    });

    test('edit PDF: whiteout, an arrow and a clickable link are dragged onto the page and saved', async ({ page }) => {
        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'form.pdf', mimeType: 'application/pdf', buffer: await makePdf(1) });
        const stage = page.locator('.pdf-editor__stage');
        const overlay = page.locator('.pdf-editor__overlay');
        await expect.poll(async () => (await page.locator('.pdf-editor__canvas').boundingBox())?.height ?? 0).toBeGreaterThan(100);
        // Re-measured on every drag (switching tools changes the toolbar height, which moves the page);
        // drags start well below the top so the sticky site header never covers them.
        const drag = async (x0, y0, x1, y1) => {
            await stage.scrollIntoViewIfNeeded();
            const box = await stage.boundingBox();
            await page.mouse.move(box.x + x0, box.y + y0);
            await page.mouse.down();
            await page.mouse.move(box.x + x1, box.y + y1, { steps: 6 });
            await page.mouse.up();
        };

        await pickTool(page, 'Whiteout');
        await drag(30, 150, 150, 190);
        await expect(page.getByRole('button', { name: 'Whiteout - drag to move' })).toBeVisible();

        await pickTool(page, 'Arrow');
        await drag(40, 230, 200, 270);
        await expect(page.getByRole('button', { name: 'Shape - drag to move' })).toBeVisible();

        // A link needs a valid address before it can be placed.
        await pickTool(page, 'Links');
        await drag(40, 310, 180, 340);
        await expect(page.getByText('Type a valid link address first')).toBeVisible();
        await page.getByLabel('Link address').fill('ilovemytools.store/merge-pdf');
        await drag(40, 310, 180, 340);
        await expect(overlay).toHaveCount(3);

        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        const saved = await PDFDocument.load(await readDownload(file));
        const annots = saved.getPage(0).node.Annots().asArray().map((ref) => saved.context.lookup(ref));
        expect(annots).toHaveLength(1);
        const action = saved.context.lookup(annots[0].get(PDFName.of('A')));
        expect(action.get(PDFName.of('URI')).decodeText()).toBe('https://ilovemytools.store/merge-pdf');
    });

    test('edit PDF: selecting an element shows its context bar; undo/redo and keyboard shortcuts cover every change', async ({ page }) => {
        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'keys.pdf', mimeType: 'application/pdf', buffer: await makePdf(2) });
        const stage = page.locator('.pdf-editor__stage');
        const overlay = page.locator('.pdf-editor__overlay');
        const bar = page.getByRole('toolbar', { name: 'Selected item' });
        await expect.poll(async () => (await page.locator('.pdf-editor__canvas').boundingBox())?.height ?? 0).toBeGreaterThan(100);

        // Pick a tool, drag on the page, and the editor goes back to the select tool with the new box selected.
        await pickTool(page, 'Rectangle');
        await expectTool(page, 'Rectangle');
        // Put the page's top 300px down the viewport: below the sticky header and toolbar, and with
        // room under it for the drag (the thumbnail strip of a 2-page PDF pushes the page lower).
        await stage.evaluate((el) => window.scrollBy(0, el.getBoundingClientRect().top - 300));
        let box = await stage.boundingBox();
        await page.mouse.move(box.x + 60, box.y + 160);
        await page.mouse.down();
        await page.mouse.move(box.x + 180, box.y + 220, { steps: 6 });
        await page.mouse.up();
        await expect(overlay).toHaveCount(1);
        await expectTool(page, 'Select');
        await expect(bar).toBeVisible();

        // One drag is one undo step, however many pointer moves it took.
        const before = await overlay.first().boundingBox();
        await page.mouse.move(before.x + before.width / 2, before.y + before.height / 2);
        await page.mouse.down();
        for (let i = 1; i <= 8; i++) await page.mouse.move(before.x + before.width / 2 + i * 6, before.y + before.height / 2 + i * 3);
        await page.mouse.up();
        const moved = await overlay.first().boundingBox();
        expect(moved.x).toBeGreaterThan(before.x + 30);
        await page.keyboard.press('Control+z');
        await expect.poll(async () => (await overlay.first().boundingBox()).x).toBeCloseTo(before.x, 0);
        await page.keyboard.press('Control+Shift+z');
        await expect.poll(async () => (await overlay.first().boundingBox()).x).toBeCloseTo(moved.x, 0);

        // Recolouring from the context bar is undoable too.
        await bar.getByLabel('Line colour').fill('#00ff00');
        await expect(overlay.first().locator('rect')).toHaveAttribute('stroke', '#00ff00');
        await page.getByRole('button', { name: 'Undo' }).click();
        await expect(overlay.first().locator('rect')).toHaveAttribute('stroke', '#dc2626');
        await page.getByRole('button', { name: 'Redo' }).click();
        await expect(overlay.first().locator('rect')).toHaveAttribute('stroke', '#00ff00');

        // Arrow keys nudge (Shift for 10px); Ctrl+D duplicates; Delete removes the selection.
        const start = await overlay.first().boundingBox();
        await page.keyboard.press('Shift+ArrowRight');
        await expect.poll(async () => (await overlay.first().boundingBox()).x).toBeGreaterThan(start.x + 5);
        await page.keyboard.press('Control+d');
        await expect(overlay).toHaveCount(2);
        await page.keyboard.press('Delete');
        await expect(overlay).toHaveCount(1);
        await page.keyboard.press('Control+z');
        await expect(overlay).toHaveCount(2);

        // Esc clears the selection; shortcuts do nothing while typing in a field.
        await page.keyboard.press('Escape');
        await expect(bar).toHaveCount(0);
        await pickTool(page, 'Add new text');
        const input = page.getByLabel('Text to add');
        await input.fill('abc');
        await input.press('Backspace');
        await input.press('Control+z');
        await expect(input).toHaveValue(/^ab?c?$/);
        await expect(overlay).toHaveCount(2);

        // PageDown changes page; + and - zoom.
        await page.evaluate(() => document.activeElement?.blur());
        await page.keyboard.press('PageDown');
        await expect(page.getByText('Page 2 of 2')).toBeVisible();
        await page.keyboard.press('+');
        await expect(page.getByLabel('Zoom', { exact: true })).toHaveValue('125');
        await page.keyboard.press('-');
        await expect(page.getByLabel('Zoom', { exact: true })).toHaveValue('100');
    });

    test('edit PDF: the toolbar keeps every tool reachable on a 360px phone without sideways scrolling', async ({ page }) => {
        await page.setViewportSize({ width: 360, height: 740 });
        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'phone.pdf', mimeType: 'application/pdf', buffer: await makePdf(1) });
        const toolbar = page.getByRole('toolbar', { name: 'PDF editing tools' });
        await expect(toolbar).toBeVisible();
        for (const name of ['Select', 'Text', 'Links', 'Forms', 'Images', 'Sign', 'Whiteout', 'Annotate', 'Shapes', 'Undo', 'Redo', 'Find & replace', 'Zoom in', 'Apply changes']) {
            const button = toolbar.getByRole('button', { name, exact: true });
            await expect(button).toBeVisible();
            const b = await button.boundingBox();
            expect(b.x).toBeGreaterThanOrEqual(0);
            expect(b.x + b.width).toBeLessThanOrEqual(360);
        }
        expect(await page.evaluate(() => document.documentElement.scrollWidth)).toBeLessThanOrEqual(360);

        // A grouped tool opens its menu on the phone too.
        await pickTool(page, 'Arrow');
        await expectTool(page, 'Arrow');
    });

    test('edit PDF: zoom scales the page view without breaking drags or the saved file', async ({ page }) => {
        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'zoomed.pdf', mimeType: 'application/pdf', buffer: await makePdf(1) });
        const stage = page.locator('.pdf-editor__stage');
        await expect.poll(async () => (await page.locator('.pdf-editor__canvas').boundingBox())?.height ?? 0).toBeGreaterThan(100);
        const baseBox = await stage.boundingBox();

        await expect(page.getByLabel('Zoom', { exact: true })).toHaveValue('100');
        await expect(page.getByRole('button', { name: 'Zoom out' })).toBeEnabled();
        await page.getByRole('button', { name: 'Zoom in' }).click();
        await expect(page.getByLabel('Zoom', { exact: true })).toHaveValue('125');
        const zoomedBox = await stage.boundingBox();
        expect(zoomedBox.width).toBeGreaterThan(baseBox.width * 1.1);

        // Add text, then drag it while zoomed in: the pointer math must still map onto the page correctly.
        await pickTool(page, 'Add new text');
        await page.getByLabel('Text to add').fill('Zoomed text');
        await page.getByRole('button', { name: 'Add text to page' }).click();
        const overlay = page.locator('.pdf-editor__overlay');
        await expect(overlay).toHaveCount(1);
        await overlay.first().scrollIntoViewIfNeeded();
        const before = await overlay.first().boundingBox();
        await page.mouse.move(before.x + before.width / 2, before.y + before.height / 2);
        await page.mouse.down();
        await page.mouse.move(before.x + 50, before.y + 40, { steps: 5 });
        await page.mouse.up();
        const after = await overlay.first().boundingBox();
        expect(after.x).not.toBeCloseTo(before.x, 0);

        await page.getByLabel('Zoom', { exact: true }).selectOption('100');
        await expect(page.getByLabel('Zoom', { exact: true })).toHaveValue('100');

        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        const text = await extractPdfText(page, await readDownload(file));
        expect(text).toContain('Zoomed text');
    });

    test('edit PDF page panel: reorder by dragging, rotate, delete, insert blank and another PDF; elements follow their page and undo restores them', async ({ page }) => {
        // Tall enough that the three thumbnails fit without scrolling the list: Playwright presses the
        // mouse on the source and then scrolls to the target, which would start the drag on another page.
        await page.setViewportSize({ width: 1280, height: 1600 });
        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'booklet.pdf', mimeType: 'application/pdf', buffer: await makePdf(3) });
        const panel = page.getByRole('region', { name: 'Pages' });
        const items = panel.locator('.page-sidebar__item');
        const card = (n) => panel.getByRole('group', { name: `Page ${n}`, exact: true });
        const label = page.locator('.pdf-editor__page-label');
        await expect(items).toHaveCount(3);
        await expect(page.getByRole('button', { name: 'Apply changes' })).toBeDisabled();

        // Text added on page 1.
        await pickTool(page, 'Add new text');
        await page.getByLabel('Text to add').fill('Stays on its page');
        await page.getByRole('button', { name: 'Add text to page' }).click();
        await expect(page.locator('.pdf-editor__overlay')).toHaveCount(1);

        // Drag page 1 onto page 3: the order becomes 2, 3, 1 and the text goes with its page.
        await card(1).dragTo(card(3));
        await expect(label).toHaveText('Page 3 of 3');
        await expect(page.locator('.pdf-editor__overlay')).toHaveCount(1);
        await card(1).getByRole('button', { name: 'Go to page 1' }).click();
        await expect(page.locator('.pdf-editor__overlay')).toHaveCount(0);

        // Rotate the moved page (now page 3), delete page 1 (original page 2), insert a blank page after the new page 1.
        await card(3).getByRole('button', { name: 'Rotate page 3 right' }).click();
        await card(1).getByRole('button', { name: 'Delete page 1' }).click();
        await expect(items).toHaveCount(2);
        await card(1).getByRole('button', { name: 'More actions for page 1' }).click();
        await card(1).getByRole('button', { name: 'Insert blank page after' }).click();
        await expect(items).toHaveCount(3);

        // Deleting the page with the text drops the text; undo brings back the page and the text.
        await card(3).getByRole('button', { name: 'Go to page 3' }).click();
        await expect(page.locator('.pdf-editor__overlay')).toHaveCount(1);
        await card(3).getByRole('button', { name: 'Delete page 3' }).click();
        await expect(items).toHaveCount(2);
        await expect(page.locator('.pdf-editor__overlay')).toHaveCount(0);
        // Page changes are part of the editor's one undo history.
        await toolButton(page, 'Undo').click();
        await expect(items).toHaveCount(3);
        await card(3).getByRole('button', { name: 'Go to page 3' }).click();
        await expect(page.locator('.pdf-editor__overlay')).toHaveCount(1);

        // Add both pages of a second PDF at the end (read in the browser, never uploaded).
        await panel.getByRole('button', { name: 'Add pages' }).click();
        const [chooser] = await Promise.all([page.waitForEvent('filechooser'), panel.getByRole('button', { name: 'Add pages from another PDF' }).click()]);
        await chooser.setFiles({ name: 'extra.pdf', mimeType: 'application/pdf', buffer: await makePdf(2, 'Extra') });
        await expect(items).toHaveCount(5);

        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(file.suggestedFilename()).toBe('booklet-edited.pdf');
        const bytes = await readDownload(file);
        expect(await pdfPageCount(bytes)).toBe(5);
        expect(await pdfPageRotations(bytes)).toEqual([0, 0, 90, 0, 0]);
        const texts = await pdfPageTexts(page, bytes);
        expect(texts[0]).toContain('Doc page 3');
        expect(texts[1]).toBe('');
        expect(texts[2]).toContain('Doc page 1');
        expect(texts[2]).toContain('Stays on its page');
        expect(texts[3]).toContain('Extra page 1');
        expect(texts[4]).toContain('Extra page 2');
    });

    test('edit PDF page panel: move buttons, duplicate, and the continuous view with insert-here controls', async ({ page }) => {
        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'booklet.pdf', mimeType: 'application/pdf', buffer: await makePdf(3) });
        const panel = page.getByRole('region', { name: 'Pages' });
        const items = panel.locator('.page-sidebar__item');
        const card = (n) => panel.getByRole('group', { name: `Page ${n}`, exact: true });
        await expect(items).toHaveCount(3);

        await card(3).getByRole('button', { name: 'More actions for page 3' }).click();
        await card(3).getByRole('button', { name: 'Move up' }).click();
        await card(1).getByRole('button', { name: 'Duplicate page 1' }).click();
        await expect(items).toHaveCount(4);

        await panel.getByLabel('Show all pages (scroll)').check();
        const scroller = page.locator('.page-scroller');
        await expect(scroller.locator('.page-scroller__slot')).toHaveCount(4);
        await scroller.getByRole('button', { name: '+ Insert blank page here' }).last().click();
        await expect(items).toHaveCount(5);
        await expect(scroller.locator('.page-scroller__slot')).toHaveCount(5);

        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        const bytes = await readDownload(file);
        expect(await pdfPageCount(bytes)).toBe(5);
        const texts = await pdfPageTexts(page, bytes);
        expect(texts.slice(0, 4)).toEqual(['Doc page 1', 'Doc page 1', 'Doc page 3', 'Doc page 2']);
        expect(texts[4]).toBe('');
    });

    test('edit PDF: Fill form fills fields on the page and saves them in one PDF with an added text element', async ({ page }) => {
        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'application.pdf', mimeType: 'application/pdf', buffer: await makePdfWithFormFields() });

        await pickTool(page, 'Forms');
        await expect(page.getByText('Fill in the fields on the page, then click Apply changes.')).toBeVisible();

        // The inputs sit exactly over the PDF's own fields.
        const nameInput = page.getByLabel('Fill in full_name');
        await expect(nameInput).toBeVisible();
        await nameInput.fill('Jane Doe');
        await page.getByLabel('Checkbox: subscribe').check();
        await page.getByLabel('Select country').selectOption('DE');

        // Another edit in the same session ends up in the same file.
        await pickTool(page, 'Add new text');
        await page.getByLabel('Text to add').fill('Approved');
        await page.getByRole('button', { name: 'Add text to page' }).click();

        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(file.suggestedFilename()).toBe('application-edited.pdf');
        const bytes = await readDownload(file);
        const form = (await PDFDocument.load(bytes)).getForm();
        expect(form.getTextField('full_name').getText()).toBe('Jane Doe');
        expect(form.getCheckBox('subscribe').isChecked()).toBe(true);
        expect(form.getDropdown('country').getSelected()).toEqual(['DE']);
        expect(await extractPdfText(page, bytes)).toContain('Approved');
    });

    test('edit PDF: Fill form can flatten the answers into the page', async ({ page }) => {
        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'application.pdf', mimeType: 'application/pdf', buffer: await makePdfWithFormFields() });
        await pickTool(page, 'Forms');
        await page.getByLabel('Fill in full_name').fill('Flat Answer');
        await page.getByLabel('Flatten the form so the answers cannot be changed').check();

        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        const saved = await PDFDocument.load(await readDownload(file));
        expect(saved.getForm().getFields()).toHaveLength(0);
    });

    test('edit PDF: Fill form - Add fields draws a text field, a checkbox, a radio group and a dropdown that can be filled', async ({ page }) => {
        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'blank.pdf', mimeType: 'application/pdf', buffer: await makePdf(1) });

        await pickTool(page, 'Forms');
        await expect(page.getByText('No fillable fields were found in this PDF.')).toBeVisible();
        await page.getByRole('tab', { name: 'Add fields' }).click();

        const stage = page.locator('.pdf-editor__stage');
        await expect.poll(async () => (await page.locator('.pdf-editor__canvas').boundingBox())?.height ?? 0).toBeGreaterThan(100);
        // Picking a kind can scroll the toolbar into view, so the page's position is read after each
        // pick, with its top scrolled clear of the sticky site header.
        const stageBox = async () => {
            await stage.evaluate((el) => {
                el.scrollIntoView({ block: 'start' });
                window.scrollBy(0, -150);
            });
            return stage.boundingBox();
        };
        const props = page.getByRole('dialog');
        let box;

        // A text field, drawn by dragging; its properties open straight away.
        await page.getByRole('button', { name: 'Text field', exact: true }).click();
        box = await stageBox();
        await page.mouse.move(box.x + 40, box.y + 40);
        await page.mouse.down();
        await page.mouse.move(box.x + 220, box.y + 64, { steps: 5 });
        await page.mouse.up();
        await props.getByLabel('Field name').fill('email');
        await props.getByLabel('Required').check();
        await props.getByRole('button', { name: 'Done' }).click();

        // A checkbox, placed with a click.
        await page.getByRole('button', { name: 'Checkbox', exact: true }).click();
        box = await stageBox();
        await page.mouse.click(box.x + 60, box.y + 110);
        await props.getByLabel('Field name').fill('subscribe');
        await props.getByRole('button', { name: 'Done' }).click();

        // Two radio buttons of one group.
        await page.getByRole('button', { name: 'Radio button', exact: true }).click();
        box = await stageBox();
        await page.mouse.click(box.x + 60, box.y + 160);
        await props.getByLabel('Group name').fill('plan');
        await props.getByLabel('Value of this button').fill('free');
        await props.getByRole('button', { name: 'Done' }).click();
        await page.mouse.click(box.x + 120, box.y + 160);
        await props.getByLabel('Value of this button').fill('pro');
        await props.getByRole('button', { name: 'Done' }).click();

        // A dropdown with its options.
        await page.getByRole('button', { name: 'Dropdown', exact: true }).click();
        box = await stageBox();
        await page.mouse.click(box.x + 120, box.y + 230);
        await props.getByLabel('Field name').fill('country');
        await props.getByLabel('Options (one per line)').fill('UK\nUS\nDE');
        await props.getByLabel('Default value').selectOption('US');
        await props.getByRole('button', { name: 'Done' }).click();

        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(file.suggestedFilename()).toBe('blank-edited.pdf');
        const saved = await PDFDocument.load(await readDownload(file));
        const form = saved.getForm();
        expect(form.getTextField('email').isRequired()).toBe(true);
        expect(form.getCheckBox('subscribe').isChecked()).toBe(false);
        expect(form.getRadioGroup('plan').getOptions()).toEqual(['free', 'pro']);
        expect(form.getDropdown('country').getOptions()).toEqual(['UK', 'US', 'DE']);
        expect(form.getDropdown('country').getSelected()).toEqual(['US']);

        // The new fields can be filled: fill one and read it back.
        form.getTextField('email').setText('a@b.c');
        form.getRadioGroup('plan').select('pro');
        const again = (await PDFDocument.load(await saved.save())).getForm();
        expect(again.getTextField('email').getText()).toBe('a@b.c');
        expect(again.getRadioGroup('plan').getSelected()).toBe('pro');
    });

    test('edit PDF: Fill form - Add fields creates a new, named signature field in the saved PDF', async ({ page }) => {
        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'contract.pdf', mimeType: 'application/pdf', buffer: await makePdf(1) });

        await pickTool(page, 'Forms');
        await page.getByRole('tab', { name: 'Add fields' }).click();
        await page.getByRole('button', { name: 'Signature field', exact: true }).click();
        await page.getByRole('button', { name: 'Add to page' }).click();
        await page.getByRole('dialog').getByLabel('Field name').fill('sign_here');
        await page.getByRole('dialog').getByRole('button', { name: 'Done' }).click();

        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        const saved = await PDFDocument.load(await readDownload(file));
        const signature = saved.getForm().getSignature('sign_here');
        expect(signature.acroField.FT().toString()).toBe('/Sig');
        expect(signature.acroField.getWidgets()).toHaveLength(1);
    });

    test('edit PDF: Fill form - Add fields blocks saving a dropdown with fewer than two options', async ({ page }) => {
        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'blank.pdf', mimeType: 'application/pdf', buffer: await makePdf(1) });

        await pickTool(page, 'Forms');
        await page.getByRole('tab', { name: 'Add fields' }).click();
        await page.getByRole('button', { name: 'Dropdown', exact: true }).click();
        await page.getByRole('button', { name: 'Add to page' }).click();
        await page.getByRole('dialog').getByLabel('Field name').fill('country');
        await page.getByRole('dialog').getByLabel('Options (one per line)').fill('Only one');
        await page.getByRole('dialog').getByRole('button', { name: 'Done' }).click();

        await page.getByRole('button', { name: 'Apply changes' }).click();
        await expect(page.getByText('Give the dropdown "country" at least two options, one per line.')).toBeVisible();
    });

    test('edit PDF: Fill form - a check mark on a PDF without fields is drawn, not added as a field', async ({ page }) => {
        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'printed.pdf', mimeType: 'application/pdf', buffer: await makePdf(1) });

        await pickTool(page, 'Forms');
        await page.getByRole('tab', { name: 'Add fields' }).click();
        await page.getByRole('button', { name: 'Check mark', exact: true }).click();
        await page.getByRole('button', { name: 'Add to page' }).click();
        await expect(page.locator('.pdf-editor__overlay--stamp')).toHaveCount(1);

        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        const saved = await PDFDocument.load(await readDownload(file));
        expect(saved.getForm().getFields()).toHaveLength(0);
    });

    test('edit PDF: dragging an element\'s rotate handle spins it in place and the saved PDF still reads its text', async ({ page }) => {
        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'rotated.pdf', mimeType: 'application/pdf', buffer: await makePdf(1) });
        await pickTool(page, 'Add new text');
        await page.getByLabel('Text to add').fill('Rotated text');
        await page.getByRole('button', { name: 'Add text to page' }).click();

        const overlay = page.locator('.pdf-editor__overlay');
        await expect(overlay).toHaveCount(1);
        await overlay.first().scrollIntoViewIfNeeded();
        const before = await overlay.first().boundingBox();
        const centerX = before.x + before.width / 2;
        const centerY = before.y + before.height / 2;

        // The rotate handle starts directly above the element's centre; dragging it to one side rotates it.
        const handle = page.locator('.pdf-editor__rotate-handle');
        await expect(handle).toBeVisible();
        const handleBox = await handle.boundingBox();
        await page.mouse.move(handleBox.x + handleBox.width / 2, handleBox.y + handleBox.height / 2);
        await page.mouse.down();
        await page.mouse.move(centerX + 60, centerY, { steps: 6 });
        await page.mouse.up();
        await expect(overlay.first()).toHaveCSS('transform', /matrix/);

        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        const text = await extractPdfText(page, await readDownload(file));
        expect(text).toContain('Rotated text');
    });

    test('edit PDF: page thumbnails jump straight to a page and track which one is open', async ({ page }) => {
        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'multi.pdf', mimeType: 'application/pdf', buffer: await makePdf(3) });
        await expect(page.getByText('Page 1 of 3')).toBeVisible();

        const thumbs = page.locator('.page-sidebar__thumb');
        await expect(thumbs).toHaveCount(3);
        await expect(thumbs.nth(0)).toHaveAttribute('aria-current', 'true');
        // Thumbnails render progressively; wait for a real image before clicking one.
        await expect.poll(async () => await thumbs.locator('img').count()).toBeGreaterThan(0);

        await thumbs.nth(2).click();
        await expect(page.getByText('Page 3 of 3')).toBeVisible();
        await expect(thumbs.nth(2)).toHaveAttribute('aria-current', 'true');
        await expect(thumbs.nth(0)).not.toHaveAttribute('aria-current', 'true');

        // The usual Previous/Next buttons still work alongside the thumbnails.
        await page.getByRole('button', { name: 'Previous page' }).click();
        await expect(page.getByText('Page 2 of 3')).toBeVisible();
        await expect(thumbs.nth(1)).toHaveAttribute('aria-current', 'true');
    });

    test('edit PDF: auto-saves the session, offers to resume it after a reload, warns before discarding it, and clears it once downloaded', async ({ page }) => {
        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'draft.pdf', mimeType: 'application/pdf', buffer: await makePdf(1) });
        await pickTool(page, 'Add new text');
        await page.getByLabel('Text to add').fill('Session text');
        await page.getByRole('button', { name: 'Add text to page' }).click();
        await expect(page.locator('.pdf-editor__overlay')).toHaveCount(1);

        // Trying to choose another PDF now warns, since the edit hasn't been downloaded yet; dismissing keeps it.
        page.once('dialog', (dialog) => dialog.dismiss());
        await page.getByRole('button', { name: 'Choose another PDF' }).click();
        await expect(page.getByText('draft.pdf', { exact: true })).toBeVisible();
        await expect(page.locator('.pdf-editor__overlay')).toHaveCount(1);

        // Give the debounced auto-save time to write to IndexedDB, then reload the page (accepting
        // the browser's own "leave site?" prompt, which the unsaved-changes warning now triggers).
        page.on('dialog', (dialog) => dialog.accept());
        await page.waitForTimeout(1200);
        await page.reload();
        await expect(page.getByText('Resume editing draft.pdf?')).toBeVisible();
        await page.getByRole('button', { name: 'Resume' }).click();
        await expect(page.getByText('draft.pdf', { exact: true })).toBeVisible();
        await expect(page.locator('.pdf-editor__overlay')).toHaveCount(1);

        // Downloading the edited PDF clears the saved session, so a later visit has nothing to resume.
        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(file.suggestedFilename()).toBe('draft-edited.pdf');
        await page.waitForTimeout(300);
        await page.reload();
        await expect(page.getByText(/Resume editing/)).toHaveCount(0);
    });

    test('watermark PDF stamps text onto only the pages chosen, matching the live preview', async ({ page }) => {
        await openTool(page, 'watermark-pdf');
        const originalBytes = await makePdf(3);
        await page.getByTestId('file-input').setInputFiles({ name: 'report.pdf', mimeType: 'application/pdf', buffer: originalBytes });
        await expect(page.getByText('report.pdf', { exact: true })).toBeVisible();
        await expect(page.getByRole('button', { name: 'Apply changes' })).toBeDisabled();

        await page.getByLabel('Watermark text').fill('CONFIDENTIAL');
        await expect(page.getByRole('button', { name: 'Apply changes' })).toBeEnabled();

        // The live preview renders the real watermarked page 1 before any page is chosen.
        const preview = page.locator('canvas[aria-label="Preview of page 1"]');
        await expect(preview).toBeVisible();
        await expect.poll(async () => (await preview.boundingBox())?.height ?? 0).toBeGreaterThan(0);

        await page.getByLabel('Pages', { exact: true }).selectOption({ label: 'All pages except the first' });
        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(file.suggestedFilename()).toBe('report-watermarked.pdf');
        const watermarkedBytes = await readDownload(file);
        expect(await pdfPageCount(watermarkedBytes)).toBe(3);
        expect(watermarkedBytes.length).toBeGreaterThan(originalBytes.length);

        // Real, selectable text (drawn with pdf-lib) only on the pages the "except the first" scope targets.
        const texts = await pdfPageTexts(page, watermarkedBytes);
        expect(texts[0]).not.toContain('CONFIDENTIAL');
        expect(texts[1]).toContain('CONFIDENTIAL');
        expect(texts[2]).toContain('CONFIDENTIAL');
        // On top (the default): drawn after the page's own text.
        expect(texts[1].indexOf('CONFIDENTIAL')).toBeGreaterThan(texts[1].indexOf('Doc page 2'));
    });

    test('watermark PDF can go behind the content, and flatten makes it permanent', async ({ page }) => {
        await openTool(page, 'watermark-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'report.pdf', mimeType: 'application/pdf', buffer: await makePdf(2) });
        await page.getByLabel('Watermark text').fill('DRAFT');
        await page.getByLabel('Layer').selectOption({ label: 'Behind the content (background)' });
        await expect(page.getByText('can hide a watermark placed behind the content')).toBeVisible();

        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [behind] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        // pdf.js lists text in drawing order: the background watermark is painted before the page text.
        const texts = await pdfPageTexts(page, await readDownload(behind));
        expect(texts[0].indexOf('DRAFT')).toBeGreaterThanOrEqual(0);
        expect(texts[0].indexOf('DRAFT')).toBeLessThan(texts[0].indexOf('Doc page 1'));

        // Flatten: same pages, but every page is now one image, so nothing (watermark included) is editable text.
        await page.getByLabel('Flatten pages so the watermark can’t be removed').check();
        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [flat] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        const flatBytes = await readDownload(flat);
        expect(await pdfPageCount(flatBytes)).toBe(2);
        expect(await pdfPageTexts(page, flatBytes)).toEqual(['', '']);
    });

    test('watermark lives inside Edit PDF as its own tab, alongside the other editing tools', async ({ page }) => {
        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'notes.pdf', mimeType: 'application/pdf', buffer: await makePdf(2) });
        await expectTool(page, 'Edit existing text');

        await pickTool(page, 'Watermark');
        await expect(page.getByRole('button', { name: 'Apply changes' })).toBeDisabled();
        await page.getByLabel('Watermark text').fill('SAMPLE');
        await expect(page.getByRole('button', { name: 'Apply changes' })).toBeEnabled();

        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(file.suggestedFilename()).toBe('notes-watermarked.pdf');
        const texts = await pdfPageTexts(page, await readDownload(file));
        expect(texts[0]).toContain('SAMPLE');
        expect(texts[1]).toContain('SAMPLE');

        // Switching back to Edit text still edits the page's own text, unaffected by the watermark tab.
        await pickTool(page, 'Edit existing text');
        await expect(page.getByRole('button', { name: 'Edit text: Doc page 1' })).toBeVisible();
    });

    test('watermark in Edit PDF saves every other edit too, and never changes the open document', async ({ page }) => {
        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'notes.pdf', mimeType: 'application/pdf', buffer: await makePdf(3) });
        const panel = page.getByRole('region', { name: 'Pages' });
        const card = (n) => panel.getByRole('group', { name: `Page ${n}`, exact: true });

        await pickTool(page, 'Add new text');
        await page.getByLabel('Text to add').fill('ADDEDTEXT');
        await page.getByRole('button', { name: 'Add text to page' }).click();
        await card(2).getByRole('button', { name: 'Delete page 2' }).click();
        await expect(panel.locator('.page-sidebar__item')).toHaveCount(2);

        const save = async () => {
            await page.getByRole('button', { name: 'Apply changes' }).click();
            const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
            const bytes = await readDownload(file);
            return { count: await pdfPageCount(bytes), texts: await pdfPageTexts(page, bytes) };
        };

        await pickTool(page, 'Watermark');
        await page.getByLabel('Watermark text').fill('AAAA');
        const first = await save();
        expect(first.count).toBe(2);
        expect(first.texts[0]).toContain('ADDEDTEXT');
        expect(first.texts[0]).toContain('AAAA');
        expect(first.texts[1]).toContain('Doc page 3');
        expect(first.texts[1]).toContain('AAAA');

        // Applying again with new text starts from the original, not from the last watermarked file.
        await page.getByLabel('Watermark text').fill('BBBB');
        const second = await save();
        expect(second.texts.join(' ')).toContain('BBBB');
        expect(second.texts.join(' ')).not.toContain('AAAA');

        // A normal save afterwards has no watermark in it.
        await pickTool(page, 'Select');
        const plain = await save();
        expect(plain.count).toBe(2);
        expect(plain.texts[0]).toContain('ADDEDTEXT');
        expect(plain.texts.join(' ')).not.toMatch(/AAAA|BBBB/);
    });

    test('edit PDF: the page menu stays on screen, a new note takes typing straight away, and placed elements select from the keyboard', async ({ page }) => {
        await page.setViewportSize({ width: 1280, height: 720 });
        await openTool(page, 'edit-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'notes.pdf', mimeType: 'application/pdf', buffer: await makePdf(2) });
        const panel = page.getByRole('region', { name: 'Pages' });
        const card = (n) => panel.getByRole('group', { name: `Page ${n}`, exact: true });
        await expect(panel.locator('.page-sidebar__item')).toHaveCount(2);

        // At this window size page 1's menu button sits low enough that a menu opening downwards ran off the screen.
        const more = card(1).getByRole('button', { name: 'More actions for page 1' });
        await more.click();
        const menu = page.locator('.page-sidebar__menu');
        await expect(menu).toBeVisible();
        await expect.poll(async () => { const m = await menu.boundingBox(); return m.y + m.height <= 720; }).toBe(true);
        await card(1).getByRole('button', { name: 'Move down' }).click();
        await expect(card(2)).toBeVisible();

        await page.getByRole('heading', { level: 1 }).scrollIntoViewIfNeeded();
        await pickTool(page, 'Sticky note');
        await page.locator('.pdf-editor__stage').click({ position: { x: 120, y: 120 } });
        await page.keyboard.type('Typed at once');
        await expect(page.getByLabel('Note text')).toHaveValue('Typed at once');
        await expect(page.getByRole('radio', { name: 'Yellow' })).toBeVisible();
        await page.getByRole('button', { name: 'Done', exact: true }).click();

        // A whiteout placed with the mouse, then picked with Tab-style focus and moved with the arrows.
        await pickTool(page, 'Whiteout');
        const stage = page.locator('.pdf-editor__stage');
        const s = await stage.boundingBox();
        await page.mouse.move(s.x + 200, s.y + 200);
        await page.mouse.down();
        await page.mouse.move(s.x + 300, s.y + 260, { steps: 4 });
        await page.mouse.up();
        await page.keyboard.press('Escape');
        await expect(page.locator('.pdf-selection')).toHaveCount(0);
        const whiteout = page.getByRole('button', { name: 'Whiteout - drag to move' });
        await whiteout.focus();
        await expect(whiteout).toHaveAttribute('aria-pressed', 'true');
        const before = await whiteout.boundingBox();
        await page.keyboard.press('Shift+ArrowRight');
        await expect.poll(async () => (await whiteout.boundingBox()).x).toBeGreaterThan(before.x + 5);
    });

    test('watermark-pdf opens Edit PDF with the Watermark tab preselected, and the full editor stays reachable', async ({ page }) => {
        await openTool(page, 'watermark-pdf');
        await page.getByTestId('file-input').setInputFiles({ name: 'report.pdf', mimeType: 'application/pdf', buffer: await makePdf(1) });
        await expectTool(page, 'Watermark');
        await expect(page.getByLabel('Watermark text')).toBeVisible();

        // The one editor is still underneath: every other tab is reachable from this page too.
        await expect(toolButton(page, 'Text')).toBeVisible();
        await expect(toolButton(page, 'Shapes')).toBeVisible();
    });

    test('add-text-to-pdf opens Edit PDF with the Add text tab preselected and can type, place and save text', async ({ page }) => {
        await openTool(page, 'add-text-to-pdf');
        const originalBytes = await makePdf(1);
        await page.getByTestId('file-input').setInputFiles({ name: 'form.pdf', mimeType: 'application/pdf', buffer: originalBytes });
        await expectTool(page, 'Add new text');
        await expect(page.getByLabel('Text to add')).toBeVisible();

        await page.getByLabel('Text to add').fill('Approved');
        await page.getByRole('button', { name: 'Add text to page' }).click();
        const overlay = page.locator('.pdf-editor__overlay');
        await expect(overlay).toHaveCount(1);

        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(file.suggestedFilename()).toBe('form-edited.pdf');
        const savedBytes = await readDownload(file);
        expect(await pdfPageCount(savedBytes)).toBe(1);
        expect(savedBytes.length).toBeGreaterThan(originalBytes.length);

        // The one editor is still underneath: every other tab is reachable from this page too.
        await expect(toolButton(page, 'Text')).toBeVisible();
        await expect(toolButton(page, 'Watermark')).toBeVisible();
    });

    test('whiteout-pdf opens Edit PDF with the Whiteout tab preselected and can cover and save content', async ({ page }) => {
        await openTool(page, 'whiteout-pdf');
        const originalBytes = await makePdf(1);
        await page.getByTestId('file-input').setInputFiles({ name: 'form.pdf', mimeType: 'application/pdf', buffer: originalBytes });
        await expectTool(page, 'Whiteout');
        const stage = page.locator('.pdf-editor__stage');
        await expect.poll(async () => (await page.locator('.pdf-editor__canvas').boundingBox())?.height ?? 0).toBeGreaterThan(100);
        await stage.scrollIntoViewIfNeeded();
        const box = await stage.boundingBox();
        await page.mouse.move(box.x + 30, box.y + 150);
        await page.mouse.down();
        await page.mouse.move(box.x + 150, box.y + 190, { steps: 6 });
        await page.mouse.up();
        const overlay = page.locator('.pdf-editor__overlay');
        await expect(overlay).toHaveCount(1);
        await expect(page.getByRole('button', { name: 'Whiteout - drag to move' })).toBeVisible();

        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        expect(file.suggestedFilename()).toBe('form-edited.pdf');
        const savedBytes = await readDownload(file);
        expect(await pdfPageCount(savedBytes)).toBe(1);
        expect(savedBytes.length).toBeGreaterThan(originalBytes.length);

        // The one editor is still underneath: every other tab is reachable from this page too.
        await expect(toolButton(page, 'Text')).toBeVisible();
        await expect(toolButton(page, 'Watermark')).toBeVisible();
    });

    test('edit-pdf-text opens Edit PDF with the Edit text tab preselected and can retype existing text', async ({ page }) => {
        await openTool(page, 'edit-pdf-text');
        await page.getByTestId('file-input').setInputFiles({ name: 'contract.pdf', mimeType: 'application/pdf', buffer: await makePdf(1) });
        await expectTool(page, 'Edit existing text');

        await page.getByRole('button', { name: 'Edit text: Doc page 1' }).click();
        const input = page.getByLabel('Edit this text');
        await expect(input).toHaveValue('Doc page 1');
        await input.fill('Signed page 1');
        await page.getByRole('button', { name: 'Done' }).click();

        await page.getByRole('button', { name: 'Apply changes' }).click();
        const [file] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PDF' }).click()]);
        const texts = await pdfPageTexts(page, await readDownload(file));
        expect(texts[0]).toContain('Signed page 1');
        expect(texts[0]).not.toContain('Doc page 1');

        // The one editor is still underneath: every other tab is reachable from this page too.
        await expect(toolButton(page, 'Text')).toBeVisible();
        await expect(toolButton(page, 'Watermark')).toBeVisible();
    });
});

test.describe('Calculators', () => {
    test('age calculator', async ({ page }) => {
        await openTool(page, 'age-calculator');
        await page.getByLabel('Date of birth').fill('1990-05-15');
        await page.getByLabel('Age at the date of').fill('2026-09-29');
        await expect(page.locator('.result__value')).toHaveText('36 years, 4 months, 14 days');
        await expect(page.getByText('Born on a Tuesday')).toBeVisible();
        await expect(page.getByText(/Next birthday: Saturday, May 15, 2027/)).toBeVisible();

        await page.getByLabel('Date of birth').fill('2027-01-01');
        await expect(page.getByRole('alert')).toContainText('must be on or before');
    });

    test('percentage calculator shows results and working', async ({ page }) => {
        await openTool(page, 'percentage-calculator');
        const results = page.locator('.result__value');
        await expect(results.nth(0)).toHaveText('30');
        await expect(results.nth(1)).toHaveText('25%');
        await expect(results.nth(2)).toHaveText('25% increase');
        await expect(results.nth(3)).toHaveText('125');
        await expect(results.nth(4)).toHaveText('60');

        await page.locator('#pc1-a').fill('12.5');
        await page.locator('#pc1-b').fill('1,000');
        await expect(results.nth(0)).toHaveText('125');

        await page.locator('#pc2-b').fill('0');
        await expect(page.getByRole('alert')).toContainText('cannot be 0');

        await page.getByLabel('Increase or decrease', { exact: true }).selectOption('decrease');
        await expect(page.locator('#pc5').locator('..').locator('.result__value')).toHaveText('40');
    });

    test('tip calculator splits the tip and total, and can round up', async ({ page }) => {
        await openTool(page, 'tip-calculator');

        // Defaults: $85 bill, 20% tip, 4 people.
        await expect(stat(page, 'Total per person')).toHaveText('25.50');
        await expect(stat(page, 'Tip per person')).toHaveText('4.25');
        await expect(stat(page, 'Total bill')).toHaveText('102.00');
        await expect(stat(page, 'Total tip')).toHaveText('17.00');

        await page.getByLabel('Bill amount').fill('50');
        await page.getByLabel('Number of people').fill('1');
        await page.getByRole('button', { name: '15%' }).click();
        await expect(stat(page, 'Total per person')).toHaveText('57.50');
        await expect(stat(page, 'Tip per person')).toHaveText('7.50');

        await page.getByLabel('Number of people').fill('3');
        await expect(page.getByRole('alert')).toHaveCount(0);
        await page.getByLabel('Round up the total per person to the next whole dollar').check();
        await expect(stat(page, 'Total per person')).toHaveText('20.00');
        await expect(stat(page, 'Total bill')).toHaveText('60.00');
        await expect(stat(page, 'Total tip')).toHaveText('10.00');
        await expect(page.getByText('Rounded up so each person pays a whole dollar amount.')).toBeVisible();

        await page.getByLabel('Number of people').fill('0');
        await expect(page.getByRole('alert')).toContainText('at least 1 person');
    });

    test('mortgage calculator computes payment, interest and extra-payment savings', async ({ page }) => {
        await openTool(page, 'mortgage-calculator');
        const mcStat = (label) => page.locator('.stat').filter({ has: page.locator('.stat__label', { hasText: label }) }).locator('.stat__value');

        // Defaults: $350,000 home, 20% down, 6.5% interest, 30-year term -> $280,000 loan.
        await expect(mcStat('Monthly payment (principal & interest)')).toHaveText('$1,769.79');
        await expect(mcStat('Loan amount')).toHaveText('$280,000.00');
        await expect(mcStat('Total interest')).toHaveText('$357,124.57');
        await expect(mcStat('Total cost (price + interest)')).toHaveText('$707,124.57');
        await expect(page.getByText('Paid off in 30 years.')).toBeVisible();

        await page.getByRole('button', { name: '15 years' }).click();
        await expect(mcStat('Monthly payment (principal & interest)')).toHaveText('$2,439.10');

        await page.getByRole('button', { name: '30 years' }).click();
        await page.getByLabel('Extra monthly payment (optional)').fill('300');
        await expect(page.getByText('Paying $300.00 extra each month pays off the loan 9 years, 7 months sooner and saves $131,511.88 in interest.')).toBeVisible();

        await page.getByText('Show the year-by-year amortization schedule').click();
        const table = page.getByTestId('mortgage-table');
        await expect(table.locator('tbody tr').first().locator('th')).toHaveText('1');

        await page.getByLabel('Extra monthly payment (optional)').fill('0');
        await page.getByLabel('Home price').fill('0');
        await expect(page.getByRole('alert')).toContainText('home price');
    });

    test('loan calculator computes payment, interest and extra-payment savings', async ({ page }) => {
        await openTool(page, 'loan-calculator');
        const lcStat = (label) => page.locator('.stat').filter({ has: page.locator('.stat__label', { hasText: label }) }).locator('.stat__value');

        // Defaults: $20,000 loan, 7% interest, 5-year term.
        await expect(lcStat('Monthly payment')).toHaveText('$396.02');
        await expect(lcStat('Total interest')).toHaveText('$3,761.44');
        await expect(lcStat('Total repayment (loan + interest)')).toHaveText('$23,761.44');
        await expect(page.getByText('Paid off in 5 years.')).toBeVisible();

        await page.getByRole('button', { name: '2 years' }).click();
        await expect(lcStat('Monthly payment')).toHaveText('$895.45');

        await page.getByRole('button', { name: '5 years' }).click();
        await page.getByLabel('Extra monthly payment (optional)').fill('100');
        await expect(page.getByText('Paying $100.00 extra each month pays off the loan 1 year, 1 month sooner and saves $893.72 in interest.')).toBeVisible();

        await page.getByText('Show the year-by-year amortization schedule').click();
        const table = page.getByTestId('loan-table');
        await expect(table.locator('tbody tr').first().locator('th')).toHaveText('1');

        await page.getByLabel('Extra monthly payment (optional)').fill('0');
        await page.getByLabel('Loan amount').fill('0');
        await expect(page.getByRole('alert')).toContainText('loan amount');
    });

    test('compound interest calculator computes growth with contributions and compounding frequency', async ({ page }) => {
        await openTool(page, 'compound-interest-calculator');
        const ciStat = (label) => page.locator('.stat').filter({ has: page.locator('.stat__label', { hasText: label }) }).locator('.stat__value');

        // Defaults: $10,000 starting amount, 6% interest, 20 years, monthly compounding, $200/month.
        await expect(ciStat('Final balance')).toHaveText('$125,510.22');
        await expect(ciStat('Total contributed')).toHaveText('$48,000.00');
        await expect(ciStat('Total interest earned')).toHaveText('$67,510.22');

        await page.getByLabel('Number of years').fill('10');
        await expect(ciStat('Final balance')).toHaveText('$50,969.84');

        await page.getByLabel('Number of years').fill('20');
        await page.getByLabel('Compound frequency').selectOption('365');
        await expect(ciStat('Final balance')).toHaveText('$125,989.48');

        await page.getByLabel('Compound frequency').selectOption('1');
        await expect(ciStat('Final balance')).toHaveText('$120,356.77');

        await page.getByLabel('Compound frequency').selectOption('12');
        await page.getByText('Show the year-by-year balance').click();
        const table = page.getByTestId('compound-interest-table');
        await expect(table.locator('tbody tr').first().locator('th')).toHaveText('1');

        await page.getByLabel('Monthly contribution (optional)').fill('0');
        await page.getByLabel('Starting amount').fill('0');
        await expect(page.getByRole('alert')).toContainText('starting amount or a monthly contribution');
    });
});

test.describe('Developer tools', () => {
    test('JSON formatter formats, minifies, validates and re-formats on option change', async ({ page }) => {
        await openTool(page, 'json-formatter');
        await page.getByRole('button', { name: 'Sample' }).click();
        await page.getByRole('button', { name: 'Format / Beautify' }).click();
        const out = page.locator('#json-out');
        await expect(out).toHaveValue(/\n {2}"name": "ilovemytools"/);

        // Regression: changing the indent updates the result.
        await page.getByLabel('Indent').selectOption('4');
        await expect(out).toHaveValue(/\n {4}"name": "ilovemytools"/);
        await page.getByLabel('Sort keys A-Z').check();
        await expect(out).toHaveValue(/^\{\n {4}"free"/);

        await page.getByRole('button', { name: 'Minify' }).click();
        await expect(out).toHaveValue(/^\{"free":true,/);

        await page.getByLabel('JSON input').fill('{\n  "a": 1,\n}');
        await page.getByRole('button', { name: 'Validate' }).click();
        await expect(page.getByRole('alert')).toContainText('line 3');
        await expect(page.getByRole('alert')).toContainText('trailing comma');
    });

    test('Base64 encodes and decodes UTF-8 text and files', async ({ page }) => {
        await openTool(page, 'base64-encoder-decoder');
        const text = 'héllo wörld 👋';
        await page.getByLabel('Input').fill(text);
        await page.getByRole('button', { name: 'Encode ↓' }).click();
        await expect(page.getByLabel('Output')).toHaveValue(Buffer.from(text).toString('base64'));

        await page.getByRole('button', { name: 'Swap ↑' }).click();
        await page.getByRole('button', { name: 'Decode ↓' }).click();
        await expect(page.getByLabel('Output')).toHaveValue(text);

        await page.getByLabel('Input').fill('not base64!!');
        await page.getByRole('button', { name: 'Decode ↓' }).click();
        await expect(page.getByRole('alert')).toContainText('not valid Base64');

        await page.getByRole('tab', { name: 'File / Image' }).click();
        const png = await makeImage(page, { width: 20, height: 20 });
        await page.getByTestId('file-input').setInputFiles({ name: 'dot.png', mimeType: 'image/png', buffer: png });
        await expect(page.getByLabel('Base64', { exact: true })).toHaveValue(png.toString('base64'));
        await expect(page.getByLabel('Data URL (for HTML / CSS)')).toHaveValue(`data:image/png;base64,${png.toString('base64')}`);
    });

    test('What Is My IP shows the IP on direct load and after in-app navigation', async ({ page }) => {
        await openTool(page, 'what-is-my-ip');
        await expect(page.getByTestId('ip-value')).toHaveText('127.0.0.1');
        await expect(page.locator('.kv')).toContainText('Browser');

        await page.getByRole('button', { name: /Refresh/ }).click();
        await expect(page.getByTestId('ip-value')).toHaveText('127.0.0.1');

        // Opened from another page: the IP is fetched from /api/ip.
        await page.goto('/');
        await page.locator('main a.tool-card[href="/what-is-my-ip"]').first().click();
        await expect(page.getByTestId('ip-value')).toHaveText('127.0.0.1');
    });
});

test.describe('Text analysis and AVIF', () => {
    test('AVIF to WebP and AVIF to JPG convert a real AVIF file', async ({ page }) => {
        const fs = await import('node:fs/promises');
        const avif = await fs.readFile(new URL('./fixtures/sample.avif', import.meta.url));

        await openTool(page, 'avif-to-webp');
        await expect(page.getByRole('heading', { level: 1 })).toHaveText('AVIF to WebP Converter');
        await page.getByTestId('file-input').setInputFiles([{ name: 'photo.avif', mimeType: 'image/avif', buffer: avif }]);
        const items = page.locator('.file-item');
        await expect(items.getByRole('button', { name: 'Download' })).toHaveCount(1, { timeout: 30_000 });
        const [webp] = await Promise.all([page.waitForEvent('download'), items.first().getByRole('button', { name: 'Download' }).click()]);
        expect(webp.suggestedFilename()).toBe('photo.webp');
        const buf = await readDownload(webp);
        expect(buf.subarray(0, 4).toString()).toBe('RIFF');
        expect(buf.subarray(8, 12).toString()).toBe('WEBP');

        await openTool(page, 'avif-to-jpg');
        await page.getByTestId('file-input').setInputFiles([{ name: 'photo.avif', mimeType: 'image/avif', buffer: avif }]);
        const [jpg] = await Promise.all([page.waitForEvent('download'), page.locator('.file-item').first().getByRole('button', { name: 'Download' }).click({ timeout: 30_000 })]);
        expect(jpg.suggestedFilename()).toBe('photo.jpg');
        const j = await readDownload(jpg);
        expect(j[0] === 0xff && j[1] === 0xd8).toBe(true);
    });

    test('readability checker scores text and lists long sentences', async ({ page }) => {
        await openTool(page, 'readability-checker');
        const box = page.getByLabel('Your text');
        await box.fill('The cat sat on the mat. The dog ran to the park. We had fun in the sun.');
        await expect(page.getByTestId('readability-level')).toHaveText('Very easy');
        expect(Number(await page.getByTestId('flesch-ease').textContent())).toBeGreaterThan(90);

        await box.fill(`${'This is a very long sentence that keeps going and going '.repeat(4)}until it ends. Short one.`);
        await expect(page.getByText(/Long sentences to shorten \(1\)/)).toBeVisible();
        await expect(page.getByRole('table', { name: 'Readability scores' })).toContainText('Gunning Fog Index');
    });

    test('AI content detector separates AI-style and casual human text', async ({ page }) => {
        await openTool(page, 'ai-content-detector');
        const box = page.getByLabel('Text to check');
        const check = page.getByRole('button', { name: 'Check text' });

        await box.fill('Just a few words here.');
        await check.click();
        await expect(page.getByText(/Please paste at least 80 words/)).toBeVisible();

        await box.fill(
            "In today's fast-paced digital landscape, it is important to note that effective communication plays a crucial role in organizational success. Furthermore, businesses must leverage robust strategies to navigate the complexities of an ever-evolving market. Moreover, fostering a holistic approach enables teams to unlock the potential of their workforce. Additionally, organizations that embrace innovation can seamlessly streamline their operations. In conclusion, a comprehensive strategy is a testament to the paramount importance of meticulous planning. Overall, companies that delve into these practices will empower their employees and elevate their performance in a vibrant and dynamic realm.",
        );
        await check.click();
        await expect(page.getByTestId('ai-verdict')).toHaveText('Likely AI-generated');
        await expect(page.locator('.tool-panel').getByText('AI-typical phrases found')).toBeVisible();

        await box.fill(
            "I didn't plan to buy a bike. Honestly, I just walked past the shop on Saturday because the bakery next door was out of bread, and there it was: a green one, a bit rusty, forty quid. The guy said it'd been sitting there since spring. I rode it home in the rain. Got soaked. My neighbour laughed at me, which, fair enough. Anyway, it's been three weeks now and I've ridden it to work almost every day. Turns out the hill on Mill Lane is brutal! But I'm getting faster, and I don't miss the bus at all. Not even a little.",
        );
        await check.click();
        await expect(page.getByTestId('ai-verdict')).toHaveText('Likely human-written');
    });
});

test.describe('Background remover', () => {
    test('removes a plain background and downloads a transparent PNG', async ({ page }) => {
        test.slow(); // AI inference on the CPU; slow when other tests share the machine
        const fs = await import('node:fs');
        // Serve ONNX Runtime from node_modules instead of the CDN, so the test never depends on it.
        await page.route(/cdn\.jsdelivr\.net\/npm\/onnxruntime-web@[^/]+\/dist\/(.+)$/, (route) => {
            const file = route.request().url().split('/dist/')[1].split('?')[0];
            route.fulfill({
                body: fs.readFileSync(`node_modules/onnxruntime-web/dist/${file}`),
                contentType: file.endsWith('.wasm') ? 'application/wasm' : 'text/javascript',
                headers: { 'Access-Control-Allow-Origin': '*' },
            });
        });
        await openTool(page, 'remove-background');
        await expect(page.getByRole('heading', { level: 1 })).toHaveText('Remove Background from Image');

        // A red circle on a white background.
        const png = await page.evaluate(async () => {
            const c = new OffscreenCanvas(400, 300);
            const x = c.getContext('2d');
            x.fillStyle = '#fff';
            x.fillRect(0, 0, 400, 300);
            x.fillStyle = '#e11d48';
            x.beginPath();
            x.arc(200, 150, 90, 0, Math.PI * 2);
            x.fill();
            return Array.from(new Uint8Array(await (await c.convertToBlob({ type: 'image/png' })).arrayBuffer()));
        });
        await page.getByTestId('file-input').setInputFiles([{ name: 'ball.png', mimeType: 'image/png', buffer: Buffer.from(png) }]);
        await expect(page.getByTestId('bg-result')).toBeVisible({ timeout: 180_000 });

        const [dl] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download PNG' }).click()]);
        expect(dl.suggestedFilename()).toBe('ball-no-bg.png');
        const bytes = Array.from(await readDownload(dl));
        const alpha = await page.evaluate(async (b) => {
            const bm = await createImageBitmap(new Blob([new Uint8Array(b)]));
            const c = new OffscreenCanvas(bm.width, bm.height);
            const x = c.getContext('2d');
            x.drawImage(bm, 0, 0);
            const at = (px, py) => x.getImageData(px, py, 1, 1).data[3];
            return { corner: at(5, 5), center: at(200, 150), w: bm.width };
        }, bytes);
        expect(alpha.w).toBe(400);
        expect(alpha.corner).toBeLessThan(30);
        expect(alpha.center).toBeGreaterThan(225);

        // White background option fills the transparent area.
        await page.getByRole('button', { name: 'White' }).click();
        await expect(page.getByRole('button', { name: 'White' })).toHaveAttribute('aria-pressed', 'true');
    });
});

test.describe('Broken link checker', () => {
    test('refuses private addresses (real server, no outside network)', async ({ page }) => {
        await openTool(page, 'broken-link-checker');
        await expect(page.getByText('This tool asks our server to fetch the address you enter.')).toBeVisible();
        await page.getByLabel('Page address (URL)').fill('http://127.0.0.1/admin');
        await page.getByRole('button', { name: 'Check links' }).click();
        await expect(page.getByRole('alert')).toContainText('This address can’t be checked');
    });

    test('lists broken links, redirects and exports a CSV', async ({ page }) => {
        await page.route('**/api/links/extract', (route) =>
            route.fulfill({
                json: {
                    url: 'https://example.com/',
                    truncated: false,
                    links: [
                        { url: 'https://example.com/ok', text: 'Fine', type: 'link', internal: true },
                        { url: 'https://example.com/gone', text: 'Old post', type: 'link', internal: true },
                        { url: 'https://example.com/moved', text: 'Moved', type: 'link', internal: true },
                        { url: 'https://other.example/logo.png', text: 'Logo', type: 'image', internal: false },
                    ],
                },
            }),
        );
        await page.route('**/api/links/check', (route) =>
            route.fulfill({
                json: {
                    results: [
                        { url: 'https://example.com/ok', status: 200, final: 'https://example.com/ok', redirects: 0, error: null },
                        { url: 'https://example.com/gone', status: 404, final: 'https://example.com/gone', redirects: 0, error: null },
                        { url: 'https://example.com/moved', status: 200, final: 'https://example.com/new', redirects: 1, error: null },
                        { url: 'https://other.example/logo.png', status: null, final: 'https://other.example/logo.png', redirects: 0, error: 'dns' },
                    ],
                },
            }),
        );
        await openTool(page, 'broken-link-checker');
        await page.getByLabel('Page address (URL)').fill('example.com');
        await page.getByRole('button', { name: 'Check links' }).click();
        await expect(page.getByTestId('blc-summary')).toContainText('Checked 4 of 4 links');

        const table = page.getByTestId('blc-table');
        await expect(table.getByRole('row')).toHaveCount(3); // header + 2 problems
        await expect(table).toContainText('404 · Broken');
        await expect(table).toContainText('Domain not found · Broken');

        await page.getByRole('tab', { name: 'Redirects' }).click();
        await expect(table).toContainText('redirects to https://example.com/new');

        const [csv] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download CSV' }).click()]);
        expect(csv.suggestedFilename()).toBe('example.com-links.csv');
        const text = (await readDownload(csv)).toString();
        expect(text.split('\n')).toHaveLength(5);
        expect(text).toContain('https://example.com/gone,404,Broken');
    });
});

test.describe('Domain authority checker', () => {
    test('says it is being set up when no API key is configured (real server)', async ({ page }) => {
        await openTool(page, 'domain-authority-checker');
        await page.getByLabel(/Domains \(one per line/).fill('github.com');
        await page.getByRole('button', { name: 'Check authority' }).click();
        await expect(page.getByRole('alert')).toContainText('being set up');
    });

    test('shows scores sorted with a CSV export', async ({ page }) => {
        await page.route('**/api/domain-authority', (route) =>
            route.fulfill({
                json: {
                    as_of: '2026-09-01',
                    invalid: ['not a domain'],
                    results: [
                        { domain: 'small-blog.example', found: true, score: 2.5, rank: 900000, referring_domains: 40 },
                        { domain: 'github.com', found: true, score: 9.67, rank: 30, referring_domains: 282833 },
                        { domain: 'brand-new.example', found: false, score: null, rank: null, referring_domains: null },
                    ],
                },
            }),
        );
        await openTool(page, 'domain-authority-checker');
        await page.getByLabel(/Domains \(one per line/).fill('small-blog.example\ngithub.com\nbrand-new.example\nnot a domain');
        await page.getByRole('button', { name: 'Check authority' }).click();

        const rows = page.getByTestId('da-table').locator('tbody tr');
        await expect(rows).toHaveCount(3);
        await expect(rows.first()).toContainText('github.com'); // highest score first
        await expect(rows.first()).toContainText('#30');
        await expect(rows.last()).toContainText('Not found');
        await expect(page.getByText('Skipped (not a domain): not a domain')).toBeVisible();

        const [csv] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download CSV' }).click()]);
        expect(csv.suggestedFilename()).toBe('domain-authority.csv');
        expect((await readDownload(csv)).toString()).toContain('github.com,9.67,30,282833');
    });

    test('opens the details panel automatically for a single domain', async ({ page }) => {
        await page.route('**/api/domain-authority', (route) =>
            route.fulfill({ json: { as_of: '2026-09-01', invalid: [], results: [{ domain: 'github.com', found: true, score: 9.67, rank: 30, referring_domains: 282833 }] } }),
        );
        await page.route('**/api/domain-details', (route) =>
            route.fulfill({
                json: {
                    domain: 'github.com',
                    resolves: true,
                    registration: { created: '2007-10-09T18:20:50Z', expires: '2028-10-09T18:20:50Z', updated: null, registrar: 'MarkMonitor Inc.', status: [], nameservers: [] },
                    dns: { ipv4: ['140.82.121.4'], ipv6: [], nameservers: ['dns1.p08.nsone.net'], dns_provider: 'NS1', mx: ['aspmx.l.google.com'], mail_provider: 'Google Workspace' },
                    hosting: { ip: '140.82.121.4', asn: 36459, network: 'GITHUB', prefix: '140.82.121.0/24', country: 'US' },
                    https: { valid: true, issuer: 'Sectigo Limited', expires: '2027-02-05T23:59:59Z' },
                    score: { domain: 'github.com', found: true, score: 9.67, rank: 30, referring_domains: 282833 },
                },
            }),
        );
        await openTool(page, 'domain-authority-checker');
        await page.getByLabel(/Domains \(one per line/).fill('github.com');
        await page.getByRole('button', { name: 'Check authority' }).click();

        const details = page.getByTestId('domain-details');
        await expect(details).toContainText('MarkMonitor Inc.');
        await expect(details).toContainText('GITHUB');
        await expect(details).toContainText('AS36459');
        await expect(details).toContainText('Google Workspace');
        await expect(details).toContainText('Valid certificate');
        await page.getByRole('button', { name: 'Hide details' }).click();
        await expect(details).toHaveCount(0);
    });
});

test.describe('Domain age checker', () => {
    test('shows dates, age and registrar, lists failures and exports a CSV', async ({ page }) => {
        await page.route('**/api/domain-age', (route) =>
            route.fulfill({
                json: {
                    invalid: ['not a domain'],
                    results: [
                        {
                            domain: 'example.com',
                            created: '1995-08-14T04:00:00Z',
                            expires: '2026-08-13T04:00:00Z',
                            updated: '2024-08-14T07:01:31Z',
                            registrar: 'RESERVED-Internet Assigned Numbers Authority',
                            status: ['client delete prohibited'],
                            nameservers: ['a.iana-servers.net', 'b.iana-servers.net'],
                        },
                        { domain: 'never-registered.example', error: 'not-found' },
                    ],
                },
            }),
        );
        await openTool(page, 'domain-age-checker');
        await page.getByLabel(/Domains \(one per line/).fill('example.com\nnever-registered.example\nnot a domain');
        await page.getByRole('button', { name: 'Check domain age' }).click();

        const rows = page.getByTestId('age-table').locator('tbody tr');
        await expect(rows).toHaveCount(1);
        await expect(rows.first()).toContainText('example.com');
        await expect(rows.first()).toContainText('RESERVED-Internet Assigned Numbers Authority');
        await expect(rows.first()).toContainText(/\d+y \d+m \d+d/);
        await expect(page.getByText('Skipped (not a domain): not a domain')).toBeVisible();
        await expect(page.getByTestId('age-errors')).toContainText('never-registered.example');
        await expect(page.getByTestId('age-errors')).toContainText('No RDAP record was found');

        const [csv] = await Promise.all([page.waitForEvent('download'), page.getByRole('button', { name: 'Download CSV' }).click()]);
        expect(csv.suggestedFilename()).toBe('domain-age.csv');
        expect((await readDownload(csv)).toString()).toContain('example.com');
    });

    test('refuses more than 20 domains without calling the server', async ({ page }) => {
        await openTool(page, 'domain-age-checker');
        const many = Array.from({ length: 21 }, (_, i) => `site${i}.com`).join('\n');
        await page.getByLabel(/Domains \(one per line/).fill(many);
        await page.getByRole('button', { name: 'Check domain age' }).click();
        await expect(page.getByRole('alert')).toContainText('at most 20 domains');
    });
});
