// Mobile Lighthouse scores for the live site's key pages, written to docs/perf-scores.md.
// Runs in GitHub Actions after each deploy (.github/workflows/perf.yml): a cloud machine measures
// close to Google's PageSpeed, unlike a slow local PC where Lighthouse's 4x CPU slowdown overshoots.
// Each page runs 3 times and the median score is kept, since single runs vary by several points.
import { execFileSync } from 'node:child_process';
import { readFileSync, writeFileSync } from 'node:fs';

const base = 'https://ilovemytools.store';
const pages = ['/', '/edit-pdf', '/word-counter', '/merge-pdf', '/image-compressor', '/qr-code-generator', '/category/pdf-tools', '/guides', '/about', '/es/edit-pdf', '/de/word-counter'];
const RUNS = 3;

const median = (values) => [...values].sort((a, b) => a - b)[Math.floor(values.length / 2)];

function run(url) {
    execFileSync('lighthouse', [url, '--only-categories=performance,accessibility,best-practices,seo', '--form-factor=mobile', '--quiet', '--output=json', '--output-path=/tmp/lh.json', '--chrome-flags=--headless=new --no-sandbox'], { stdio: 'ignore', timeout: 180000 });
    const report = JSON.parse(readFileSync('/tmp/lh.json', 'utf8'));
    const score = (k) => Math.round((report.categories[k]?.score ?? 0) * 100);
    const audit = (k) => report.audits[k]?.numericValue ?? 0;
    return {
        perf: score('performance'),
        a11y: score('accessibility'),
        bp: score('best-practices'),
        seo: score('seo'),
        fcp: audit('first-contentful-paint'),
        lcp: audit('largest-contentful-paint'),
        tbt: audit('total-blocking-time'),
        cls: audit('cumulative-layout-shift'),
        bench: report.environment?.benchmarkIndex ?? 0,
    };
}

const rows = [];
for (const path of pages) {
    const results = [];
    for (let i = 0; i < RUNS; i++) {
        try {
            results.push(run(base + path));
        } catch (e) {
            console.error(`${path}: run ${i + 1} failed: ${e.message}`);
        }
    }
    if (results.length === 0) {
        rows.push(`| ${path} | failed | | | | | | | |`);
        continue;
    }
    const m = (k) => median(results.map((r) => r[k]));
    rows.push(`| ${path} | **${m('perf')}** | ${m('a11y')} | ${m('bp')} | ${m('seo')} | ${(m('fcp') / 1000).toFixed(1)} s | ${(m('lcp') / 1000).toFixed(1)} s | ${Math.round(m('tbt'))} ms | ${m('cls').toFixed(3)} |`);
    console.log(rows.at(-1));
}

const bench = 'cloud runner';
const now = new Date().toISOString().replace('T', ' ').slice(0, 16);
writeFileSync(
    'docs/perf-scores.md',
    `# Mobile Lighthouse scores (live site)\n\nMeasured ${now} UTC from GitHub Actions (${bench}), median of ${RUNS} runs per page, mobile emulation with simulated throttling (same method as PageSpeed Insights).\nTarget: performance 90+ on every page.\n\n| Page | Perf | A11y | Best practices | SEO | FCP | LCP | TBT | CLS |\n|---|---|---|---|---|---|---|---|---|\n${rows.join('\n')}\n`,
);
