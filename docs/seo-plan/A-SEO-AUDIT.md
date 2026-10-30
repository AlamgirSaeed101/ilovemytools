# A · SEO audit (condensed): ilovemytools.store
Source: `../ilovemytools-audit-2026-10-30/FINDINGS.md` (crawl of 30 Oct 2026, about 19:07–19:45 PKT) plus the GSC baseline (30 Oct 2026). Raw evidence is in `../ilovemytools-audit-2026-10-30/raw/`.
Status key: **Fixed** = verified live · **Open** = not done · **In progress** = started, outcome pending · **Verify** = needs a check we could not run.

## Summary
The technical and on-page foundations are strong (all 462 URLs return 200, clean canonicals and hreflang, rich valid JSON-LD, Lighthouse 93–95). The constraints are **authority** (off-page 2/10), **visibility** (average position 33.5, CTR 0.5%) and **index coverage** (GSC shows 259 "Crawled – currently not indexed").

## Issue register
| ID | Area | Affected URL(s) | Issue | Evidence | Severity | Impact | Fix | Status |
|---|---|---|---|---|---|---|---|---|
| A1 | Off-page | Site-wide | Almost no editorial backlinks. Mentions are limited to own profiles (LinkedIn, dev.to, deepnlp, CircleSaaS, Cazaproducto). | Brand search, 30 Oct 2026 | **P0** | Main ranking limiter for a young site (launched Sep 2026) | White-hat plan in `F-BACKLINKS.md` | Open |
| A2 | Visibility | Non-branded queries | Not in the top 5 results for tested non-branded queries. GSC average position 33.5, CTR 0.5%. | WebSearch checks + GSC baseline | **P0** | Little organic traffic | Target long-tail quick wins (`B`, `C`) | Open |
| A3 | Indexing | Mostly locale URLs (assumed; examples needed) | **Crawled – currently not indexed: 259.** Discovered – not indexed: 31. | GSC baseline | **P0** | Many tool/locale pages earn no impressions | Export examples. Strengthen zh/locale content and internal links. Request indexing for priority URLs after improving them. Track weekly. | Open |
| A4 | Indexing | 19 redirecting URLs (locale guides) | "Page with redirect" | GSC | P2 | Housekeeping only | Removed from sitemap. Validation started. | **In progress** (validation started) |
| A5 | Sitemap | `/sitemap.xml` | It held about 686 URLs, including redirecting `/{locale}/guides/*`. | Previous audit (28 Oct) | P1 | Crawl waste | Cleaned to 462 URLs with no 3xx/4xx. Resubmitted to GSC and Bing (Success, 462 discovered). | **Fixed** |
| A6 | Locales | `/ko/*`, `/pl/*`, `/ur/*` (67 each) | Thin translations were indexable. | Previous audit | P1 | Thin-content risk | `noindex, follow`, no hreflang, removed from sitemap | **Fixed** |
| A7 | Discovery | Site-wide | No IndexNow | Previous audit | P2 | Slower Bing/Yandex discovery | Key file live (200) | **Fixed** |
| A8 | HTTP | `http://` and `http://www` | They returned 500 (`Server: Pingora`) from the box, but so did `http://example.com`, which points to a box proxy artefact. | Crawl | P1 | Possible lost signals if it's real | Confirm with httpstatus.io or GSC URL Inspection | **Verify** |
| A9 | Entity / GEO | llms.txt, LinkedIn, dev.to, deepnlp, CircleSaaS | The tool count is inconsistent: the site says **54**, other profiles say 52, 48 or "50+". The Product Hunt slug `ilovetools-3` doesn't match the brand. | Crawl + search | P1 | AI engines repeat mismatched facts | Set 54 everywhere. Fix the slug. | Open |
| A10 | GEO accuracy | `/llms.txt` | It says "Every tool runs entirely in the visitor's browser" and "Every page exists in each language". But the lookup tools (domain authority, broken link, domain age, what-is-my-ip) state on-page that they call the server, and ko/pl/ur are noindex. | `raw/llms_head.txt` vs `/domain-authority-checker` ("This tool asks our server to fetch the address…") | P1 | An inaccurate claim undermines trust and AEO | Rewrite llms.txt (prompt in D) | Open |
| A11 | Internal links | 16 guides | Each guide's main content links to only one tool. The `/guides` hub has no ItemList. | Crawl | P1 | Weak topical clustering | 2–3 contextual links per guide, a "Related guides" block, ItemList/CollectionPage on `/guides` | Open |
| A12 | Content coverage | Guides | 16 guides for 54 tools | Crawl | P1 | Informational intent is under-served. Guides earn links. | `G-CONTENT-30.md` | Open |
| A13 | Performance | Site-wide | TTFB averages 0.87 s even on a Sucuri cache HIT (worst 2.36 s on `/what-is-my-ip`) | `raw/sitemap_status.tsv` | P1 | LCP headroom | Review Sucuri caching/PoP. Consider a CDN in front. | Open |
| A14 | Performance | Site-wide | About 125 KB of inline CSS repeated on every page (about 240 KB HTML raw). app.js is 393 KB raw. | Crawl | P1 | Bytes and Speed Index (4.5 s lab) | Externalise CSS with a hashed filename, inline only critical CSS (prompt in D) | Open |
| A15 | International | `/zh/*` | zh-Hant pages carry about half the EN content (about 1.8k characters vs 3.4k on `/merge-pdf`) | Crawl | P2 | Likely part of A3 | Expand zh content (prompt in D) | Open |
| A16 | 404 | Unknown URLs | The 404 template outputs a self-canonical and weighs about 190 KB | Crawl | P2 | Cosmetic (already noindex + 404) | Remove the canonical on 404 and slim the template | Open |
| A17 | Trust | `/.well-known/security.txt` | Missing (404) | Crawl | P3 | Small trust signal | Add the file | Open |
| A18 | Crawl budget | Language switcher on 462 pages | Links to noindex ko/pl/ur on every page | Crawl | P3 | Minor crawl dilution | Keep them, or remove from the switcher until ready | Open (optional) |
| A19 | Schema | HowTo/FAQ | Google no longer shows HowTo rich results, and FAQ rich results are limited to authoritative gov/health sites. | Google Search Central | Info | Expectation setting | Keep for parsing. Expect no SERP features. | Info |
| A20 | E-E-A-T | `/about`, guide `author.url` | No dedicated author page, photo or credentials. YMYL-adjacent calculators (mortgage, loan). | Crawl | P2 | Trust | Author page with Person schema. Point guides' `author.url` to it. | Open |
| A21 | CTR | `/category/calculators` | 121 impressions at position 8.9, 0 clicks. The title promises age/loan/mortgage/compound interest, but the description talks about percentages. | GSC baseline + onpage.csv | P1 | Lost clicks on page 1 | Rewrite the title and description (E §1) | Open |
| A22 | CTR | `/domain-authority-checker` | 277 impressions at position 14.6, 0 clicks | GSC baseline | **P0** | Biggest quick-win page | On-page lift + title test (C, E) | Open |

## What passes (verified 30 Oct 2026)
- 462/462 sitemap URLs return 200. 226/226 non-sitemap internal links return 200. 0 broken images. 70/70 assets return 200. 0 empty `#` hrefs.
- Redirects: www → apex (301). Trailing slash → no slash (301). Locale guides → EN guide in a single 301. Unknown URL → real 404 + noindex.
- Canonicals are self and absolute. Robots are `index, follow, max-image-preview:large` on all indexable pages.
- Titles are 60 characters or fewer with 0 duplicates. Descriptions are 70–160 characters with 0 duplicates. Exactly one H1 per page. `html lang` is correct (zh = `zh-Hant`).
- Hreflang: 8-entry reciprocal (en, es, pt, fr, de, it, zh-Hant, x-default) in both HTML and sitemap.
- JSON-LD: Organization, WebSite, Person, FAQPage (457), BreadcrumbList (455), WebApplication (434), HowTo (378), Speakable (401), Article (16), CollectionPage (56). All parse.
- robots.txt allows the major search and AI crawlers and blocks only `/api/`. HSTS, nosniff, XFO, Referrer-Policy and Permissions-Policy are all set.
- Lab: home LCP 1.9 s / CLS 0.002. `/merge-pdf` LCP 1.9 s / CLS 0.
- Tool count: **54** EN tool URLs, all independently accessible, 200 and indexable. Functional tests of every tool were **not** run (only representative tools were checked in the audit).
