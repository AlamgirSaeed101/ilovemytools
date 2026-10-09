// After a deploy the firewall (Sucuri) cache is empty, so the first visitor to each page (often Googlebot)
// waits for the origin server. This requests every sitemap URL once so they are cached again.
// Usage: node scripts/warm-cache.mjs [base-url]
const base = (process.argv[2] || 'https://ilovemytools.store').replace(/\/$/, '');
const CONCURRENCY = 2; // gentle: shared hosting has a low limit on simultaneous PHP processes

const xml = await (await fetch(`${base}/sitemap.xml`)).text();
const urls = [...xml.matchAll(/<loc>([^<]+)<\/loc>/g)].map((m) => m[1]);

let ok = 0;
let failed = 0;
const queue = [...urls];
await Promise.all(
    Array.from({ length: CONCURRENCY }, async () => {
        while (queue.length) {
            const url = queue.shift();
            try {
                const res = await fetch(url, { headers: { 'User-Agent': 'ILoveTools cache warmer' } });
                await res.arrayBuffer();
                res.ok ? ok++ : failed++;
            } catch {
                failed++;
            }
        }
    }),
);
console.log(`Warmed ${ok} of ${urls.length} pages (${failed} failed).`);
