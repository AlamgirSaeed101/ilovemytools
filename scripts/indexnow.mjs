// Tell IndexNow search engines (Bing, Yandex, Seznam, Naver...) which pages are new or changed.
// Usage: node scripts/indexnow.mjs [--all]
//   default: URLs whose sitemap <lastmod> is today (UTC); --all: every URL in the sitemap.
// The key is public by design: search engines check it at https://<host>/<key>.txt.
const HOST = 'ilovemytools.store';
const KEY = 'f27033772f157c8897ff513aef676628';

const xml = await (await fetch(`https://${HOST}/sitemap.xml`)).text();
const today = new Date().toISOString().slice(0, 10);
const urls = [...xml.matchAll(/<url>[\s\S]*?<loc>([^<]+)<\/loc>[\s\S]*?(?:<lastmod>([^<]+)<\/lastmod>)?[\s\S]*?<\/url>/g)]
    .filter(([, , lastmod]) => process.argv.includes('--all') || (lastmod || '').startsWith(today))
    .map(([, loc]) => loc);

if (urls.length === 0) {
    console.log('IndexNow: no pages changed today');
    process.exit(0);
}

const res = await fetch('https://www.bing.com/indexnow', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json; charset=utf-8' },
    body: JSON.stringify({ host: HOST, key: KEY, keyLocation: `https://${HOST}/${KEY}.txt`, urlList: urls.slice(0, 10000) }),
});
// 200/202 = accepted. Never fail the deploy over this.
console.log(`IndexNow: submitted ${urls.length} URLs -> HTTP ${res.status}`);
