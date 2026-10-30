# D · Technical implementation: prioritised changes + Claude-ready prompts
**Blocker B1:** there is no site repo on this box and no hosting (GoDaddy) write access, so **no files were changed and nothing was deployed.** This file holds the exact changes plus copy-paste prompts to run in Claude.ai or Claude Code with the repo attached.

## Stack evidence (what we observed, not assumed)
- Hashed JS bundles live under `/build/assets/` (`app-BCWXJ-pM.js` 393 KB, `i18n-*.js`, `jsx-runtime-*.js`, `rolldown-runtime-*.js`). That points to **Vite (Rolldown) + React JSX**. The `/build/` prefix is the Laravel-Vite convention, but **confirm in the repo**.
- Pages are server-rendered HTML with full metadata and JSON-LD in the initial response. Boot data is in `<script id="boot-data" type="application/json">`.
- There is 1 inline `<style>` block (about 125 KB) per page. Google Fonts load Plus Jakarta Sans via preload plus a stylesheet. AdSense is present.
- Fronted by the Sucuri WAF/CDN (cache HIT) with HSTS.

## Prioritised change list
| # | Pri | Change | Files (locate in repo) | Effort | Expected impact | Test / acceptance |
|---|---|---|---|---|---|---|
| D1 | P1 | **Externalise the inline CSS.** Move the about 125 KB `<style>` to a hashed `/build/assets/app-[hash].css` (long cache) and keep about ≤14 KB critical CSS inline. | Base layout template (the file that prints `<style>`), Vite entry (`resources/css/app.css` or equivalent), `vite.config.*` | M | Smaller HTML (about 240 KB → about 115 KB raw). CSS is cached across pages. Better Speed Index / LCP on repeat views. | `curl -s URL \| wc -c` drops by about 110 KB or more. Lighthouse Perf is ≥ the current 93/95. CLS stays ≤ 0.01. No unstyled flash. |
| D2 | P1 | **Make llms.txt accurate.** Tool count 54, the 6 indexable locales listed as full, ko/pl/ur marked "beta, not indexed". Replace "every tool runs entirely in the browser" with an accurate split (local tools vs server lookup tools). | The generator for `/llms.txt` (route/controller or static file) | S | GEO consistency | `curl /llms.txt` shows "54", no claim that every page exists in all 10 languages, and lists the server-assisted tools |
| D3 | P1 | **Guides ↔ tools linking.** Add 2–3 contextual in-body links per guide and a "Related guides" block (3 items) on every guide and on tool pages that have a guide. | Guide content source (MD/DB/JSON), guide template, tool template | M | Topical clustering, crawl paths to deep tools | Each guide body has ≥3 internal tool links. A Related guides block appears on the 16 guides. Crawl shows no broken links. |
| D4 | P1 | **ItemList + CollectionPage JSON-LD on `/guides`** (it currently has only Breadcrumb/Org/WebSite) | Guides hub template | S | Clear entity listing for parsers | Rich Results Test / Schema Markup Validator: 0 errors. `ItemList.numberOfItems` = live guide count. |
| D5 | P1 | **Expand zh-Hant content** to parity with EN: intro, how-to, features, limitations, FAQ, in native Traditional Chinese (Taiwan usage). Start with the top 15 tools. | zh locale strings / content JSON (`lang/zh*`, `i18n`) | L | Likely reduces "Crawled – not indexed". Taiwan already sends clicks. | zh `/merge-pdf` text length ≥ about 3k CJK characters. Native review. The GSC zh indexed count goes up. |
| D6 | P1 | **Fix the `/category/calculators` title/description mismatch** and run the CTR title tests in E §1 | Category metadata source | S | CTR on page-1 impressions | The new title and description render in the initial HTML. Compare matched 28-day CTR. |
| D7 | P2 | **404 template:** remove `<link rel="canonical">` and slim the payload (no tool bundle, minimal CSS) | 404/error view | S | Hygiene | `curl -s /doesnotexist-xyz` → 404, `noindex`, no canonical, < 30 KB |
| D8 | P2 | **`/.well-known/security.txt`** (RFC 9116) | Public dir / route | S | Trust signal | Returns 200 `text/plain` with Contact and Expires |
| D9 | P2 | **TTFB:** review Sucuri cache rules (cache HTML for anonymous users, longer edge TTL, `stale-while-revalidate`). Exclude `/what-is-my-ip` and `/api/*`. | Sucuri dashboard (not code) | S–M | TTFB 0.87 s → < 0.5 s target | Check TTFB from 3 regions (e.g. webpagetest) |
| D10 | P2 | **Author page** `/about/muhammad-alamgir-saeed` (or `/author/...`) with Person schema (sameAs LinkedIn/Crunchbase/GitHub). Point guides' `author.url` to it. | New route + template, guide JSON-LD builder | M | E-E-A-T on guides and calculators | The page returns 200, is in the sitemap, and Person schema validates |
| D11 | P3 | Language switcher: add `rel="nofollow"` to ko/pl/ur links, or hide them until those locales are indexable | Header/switcher component | S | Minor crawl focus | No ko/pl/ur hrefs without nofollow on indexable pages |
| D12 | P1 | **Tool-page on-page lifts for the quick wins** (domain-authority-checker, avif-to-webp, de/word-counter, de/merge-pdf, de/image-compressor). See E §1–§3. | Tool content/metadata JSON per locale | M | Moves positions 5–17 toward the top 5 | GSC position/CTR on matched windows |

---

## Prompt 1: P1 bundle (copy everything below the line into Claude with the repo attached)

---
You are a senior full-stack + technical SEO engineer working in the **ILoveMyTools** repository (live site https://ilovemytools.store/). Make the changes below **incrementally on a new branch `seo/p1-2026-10`**, one commit per task, with no change to tool functionality, URLs, canonicals, hreflang or the sitemap URL set.

### Site facts (verified 30 Oct 2026; do not assume a different stack)
- Vite (Rolldown) + React JSX bundles served from `/build/assets/*` with hashed names. Pages are server-rendered with full meta + JSON-LD. Boot data is in `<script id="boot-data" type="application/json">`. First identify the framework (likely Laravel + Vite; confirm from `composer.json`/`package.json`) and tell me which files you will touch before editing.
- 54 EN tools, 8 categories, 16 EN guides, 4 legal/about pages. Indexable locales: en (no prefix), es, pt, fr, de, it, zh (hreflang `zh-Hant`). ko/pl/ur are `noindex, follow`, out of the sitemap and out of hreflang. **Keep that policy.**
- The sitemap has 462 URLs. IndexNow key file `/04a72c039825434292d3a51b4891960d.txt` must stay.
- Every page today has ONE inline `<style>` of about 125 KB. HTML is about 240 KB raw.

### Task 1: externalise CSS (P1)
1. Find where the large inline `<style>` is emitted. Move its source into the Vite CSS entry so it builds to `/build/assets/app-[hash].css`.
2. Emit `<link rel="stylesheet" href="…app-[hash].css">` via the framework's Vite helper (e.g. `@vite`), with long-lived immutable caching for `/build/assets/*`.
3. Keep a small **critical CSS** block inline (≤ about 14 KB): header, hero/H1, the tool container skeleton and fonts' fallback metrics, so above-the-fold content doesn't shift.
4. Don't change class names or visual output.
5. Acceptance: the HTML of `/`, `/merge-pdf` and `/de/word-counter` shrinks by ≥100 KB raw. Lighthouse mobile Perf ≥ 93 (home) / 95 (merge-pdf). CLS ≤ 0.01. Visual diff is clean on mobile 390px and desktop 1366px.

### Task 2: llms.txt accuracy (P1)
Regenerate `/llms.txt` from the same tool registry that builds the sitemap, so counts can't drift:
- Say "**54** free online tools" (computed, not hard-coded).
- Languages: list en, es, pt, fr, de, it, zh-Hant as full. List ko, pl, ur as "beta, not indexed yet". Remove "Every page exists in each language".
- Replace "Every tool runs entirely in the visitor's browser" with: "File and text tools run in your browser and never upload your files. Lookup tools (Bulk Domain Authority Checker, Broken Link Checker, Domain Age Checker, What Is My IP) ask our server to fetch public data; we don't store the inputs or results." Derive this list from a `processing: 'local' | 'server'` flag on each tool; add the flag if it doesn't exist and verify each tool's actual behaviour in code.
- Keep the per-category tool list with one-line descriptions, add a "Guides" section listing all guides, and add a "Facts" section (founded Sep 2026, founder name, contact URL, privacy policy URL).

### Task 3: guides ↔ tools internal linking (P1)
For each of the 16 guides, add 2–3 **contextual, in-sentence** links to relevant tools (not only the main one) and a "Related guides" block (3 guides, same cluster first). Use this map:
| Guide | Add links to |
|---|---|
| how-to-merge-pdf-files | /organize-pdf, /compress-pdf, /jpg-to-pdf |
| how-to-compress-pdf-for-email | /compress-pdf, /merge-pdf, /pdf-to-jpg |
| how-to-convert-pdf-to-word | /pdf-to-word, /word-to-pdf, /edit-pdf |
| how-to-edit-text-in-a-pdf | /edit-pdf, /sign-pdf, /redact-pdf |
| how-to-white-out-text-in-a-pdf | /edit-pdf, /redact-pdf, /watermark-pdf |
| how-to-redact-a-pdf-properly | /redact-pdf, /protect-pdf, /edit-pdf |
| how-to-add-a-watermark-to-a-pdf | /watermark-pdf, /protect-pdf, /merge-pdf |
| jpg-vs-png-vs-webp-vs-avif | /image-compressor, /webp-to-png, /avif-to-webp, /png-to-jpg |
| how-to-resize-an-image-for-social-media | /image-resizer, /image-compressor, /remove-background |
| how-to-remove-background-from-image | /remove-background, /jpg-to-png, /image-resizer |
| how-many-words-is-a-page | /word-counter, /readability-checker, /case-converter |
| how-to-create-a-strong-password | /password-generator, /protect-pdf |
| how-to-make-a-qr-code | /qr-code-generator, /image-resizer |
| how-to-calculate-percentages | /percentage-calculator, /tip-calculator |
| how-to-calculate-a-tip-and-split-a-bill | /tip-calculator, /percentage-calculator |
| how-to-calculate-a-mortgage-payment | /mortgage-calculator, /loan-calculator, /compound-interest-calculator |
Links must use the current locale-correct absolute paths, and anchors must be descriptive (no "click here").

### Task 4: ItemList on /guides (P1)
On `/guides`, add JSON-LD `CollectionPage` with `mainEntity: ItemList` (`itemListElement` = `ListItem{position,url,name}` for each guide, generated from the guides registry), and keep the existing Breadcrumb/Org/WebSite. Validate with https://validator.schema.org/ : 0 errors.

### Task 5: 404 hygiene (P2)
The 404 template must return HTTP 404 with `noindex` and **no `<link rel="canonical">`**. Don't load the tool bundle on 404. Keep the search box and category links. Target < 30 KB HTML.

### Task 6: security.txt (P2, optional)
Serve `/.well-known/security.txt` (text/plain) per RFC 9116 with `Contact: mailto:<owner contact email>` (ask me; don't invent it), `Expires:` 12 months ahead, `Preferred-Languages: en`, `Canonical:`.

### Task 7: category/calculators metadata (P1)
Set the EN `/category/calculators` title to "Free Online Calculators: Age, Percentage, Loan & Mortgage" (≤60 chars) and the meta description to "Free calculators for age, percentages, tips, loans, mortgages and compound interest. Instant results with the formula and working shown. No sign-up." Make sure the listed calculators exist on the page.

### Deliverables
- A list of every file changed and why. The `npm run build` (and backend tests if any) output. Before/after byte sizes for 3 URLs. Schema validator results. Confirmation that the sitemap still has 462 URLs and that all hreflang/canonicals are unchanged (`diff` of rendered `<head>` for 5 sample URLs, excluding the CSS link).
- Don't deploy. Give me the deployment steps for the existing process.
---

## Prompt 2: zh-Hant content expansion (P1/P2)

---
You are a native Traditional Chinese (Taiwan) technical writer + i18n engineer in the ILoveMyTools repo. `/zh/*` pages carry about half the English content (e.g. `/zh/merge-pdf` is about 1.8k characters vs EN 3.4k), and GSC shows many locale URLs as "Crawled – currently not indexed". For these 15 tools first: merge-pdf, compress-pdf, split-pdf, pdf-to-jpg, jpg-to-pdf, image-compressor, image-resizer, webp-to-png, avif-to-jpg, remove-background, word-counter, qr-code-generator, json-formatter, password-generator, age-calculator:
1. Find the zh content source (i18n JSON/strings). Rewrite each page's intro, how-to steps, features, limitations, privacy note and 4–6 FAQs **natively** (Taiwan vocabulary: 檔案, 免費, 線上, 下載). Don't machine-translate the EN sentence by sentence. Use Taiwan search phrasing verified on 30 Oct 2026, e.g. 「合併pdf免費」「圖片壓縮指定大小」「圖片壓縮不失真」「qr code 產生器 永久」「字數計算器 中文」.
2. Keep the facts identical to EN (limits, formats, local vs server processing). Don't add features that don't exist.
3. Keep titles ≤ 30 CJK characters and descriptions ≤ about 80 CJK characters. Keep `zh-Hant` lang and hreflang unchanged.
4. Output a per-page before/after character count and a list of the files changed.
---

## Prompt 3: quick-win tool page lifts (P0/P1)

---
In the ILoveMyTools repo, update the content and metadata (only content, no tool logic) for these pages. Keep all existing sections; add the new ones below them:
1. `/domain-authority-checker` (EN): title "Bulk Domain Authority Checker: Check 100 Sites Free" (51 chars). H1 "Bulk Domain Authority Checker". The first paragraph must state "check up to 100 domains at once, free, no sign-up, OpenPageRank 0–10 + referring domains, CSV export". Add an H2 "OpenPageRank vs Moz DA vs Ahrefs DR" with a 3-column factual table (owner, scale, data source, free access) and links to the official docs. Add an FAQ "Can I check domain authority in bulk for free?" Keep the existing honest note that it uses the server.
2. `/avif-to-webp` (EN): add an H2 "Does converting AVIF to WebP lose quality?" with an accurate answer based on the encoder actually used (check the code: lossy/lossless, default quality, alpha). Mention the batch limit (30) and ZIP.
3. `/de/word-counter`: add a German H2 "Wie zählt der Wortzähler?" covering compounds (Bachelorarbeit = 1 word), numbers, hyphenated words and "z. B." versus Microsoft Word, matching the tool's real tokenizer (read the code). Add FAQ "Wörter zählen online ohne Anmeldung – ist mein Text privat?"
4. `/de/merge-pdf`: put "kostenlos und ohne Anmeldung" in the intro sentence. Add an FAQ on file limits and offline use (only if true in code).
5. `/de/image-compressor`: add an H2 "JPG verkleinern auf eine Zielgröße (z. B. 100 KB)" with steps that match the UI.
Return the diff and the files changed.
---
