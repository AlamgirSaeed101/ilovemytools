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
7. **Tests.** Add Vitest tests for new logic in `resources/js/lib`. Add an e2e test in `tests/e2e/tools.spec.js` that uses the tool end to end. Run everything you can locally: `npm run build && npm test && php artisan test && npx playwright test`. If PHP or Chrome aren't available in your environment, say so in the log; CI still gates the deploy.
8. **Never touch secrets or the server.** Don't edit `.env`, GitHub secrets or `scripts/cpanel/deploy.sh` credentials handling, and never SSH to the server yourself. Deploys happen only through CI.
9. **AdSense policy.** No ads inside tool UIs. No content about piracy, downloading copyrighted media (YouTube/Instagram downloaders), hacking or adult topics.
10. **Commit message:** `feat(tool): add JPG to PDF` / `seo: ...` / `fix: ...`, with a short body saying what changed.

## Backlog (in priority order)

Ranked by search demand (what iLovePDF, Smallpdf, FreeConvert and the big calculator sites put first) and
by whether the tool works well entirely in the browser.

Real US search data (Semrush, 30 Sep 2026) is in `docs/keywords/`. Use it for each new page: the
highest-volume exact phrase becomes the H1/title keyword; the next variants go in the intro, steps, headings
and FAQs. When the owner adds new Semrush exports there, re-rank the unchecked items by volume ÷ difficulty.

### New tools
- [ ] **JPG to PDF** `/jpg-to-pdf` (pdf-lib; JPG/PNG/WebP in, reorder, A4/Letter/fit, orientation, margin). Spec: TOOLS_SPEC_PROMPT Part 4 #4. *Semrush: "jpg to pdf" 301K/mo, "jpeg to pdf" 49.5K.*
- [ ] **PDF to JPG** `/pdf-to-jpg` (pdfjs-dist render, 72/150/300 DPI, single image or ZIP). Part 4 #5. *"pdf to jpg" 246K, "convert pdf to jpg" 40.5K, "pdf to jpeg" 33.1K.*
- [ ] **WebP to PNG** `/webp-to-png`, **PNG to JPG** `/png-to-jpg`, **JPG to PNG** `/jpg-to-png` (dedicated landing pages reusing the image converter engine with the format preset; batch + ZIP). *"webp to png" 165K (KD 64), "png to jpg" 49.5K, "png converter" 33.1K, "jpeg to png" 9.9K (KD 37).*
- [ ] **Click Counter / Tally Counter** `/click-counter` (big tap button, +/−, reset, several named counters, keyboard, vibration on mobile, remembers counts locally). *"click counter" 22.2K (KD 40), "tally counter" 18.1K (KD 42), "clicker counter" 9.9K.*
- [ ] **Compress PDF** `/compress-pdf` (re-save with object streams + optional page re-render at chosen quality via pdfjs; show before/after size; warn that strong mode rasterises text).
- [ ] **Unit Converter** `/unit-converter` (length, weight, temperature, area, volume, speed, data, time). Part 4 #1.
- [ ] **WebP to JPG** `/webp-to-jpg`, **PNG to WebP** `/png-to-webp` (same landing-page pattern as above).
- [ ] **HEIC to JPG** `/heic-to-jpg` (heic2any, batch, ZIP). Part 4 #8.
- [ ] **BMI Calculator** `/bmi-calculator` (metric/imperial, WHO categories, healthy weight range).
- [ ] **Loan / EMI Calculator** `/loan-calculator` (amount, rate, term; monthly payment, total interest, amortisation table).
- [ ] **Mortgage Calculator** `/mortgage-calculator` (price, deposit, rate, term, optional tax/insurance; amortisation table).
- [ ] **Rotate PDF** `/rotate-pdf` (per page or all pages, 90/180/270). Part 4 #6.
- [ ] **Add Page Numbers to PDF** `/add-page-numbers-to-pdf`. Part 4 #6.
- [ ] **Watermark PDF** `/watermark-pdf` (text, size, opacity, angle, position). Part 4 #6.
- [ ] **Image to Text (OCR)** `/image-to-text` (tesseract.js with language data served from `/public`, not a CDN). Part 4 #7.
- [ ] **Character Counter** `/character-counter` (limits for X/Twitter, Instagram, meta title/description, SMS).
- [ ] **Text to Speech** `/text-to-speech` (Web Speech API, voice/rate/pitch; note browser support).
- [ ] **Colour Picker & Converter** `/color-picker` (HEX/RGB/HSL, contrast ratio). Part 4 #12.
- [ ] **Lorem Ipsum Generator** `/lorem-ipsum-generator`. Part 4 #2.
- [ ] **Date Difference Calculator** `/date-calculator` (days between dates, add/subtract days, business days).
- [ ] **Discount Calculator** `/discount-calculator` and **Tip Calculator** `/tip-calculator`.
- [ ] **GPA Calculator** `/gpa-calculator`.
- [ ] **Text Diff Checker** `/text-diff-checker`. Part 4 #3.
- [ ] **Hash Generator** `/hash-generator`, **UUID Generator** `/uuid-generator`. Part 4 #10-11.
- [ ] **Barcode Generator** `/barcode-generator`. Part 4 #9.
- [ ] **Time Zone Converter** `/time-zone-converter` (Intl time zones, meeting planner row).
- [ ] **Remove Image Background** `/remove-background` (in-browser segmentation model; only if the model is under ~10 MB and loads lazily).

Not planned: PDF↔Word/Excel/PowerPoint (can't be done well in the browser), video/audio converters (too heavy), social-media downloaders (AdSense and copyright risk).

### SEO / GEO / AEO (from the audit of 30 Sep 2026, Desktop report)
- [ ] Rewrite meta descriptions that get truncated with "…" (home + 5 localised homes + 3 localised Word Counter pages); lengthen /terms, /contact and /about descriptions to 140-155 chars (all 6 languages).
- [ ] Shorten the 16 titles longer than 60 characters (all languages).
- [ ] Long-cache hashed assets: `Cache-Control: public, max-age=31536000, immutable` for `/build/*` in `public/.htaccess`; remove the `X-Powered-By` header.
- [ ] Add `/llms.txt` (generated like the sitemap: site summary, every tool with one line, languages).
- [ ] Expand each of the 8 category pages to 300+ unique words: when to use which tool, a comparison table and 3-4 FAQs (plus FAQPage schema). All languages.
- [ ] Add one reference table per tool where it helps answers (image sizes, bedtime chart, percentage formulas, QR error-correction levels, dice types…).
- [ ] Cite real sources with outbound links for factual claims (sleep hours, coin-flip bias study, Base64 spec…). Only cite pages you fetched and checked.
- [ ] Show "Last updated" on tool pages and add `dateModified` to the WebApplication schema.
- [ ] Per-tool Open Graph images (tool name + icon, generated at build time).
- [ ] Rephrase statement H2s as questions where natural, and open each tool intro with a one-line "X is…" definition.
- [ ] HowTo and SpeakableSpecification schema on tool pages.
- [ ] *(owner input)* About page: real founder name, bio and founding date; Person schema linked as Organization.founder.
- [ ] *(owner input)* Brand social profiles in Organization.sameAs and the footer.

## Log

<!-- One line per run, newest first: YYYY-MM-DD · what changed · CI result -->
- 2026-09-30 · Backlog re-ranked with Semrush US data (docs/keywords/); added WebP/PNG/JPG converter pages and Click Counter near the top.
- 2026-09-30 · Routine set up; backlog created from search-demand research and the SEO/GEO/AEO audit.
