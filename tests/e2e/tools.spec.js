import { expect, test } from '@playwright/test';
import JSZip from 'jszip';
import { makeImage, makePdf, openTool, pdfPageCount, readDownload, trackErrors } from './helpers.js';

let errors;
test.beforeEach(({ page }) => {
    errors = trackErrors(page);
});
test.afterEach(() => errors.assertNone());

const stat = (page, label) =>
    page.locator('.stat').filter({ has: page.locator('.stat__label', { hasText: new RegExp(`^${label}$`) }) }).locator('.stat__value');

const pngSize = (buf) => ({ width: buf.readUInt32BE(16), height: buf.readUInt32BE(20) });

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
        await expect(page.getByText('AI-typical phrases found')).toBeVisible();

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
