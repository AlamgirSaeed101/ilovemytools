// Measures how tall each tool's panel is once the tool has rendered, on a phone and a desktop
// screen, and writes resources/data/tool-panels.json. The page reserves that height before the
// tool's JavaScript loads, so the content below doesn't jump (CLS). Re-run after changing a
// tool's layout.
// Usage: npm run build && php artisan serve --port=8123, then node scripts/measure-panels.mjs [base-url]
import fs from 'node:fs';
import path from 'node:path';
import { chromium } from '@playwright/test';

const root = path.resolve(import.meta.dirname, '..');
const base = (process.argv[2] || 'http://127.0.0.1:8123').replace(/\/$/, '');
const out = path.join(root, 'resources/data/tool-panels.json');

// Same widths as Lighthouse's mobile preset and a common desktop window.
const screens = { sm: { width: 412, height: 823 }, lg: { width: 1350, height: 940 } };

const sitemap = await (await fetch(`${base}/sitemap.xml`)).text();
const slugs = [
    ...new Set(
        [...sitemap.matchAll(/<loc>([^<]+)<\/loc>/g)]
            .map((m) => new URL(m[1]).pathname.replace(/^\//, ''))
            .filter((p) => p && !p.includes('/') && !/^[a-z]{2}$/.test(p) && !['about', 'contact', 'privacy-policy', 'terms', 'guides'].includes(p)),
    ),
].sort();

const browser = await chromium.launch();
const result = {};
for (const [size, viewport] of Object.entries(screens)) {
    const page = await browser.newPage({ viewport });
    for (const slug of slugs) {
        await page.goto(`${base}/${slug}`, { waitUntil: 'networkidle' });
        // Wait until React has replaced the server panel and the lazy tool has rendered.
        await page.waitForFunction(() => {
            const panel = document.querySelector('#app .tool-panel');
            return panel && !panel.querySelector('.privacy-note') && !panel.querySelector('.tool-loading');
        });
        await page.waitForTimeout(300);
        const height = await page.$eval('#app .tool-panel', (el) => Math.round(el.getBoundingClientRect().height));
        result[slug] = { ...(result[slug] ?? {}), [size]: height };
    }
    await page.close();
}
await browser.close();

fs.mkdirSync(path.dirname(out), { recursive: true });
fs.writeFileSync(out, JSON.stringify(result, null, 4) + '\n');
console.log(`Measured ${slugs.length} tools -> ${path.relative(root, out)}`);
