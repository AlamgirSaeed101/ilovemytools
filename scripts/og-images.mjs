// Draws a 1200x630 share image for every tool into public/images/og/{slug}.jpg,
// used for og:image / twitter:image and in the tool's schema.
// Run after adding a tool:  node scripts/og-images.mjs   (add --force to redraw existing images)
import { execFileSync } from 'node:child_process';
import fs from 'node:fs';
import path from 'node:path';
import { chromium } from '@playwright/test';

const root = path.resolve(import.meta.dirname, '..');
const outDir = path.join(root, 'public/images/og');
const force = process.argv.includes('--force');
const { site, tools } = JSON.parse(execFileSync('php', [path.join(root, 'scripts/og-data.php')], { cwd: root, encoding: 'utf8' }));
const logo = fs.readFileSync(path.join(root, 'public/images/logo-white.svg'), 'utf8');

const esc = (s) => s.replace(/[&<>"]/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' })[c]);

const html = (tool) => `<!doctype html><html><head><meta charset="utf-8"><style>
* { box-sizing: border-box; margin: 0; }
body { width: 1200px; height: 630px; font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif; color: #fff;
  background: radial-gradient(circle at 85% 15%, ${tool.accent2}55, transparent 45%), linear-gradient(135deg, #0f172a 0%, #1e293b 60%, ${tool.accent}66 100%);
  display: flex; flex-direction: column; justify-content: space-between; padding: 64px 72px; }
.top { display: flex; align-items: center; justify-content: space-between; }
.logo svg { height: 46px; width: auto; }
.pill { font-size: 24px; font-weight: 600; padding: 10px 22px; border-radius: 999px; background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.2); }
.main { display: flex; align-items: center; gap: 44px; }
.icon { flex: none; width: 168px; height: 168px; border-radius: 40px; display: grid; place-items: center;
  background: linear-gradient(135deg, ${tool.accent}, ${tool.accent2}); box-shadow: 0 20px 50px ${tool.accent}66; }
.icon svg { width: 96px; height: 96px; stroke: #fff; stroke-width: 1.8; fill: none; }
h1 { font-size: ${tool.name.length > 26 ? 64 : 76}px; line-height: 1.05; font-weight: 800; letter-spacing: -1.5px; }
p { margin-top: 18px; font-size: 30px; line-height: 1.3; color: #cbd5e1; max-width: 820px; }
.bottom { display: flex; gap: 14px; font-size: 24px; font-weight: 600; color: #e2e8f0; }
.bottom span { padding: 8px 18px; border-radius: 12px; background: rgba(255,255,255,.08); }
</style></head><body>
<div class="top"><div class="logo">${logo}</div><div class="pill">${esc(tool.category)}</div></div>
<div class="main"><div class="icon">${tool.icon}</div><div><h1>${esc(tool.name)}</h1><p>${esc(tool.tagline)}</p></div></div>
<div class="bottom"><span>100% free</span><span>No sign up</span><span>${tool.server ? 'Nothing stored' : 'Files stay on your device'}</span></div>
</body></html>`;

fs.mkdirSync(outDir, { recursive: true });
const browser = await chromium.launch();
const page = await browser.newPage({ viewport: { width: 1200, height: 630 } });
let made = 0;
for (const tool of tools) {
    const file = path.join(outDir, `${tool.slug}.jpg`);
    if (!force && fs.existsSync(file)) continue;
    await page.setContent(html(tool), { waitUntil: 'load' });
    await page.screenshot({ path: file, type: 'jpeg', quality: 84 });
    made++;
}
await browser.close();
console.log(`${site}: ${made} share image(s) written to public/images/og/ (${tools.length} tools)`);
