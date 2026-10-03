# Daily improvement routine

This file drives the scheduled Claude routine that improves ilovemytools.store every day.
Each run: read this file, do the **first unchecked item** in the backlog (or the first failing-CI fix),
test, commit, push to `main`, and add a line to the log at the bottom. GitHub Actions
(`.github/workflows/deploy.yml`) runs every test suite and deploys only if all of them pass.

Read `TOOLS_SPEC_PROMPT.md` (architecture, SEO rules, tool specs) before changing anything.

## Rules (never break these)

1. **Start with CI.** Run `gh run list --limit 3`. If the latest run on `main` failed, fixing it is today's task: open the log (`gh run view <id> --log-failed`), fix the cause, and push. Nothing else until CI is green.
2. **One item per run.** One new tool, or one SEO item. Small, finished, tested changes. Never leave half-built work on `main`.
3. **Everything runs in the browser.** No paid APIs, no API keys, no server-side file processing, no new server endpoints. Heavy libraries are lazy-loaded inside the tool.
4. **All 6 languages.** Every new or changed text needs English plus es, pt, fr, de and it:
   - interface strings: `t('...')` in JSX, then `node scripts/i18n-extract.mjs` and add each new key to `lang/{es,pt,fr,de,it}.json` (plural objects where needed, keep `{placeholders}`);
   - page content: add the tool to `lang/{code}/tools.php` with the same number of steps, features, content sections and FAQs as `config/tools.php`.
   The translation tests fail if anything is missing. Write natural, native-quality translations; don't copy English.
5. **Honest content only.** Never invent people, reviews, ratings, user counts, awards, testimonials, statistics or sources. Only cite sources you actually fetched. Items that need facts from the owner (for example real names or social profiles) are marked *(owner input)*. Skip those and leave them unchecked.
6. **SEO rules** (from `TOOLS_SPEC_PROMPT.md` Part 2): title ≤ 60 chars with the main keyword first, description 140-155 chars (no truncation "…"), one H1 matching the search phrase, 4-5 real FAQs, 2-4 related tools, `updated` date set to today.
7. **Tests.** `tests/e2e/smoke.spec.js` opens EVERY tool in EVERY language and must pass before any push. Add Vitest tests for new logic in `resources/js/lib`. Add an e2e test in `tests/e2e/tools.spec.js` that uses the tool end to end. Run everything locally: `npm run build && npm test && php artisan test && npx playwright test`. **Do not push until all of it passes**: every red CI run emails the owner. If Google Chrome isn't installed, run Playwright against local Chromium; console errors from Google Fonts (blocked by sandbox proxies) are ignored by `tests/e2e/helpers.js`, so any remaining e2e failure is real. Never hard-code tool or category counts in tests; read them from `/api/site` so a new tool can't break existing tests.
8. **Never touch secrets or the server.** Don't edit `.env`, GitHub secrets or `scripts/cpanel/deploy.sh` credentials handling, and never SSH to the server yourself. Deploys happen only through CI.
9. **AdSense policy.** No ads inside tool UIs. No content about piracy, downloading copyrighted media (YouTube/Instagram downloaders), hacking or adult topics.
10. **Commit message:** `feat(tool): add JPG to PDF` / `seo: ...` / `fix: ...`, with a short body saying what changed.
11. **Tell the owner.** After pushing (or when the run ends early), comment on the pinned issue #1 "Daily site updates": `gh issue comment 1 --body-file update.md`. GitHub emails the owner each comment. Use plain, non-technical English and this shape:
    ```
    ### <date>
    **Changed today**
    - <what visitors will notice, e.g. "New Tip Calculator at ilovemytools.store/tip-calculator (6 languages)">
    **Status:** CI <passed/failed> · live <yes/no>
    **Coming next**
    - <the next 2-3 unchecked backlog items>
    **Waiting on you** (only if something needs the owner)
    - <owner-input items still open>
    ```
    If CI fails after your push, comment again saying what failed and that tomorrow's run fixes it first.

12. **Target markets.** The site serves every country, but ad revenue comes mostly from the US, UK, Canada,
    Australia and Western Europe (Germany, the Nordics, Switzerland, the Netherlands, France). So: research
    keywords in the Semrush `us` database first, then `uk` and `de` (and `fr`/`it`/`es` for those pages);
    prefer tools whose keywords have a high CPC (finance calculators earn far more per ad than file tools);
    use local conventions via `resources/js/lib/region.js` (Letter vs A4, tipping, US vs metric units); and
    for money tools be exact: show formulas, cite official sources (e.g. EU/HMRC VAT rates) and never give tax advice.

## Backlog (in priority order)

Ranked by search demand (what iLovePDF, Smallpdf, FreeConvert and the big calculator sites put first) and
by whether the tool works well entirely in the browser.

Real US search data (Semrush, 30 Sep 2026) is in `docs/keywords/`. Use it for each new page: the
highest-volume exact phrase becomes the H1/title keyword; the next variants go in the intro, steps, headings
and FAQs. When the owner adds new Semrush exports there, re-rank the unchecked items by volume ÷ difficulty.

### High-revenue tools (do these first, from 3 Oct 2026)
Finance topics have much higher ad prices in the US/UK/EU than file tools. Before building each one, check
volume and CPC in Semrush (`us`, `uk`, `de`) and save the data in `docs/keywords/`.
- [ ] **Mortgage Calculator** `/mortgage-calculator` (monthly payment, amortization table, extra payments; US and UK wording).
- [ ] **Loan Calculator** `/loan-calculator` (payment, total interest, amortization schedule).
- [ ] **Compound Interest Calculator** `/compound-interest-calculator` (monthly contributions, chart, table).
- [ ] **VAT Calculator** `/vat-calculator` (add/remove VAT; UK and EU country rates from official sources, dated).
- [ ] **Salary to Hourly Calculator** `/salary-calculator` (hourly, weekly, monthly, yearly; no tax estimates).

### New tools
Ranked by real US search volume and keyword difficulty (KD 0-100, lower is easier) from Semrush,
30 Sep 2026: `docs/keywords/semrush-us-bulk-2026-09-30.json`. Use those exact phrases for titles and H1s.

- [x] **JPG to PDF** `/jpg-to-pdf`. *"jpg to pdf" 301K (KD 82).*
- [x] **WebP to PNG** `/webp-to-png`, **PNG to JPG** `/png-to-jpg`, **JPG to PNG** `/jpg-to-png` (ImageConverter). *165K / 49.5K / 33.1K.*
- [x] **Tip Calculator** `/tip-calculator` (bill, tip %, split between people, round up; presets 15/18/20/25%). *"tip calculator" 1.5M (KD 49).*
- [ ] **PNG to PDF** `/png-to-pdf` (landing page reusing the JPG to PDF tool, PNG-first copy). *"png to pdf" 110K (KD 42).*
- [ ] **Unit Converter** `/unit-converter` plus landing pages **kg to lbs** `/kg-to-lbs`, **Celsius to Fahrenheit** `/celsius-to-fahrenheit`, **cm to inches** `/cm-to-inches` (one engine, preset units, conversion table on each page). *1.5M cm to inches (KD 72), 823K kg to lbs (KD 51), 450K celsius to fahrenheit (KD 49), 135K unit converter (KD 69).*
- [ ] **GPA Calculator** `/gpa-calculator` (courses, credits, letter or 4.0 grades, cumulative GPA). *673K (KD 50).*
- [ ] **WebP to JPG** `/webp-to-jpg`, **PNG to WebP** `/png-to-webp` (ImageConverter pages). *90.5K (KD 60) / 14.8K (KD 48).*
- [ ] **PDF to JPG** `/pdf-to-jpg` and **PDF to PNG** `/pdf-to-png` (pdfjs-dist render, 72/150/300 DPI, ZIP). *246K (KD 81) / 74K (KD 56).*
- [ ] **Barcode Generator** `/barcode-generator` (JsBarcode: CODE128, EAN-13, UPC-A, CODE39; PNG/SVG). *823K (KD 60).*
- [ ] **HEIC to JPG** `/heic-to-jpg` (heic2any, batch, ZIP). *246K (KD 71).*
- [ ] **Compress PDF** `/compress-pdf` (object-stream re-save + optional re-render at chosen quality; before/after size; warn that strong mode rasterises text). *110K "compress pdf" (KD 74) + 74K "pdf compressor" (KD 67).*
- [ ] **Compound Interest Calculator** `/compound-interest-calculator` (principal, rate, years, compounding, monthly contributions, yearly table). *1.22M (KD 66).*
- [ ] **Date Calculator** `/date-calculator` (days between dates, add/subtract days, business days). *368K (KD 63) + "days between dates" 90.5K.*
- [ ] **TDEE Calculator** `/tdee-calculator` (Mifflin-St Jeor with activity levels; cite the formula's source; not medical advice). *368K (KD 57).*
- [ ] **Invoice Generator** `/invoice-generator` (form, live preview, PDF via pdf-lib, data only in memory). *673K (KD 63).*
- [ ] **Character Counter** `/character-counter` (reuse the word counter engine; limits for X, Instagram, meta tags, SMS). *201K (KD 74).*
- [ ] **Discount Calculator** `/discount-calculator`. *33.1K (KD 43).*
- [ ] **Click Counter / Tally Counter** `/click-counter` (big tap button, +/−, named counters, keyboard, remembered locally). *22.2K (KD 40) + "tally counter" 18.1K (KD 42).*
- [ ] **Roman Numeral Converter** `/roman-numeral-converter`, **Binary to Text** `/binary-to-text`. *40.5K (KD 58) / 27.1K (KD 51).*
- [ ] **UUID Generator** `/uuid-generator`, **Hex to RGB** `/hex-to-rgb` (colour converter with contrast ratio). *14.8K (KD 22) / 8.1K (KD 24).*
- [ ] **PNG to SVG** `/png-to-svg` (only if a good in-browser tracer exists) and **SVG to PNG** `/svg-to-png`. *40.5K / 33.1K (KD 55-56).*
- [ ] **Signature Generator** `/signature-generator` (draw or type, transparent PNG). *49.5K (KD 51).*
- [ ] **Fancy Text Generator** `/fancy-text-generator` (Unicode styles, copy). *60.5K (KD 66).*
- [ ] **Image to Text (OCR)** `/image-to-text` (tesseract.js, language data served from `/public`). *60.5K (KD 67).*
- [ ] **Online Timer** `/online-timer` landing page for the countdown timer, and **Hours Calculator** `/hours-calculator`. *135K (KD 80) / 165K (KD 72).*
- [ ] **Rotate PDF** `/rotate-pdf`, **Add Page Numbers to PDF** `/add-page-numbers-to-pdf`, **Watermark PDF** `/watermark-pdf`. *8.1K (KD 47) / 2.4K (KD 39) / 1.3K (KD 40).*
- [ ] Later (huge but very hard, KD 83-100): BMI 4.09M, mortgage 3.35M, loan 1.5M, calorie 3.35M, time zone converter 550K, text to speech 246K, colour picker 550K, remove background 673K, scientific calculator 1M. Build only after the easier items are done.

Not planned: PDF↔Word/Excel/PowerPoint (can't be done well in the browser), video/audio converters (too heavy), social-media downloaders (AdSense and copyright risk), pregnancy/due-date calculators (medical advice risk).

### SEO / GEO / AEO (from the audit of 30 Sep 2026, Desktop report)
- [x] Rewrite meta descriptions that get truncated with "…" (home + 5 localised homes + 3 localised Word Counter pages); lengthen /terms, /contact and /about descriptions to 140-155 chars (all 6 languages).
- [x] Shorten the 16 titles longer than 60 characters (all languages).
- [x] Long-cache hashed assets: `Cache-Control: public, max-age=31536000, immutable` for `/build/*` in `public/.htaccess`; remove the `X-Powered-By` header.
- [x] Add `/llms.txt` (generated like the sitemap: site summary, every tool with one line, languages).
- [x] Expand each of the 8 category pages to 300+ unique words: when to use which tool, a comparison table and 3-4 FAQs (plus FAQPage schema). All languages.
- [x] Add one reference table per tool where it helps answers (image sizes, bedtime chart, percentage formulas, QR error-correction levels, dice types…).
- [x] Cite real sources with outbound links for factual claims (sleep hours, coin-flip bias study, Base64 spec…). Only cite pages you fetched and checked.
- [x] Show "Last updated" on tool pages and add `dateModified` to the WebApplication schema.
- [ ] Per-tool Open Graph images (tool name + icon, generated at build time).
- [ ] Rephrase statement H2s as questions where natural (e.g. "Common image sizes" -> "What size should my image be?"), all languages. (Intro definitions are done.)
- [x] HowTo and SpeakableSpecification schema on tool pages.
- [ ] Homepage FAQ (4-5 questions such as "Are these tools really free?", "Are my files uploaded?") with FAQPage schema, all languages. *(quick audit 30 Sep)*
- [ ] Tools without them get a one-line definition, a reference table and 2-3 cited sources, like /image-compressor (start with /merge-pdf, /split-pdf). *(quick audit 30 Sep)*
- [x] *(owner input)* OPcache enabled (3 Oct 2026): uncached pages went from ~1.8 s to ~0.6 s to first byte, the same as a static file. What remains is distance to the Singapore server (moving hosting to the US would help US visitors).
- [ ] *(owner input, REMIND on 4 Oct 2026)* Connect **Google Search Console** to Windsor.ai while logged in to the Windsor account **talibhussain.monzo@gmail.com** (Google account mas032746@gmail.com is fine): https://onboard.windsor.ai/connect?connector=searchconsole&next=/searchconsole/authorize then tick ilovemytools.store and Finish. It was connected to a different Windsor account (mas032746).
- [ ] *(owner input, REMIND on 4 Oct 2026)* Connect **Google Analytics 4** (property with ID G-GMWZ0PJW1R) the same way: https://onboard.windsor.ai/connect?connector=googleanalytics4&next=/googleanalytics4/authorize then select the GA4 property and Finish.
- [ ] *(owner input)* About page: real founder name, bio and founding date; Person schema linked as Organization.founder.
- [ ] *(owner input)* Brand social profiles in Organization.sameAs and the footer.

## Log

<!-- One line per run, newest first: YYYY-MM-DD · what changed · CI result -->
- 2026-10-03 · Added **Urdu (ur)** as a new right-to-left language, live at `/ur` (e.g. `/ur/merge-pdf`): `config/locales.php` entry (`dir: rtl`, native `اردو`, `og: ur_PK`), `lang/ur.json` (all 880 UI strings, 21 plural keys), and `lang/ur/{tools,categories,site}.php` (all 33 tools and 8 categories, same steps/features/content/FAQ/table counts as the English source, natural modern Urdu as written online in Pakistan, keeping PDF/JPG/QR code/Wi-Fi/JSON and other technical terms in Latin script). Fixed physical left/right CSS in `kit.css`/`games.css`/`landing.css` to logical properties (`margin-inline-*`, `padding-inline-*`, `inset-inline-*`, `text-align: start`) across the header actions, search box, select dropdown arrow, command palette, prose lists, key-value and laps tables, category/way-card arrows, back-to-top button and sleep/lap cards, plus two `text-left` → `text-start` fixes in `AdblockNotice.jsx`/`BackgroundRemover.jsx`; verified no `ml-`/`mr-`/`pl-`/`pr-` Tailwind utilities remained in any `.jsx`. Added `:root:lang(ur)` font-family (Noto Nastaliq Urdu, loaded only on Urdu pages via a conditional `<link>` in `app.blade.php`, same non-blocking preload pattern as the existing Plus Jakarta Sans) with extra `line-height: 2.1` on `html:lang(ur) body` so Nastaliq's diagonal strokes and loops don't clip. New e2e check in `language.spec.js` that `/ur` and `/ur/merge-pdf` render `dir="rtl"`. Shortened several tool/category titles and descriptions that came out over the 60/160-character SEO limits once translated. Live Semrush lookups (`phrase_this`/`phrase_these`, `pk` database) returned the same "WRONG FORMAT OR EMPTY KEY" error seen on 2026-10-01 and 2026-10-03, so no `docs/keywords/ur.json` was created rather than invent numbers. Ran `npm ci`, `composer install`, `cp .env.example .env && php artisan key:generate`, `touch database/database.sqlite && php artisan migrate --force`, `node scripts/i18n-extract.mjs` (880 keys, unchanged), `npm run build`, `npm test` (149 passed), `php artisan test` (83 passed, 9508 assertions, including `SeoLengthsTest` and `TranslationsTest` for the new `ur` data set) and the full `npx playwright test` suite (69 passed, including `smoke.spec.js` for "ur" and the new RTL check) against local Chromium via a throwaway local-only config (not committed) with `launchOptions.executablePath` pointing at `/opt/pw-browsers/chromium-1194/chrome-linux/chrome`.
- 2026-10-03 · Added **Polish (pl)** as a new language: `config/locales.php` entry, `lang/pl.json` (all 880 UI strings, reusing and extending the first 300 already drafted in `docs/translations-wip/pl-ui-part1.json`, 21 plural keys written with the full Polish one/few/many/other categories), and `lang/pl/{tools,categories,site}.php` (all 33 tools and 8 categories, same steps/features/content/FAQ/table counts as the English source). SEO titles lead with the Polish search phrase (e.g. "Połącz PDF", "Kompresja zdjęć", "Licznik słów"); every title/description checked by script against the 60-char title and 70-160-char description rules before pushing. Live Semrush lookups (`phrase_this`/`phrase_these`, `pl` database) returned the same "WRONG FORMAT OR EMPTY KEY" error seen on 2026-10-01, so no `docs/keywords/pl.json` was created rather than invent numbers. Deleted `docs/translations-wip/pl-ui-part1.json` now that its content is folded into `lang/pl.json`. Ran `npm ci`, `composer install`, `node scripts/i18n-extract.mjs` (880 keys, unchanged), `npm run build`, `npm test` (145 passed), `php artisan test` (80 passed, 8346 assertions, including `SeoLengthsTest` and `TranslationsTest` for the new `pl` data set) and the full `npx playwright test` suite (67 passed, including `smoke.spec.js` for "pl") against local Chromium via a throwaway local-only config (not committed) with `launchOptions.executablePath` pointing at `/opt/pw-browsers/chromium-1194/chrome-linux/chrome` (plain `use.executablePath` was silently ignored by this Playwright version and tried to launch a missing `chrome-headless-shell`; two newsletter e2e tests also failed until `php artisan migrate --force` was run against the fresh `database/database.sqlite`, an environment setup step, not a translation issue). No other agent pushed to `main` while this ran, so no rebase was needed.
- 2026-10-03 · CI on main (run #47, commit 288ba99 "test: every tool must open without errors...") was red, so per rule 1 that was today's only task. `smoke.spec.js` fetches `/api/site` at module load from a hardcoded `http://127.0.0.1:${process.env.PORT || 8765}`, but `playwright.config.js` runs `php artisan serve` on port 8123 and `PORT` is never set anywhere — so the fetch always failed, `tools`/`locales` silently fell back to empty defaults, and "the site list was loaded" failed every run since that test was added (the per-language loop then trivially "passed" by iterating zero tools). Fixed by hardcoding the real port, 8123, matching `playwright.config.js`. Verified locally: `npm run build`, `npm test` (141 passed), `php artisan test` (77 passed, 7184 assertions, after `touch database/database.sqlite && php artisan migrate --force`, same as CI's "App environment" step), and the full `npx playwright test` suite (66 passed) run against local Chromium (no Google Chrome in this sandbox) via a throwaway local-only config pointing `executablePath` at `/opt/pw-browsers/chromium-1194/chrome-linux/chrome` (not committed). Pushed as 27d2c51; no backlog item was touched today.
- 2026-10-01 · CI on main was green (run #20, "test: use the configured site name in the title assertion"). Added the **Tip Calculator** (`/tip-calculator`, all 6 languages): bill amount, 15/18/20/25% presets plus a custom percentage, split between any number of people, and an optional "round up" that rounds the per-person total up to the next whole dollar (the extra is added to the tip). Logic in `resources/js/lib/tip.js` with 12 Vitest unit tests; new e2e test in `tests/e2e/tools.spec.js`. Live Semrush lookup (`phrase_this`/`phrase_these`) returned a "WRONG FORMAT OR EMPTY KEY" error, so keyword data was taken from the existing `docs/keywords/semrush-us-bulk-2026-09-30.json` export and saved to `docs/keywords/tip-calculator.json`: "tip calculator" (1.5M/mo, KD 49, used for title/H1); no close-variant volumes were available from that export, so none were invented. Added a new `receipt` icon and linked the tool from Percentage Calculator's related tools (and back). Ran `npm run build`, `npm test` (120 passed), `php artisan test` (64 passed, 5618 assertions) before pushing. `npx playwright test` could not fully verify in this sandbox: Chrome itself isn't installed (ran against local Chromium instead, same as previous runs), and every e2e test - including pre-existing, unmodified ones like the word counter and percentage calculator - fails only in its `afterEach` no-console-errors check because the sandbox's TLS-intercepting proxy breaks the page's Google Fonts request (`ERR_CERT_AUTHORITY_INVALID`), unrelated to any tool's logic; the new tip-calculator test's own body (all assertions) passed. Pushed, and CI (run #21) confirmed the new tip-calculator e2e test passes for real, but failed one pre-existing test: `site.spec.js`'s "header category menus" expected 2 tool cards on `/category/calculators` and now there are 3 (age, percentage, tip). Fixed that count and pushed again (run #22, pending).
- 2026-09-30 · Backlog re-ranked with Semrush bulk data for 90 tool keywords (docs/keywords/semrush-us-bulk-2026-09-30.json).
- 2026-09-30 · (manual session) SEO/GEO/AEO pass: all titles ≤60 and descriptions 130-160 in 6 languages, llms.txt, HowTo/Speakable/citation schema, verified sources on 15 tools, 8 category pages expanded, definitions + 9 reference tables, asset caching; new WebP to PNG / PNG to JPG / JPG to PNG pages from Semrush data (webp to png 165K, png to jpg 49.5K, jpeg to png 9.9K). All suites green.
- 2026-09-30 · Added the **JPG to PDF** tool (`/jpg-to-pdf`, all 6 languages): JPG/PNG/WebP images (JPG/PNG embedded directly via pdf-lib, WebP re-encoded to PNG via canvas) combined into one PDF with reorder, A4/Letter/Fit-image page size, automatic/manual orientation and margin controls. Live Semrush lookup returned `no_api_units`, so keyword data was taken from the existing `docs/keywords/semrush-us-2026-09-30.json` export and saved to `docs/keywords/jpg-to-pdf.json`: "jpg to pdf" (301K/mo, used for title/H1) plus "jpeg to pdf", "jpg to pdf converter" and other variants in the intro/FAQs. Linked from Merge PDF and Image Resizer's related tools. Note: CI was red on `main` before this run (a command-palette test flake); another concurrent run of this routine already fixed it and pushed two more commits, so this run rebased on top of that instead of duplicating the fix, and also fixed two tests (`ApiTest::test_category_endpoint`, `site.spec.js`'s tool-count assertions) that only needed updating for the new tool. Ran `npm run build`, `npm test` (102 passed), `php artisan test` (43 passed) and `npx playwright test` (40 passed, against local Chromium since CI's Google Chrome isn't installed here) before pushing.
- 2026-09-30 · Backlog re-ranked with Semrush US data (docs/keywords/); added WebP/PNG/JPG converter pages and Click Counter near the top.
- 2026-09-30 · Routine set up; backlog created from search-demand research and the SEO/GEO/AEO audit.
