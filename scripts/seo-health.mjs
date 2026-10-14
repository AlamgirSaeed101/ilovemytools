// Crawls the live site from its sitemap and reports everything that can hurt rankings:
// broken or redirecting pages, wrong canonicals, hreflang to missing pages, broken JSON-LD,
// title/description/H1 problems, broken internal links and dead outbound links.
// Used by the daily site-health routine (docs/ROUTINE.md rule 15).
//
//   node scripts/seo-health.mjs                 report to stdout, full JSON in storage/seo-health.json
//   node scripts/seo-health.mjs --pin 1.2.3.4   connect to the site through this IP (bypasses a broken local DNS)
//
// Outbound links that fail on several daily runs in a row are tracked in docs/health-state.json,
// so a one-off timeout never gets a link removed.
import fs from 'node:fs';
import http from 'node:http';
import https from 'node:https';
import path from 'node:path';

const root = path.resolve(import.meta.dirname, '..');
const SITE = 'https://ilovemytools.store';
const HOST = new URL(SITE).hostname;
const UA = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0 Safari/537.36 ilovemytools-health-check';
const argPin = process.argv.indexOf('--pin');
const PIN = argPin > -1 ? process.argv[argPin + 1] : null;
const CONCURRENCY = 3;

function request(url, { method = 'GET', timeout = 25000 } = {}) {
    return new Promise((resolve) => {
        let u;
        try {
            u = new URL(url);
        } catch {
            return resolve({ status: 0, error: 'bad url', headers: {}, body: '' });
        }
        const lib = u.protocol === 'http:' ? http : https;
        const opts = { method, headers: { 'User-Agent': UA, Accept: 'text/html,application/xml;q=0.9,*/*;q=0.8' }, timeout };
        if (PIN && u.hostname === HOST) opts.lookup = (_h, o, cb) => (o && o.all ? cb(null, [{ address: PIN, family: 4 }]) : cb(null, PIN, 4));
        const req = lib.request(u, opts, (res) => {
            const chunks = [];
            res.on('data', (c) => method === 'GET' && chunks.push(c));
            res.on('end', () => resolve({ status: res.statusCode, headers: res.headers, body: Buffer.concat(chunks).toString('utf8') }));
        });
        req.on('timeout', () => req.destroy(new Error('timeout')));
        req.on('error', (e) => resolve({ status: 0, error: e.message, headers: {}, body: '' }));
        req.end();
    });
}

async function pool(items, fn) {
    const out = [];
    let i = 0;
    await Promise.all(
        Array.from({ length: CONCURRENCY }, async () => {
            while (i < items.length) {
                const n = i++;
                out[n] = await fn(items[n]);
            }
        }),
    );
    return out;
}

const decode = (s) => s.replace(/&amp;/g, '&').replace(/&quot;/g, '"').replace(/&#0?39;/g, "'").replace(/&lt;/g, '<').replace(/&gt;/g, '>');
const attr = (tag, name) => (tag.match(new RegExp(`${name}="([^"]*)"`, 'i')) || [])[1];
const isCjk = (url) => /\/(zh|ko)(\/|$)/.test(url);

// schema.org properties whose value must be an object of a given type, not a bare string.
const OBJECT_PROPS = { primaryImageOfPage: 'ImageObject', offers: 'Offer', publisher: null, author: null, isPartOf: null };

function checkPage(url, html, issues) {
    const add = (type, detail) => issues.push({ type, url, detail });
    const head = html.slice(0, html.indexOf('</head>') + 7 || undefined);

    const title = decode((head.match(/<title>([^<]*)<\/title>/i) || [])[1] || '');
    if (!title) add('title-missing');
    else if ([...title].length > 60) add('title-too-long', `${[...title].length} chars: ${title}`);

    const desc = decode(attr((head.match(/<meta name="description"[^>]*>/i) || [''])[0], 'content') || '');
    const dlen = [...desc].length;
    if (!desc) add('description-missing');
    else if (dlen > 160) add('description-too-long', `${dlen} chars`);
    else if (dlen < (isCjk(url) ? 50 : 110)) add('description-too-short', `${dlen} chars`);

    const robots = attr((head.match(/<meta name="robots"[^>]*>/i) || [''])[0], 'content') || '';
    if (/noindex/i.test(robots)) add('noindex', robots);

    const canonical = attr((head.match(/<link rel="canonical"[^>]*>/i) || [''])[0], 'href');
    if (!canonical) add('canonical-missing');
    else if (canonical !== url) add('canonical-mismatch', canonical);

    const h1s = html.match(/<h1[\s>]/gi) || [];
    if (h1s.length !== 1) add('h1-count', `${h1s.length} H1 tags`);

    const hreflangs = [...head.matchAll(/<link rel="alternate" hreflang="([^"]+)" href="([^"]+)"/gi)].map((m) => ({ lang: m[1], href: decode(m[2]) }));
    if (hreflangs.length && !hreflangs.some((h) => h.href === url)) add('hreflang-no-self', 'page is missing from its own hreflang set');

    for (const m of html.matchAll(/<script type="application\/ld\+json">([\s\S]*?)<\/script>/gi)) {
        let data;
        try {
            data = JSON.parse(m[1]);
        } catch (e) {
            add('jsonld-invalid-json', e.message);
            continue;
        }
        const walk = (node) => {
            if (Array.isArray(node)) return node.forEach(walk);
            if (!node || typeof node !== 'object') return;
            for (const [prop, type] of Object.entries(OBJECT_PROPS)) {
                if (typeof node[prop] === 'string' && type) add('jsonld-wrong-type', `${node['@type']}.${prop} is a string, schema.org expects ${type}`);
            }
            if (node['@type'] === 'FAQPage' && !(node.mainEntity || []).length) add('jsonld-empty', 'FAQPage without questions');
            Object.values(node).forEach(walk);
        };
        walk(data);
    }

    const imgs = html.match(/<img\b[^>]*>/gi) || [];
    const noAlt = imgs.filter((t) => !/\salt=/i.test(t)).length;
    if (noAlt) add('img-no-alt', `${noAlt} image(s) without alt`);

    return { hreflangs, links: [...html.matchAll(/<a\b[^>]*href="([^"#]+)"/gi)].map((m) => decode(m[1])) };
}

const started = Date.now();
const sm = await request(`${SITE}/sitemap.xml`);
if (sm.status !== 200) {
    console.log(`FATAL sitemap.xml returned ${sm.status} ${sm.error || ''}`);
    process.exit(1);
}
const pages = [...new Set([...sm.body.matchAll(/<loc>([^<]+)<\/loc>/g)].map((m) => decode(m[1])))];
const inSitemap = new Set(pages);
const issues = [];
const internal = new Set();
const external = new Map(); // url -> first page that links to it
const slow = [];

const recheck = [];
await pool(pages, async (url) => {
    const t = Date.now();
    let res = await request(url);
    const ms = Date.now() - t;
    if (res.status >= 500 || res.status === 0) {
        // A deploy clears the app caches for a moment; try again later before calling it broken.
        recheck.push(url);
        return;
    }
    if (res.status !== 200) {
        issues.push({ type: res.status >= 300 && res.status < 400 ? 'sitemap-redirect' : 'sitemap-not-200', url, detail: `${res.status} ${res.headers.location || res.error || ''}`.trim() });
        return;
    }
    if (ms > 3000) slow.push({ url, ms });
    const { hreflangs, links } = checkPage(url, res.body, issues);
    for (const h of hreflangs) if (!inSitemap.has(h.href)) issues.push({ type: 'hreflang-not-in-sitemap', url, detail: `${h.lang} -> ${h.href}` });
    for (const l of links) {
        const abs = l.startsWith('/') ? SITE + l : l;
        if (!/^https?:\/\//.test(abs)) continue;
        const host = new URL(abs).hostname.replace(/^www\./, '');
        if (host === HOST) {
            if (!inSitemap.has(abs.split('?')[0])) internal.add(abs);
        } else if (!external.has(abs)) external.set(abs, url);
    }
});

if (recheck.length) {
    await new Promise((r) => setTimeout(r, 90000));
    await pool(recheck, async (url) => {
        const res = await request(url);
        if (res.status !== 200) issues.push({ type: 'sitemap-not-200', url, detail: `${res.status} ${res.error || ''} (twice, 90s apart)`.trim() });
        else issues.push({ type: 'server-error-transient', url, detail: 'returned 5xx, then 200 after 90s' });
    });
}

// Internal links that are not sitemap pages (files, legal pages, guides...) must still answer 200.
const skipInternal = /\/(sitemap\.xml|llms\.txt|robots\.txt)$|\/api\//;
await pool([...internal].filter((u) => !skipInternal.test(u)), async (u) => {
    const r = await request(u, { method: 'HEAD' });
    if (r.status >= 400 || r.status === 0) issues.push({ type: 'internal-link-broken', url: u, detail: `${r.status} ${r.error || ''}`.trim() });
    else if (r.status >= 300) issues.push({ type: 'internal-link-redirect', url: u, detail: `${r.status} -> ${r.headers.location}` });
});

// Outbound links: 404/410/DNS failures count as dead; 401/403/429 usually mean bot blocking, so they are only noted.
const statePath = path.join(root, 'docs/health-state.json');
let state = {};
try {
    state = JSON.parse(fs.readFileSync(statePath, 'utf8'));
} catch {}
const today = new Date().toISOString().slice(0, 10);
const deadNow = {};
// Some sites answer HEAD with 404/405, so anything that is not a plain 2xx is confirmed with a GET
// that follows redirects before it counts.
async function getFollow(u, hops = 5) {
    let r = await request(u, { timeout: 20000 });
    while (hops-- > 0 && r.status >= 300 && r.status < 400 && r.headers.location) {
        u = new URL(r.headers.location, u).href;
        r = await request(u, { timeout: 20000 });
    }
    return r;
}
await pool([...external.keys()], async (u) => {
    let r = await request(u, { method: 'HEAD', timeout: 15000 });
    if (r.status < 200 || r.status >= 300) r = await getFollow(u);
    const dead = r.status === 404 || r.status === 410 || (r.status === 0 && /ENOTFOUND|ECONNREFUSED|certificate/i.test(r.error || '')) || r.status >= 500;
    if (dead) deadNow[u] = `${r.status} ${r.error || ''}`.trim();
});
const outbound = {};
for (const [u, why] of Object.entries(deadNow)) {
    const prev = state.outbound?.[u];
    const days = prev && prev.last !== today ? prev.days + 1 : prev?.days || 1;
    outbound[u] = { days, last: today, why, linkedFrom: external.get(u) };
    issues.push({ type: days >= 3 ? 'outbound-dead-remove' : 'outbound-failing', url: u, detail: `${why}; failing ${days} day(s); linked from ${external.get(u)}` });
}
fs.writeFileSync(statePath, JSON.stringify({ updated: today, outbound }, null, 2) + '\n');

const byType = {};
for (const i of issues) (byType[i.type] ??= []).push(i);
const summary = {
    checked: { pages: pages.length, internalLinks: internal.size, externalLinks: external.size },
    seconds: Math.round((Date.now() - started) / 1000),
    slowPages: slow.sort((a, b) => b.ms - a.ms).slice(0, 10),
    counts: Object.fromEntries(Object.entries(byType).map(([k, v]) => [k, v.length])),
};
fs.mkdirSync(path.join(root, 'storage'), { recursive: true });
fs.writeFileSync(path.join(root, 'storage/seo-health.json'), JSON.stringify({ summary, issues }, null, 2));

console.log(`Checked ${pages.length} pages, ${internal.size} other internal links, ${external.size} outbound links in ${summary.seconds}s`);
if (!issues.length) console.log('No issues found.');
for (const [type, list] of Object.entries(byType)) {
    console.log(`\n${type} (${list.length})`);
    for (const i of list.slice(0, 8)) console.log(`  ${i.url}${i.detail ? ' - ' + i.detail : ''}`);
    if (list.length > 8) console.log(`  ... ${list.length - 8} more in storage/seo-health.json`);
}
if (slow.length) console.log(`\nslow pages over 3s (${slow.length}): ${slow.slice(0, 5).map((s) => `${s.url} ${s.ms}ms`).join(', ')}`);
