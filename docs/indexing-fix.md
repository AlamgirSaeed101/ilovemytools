# Search Console indexing fix (30 Oct 2026)

Search Console (28 Oct): 384 indexed, 309 not indexed - 259 "Crawled, currently not indexed"
(mostly translated pages), 31 "Discovered, currently not indexed" (incl. English guides),
19 "Page with redirect" (validation failed: /{lang}/guides/* plus the expected http/www redirects).

## Policy: which languages Google may index

`config/locales.php` -> `indexable`: **en, de, it, es, fr, zh, pt**.
Chosen from Search Console impressions over the last 28 days (approx.): en 1,100, de 1,100, it 450,
es 350, fr 280, zh 220, pt 150, pl 150, ko 90, ur 55. German alone matches English, and it, zh and
pt already bring clicks, so an "en + es only" policy would have thrown most foreign visibility away.

**pl, ko, ur** stay fully usable for visitors but send `noindex, follow`, are out of the sitemap and
out of every hreflang set. To index a language again, add it to `indexable` once its pages have
reviewed, unique copy; nothing else needs changing.

## What changed

| Bug | Fix |
|---|---|
| A: /{lang}/guides/* 302 | Root cause: React's footer "Guides" link and the tool pages' "Read the guide" links were router `<Link>`s, so on /ko pages they became /ko/guides/...; the language switcher also built /ko/guides/... on guide pages, and the /guides hub emitted hreflang to /{lang}/guides. Now: plain absolute links to the English guide, the switcher on guides goes to each language's home page, the hub has no hreflang, and any request to /{lang}/guides/* gets one 301 to the English guide. |
| B: thin translated pages | Non-indexable languages are noindex (server `Seo` and client `applyMeta`). Legal pages (/about, /contact, /privacy-policy, /terms) are indexed in English only (`Seo::englishOnly()`): other languages' copies are noindex and none of them carry hreflang. |
| C: guides only "discovered" | Every tool page in every language links its English guide (`guidesFor()` no longer English-only); the home page in every language lists the 3 newest guides plus "All guides"; each guide page has "More guides" (3 related, `Guides::relatedTo()`); the /guides hub stays linked from the footer of every page. |
| D: sitemap | Only canonical indexable URLs: home/tools/categories x 7 indexable languages with hreflang among them, legal pages in English only, /guides and every English guide. No /{lang}/guides, no pl/ko/ur. 686 -> 462 URLs. |
| E: hreflang | Server and client emit exactly the indexable languages + x-default, only on indexable pages, so hreflang never points at a redirect or a noindex page. The first-visit language redirect (layout script) follows hreflang, so it now only sends visitors to indexable languages. |

Unchanged: http->https and www->apex redirects, the IndexNow key file, AdSense and analytics IDs.

Tests: `tests/Feature/IndexingTest.php` (sitemap contents, hreflang sets, noindex languages, legal
pages, 301 for language guide URLs, no /{lang}/guides links on guide pages, guide links from tool
pages in every indexable language, hub, home and sibling guides).

## After deploy (owner, in Search Console and Bing)

1. Resubmit https://ilovemytools.store/sitemap.xml in Search Console and Bing Webmaster Tools.
2. Search Console > Pages > "Page with redirect" > Validate fix.
3. Expect "Crawled/Discovered - currently not indexed" to fall over 2-6 weeks as Google recrawls;
   pl/ko/ur pages will move to "Excluded by noindex tag" - that is intended.
