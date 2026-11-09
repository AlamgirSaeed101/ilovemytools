// Renders a LinkedIn post image that Claude designed (an HTML or SVG file) into a PNG.
//   node scripts/linkedin-image.mjs <design.html|design.svg> <out.png> [--size 1200x1200]
// Used by the daily LinkedIn routine: the design shows the tool being promoted, the PNG is
// committed under public/images/linkedin/ and posted from its raw GitHub URL.
import fs from 'node:fs';
import path from 'node:path';
import { chromium } from '@playwright/test';

const [input, output] = process.argv.slice(2).filter((a) => !a.startsWith('--'));
const sizeArg = process.argv.find((a) => /^\d+x\d+$/.test(a)) || '1200x1200';
const [width, height] = sizeArg.split('x').map(Number);
if (!input || !output) {
    console.error('usage: node scripts/linkedin-image.mjs <design.html|design.svg> <out.png> [1200x1200]');
    process.exit(1);
}

const source = fs.readFileSync(input, 'utf8');
const page = source.trimStart().startsWith('<svg')
    ? `<!doctype html><html><head><meta charset="utf-8"><style>*{margin:0}body{width:${width}px;height:${height}px;overflow:hidden}svg{display:block;width:${width}px;height:${height}px}</style></head><body>${source}</body></html>`
    : source;

const browser = await chromium.launch();
try {
    const tab = await browser.newPage({ viewport: { width, height } });
    await tab.setContent(page, { waitUntil: 'networkidle' });
    fs.mkdirSync(path.dirname(output), { recursive: true });
    await tab.screenshot({ path: output, clip: { x: 0, y: 0, width, height } });
    console.log(`${output} ${width}x${height} ${fs.statSync(output).size} bytes`);
} finally {
    await browser.close();
}
