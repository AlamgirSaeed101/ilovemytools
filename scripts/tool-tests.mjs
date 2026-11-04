// Runs the top tools on the live site with real sample files and records what happened, for the
// "We tested it" notes on English tool pages (resources/data/tool-tests.json). Ads and analytics stay
// blocked, and every request is logged to confirm that file tools send no file anywhere.
// Usage: node scripts/tool-tests.mjs [base-url] [slug,slug]
// (HOST_RULES="MAP ilovemytools.store 192.124.249.6" on a PC with broken DNS.)
import fs from 'node:fs';
import path from 'node:path';
import { chromium } from '@playwright/test';
import { PDFDocument, StandardFonts } from 'pdf-lib';

const root = path.resolve(import.meta.dirname, '..');
const base = (process.argv[2] || 'https://ilovemytools.store').replace(/\/$/, '');
const only = process.argv[3] ? process.argv[3].split(',') : null;
const outFile = path.join(root, 'resources/data/tool-tests.json');

async function makePdf(pages, label) {
    const doc = await PDFDocument.create();
    const font = await doc.embedFont(StandardFonts.Helvetica);
    for (let i = 1; i <= pages; i++) {
        const page = doc.addPage([595, 842]);
        page.drawText(`${label} page ${i}`, { x: 60, y: 760, size: 24, font });
    }
    return Buffer.from(await doc.save());
}

// A photo-like image: a gradient plus film grain, from a fixed seed so anyone gets the same file.
async function makePhoto(page, width, height, type, quality = 0.95) {
    const url = await page.evaluate(({ width, height, type, quality }) => {
        const c = document.createElement('canvas');
        c.width = width;
        c.height = height;
        const g = c.getContext('2d');
        const sky = g.createLinearGradient(0, 0, 0, height);
        sky.addColorStop(0, '#7fb2d9');
        sky.addColorStop(0.6, '#f0d9b5');
        sky.addColorStop(1, '#5d7a4f');
        g.fillStyle = sky;
        g.fillRect(0, 0, width, height);
        const img = g.getImageData(0, 0, width, height);
        let seed = 7;
        for (let i = 0; i < img.data.length; i += 4) {
            seed = (seed * 1103515245 + 12345) & 0x7fffffff;
            const grain = (seed % 25) - 12;
            img.data[i] += grain;
            img.data[i + 1] += grain;
            img.data[i + 2] += grain;
        }
        g.putImageData(img, 0, 0);
        return c.toDataURL(type, quality);
    }, { width, height, type, quality });
    return Buffer.from(url.split(',')[1], 'base64');
}

async function pdfWithPhoto(jpeg, pages = 1) {
    const doc = await PDFDocument.create();
    const img = await doc.embedJpg(jpeg);
    for (let i = 0; i < pages; i++) {
        const p = doc.addPage([595, 842]);
        p.drawImage(img, { x: 40, y: 200, width: 515, height: 343 });
    }
    return Buffer.from(await doc.save());
}

const pdfFile = (name, buffer) => ({ name, mimeType: 'application/pdf', buffer });
const input = (page) => page.getByTestId('file-input');
async function grab(page, button) {
    const [dl] = await Promise.all([page.waitForEvent('download', { timeout: 60_000 }), button.click()]);
    const p = await dl.path();
    return { name: dl.suggestedFilename(), bytes: fs.readFileSync(p) };
}
const pages = async (bytes) => (await PDFDocument.load(bytes)).getPageCount();
const kb = (n) => Math.round(n / 1024);
const btn = (page, name) => page.getByRole('button', { name, exact: true });

const tests = {
    'merge-pdf': async (page) => {
        const files = [pdfFile('cover.pdf', await makePdf(1, 'Cover')), pdfFile('report.pdf', await makePdf(5, 'Report')), pdfFile('annex.pdf', await makePdf(2, 'Annex'))];
        await input(page).setInputFiles(files);
        await btn(page, 'Merge PDF').click();
        const out = await grab(page, page.getByRole('button', { name: 'Download merged PDF' }));
        return { inputFiles: 3, inputPages: 8, outputPages: await pages(out.bytes), outputKB: kb(out.bytes.length) };
    },
    'compress-pdf': async (page) => {
        const jpeg = await makePhoto(page, 1600, 1067, 'image/jpeg', 0.95);
        const original = await pdfWithPhoto(jpeg, 3);
        await input(page).setInputFiles(pdfFile('photos.pdf', original));
        await page.getByRole('button', { name: 'Compress PDF' }).click();
        const rec = await grab(page, page.getByRole('button', { name: 'Download PDF' }));
        await page.getByRole('button', { name: 'Choose another PDF' }).click().catch(() => {});
        return { pages: 3, originalKB: kb(original.length), recommendedKB: kb(rec.bytes.length), recommendedPages: await pages(rec.bytes) };
    },
    'split-pdf': async (page) => {
        await input(page).setInputFiles(pdfFile('report.pdf', await makePdf(12, 'Report')));
        await page.getByLabel('Pages to extract').fill('1-3、5');
        await page.getByRole('button', { name: 'Split PDF' }).click();
        const out = await grab(page, page.getByRole('button', { name: /Download/ }).first());
        return { inputPages: 12, range: '1-3, 5', outputPages: await pages(out.bytes), fileName: out.name };
    },
    'pdf-to-jpg': async (page) => {
        await input(page).setInputFiles(pdfFile('doc.pdf', await makePdf(1, 'Doc')));
        await page.locator('.page-card').first().waitFor();
        const sizes = {};
        for (const dpi of ['72', '150', '300']) {
            await page.getByLabel('Image quality (DPI)').selectOption(dpi);
            await btn(page, 'Convert').click();
            const out = await grab(page, page.getByRole('button', { name: /Download/ }).first());
            sizes[dpi] = kb(out.bytes.length);
            await page.getByRole('button', { name: 'Choose another PDF' }).click();
            await input(page).setInputFiles(pdfFile('doc.pdf', await makePdf(1, 'Doc')));
            await page.locator('.page-card').first().waitFor();
        }
        return { pageKBByDpi: sizes };
    },
    'jpg-to-pdf': async (page) => {
        const jpg = await makePhoto(page, 1600, 1067, 'image/jpeg', 0.9);
        await input(page).setInputFiles([{ name: 'a.jpg', mimeType: 'image/jpeg', buffer: jpg }, { name: 'b.jpg', mimeType: 'image/jpeg', buffer: jpg }, { name: 'c.jpg', mimeType: 'image/jpeg', buffer: jpg }]);
        await page.locator('.file-item').nth(2).waitFor();
        await page.getByRole('button', { name: /Create PDF|Convert/ }).first().click();
        const out = await grab(page, page.getByRole('button', { name: /Download/ }).first());
        return { images: 3, imageKB: kb(jpg.length), outputPages: await pages(out.bytes), outputKB: kb(out.bytes.length) };
    },
    'edit-pdf': async (page) => {
        await input(page).setInputFiles(pdfFile('contract.pdf', await makePdf(2, 'Contract')));
        await page.getByLabel('Find').fill('Contract');
        await page.getByLabel('Replace with').fill('Agreement');
        await page.getByRole('button', { name: 'Replace all' }).click();
        const note = await page.getByText(/Replaced \d+ time/).first().innerText();
        await btn(page, 'Save PDF').click();
        const out = await grab(page, page.getByRole('button', { name: /Download/ }).first());
        const text = out.bytes.includes('Contract');
        return { note, outputPages: await pages(out.bytes), rawOldWordInFile: text };
    },
    'image-compressor': async (page) => {
        const jpg = await makePhoto(page, 1600, 1067, 'image/jpeg', 0.98);
        const item = page.locator('.file-item').first();
        await input(page).setInputFiles({ name: 'photo.jpg', mimeType: 'image/jpeg', buffer: jpg });
        await item.getByRole('button', { name: 'Download' }).waitFor({ timeout: 60_000 });
        const q75 = await item.innerText();
        await page.getByRole('tab', { name: /Target size/ }).click();
        await page.getByLabel('Maximum file size (KB)').fill('100');
        await page.getByRole('button', { name: /Apply|Re-?compress/ }).first().click();
        await page.waitForTimeout(8000);
        const out = await grab(page, item.getByRole('button', { name: 'Download' }));
        return { originalKB: kb(jpg.length), quality75: q75.replace(/\s+/g, ' '), target100KB: kb(out.bytes.length) };
    },
    'image-resizer': async (page) => {
        const png = await makePhoto(page, 1600, 1067, 'image/png');
        await input(page).setInputFiles({ name: 'pic.png', mimeType: 'image/png', buffer: png });
        await page.getByLabel('Width (px)').fill('800');
        const height = await page.getByLabel('Height (px)').inputValue();
        await page.getByRole('button', { name: /^Resize to/ }).click();
        const out = await grab(page, page.getByRole('button', { name: 'Download image' }));
        return { from: '1600 x 1067', widthSet: 800, heightAuto: height, width: out.bytes.readUInt32BE(16), height: out.bytes.readUInt32BE(20) };
    },
    'webp-to-png': async (page) => {
        const webp = await makePhoto(page, 800, 533, 'image/webp', 0.8);
        await input(page).setInputFiles({ name: 'a.webp', mimeType: 'image/webp', buffer: webp });
        const item = page.locator('.file-item').first();
        await item.getByRole('button', { name: 'Download' }).waitFor({ timeout: 60_000 });
        const out = await grab(page, item.getByRole('button', { name: 'Download' }));
        return { webpKB: kb(webp.length), pngKB: kb(out.bytes.length), name: out.name };
    },
    'word-counter': async (page) => {
        const box = page.locator('.tool-panel textarea').first();
        const stat = (label) => page.locator('.stat').filter({ has: page.locator('.stat__label', { hasText: new RegExp(`^${label}$`) }) }).locator('.stat__value').innerText();
        const results = {};
        for (const [name, text] of Object.entries({
            plain: 'The quick brown fox jumps over the lazy dog.',
            hyphen: 'A state-of-the-art tool.',
            apostrophe: "Don't stop, it's fine.",
            numbers: 'In 2026 we paid 1,250.50 dollars.',
            german: 'Die Bachelorarbeit ist z. B. lang.',
        })) {
            await box.fill(text);
            await page.waitForTimeout(150);
            results[name] = { text, words: await stat('Words') };
        }
        return results;
    },
    'qr-code-generator': async (page) => {
        await page.locator('.tool-panel input[type=url], .tool-panel input[type=text]').first().fill('https://ilovemytools.store/');
        await page.waitForTimeout(800);
        const png = await grab(page, page.getByRole('button', { name: 'Download PNG' }));
        const svg = await grab(page, page.getByRole('button', { name: 'Download SVG' }));
        return { pngKB: Math.round(png.bytes.length / 102.4) / 10, pngSize: `${png.bytes.readUInt32BE(16)} x ${png.bytes.readUInt32BE(20)}`, svgIsVector: svg.bytes.toString().includes('<svg') };
    },
    'json-formatter': async (page) => {
        const box = page.locator('.tool-panel textarea').first();
        await box.fill('{"name":"Ann","tags":["a","b"],}');
        await page.getByRole('button', { name: /Format/ }).first().click();
        await page.waitForTimeout(400);
        const bad = await page.locator('.tool-panel .notice').first().innerText();
        await box.fill('{"name":"Ann","tags":["a","b"]}');
        await page.getByRole('button', { name: /Format/ }).first().click();
        await page.waitForTimeout(400);
        const good = await page.locator('.tool-panel .notice').first().innerText();
        return { trailingCommaMessage: bad, validMessage: good };
    },
    'password-generator': async (page) => {
        const seen = await page.evaluate(() => document.querySelector('.tool-panel').innerText.match(/\d+ bits of entropy/)?.[0]);
        return { default16Chars: seen };
    },
    'domain-authority-checker': async (page) => {
        await page.locator('.tool-panel textarea').first().fill('wikipedia.org\nilovemytools.store');
        await page.getByRole('button', { name: 'Check authority' }).click();
        await page.waitForTimeout(9000);
        return { table: (await page.locator('.tool-panel table').first().innerText().catch(() => '')).replace(/\s+/g, ' ').slice(0, 300) };
    },
    'domain-age-checker': async (page) => {
        await page.locator('.tool-panel textarea').first().fill('wikipedia.org');
        await page.getByRole('button', { name: 'Check domain age' }).click();
        await page.waitForTimeout(8000);
        return { result: (await page.locator('.tool-panel').first().innerText()).replace(/\s+/g, ' ').slice(0, 300) };
    },
};

Object.assign(tests, {
    'coin-flip': async (page) => {
        await page.emulateMedia({ reducedMotion: 'reduce' });
        await page.locator('.tool-panel').getByText('100', { exact: true }).first().click();
        for (let i = 0; i < 10; i++) {
            await page.locator('.tool-panel button.btn--primary').first().click();
            await page.waitForTimeout(1500);
        }
        return { coinsPerFlip: 100, flips: 10, panel: (await page.locator('.tool-panel').innerText()).replace(/\s+/g, ' ').slice(0, 400) };
    },
    'json-errors': { slug: 'json-formatter', run: async (page) => {
        const box = page.locator('.tool-panel textarea').first();
        const out = {};
        for (const [name, text] of Object.entries({
            singleQuotes: "{'name': 'Ann'}",
            missingComma: '{"a": 1 "b": 2}',
            unquotedKey: '{name: "Ann"}',
            trailingArrayComma: '[1, 2, 3,]',
            missingBracket: '{"tags": ["a", "b"}',
            comment: '{"a": 1 // note\n}',
        })) {
            await box.fill(text);
            await page.getByRole('button', { name: /Format/ }).first().click();
            await page.waitForTimeout(300);
            out[name] = { text, message: await page.locator('.tool-panel .notice').first().innerText() };
        }
        return out;
    } },
    'broken-link-checker': async (page) => {
        await page.locator('.tool-panel input').first().fill('https://ilovemytools.store/about');
        await page.getByRole('button', { name: /Check links/ }).click();
        await page.waitForTimeout(25000);
        return { panel: (await page.locator('.tool-panel').innerText()).replace(/\s+/g, ' ').slice(0, 500) };
    },
    'jpg-to-png': async (page) => {
        const jpg = await makePhoto(page, 800, 533, 'image/jpeg', 0.85);
        await input(page).setInputFiles({ name: 'a.jpg', mimeType: 'image/jpeg', buffer: jpg });
        const item = page.locator('.file-item').first();
        await item.getByRole('button', { name: 'Download' }).waitFor({ timeout: 60_000 });
        const out = await grab(page, item.getByRole('button', { name: 'Download' }));
        return { jpgKB: kb(jpg.length), pngKB: kb(out.bytes.length) };
    },
    'organize-pdf': async (page) => {
        await input(page).setInputFiles(pdfFile('doc.pdf', await makePdf(3, 'Doc')));
        await page.locator('.page-card').first().waitFor();
        return { panel: (await page.locator('.tool-panel').innerText()).replace(/\s+/g, ' ').slice(0, 300) };
    },
    'unlock-pdf': async (page) => {
        await input(page).setInputFiles(pdfFile('plain.pdf', await makePdf(1, 'Plain')));
        await page.waitForTimeout(4000);
        return { noPasswordMessage: (await page.locator('.tool-panel').innerText()).replace(/\s+/g, ' ').slice(0, 300) };
    },
    'excel-to-pdf': async (page) => ({ notice: (await page.locator('.tool-panel').innerText()).replace(/\s+/g, ' ').slice(0, 400) }),
    'compound-interest-calculator': async (page) => ({ panel: (await page.locator('.tool-panel').innerText()).replace(/\s+/g, ' ').slice(0, 400) }),
    'mortgage-calculator': async (page) => ({ panel: (await page.locator('.tool-panel').innerText()).replace(/\s+/g, ' ').slice(0, 400) }),
});

const results = fs.existsSync(outFile) ? JSON.parse(fs.readFileSync(outFile, 'utf8')) : {};
const browser = await chromium.launch({ channel: 'chrome', args: process.env.HOST_RULES ? [`--host-resolver-rules=${process.env.HOST_RULES}`] : [] });
for (const [slug, entry] of Object.entries(tests)) {
    if (only && !only.includes(slug)) continue;
    const run = entry.run || entry;
    const context = await browser.newContext({ acceptDownloads: true, viewport: { width: 1350, height: 1000 } });
    const page = await context.newPage();
    await page.route(/googlesyndication|doubleclick|googletagmanager|google-analytics|adservice|fundingchoices/, (r) => r.abort());
    let largestUpload = 0;
    const started = [];
    page.on('request', (r) => {
        const size = (r.postDataBuffer() || Buffer.alloc(0)).length;
        if (r.method() !== 'GET') started.push(`${r.method()} ${new URL(r.url()).pathname}`);
        largestUpload = Math.max(largestUpload, size);
    });
    try {
        await page.goto(`${base}/${entry.slug || slug}`, { waitUntil: 'load', timeout: 60_000 });
        await page.locator('.tool-panel').first().waitFor();
        await page.waitForTimeout(1500);
        const result = await run(page);
        results[slug] = { tested: new Date().toISOString().slice(0, 10), ...result, largestUploadBytes: largestUpload, nonGetRequests: started };
        console.log('OK  ', slug, JSON.stringify(results[slug]).slice(0, 400));
    } catch (e) {
        console.log('FAIL', slug, String(e.message).split('\n')[0].slice(0, 200));
    }
    await context.close();
}
await browser.close();
fs.writeFileSync(outFile, JSON.stringify(Object.fromEntries(Object.entries(results).sort()), null, 4) + '\n');
