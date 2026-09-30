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
