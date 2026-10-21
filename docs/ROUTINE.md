# Daily improvement routine

This file drives the scheduled Claude routine that improves ilovemytools.store every day.
Each run: read this file, do the **first unchecked item** in the backlog (or the first failing-CI fix),
test, commit, push to `main`, and add ONE short line (max 300 characters) to `docs/routine-log.md`. GitHub Actions
(`.github/workflows/deploy.yml`) runs every test suite and deploys only if all of them pass.

Read Parts 1-2 of `TOOLS_SPEC_PROMPT.md` (architecture, SEO rules: lines 1-87) before changing anything. Read Part 3/4 only for the one tool you are working on (grep its name), not the whole file.

**Save tokens (weekly limit):** never create reports, screenshots or extra docs; images only when a new tool needs its share image (scripts/og-images.mjs, new tools only, never --force). keep command output short (`| tail -20`, `--reporter=line`, `-q`), read only the files and line ranges you need, never print whole lang files or build output, and work alone (no subagents).

## Rules (never break these)

1. **Start with CI.** Run `gh run list --limit 3`. If the latest run on `main` failed, fixing it is today's task: open the log (`gh run view <id> --log-failed`), fix the cause, and push. Nothing else until CI is green.
2. **One item per run.** One new tool, or one SEO item. Small, finished, tested changes. Never leave half-built work on `main`.
3. **Everything runs in the browser.** No paid APIs, no API keys, no server-side file processing, no new server endpoints. Heavy libraries are lazy-loaded inside the tool.
4. **Every language in `config/locales.php` (now 10: en, es, pt, fr, de, it, pl, ko, zh, ur).** Every new or CHANGED text (including reworded headings, titles, descriptions and FAQs) must be updated in ALL of them, not only es, pt, fr, de and it. Urdu is right-to-left; Chinese is Traditional (Taiwan/Hong Kong):
   - share image: run `node scripts/og-images.mjs` (draws public/images/og/{slug}.jpg; PagesTest fails without it); add real `sources` (standards, specs, research) where facts or formulas are used;
   - interface strings: `t('...')` in JSX, then `node scripts/i18n-extract.mjs` and add each new key to `lang/{es,pt,fr,de,it,pl,ko,zh,ur}.json` (plural objects where needed, keep `{placeholders}`);
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
    - <what visitors will notice, e.g. "New Tip Calculator at ilovemytools.store/tip-calculator (10 languages)">
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
13. **LinkedIn.** Do nothing for LinkedIn. A separate routine (trig_01VFS234jmvk89a4DutEGqbd, weekdays 08:00 UTC) posts to the owner's profile via Zapier and keeps `docs/linkedin-log.md`. Never edit that log yourself.
14. **SEO / GEO / AEO on top pages (every 3 hours).** Routine trig_01N2Jft7zA1zDR56Mm9R9ntm runs every 3 hours at :37 UTC (hourly used up the weekly Claude limit on 14 Oct) and deploys every change right away once all tests pass (owner's choice, 14 Oct 2026), because every deploy clears the site caches and briefly risks 5xx errors. It refreshes `docs/seo-targets.md` once a day from Search Console + GA4 (every page with at least one impression, up to 100, ranked by clicks then impressions, with their top queries), improves ONE of those pages per run in every language (the highest-ranked one not improved in the last 7 days, so lower pages get work while the top ones cool down), and logs it in `docs/seo-audit.md`. When every listed page is still within its 7 days it stops without a log line or commit (on 18-21 Oct about 20 idle runs logged "no eligible target" and 3 of them triggered pointless deploys). A commit that changes only files under docs/ always ends with [skip ci]. Pages with no impressions are not worked on. The daily new-tools routine (trig_0121zRuvBajgQns77NiGBoRy) is paused since 13 Oct 2026 so all effort goes to pages people already find. Titles stay plain and descriptive (main query first, then a clear benefit, e.g. "Bulk Domain Authority Checker - Free, 100 at Once"); never sales-style patterns like "100 Free, No Signup": after that rewrite on 13 Oct Google dropped the page from its index. If a page falls out of the index or loses most impressions within days of a change, revert that change first.
15. **Site-health guard (daily).** Routine trig_01RTgXMSXLZtSQh5P6SGrXKp (05:07 UTC, when no deploy runs) runs `node scripts/seo-health.mjs` (crawls every sitemap page plus every internal and outbound link) and treats every ranking risk as its job. It FIXES on its own, in every language: redirecting or non-200 sitemap URLs, wrong canonicals, hreflang to missing pages, invalid or wrongly-typed JSON-LD, titles over 60 / descriptions outside 110-160 chars (CJK may be shorter), missing or extra H1s, images without alt, broken internal links, and outbound links that are dead (404/410/DNS) on 3 daily runs in a row (`docs/health-state.json` counts the days; one bad day never removes anything). It also REMOVES from the site any badge or `same_as` profile whose listing is dead, no longer links to the site, or is a paid/spam directory (sponsored + nofollow only, or flagged as spam); it never removes a whole page, tool, language or guide, and never adds `noindex` without the owner. Things only the owner can change (DNS, hosting speed, the GoDaddy/Sucuri firewall or injected scripts, disavowing bad inbound links, unfinished directory listings) go under "Waiting on you" in the daily issue #1 comment, once, not every day. StartupBase rejected the site on 15 Oct 2026 (their policy excludes free online tools, converters and generators); do not re-add its badge. Never buy listings or links (e.g. paid dofollow boards): that is a Google link scheme.
16. **Backlink prospector (weekdays).** Routine trig_01X7E7GYtiXNoe88eJUAj9xr (06:07 UTC Mon-Fri; mailbox warm-up: 10 drafts a day until 27 Oct, 20 until 3 Nov, then 30; email prospects only, no typed sign-off because Outlook adds the signature; the owner says "send them" and Claude sends the batch from hello@) finds "best free tools" roundup articles and resource pages, checks each site's authority and whether its links are dofollow, finds the author or contact page, and drafts ONE short personal email per prospect into `docs/outreach/prospects.md` and the issue #1 comment as one-click `mailto:` links. It never sends emails, fills contact forms, signs up anywhere, comments or offers payment: the owner reads and sends each email. It skips pay-to-list pages and competitors' own blogs, never pitches the same site twice, suggests one follow-up 7 days after the owner marks a pitch `sent`, and re-checks pitched articles: when one starts linking to ilovemytools.store it records `linked (dofollow|nofollow)`.

## Backlog (in priority order)

- AdSense was **rejected for "Low value content" on 12 Oct 2026**. The plan: a new guide every 2 days until 30 Nov (guide routine), tool pages link to their guides, and steady Search Console growth. The owner requests a review in December, not before. Never add thin pages, doorway pages or auto-generated text to pad the site.
- [ ] *(owner input)* When the owner says Google AdSense has **approved** the site, set `site.ads.adblock_notice` to `true` in `config/site.php` (the ad-block request, closable for 7 days) and deploy. Keep it `false` until then.

Ranked by search demand (what iLovePDF, Smallpdf, FreeConvert and the big calculator sites put first) and
by whether the tool works well entirely in the browser.

Real US search data (Semrush, 30 Sep 2026) is in `docs/keywords/`. Use it for each new page: the
highest-volume exact phrase becomes the H1/title keyword; the next variants go in the intro, steps, headings
and FAQs. When the owner adds new Semrush exports there, re-rank the unchecked items by volume ÷ difficulty.

### High-revenue tools (do these first, from 3 Oct 2026)
Finance topics have much higher ad prices in the US/UK/EU than file tools. Before building each one, check
volume and CPC in Semrush (`us`, `uk`, `de`) and save the data in `docs/keywords/`.
- [x] **Mortgage Calculator** `/mortgage-calculator` (monthly payment, amortization table, extra payments; US and UK wording).
- [x] **Loan Calculator** `/loan-calculator` (payment, total interest, amortization schedule).
- [x] **Compound Interest Calculator** `/compound-interest-calculator` (monthly contributions, chart, table).
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
- [x] **PDF to JPG** `/pdf-to-jpg` and **PDF to PNG** `/pdf-to-png` (pdfjs-dist render, 72/150/300 DPI, ZIP). *246K (KD 81) / 74K (KD 56).*
- [ ] **Barcode Generator** `/barcode-generator` (JsBarcode: CODE128, EAN-13, UPC-A, CODE39; PNG/SVG). *823K (KD 60).*
- [ ] **HEIC to JPG** `/heic-to-jpg` (heic2any, batch, ZIP). *246K (KD 71).*
- [x] **Compress PDF** `/compress-pdf` (object-stream re-save + optional re-render at chosen quality; before/after size; warn that strong mode rasterises text). *110K "compress pdf" (KD 74) + 74K "pdf compressor" (KD 67).*
- [x] **Compound Interest Calculator** `/compound-interest-calculator` (principal, rate, years, compounding, monthly contributions, yearly table). *1.22M (KD 66).* Done 13 Oct 2026 - see the High-revenue tools item above.
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
- [x] **Rotate PDF** `/rotate-pdf`. *8.1K (KD 47).*
- [x] **Delete PDF Pages** `/delete-pdf-pages` and **Organize PDF** `/organize-pdf` (page thumbnail grid: pick pages to remove, or drag/keyboard reorder). Not on the ranked list below (no Semrush volume data found for either), but requested directly and genuinely useful alongside Rotate PDF.
- [x] **PDF to Word** `/pdf-to-word`, **Word to PDF** `/word-to-pdf`, **Excel to PDF** `/excel-to-pdf`, **PDF to Excel** `/pdf-to-excel`, **HTML to PDF** `/html-to-pdf`. Not on the ranked list below (requested directly), and specifically contradicted the "Not planned" note from 2026-09-30 that PDF↔Word/Excel "can't be done well in the browser" - revisited 2026-10-04 with a browser-only best-effort approach (see that day's log) rather than taken as settled.
- [ ] **Add Page Numbers to PDF** `/add-page-numbers-to-pdf`, **Watermark PDF** `/watermark-pdf`. *2.4K (KD 39) / 1.3K (KD 40).*
- [ ] Later (huge but very hard, KD 83-100): BMI 4.09M, mortgage 3.35M, loan 1.5M, calorie 3.35M, time zone converter 550K, text to speech 246K, colour picker 550K, remove background 673K, scientific calculator 1M. Build only after the easier items are done.

Not planned: PDF↔PowerPoint (no permissively-licensed in-browser library renders real slide content well enough - see 2026-10-04 log entry), video/audio converters (too heavy), social-media downloaders (AdSense and copyright risk), pregnancy/due-date calculators (medical advice risk).

### SEO / GEO / AEO (from the audit of 30 Sep 2026, Desktop report)
- [x] Rewrite meta descriptions that get truncated with "…" (home + 5 localised homes + 3 localised Word Counter pages); lengthen /terms, /contact and /about descriptions to 140-155 chars (all 6 languages).
- [x] Shorten the 16 titles longer than 60 characters (all languages).
- [x] Long-cache hashed assets: `Cache-Control: public, max-age=31536000, immutable` for `/build/*` in `public/.htaccess`; remove the `X-Powered-By` header.
- [x] Add `/llms.txt` (generated like the sitemap: site summary, every tool with one line, languages).
- [x] Expand each of the 8 category pages to 300+ unique words: when to use which tool, a comparison table and 3-4 FAQs (plus FAQPage schema). All languages.
- [x] Add one reference table per tool where it helps answers (image sizes, bedtime chart, percentage formulas, QR error-correction levels, dice types…).
- [x] Cite real sources with outbound links for factual claims (sleep hours, coin-flip bias study, Base64 spec…). Only cite pages you fetched and checked.
- [x] Show "Last updated" on tool pages and add `dateModified` to the WebApplication schema.
- [x] Per-tool Open Graph images (tool name + icon, generated at build time). **Done** — `scripts/og-images.mjs` already draws one per tool (name, icon, category, tagline) into `public/images/og/{slug}.jpg`; verified all 52 tools have one.
- [ ] Rephrase statement H2s as questions where natural (e.g. "Common image sizes" -> "What size should my image be?"), all languages. (Intro definitions are done.) **In progress** — Mortgage Calculator and Loan Calculator done 12 Oct 2026 (highest-revenue pages); Image Resizer done 12 Oct 2026; Word Counter and Case Converter done 13 Oct 2026; Password Generator and QR Code Generator done 13 Oct 2026; JPG to PDF and Merge PDF done 13 Oct 2026; Percentage Calculator and JSON Formatter done 13 Oct 2026. ~30 tools still have statement H2s; continue a few per run.
- [x] HowTo and SpeakableSpecification schema on tool pages.
- [x] Homepage FAQ (4-5 questions such as "Are these tools really free?", "Are my files uploaded?") with FAQPage schema, all languages. *(quick audit 30 Sep)* **Done** — `AppSupportHomeFaq` with FAQPage schema on every language home page (checked live 13 Oct 2026).
- [ ] Tools without them get a one-line definition, a reference table and 2-3 cited sources, like /image-compressor (start with /merge-pdf, /split-pdf). *(quick audit 30 Sep)*
- [x] *(owner input)* OPcache enabled (3 Oct 2026): uncached pages went from ~1.8 s to ~0.6 s to first byte, the same as a static file. What remains is distance to the Singapore server (moving hosting to the US would help US visitors).
- [x] *(owner input, REMIND on 4 Oct 2026)* Connect **Google Search Console** to Windsor.ai while logged in to the Windsor account **talibhussain.monzo@gmail.com** (Google account mas032746@gmail.com is fine): https://onboard.windsor.ai/connect?connector=searchconsole&next=/searchconsole/authorize then tick ilovemytools.store and Finish. It was connected to a different Windsor account (mas032746). **Done by 4 Oct 2026** — confirmed connected (account `sc-domain:ilovemytools.store`), though it's returning 0 rows for the last 28 days so far (see `docs/search-console.md`).
- [x] *(owner input, REMIND on 4 Oct 2026)* Connect **Google Analytics 4** (property with ID G-GMWZ0PJW1R) the same way: https://onboard.windsor.ai/connect?connector=googleanalytics4&next=/googleanalytics4/authorize then select the GA4 property and Finish. **Done by 4 Oct 2026** — confirmed connected (account `517324997`, "ilovemytools.store"); data is flowing (see `docs/search-console.md`).
- [x] *(owner input)* About page: real founder name, bio and founding date; Person schema linked as Organization.founder. **Done 9-10 Oct 2026** — M Alamgir Saeed is named on the About page and as Organization.founder with his LinkedIn (`config/site.php` `founder`). A longer bio or founding date can be added if the owner sends one; don't list it under "Waiting on you".
- [x] *(owner input)* Brand social profiles in Organization.sameAs and the footer. **Done 10 Oct 2026** — LinkedIn company page in the footer and `sameAs` (plus Uneed). Add more only if the owner sends them.
- [x] German "verkleinern" (shrink/resize) query cluster on `/de/image-compressor` - real Search Console demand (~39 impressions/28 days across "jpg verkleinern online", "png größe verkleinern", "png verkleinern", "jpg größe verkleinern" and 8 more variants, mostly position 13-28). Same pattern as the `/de/word-counter` fix done 5 Oct 2026: check the German title/H1/description foreground "verkleinern" clearly, and that the FAQs cover the exact phrases above. See `docs/search-console.md` 2026-10-05 entry for the full list.
- [ ] `/domain-authority-checker` CTR anomaly (9 Oct 2026): 241 Search Console impressions/28 days across 14 "bulk domain authority ..." query variants at a genuinely good average position (7.8, several at 2.6-6.6), but 0 clicks total. Title/description/H1/FAQ already lead with the exact phrase, so this isn't an obvious wording fix - worth checking the rendered SERP snippet (rich result markup, favicon, any truncation Search Console doesn't show) and whether the impressions are rank-tracking bots rather than people, before changing anything. See `docs/search-console.md` 2026-10-09 entry.

## Log

Older entries: `docs/routine-log.md` (do NOT read it unless a task needs history; append new entries there, newest at the bottom).
Each entry is ONE line of at most 300 characters: date · what changed · URLs. Details belong in the commit message.

- 2026-10-09: New Loan Calculator at ilovemytools.store/loan-calculator (10 languages): payment, interest, amortization schedule. Organic Search sessions: 10 this week (first time >1). Flagged a 0-click/good-position /domain-authority-checker anomaly for a future run.
- 2026-10-13: New Compound Interest Calculator at ilovemytools.store/compound-interest-calculator (10 languages): contributions, any compounding frequency, growth chart, table. Checked /domain-authority-checker CTR anomaly again (still 0 clicks); ruled out a noindex bug, likely rank-tracker traffic.
