#!/usr/bin/env node
/**
 * JPG vs WebP vs AVIF file-size benchmark (reproducible).
 *
 * Generates 24 synthetic test images from a fixed seed (8 photo-like, 8 UI screenshots,
 * 8 flat graphics with transparency), encodes each with sharp (libvips: mozjpeg, libwebp,
 * libaom AVIF) and records bytes and SSIM (luma, vs the lossless source) per format.
 *
 * Two passes:
 *   1. Fixed quality: JPEG q80 (mozjpeg), WebP q80, AVIF q50 (sharp defaults otherwise).
 *   2. Matched SSIM: for WebP and AVIF, the lowest quality (1-100) whose SSIM is at least
 *      the SSIM of the JPEG q80 file, found by binary search.
 *
 * Images with transparency are flattened onto white for JPEG (JPEG has no alpha channel);
 * WebP and AVIF keep the alpha. SSIM is always measured on the image composited on white.
 *
 * Usage:
 *   npm i --no-save sharp
 *   node scripts/format-benchmark.mjs [out.csv] [--save-images dir]
 * Default output: docs/benchmarks/format-benchmark-2026-10.csv
 */
import sharp from 'sharp';
import { mkdirSync, writeFileSync } from 'node:fs';
import { dirname, join } from 'node:path';

const args = process.argv.slice(2);
const saveIdx = args.indexOf('--save-images');
const saveDir = saveIdx >= 0 ? args.splice(saveIdx, 2)[1] : null;
const outCsv = args[0] ?? 'docs/benchmarks/format-benchmark-2026-10.csv';

const Q = { jpeg: 80, webp: 80, avif: 50 };
const PER_CATEGORY = 8;
sharp.cache(false);

// ---------- deterministic randomness ----------
function mulberry32(seed) {
    let a = seed >>> 0;
    return () => {
        a = (a + 0x6d2b79f5) >>> 0;
        let t = a;
        t = Math.imul(t ^ (t >>> 15), t | 1);
        t ^= t + Math.imul(t ^ (t >>> 7), t | 61);
        return ((t ^ (t >>> 14)) >>> 0) / 4294967296;
    };
}
const gauss = (rnd) => Math.sqrt(-2 * Math.log(rnd() || 1e-12)) * Math.cos(2 * Math.PI * rnd());

// ---------- photo-like images: fractal value noise + lighting + sensor noise ----------
function valueNoise(rnd, w, h, cell) {
    const gw = Math.ceil(w / cell) + 2, gh = Math.ceil(h / cell) + 2;
    const grid = new Float32Array(gw * gh).map(() => rnd());
    const out = new Float32Array(w * h);
    for (let y = 0; y < h; y++) {
        const gy = y / cell, y0 = Math.floor(gy), fy = gy - y0, sy = fy * fy * (3 - 2 * fy);
        for (let x = 0; x < w; x++) {
            const gx = x / cell, x0 = Math.floor(gx), fx = gx - x0, sx = fx * fx * (3 - 2 * fx);
            const a = grid[y0 * gw + x0], b = grid[y0 * gw + x0 + 1];
            const c = grid[(y0 + 1) * gw + x0], d = grid[(y0 + 1) * gw + x0 + 1];
            out[y * w + x] = (a + (b - a) * sx) * (1 - sy) + (c + (d - c) * sx) * sy;
        }
    }
    return out;
}
function fractal(rnd, w, h, baseCell, octaves, persistence) {
    const sum = new Float32Array(w * h);
    let amp = 1, cell = baseCell, total = 0;
    for (let o = 0; o < octaves && cell >= 1; o++) {
        const n = valueNoise(rnd, w, h, cell);
        for (let i = 0; i < sum.length; i++) sum[i] += n[i] * amp;
        total += amp;
        amp *= persistence;
        cell /= 2;
    }
    for (let i = 0; i < sum.length; i++) sum[i] /= total;
    return sum;
}
async function photo(i) {
    const rnd = mulberry32(1000 + i);
    const w = 1600, h = 1067;
    // Each photo gets a different texture: smooth (sky/studio) through busy (foliage/gravel).
    const persistence = 0.45 + 0.04 * i; // 0.45 .. 0.73
    const noiseSigma = 2 + i * 0.6; // sensor noise, 2 .. 6.2 levels
    const horizon = h * (0.35 + 0.3 * rnd());
    const sky = [120 + 100 * rnd(), 150 + 90 * rnd(), 200 + 55 * rnd()];
    const ground = [60 + 120 * rnd(), 60 + 100 * rnd(), 30 + 80 * rnd()];
    const accent = [255 * rnd(), 255 * rnd(), 255 * rnd()];
    const tex = fractal(rnd, w, h, 256, 8, persistence);
    const tex2 = fractal(rnd, w, h, 128, 7, persistence);
    const blobs = Array.from({ length: 4 + Math.floor(rnd() * 5) }, () => ({
        x: rnd() * w, y: horizon + (rnd() - 0.3) * h * 0.5, r: 60 + rnd() * 220, k: rnd(),
    }));
    const light = { x: rnd() * w, y: -h * 0.2 };
    const buf = Buffer.alloc(w * h * 3);
    for (let y = 0; y < h; y++) {
        for (let x = 0; x < w; x++) {
            const p = y * w + x;
            const edge = horizon + (tex2[p] - 0.5) * 160; // irregular horizon line
            let c;
            if (y < edge) {
                const t = y / edge;
                c = sky.map((v) => v * (0.75 + 0.25 * t) + (tex[p] - 0.5) * 40);
            } else {
                const shade = 0.55 + 0.9 * tex[p];
                c = ground.map((v) => v * shade);
            }
            for (const b of blobs) {
                const d = Math.hypot(x - b.x, y - b.y) / b.r;
                if (d < 1.15) {
                    const m = Math.min(1, Math.max(0, (1.15 - d) / 0.15)); // soft edge
                    const s = 0.6 + 0.8 * tex2[p];
                    c = c.map((v, k) => v * (1 - m) + accent[k] * b.k * s * m + v * 0.3 * m * (1 - b.k));
                }
            }
            const lit = 1.15 - 0.45 * Math.min(1, Math.hypot(x - light.x, y - light.y) / (w * 1.2)); // vignette/light falloff
            for (let k = 0; k < 3; k++) {
                buf[p * 3 + k] = Math.max(0, Math.min(255, Math.round(c[k] * lit + gauss(rnd) * noiseSigma)));
            }
        }
    }
    // Slight softening of the whole frame (noise included), like a camera's demosaic/lens.
    return sharp(buf, { raw: { width: w, height: h, channels: 3 } }).blur(0.6).png().toBuffer();
}

// ---------- UI screenshots: SVG layouts with real text ----------
const WORDS = 'account settings profile billing invoice report dashboard project team members export import search filter status active pending archived revenue orders customers analytics overview notifications security password storage upload download share preview edit delete save cancel today yesterday weekly monthly total average growth'.split(' ');
const esc = (s) => s.replace(/&/g, '&amp;').replace(/</g, '&lt;');
async function screenshot(i) {
    const rnd = mulberry32(2000 + i);
    const w = 1440, h = 900;
    const pick = () => WORDS[Math.floor(rnd() * WORDS.length)];
    const phrase = (n) => Array.from({ length: n }, pick).join(' ');
    const dark = i % 4 === 3;
    const bg = dark ? '#1e1f24' : '#f5f6f8', panel = dark ? '#2a2c33' : '#ffffff';
    const fg = dark ? '#e6e6e6' : '#1f2328', muted = dark ? '#9aa0a6' : '#6b7280';
    const brand = ['#2563eb', '#16a34a', '#db2777', '#ea580c', '#7c3aed', '#0891b2', '#dc2626', '#4f46e5'][i];
    const font = 'font-family="Segoe UI, Arial, Helvetica, sans-serif"';
    let s = `<svg xmlns="http://www.w3.org/2000/svg" width="${w}" height="${h}"><rect width="100%" height="100%" fill="${bg}"/>`;
    // top bar + sidebar
    s += `<rect width="${w}" height="56" fill="${panel}"/><rect y="56" width="${w}" height="1" fill="${muted}" opacity=".3"/>`;
    s += `<text x="24" y="36" ${font} font-size="20" font-weight="700" fill="${brand}">${esc(phrase(1))}</text>`;
    s += `<rect x="${w - 340}" y="12" width="260" height="32" rx="6" fill="${bg}" stroke="${muted}" stroke-opacity=".4"/><text x="${w - 326}" y="33" ${font} font-size="14" fill="${muted}">Search ${esc(pick())}...</text>`;
    s += `<circle cx="${w - 40}" cy="28" r="16" fill="${brand}"/>`;
    s += `<rect y="57" width="230" height="${h - 57}" fill="${panel}"/>`;
    for (let k = 0; k < 12; k++) {
        const y = 90 + k * 40;
        if (k === 2) s += `<rect x="12" y="${y - 22}" width="206" height="34" rx="6" fill="${brand}" opacity=".12"/>`;
        s += `<rect x="28" y="${y - 12}" width="14" height="14" rx="3" fill="${k === 2 ? brand : muted}"/>`;
        s += `<text x="52" y="${y}" ${font} font-size="15" fill="${k === 2 ? brand : fg}">${esc(phrase(1 + (k % 2)))}</text>`;
    }
    // heading + stat cards
    s += `<text x="262" y="104" ${font} font-size="26" font-weight="600" fill="${fg}">${esc(phrase(2))}</text>`;
    for (let k = 0; k < 4; k++) {
        const x = 262 + k * 290;
        s += `<rect x="${x}" y="128" width="270" height="110" rx="10" fill="${panel}" stroke="${muted}" stroke-opacity=".25"/>`;
        s += `<text x="${x + 18}" y="160" ${font} font-size="14" fill="${muted}">${esc(phrase(2))}</text>`;
        s += `<text x="${x + 18}" y="200" ${font} font-size="30" font-weight="700" fill="${fg}">${(rnd() * 99999).toFixed(0)}</text>`;
        s += `<text x="${x + 18}" y="224" ${font} font-size="13" fill="${rnd() > 0.4 ? '#16a34a' : '#dc2626'}">${(rnd() * 30).toFixed(1)}% ${esc(pick())}</text>`;
    }
    // chart panel with a line chart
    s += `<rect x="262" y="262" width="720" height="300" rx="10" fill="${panel}" stroke="${muted}" stroke-opacity=".25"/>`;
    s += `<text x="282" y="294" ${font} font-size="16" font-weight="600" fill="${fg}">${esc(phrase(2))}</text>`;
    for (let g = 0; g < 5; g++) s += `<line x1="282" x2="962" y1="${330 + g * 50}" y2="${330 + g * 50}" stroke="${muted}" stroke-opacity=".2"/>`;
    let pts = '';
    for (let k = 0; k <= 20; k++) pts += `${282 + k * 34},${520 - rnd() * 170} `;
    s += `<polyline points="${pts}" fill="none" stroke="${brand}" stroke-width="3"/>`;
    // side list
    s += `<rect x="1002" y="262" width="410" height="300" rx="10" fill="${panel}" stroke="${muted}" stroke-opacity=".25"/>`;
    for (let k = 0; k < 6; k++) {
        const y = 300 + k * 44;
        s += `<circle cx="1030" cy="${y - 5}" r="13" fill="${brand}" opacity="${0.3 + 0.1 * k}"/>`;
        s += `<text x="1054" y="${y - 6}" ${font} font-size="14" fill="${fg}">${esc(phrase(3))}</text>`;
        s += `<text x="1054" y="${y + 12}" ${font} font-size="12" fill="${muted}">${esc(phrase(4))}</text>`;
    }
    // table
    s += `<rect x="262" y="586" width="1150" height="290" rx="10" fill="${panel}" stroke="${muted}" stroke-opacity=".25"/>`;
    const cols = [282, 520, 760, 960, 1160, 1300];
    cols.forEach((x) => (s += `<text x="${x}" y="618" ${font} font-size="13" font-weight="600" fill="${muted}">${esc(pick().toUpperCase())}</text>`));
    for (let r = 0; r < 6; r++) {
        const y = 656 + r * 38;
        s += `<line x1="262" x2="1412" y1="${y - 24}" y2="${y - 24}" stroke="${muted}" stroke-opacity=".2"/>`;
        s += `<text x="282" y="${y}" ${font} font-size="14" fill="${fg}">${esc(phrase(2))}</text>`;
        s += `<text x="520" y="${y}" ${font} font-size="14" fill="${fg}">${esc(phrase(2))}</text>`;
        s += `<text x="760" y="${y}" ${font} font-size="14" fill="${fg}">${Math.floor(rnd() * 28) + 1} Oct 2026</text>`;
        s += `<text x="960" y="${y}" ${font} font-size="14" fill="${fg}">$${(rnd() * 5000).toFixed(2)}</text>`;
        s += `<rect x="1160" y="${y - 16}" width="84" height="22" rx="11" fill="${brand}" opacity=".15"/><text x="1172" y="${y}" ${font} font-size="12" fill="${brand}">${esc(pick())}</text>`;
        s += `<rect x="1300" y="${y - 18}" width="90" height="26" rx="6" fill="${brand}"/><text x="1316" y="${y}" ${font} font-size="13" fill="#fff">${esc(pick())}</text>`;
    }
    s += '</svg>';
    return sharp(Buffer.from(s)).flatten({ background: bg }).png().toBuffer();
}

// ---------- flat graphics with transparency: icons, badges, logos ----------
async function graphic(i) {
    const rnd = mulberry32(3000 + i);
    const w = 800, h = 800;
    const palette = Array.from({ length: 4 }, () => `hsl(${Math.floor(rnd() * 360)},${60 + Math.floor(rnd() * 30)}%,${40 + Math.floor(rnd() * 25)}%)`);
    let s = `<svg xmlns="http://www.w3.org/2000/svg" width="${w}" height="${h}"><defs>`;
    s += `<linearGradient id="g" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="${palette[0]}"/><stop offset="1" stop-color="${palette[1]}"/></linearGradient></defs>`;
    const kind = i % 4;
    if (kind === 0) {
        // round badge with star and ring
        s += `<circle cx="400" cy="400" r="330" fill="url(#g)"/><circle cx="400" cy="400" r="290" fill="none" stroke="#fff" stroke-width="14" stroke-dasharray="24 14"/>`;
        let star = '';
        for (let k = 0; k < 10; k++) {
            const r = k % 2 ? 90 : 200, a = (Math.PI / 5) * k - Math.PI / 2;
            star += `${400 + r * Math.cos(a)},${400 + r * Math.sin(a)} `;
        }
        s += `<polygon points="${star}" fill="#fff"/>`;
    } else if (kind === 1) {
        // app icon: rounded square, shadow-like translucent layer, glyph
        s += `<rect x="90" y="110" width="620" height="620" rx="140" fill="#000" opacity=".18"/>`;
        s += `<rect x="80" y="80" width="620" height="620" rx="140" fill="url(#g)"/>`;
        s += `<path d="M250 520 L390 260 L530 520 Z" fill="none" stroke="#fff" stroke-width="40" stroke-linejoin="round"/><circle cx="390" cy="450" r="34" fill="${palette[2]}"/>`;
    } else if (kind === 2) {
        // logo: overlapping translucent circles + wordmark
        for (let k = 0; k < 3; k++) s += `<circle cx="${280 + k * 120}" cy="330" r="160" fill="${palette[k]}" opacity=".8"/>`;
        s += `<text x="400" y="640" text-anchor="middle" font-family="Segoe UI, Arial, Helvetica, sans-serif" font-size="96" font-weight="800" fill="${palette[3]}">${WORDS[Math.floor(rnd() * WORDS.length)].toUpperCase()}</text>`;
    } else {
        // sticker / illustration: scattered shapes with outlines
        for (let k = 0; k < 14; k++) {
            const x = 120 + rnd() * 560, y = 120 + rnd() * 560, r = 30 + rnd() * 90;
            s += rnd() > 0.5
                ? `<circle cx="${x}" cy="${y}" r="${r}" fill="${palette[k % 4]}" stroke="#222" stroke-width="6"/>`
                : `<rect x="${x - r}" y="${y - r}" width="${r * 2}" height="${r * 1.4}" rx="${r / 4}" fill="${palette[k % 4]}" stroke="#222" stroke-width="6" transform="rotate(${Math.floor(rnd() * 90)} ${x} ${y})"/>`;
        }
    }
    s += '</svg>';
    return sharp(Buffer.from(s)).ensureAlpha().png().toBuffer();
}

// ---------- SSIM on luma (8x8 windows, stride 4) ----------
async function luma(input) {
    const { data, info } = await sharp(input).flatten({ background: '#ffffff' }).removeAlpha().raw().toBuffer({ resolveWithObject: true });
    const y = new Float64Array(info.width * info.height);
    for (let p = 0, q = 0; p < y.length; p++, q += info.channels) y[p] = 0.299 * data[q] + 0.587 * data[q + 1] + 0.114 * data[q + 2];
    return { y, w: info.width, h: info.height };
}
function ssim(a, b) {
    const { w, h } = a, N = 8, step = 4, C1 = (0.01 * 255) ** 2, C2 = (0.03 * 255) ** 2;
    let total = 0, count = 0;
    for (let y0 = 0; y0 + N <= h; y0 += step) {
        for (let x0 = 0; x0 + N <= w; x0 += step) {
            let sa = 0, sb = 0, saa = 0, sbb = 0, sab = 0;
            for (let y = y0; y < y0 + N; y++) {
                for (let x = x0, p = y * w + x0; x < x0 + N; x++, p++) {
                    const u = a.y[p], v = b.y[p];
                    sa += u; sb += v; saa += u * u; sbb += v * v; sab += u * v;
                }
            }
            const n = N * N, ma = sa / n, mb = sb / n;
            const va = saa / n - ma * ma, vb = sbb / n - mb * mb, cov = sab / n - ma * mb;
            total += ((2 * ma * mb + C1) * (2 * cov + C2)) / ((ma * ma + mb * mb + C1) * (va + vb + C2));
            count++;
        }
    }
    return total / count;
}

// ---------- encoders ----------
const encode = {
    jpeg: (src, q) => sharp(src).flatten({ background: '#ffffff' }).jpeg({ quality: q, mozjpeg: true }).toBuffer(),
    webp: (src, q) => sharp(src).webp({ quality: q }).toBuffer(),
    avif: (src, q) => sharp(src).avif({ quality: q }).toBuffer(),
};
async function measure(fmt, src, ref, q) {
    const out = await encode[fmt](src, q);
    return { q, bytes: out.length, ssim: ssim(ref, await luma(out)), out };
}
/** Lowest quality whose SSIM >= target (SSIM rises with quality; binary search, 7 encodes). */
async function matchSsim(fmt, src, ref, target) {
    let lo = 1, hi = 100, best = null;
    while (lo <= hi) {
        const mid = (lo + hi) >> 1;
        const m = await measure(fmt, src, ref, mid);
        if (m.ssim >= target) { best = m; hi = mid - 1; } else lo = mid + 1;
    }
    return best ?? (await measure(fmt, src, ref, 100));
}

// ---------- run ----------
const kinds = { photo, screenshot, graphic };
const rows = [];
if (saveDir) mkdirSync(saveDir, { recursive: true });
for (const [category, make] of Object.entries(kinds)) {
    for (let i = 0; i < PER_CATEGORY; i++) {
        const name = `${category}-${String(i + 1).padStart(2, '0')}`;
        const src = await make(i);
        const meta = await sharp(src).metadata();
        const ref = await luma(src);
        const jpg = await measure('jpeg', src, ref, Q.jpeg);
        const webp = await measure('webp', src, ref, Q.webp);
        const avif = await measure('avif', src, ref, Q.avif);
        const webpM = await matchSsim('webp', src, ref, jpg.ssim);
        const avifM = await matchSsim('avif', src, ref, jpg.ssim);
        if (saveDir) {
            writeFileSync(join(saveDir, `${name}.png`), src);
            writeFileSync(join(saveDir, `${name}.jpg`), jpg.out);
            writeFileSync(join(saveDir, `${name}.webp`), webp.out);
            writeFileSync(join(saveDir, `${name}.avif`), avif.out);
        }
        const row = {
            image: name, category, width: meta.width, height: meta.height, has_alpha: meta.hasAlpha ? 1 : 0,
            png_bytes: src.length,
            jpg_q80_bytes: jpg.bytes, jpg_q80_ssim: jpg.ssim,
            webp_q80_bytes: webp.bytes, webp_q80_ssim: webp.ssim,
            avif_q50_bytes: avif.bytes, avif_q50_ssim: avif.ssim,
            webp_matched_q: webpM.q, webp_matched_bytes: webpM.bytes, webp_matched_ssim: webpM.ssim,
            avif_matched_q: avifM.q, avif_matched_bytes: avifM.bytes, avif_matched_ssim: avifM.ssim,
        };
        rows.push(row);
        console.log(`${name}: jpg ${jpg.bytes} | webp ${webp.bytes} | avif ${avif.bytes} | matched webp q${webpM.q} ${webpM.bytes} avif q${avifM.q} ${avifM.bytes}`);
    }
}

const fmt = (v) => (typeof v === 'number' && !Number.isInteger(v) ? v.toFixed(4) : v);
const header = Object.keys(rows[0]);
mkdirSync(dirname(outCsv), { recursive: true });
writeFileSync(outCsv, [header.join(','), ...rows.map((r) => header.map((k) => fmt(r[k])).join(','))].join('\n') + '\n');

// ---------- summary: savings vs JPEG q80 (positive = smaller than JPEG) ----------
const median = (xs) => { const s = [...xs].sort((a, b) => a - b), m = s.length >> 1; return s.length % 2 ? s[m] : (s[m - 1] + s[m]) / 2; };
const mean = (xs) => xs.reduce((a, b) => a + b, 0) / xs.length;
const pct = (x) => `${(x * 100).toFixed(1)}%`;
const saving = (r, col) => 1 - r[col] / r.jpg_q80_bytes;
console.log('\nSavings vs JPEG q80 (median / mean); median bytes per format');
for (const cat of [...Object.keys(kinds), 'all']) {
    const rs = cat === 'all' ? rows : rows.filter((r) => r.category === cat);
    const line = ['webp_q80_bytes', 'avif_q50_bytes', 'webp_matched_bytes', 'avif_matched_bytes']
        .map((c) => `${c.replace('_bytes', '')} ${pct(median(rs.map((r) => saving(r, c))))} / ${pct(mean(rs.map((r) => saving(r, c))))}`)
        .join(' | ');
    const kb = (c) => `${(median(rs.map((r) => r[c])) / 1024).toFixed(1)} KB`;
    console.log(`${cat}: ${line}`);
    console.log(`   median size: png ${kb('png_bytes')}, jpg ${kb('jpg_q80_bytes')}, webp ${kb('webp_q80_bytes')}, avif ${kb('avif_q50_bytes')}; median SSIM jpg ${median(rs.map((r) => r.jpg_q80_ssim)).toFixed(4)} webp ${median(rs.map((r) => r.webp_q80_ssim)).toFixed(4)} avif ${median(rs.map((r) => r.avif_q50_ssim)).toFixed(4)}; matched q median webp ${median(rs.map((r) => r.webp_matched_q))} avif ${median(rs.map((r) => r.avif_matched_q))}`);
}
console.log(`\nsharp ${sharp.versions.sharp}, libvips ${sharp.versions.vips}, mozjpeg ${sharp.versions.mozjpeg}, libwebp ${sharp.versions.webp}, libaom ${sharp.versions.aom}, libheif ${sharp.versions.heif}`);
console.log(`Wrote ${outCsv}`);
