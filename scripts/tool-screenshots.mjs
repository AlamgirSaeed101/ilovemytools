// Takes a real screenshot of each top tool while it is in use, into public/images/tools/, and lists
// them in resources/data/tool-screenshots.json. English pages show them under "How to use".
// Re-run after changing a listed tool's layout.
// Usage: npm run build && php artisan serve --port=8123, then node scripts/tool-screenshots.mjs [base-url]
import fs from 'node:fs';
import path from 'node:path';
import { chromium } from '@playwright/test';
import { PDFDocument, StandardFonts } from 'pdf-lib';

const root = path.resolve(import.meta.dirname, '..');
const base = (process.argv[2] || 'http://127.0.0.1:8123').replace(/\/$/, '');
const outDir = path.join(root, 'public/images/tools');
const listFile = path.join(root, 'resources/data/tool-screenshots.json');
fs.mkdirSync(outDir, { recursive: true });

async function samplePdf(title, pages = 2) {
    const doc = await PDFDocument.create();
    const font = await doc.embedFont(StandardFonts.Helvetica);
    for (let i = 1; i <= pages; i++) {
        const page = doc.addPage([595, 842]);
        page.drawText(title, { x: 60, y: 760, size: 26, font });
        page.drawText(`Page ${i} of ${pages}. Sample document used for this screenshot.`, { x: 60, y: 720, size: 13, font });
        for (let line = 0; line < 12; line++) {
            page.drawText('The quick brown fox jumps over the lazy dog, again and again.', { x: 60, y: 680 - line * 24, size: 12, font });
        }
    }
    return { name: `${title.toLowerCase().replace(/\s+/g, '-')}.pdf`, mimeType: 'application/pdf', buffer: Buffer.from(await doc.save()) };
}

const firstFile = (page) => page.locator('input[type=file]').first();
const TEXT = 'Paste or type your text here and the counts update as you write. This sample has a few short sentences. It shows words, characters, sentences and reading time together.';

const shots = {
    'merge-pdf': {
        alt: 'Merge PDF tool with three PDF files listed in order, ready to combine',
        run: async (page) => firstFile(page).setInputFiles([await samplePdf('Cover letter', 1), await samplePdf('Resume', 2), await samplePdf('References', 1)]),
    },
    'split-pdf': {
        alt: 'Split PDF tool with a loaded PDF and the page range options',
        run: async (page) => firstFile(page).setInputFiles(await samplePdf('Annual report', 12)),
    },
    'compress-pdf': {
        alt: 'Compress PDF tool with a loaded PDF and the compression options',
        run: async (page) => firstFile(page).setInputFiles(await samplePdf('Annual report', 4)),
    },
    'edit-pdf': {
        alt: 'Edit PDF tool showing an open document with the editing toolbar',
        run: async (page) => {
            await firstFile(page).setInputFiles(await samplePdf('Service agreement', 2));
            await page.locator('.tool-panel canvas').first().waitFor({ timeout: 60_000 });
        },
    },
    'image-compressor': {
        alt: 'Image Compressor with a loaded image, its compressed size and the quality setting',
        run: async (page) => {
            // A photo-like JPEG (soft light plus grain), so the result shows a typical saving.
            const dataUrl = await page.evaluate(() => {
                const c = document.createElement('canvas');
                c.width = 1600;
                c.height = 1067;
                const g = c.getContext('2d');
                const sky = g.createLinearGradient(0, 0, 0, c.height);
                sky.addColorStop(0, '#7fb2d9');
                sky.addColorStop(0.6, '#f0d9b5');
                sky.addColorStop(1, '#5d7a4f');
                g.fillStyle = sky;
                g.fillRect(0, 0, c.width, c.height);
                const img = g.getImageData(0, 0, c.width, c.height);
                let seed = 7;
                for (let i = 0; i < img.data.length; i += 4) {
                    seed = (seed * 1103515245 + 12345) & 0x7fffffff;
                    const grain = (seed % 41) - 20;
                    img.data[i] += grain;
                    img.data[i + 1] += grain;
                    img.data[i + 2] += grain;
                }
                g.putImageData(img, 0, 0);
                return c.toDataURL('image/jpeg', 1);
            });
            await firstFile(page).setInputFiles({ name: 'photo.jpg', mimeType: 'image/jpeg', buffer: Buffer.from(dataUrl.split(',')[1], 'base64') });
        },
    },
    'word-counter': {
        alt: 'Word Counter showing live word, character and sentence counts for sample text',
        run: async (page) => page.locator('textarea').first().fill(TEXT),
    },
    'qr-code-generator': {
        alt: 'QR Code Generator showing a generated QR code and the download options',
        run: async (page) => page.locator('textarea, input[type=url], input[type=text]').first().fill('https://ilovemytools.store/'),
    },
    'password-generator': {
        alt: 'Password Generator showing a generated password with length and character options',
        run: async () => {},
    },
    'json-formatter': {
        alt: 'JSON Formatter showing sample JSON formatted with indentation',
        run: async (page) => {
            await page.locator('textarea').first().fill('{"name":"ILoveMyTools","tools":54,"free":true,"languages":["en","de","es"]}');
            await page.getByRole('button', { name: /Format/ }).first().click();
        },
    },
    'percentage-calculator': {
        alt: 'Percentage Calculator showing a result with the formula used',
        run: async (page) => {
            const inputs = page.locator('.tool-panel input[type=number], .tool-panel input[inputmode]');
            await inputs.nth(0).fill('15');
            await inputs.nth(1).fill('200');
        },
    },
};

const only = process.argv[3] ? process.argv[3].split(',') : Object.keys(shots);
const list = fs.existsSync(listFile) ? JSON.parse(fs.readFileSync(listFile, 'utf8')) : {};
// HOST_RULES lets this PC reach the live site (see the local DNS note); ads and analytics stay blocked
// so screenshots never count as impressions or visits.
const browser = await chromium.launch({ channel: 'chrome', args: process.env.HOST_RULES ? [`--host-resolver-rules=${process.env.HOST_RULES}`] : [] });
const page = await browser.newPage({ viewport: { width: 1350, height: 1000 } });
await page.route(/googlesyndication|doubleclick|googletagmanager|google-analytics|adservice|fundingchoices/, (route) => route.abort());

for (const slug of only) {
    await page.goto(`${base}/${slug}`, { waitUntil: 'networkidle' });
    await page.locator('.tool-panel').first().waitFor();
    await shots[slug].run(page);
    await page.waitForTimeout(2500);
    const panel = page.locator('.tool-panel').first();
    const file = path.join(outDir, `${slug}.jpg`);
    await panel.screenshot({ path: file, type: 'jpeg', quality: 72 });
    const box = await panel.boundingBox();
    list[slug] = { width: Math.round(box.width), height: Math.round(box.height), alt: shots[slug].alt };
    console.log(slug, list[slug].width, list[slug].height, Math.round(fs.statSync(file).size / 1024) + ' KB');
}
await browser.close();

fs.writeFileSync(listFile, JSON.stringify(Object.fromEntries(Object.entries(list).sort()), null, 4) + '\n');
