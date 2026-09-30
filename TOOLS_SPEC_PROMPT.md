# MASTER PROMPT - Toolzy Free Online Tools Website (Complete Tool Specifications)

> **How to use this file:** paste it (or the relevant sections) into an AI assistant together with your request, for example *"Using the master prompt below, add the Unit Converter tool"* or *"Using the master prompt below, fix a bug in Split PDF"*. It describes exactly how the project is built and how every tool must work, so any future change stays consistent, SEO-friendly, ad-ready and bug-free.

---

## PART 1 - PROJECT CONTEXT (always include this part)

You are a senior full-stack developer working on **Toolzy**, a free online tools website run as a side business funded by Google AdSense. The brand name comes from `APP_NAME` in `.env` and may change, so never hard-code it.

### 1.1 Tech stack
- **Backend:** Laravel 12 (PHP 8.2+). No database. Blade templates render every page server-side.
- **Frontend:** React 19 + Vite 8 (via `laravel-vite-plugin`). Plain CSS in `resources/css/app.css` (CSS variables at the top, no CSS framework).
- **Libraries (all free, MIT/Apache):** `pdf-lib` (PDF), `jszip` (ZIP downloads), `qrcode` (QR codes). Everything else uses browser APIs: Canvas, Web Crypto, TextEncoder, Intl, Clipboard, Blob/URL.
- **Tests:** PHPUnit feature tests (`tests/Feature`) and Vitest unit tests (`resources/js/lib/*.test.js`).

### 1.2 Non-negotiable rules
1. **Zero running cost.** No paid APIs, no API keys, no server-side file processing. Every tool runs 100% in the visitor's browser. The only server endpoint is `/api/ip`.
2. **Privacy.** Files and text never leave the device. Never add analytics events that include user content.
3. **No bugs, no console errors.** Every input is validated. Every error shows a friendly message in plain English (never "NaN", "undefined", "Infinity" or a raw stack trace). Buttons are disabled when an action is impossible. Wrap tools in the existing `ErrorBoundary`.
4. **SEO first.** Every tool page is server-rendered with unique title, description, H1, content and FAQs (see Part 2).
5. **Ad-ready.** Use the existing ad slots only; never place ads inside the tool UI or where they could be clicked by accident (AdSense policy).
6. **User friendly.** Works on 375px-wide phones with no horizontal scrolling, keyboard accessible, labels on every input, results announced with `aria-live`.
7. **Fast.** Each tool is lazy-loaded (`React.lazy`) into its own chunk. Heavy libraries are imported inside the tool (or dynamically, like `jszip`) so other pages never download them.

### 1.3 File layout and how a tool is wired
```
config/tools.php          SEO + content for every tool (the key = URL slug)
config/categories.php     Category landing pages
routes/web.php            /{tool} route matches only slugs from config/tools.php
app/Support/Seo.php       <title>, meta, canonical, OG/Twitter, JSON-LD
app/Support/ToolRegistry  Lookups, categories, related tools
app/Support/Ads.php       Ad slot logic (live / placeholder / hidden)
resources/views/pages/tool.blade.php   Tool page template (H1, tool mount, article, FAQ, related)
resources/js/app.jsx      Mounts the React tool into <div id="tool-root" data-tool="slug" data-props="{...}">
resources/js/tools/index.js   slug -> lazy(() => import('./Tool.jsx'))
resources/js/tools/*.jsx  One component per tool
resources/js/lib/*.js     Pure logic (unit tested) + browser helpers (image.js, pdf.js, util.js)
resources/js/components/  CopyButton, Dropzone, ErrorBoundary, ui.jsx (Notice, Stat, Tabs)
```

**To add a tool:** (1) add the config entry, (2) create the React component, (3) register the slug in `tools/index.js`, (4) put pure logic in `resources/js/lib` with Vitest tests, (5) `npm run build`, (6) `php artisan test && npm test`. Sitemap, breadcrumbs, schema, footer and related links update automatically.

### 1.4 Shared UI building blocks (reuse, don't reinvent)
- `Dropzone` - drag & drop + click + keyboard (Enter/Space). Props: `accept`, `multiple`, `isAccepted(file)`, `onFiles(files)`, `onReject(badFiles)`, `title`, `hint`, `compact`. Resets the input so the same file can be chosen twice.
- `CopyButton` - uses the Clipboard API with a textarea fallback; shows "Copied!" for 2 s or "Press Ctrl+C" if blocked; disabled when there is nothing to copy.
- `Notice type="error|warn|success|info"` - renders nothing when empty. Errors use `role="alert"`.
- `Stat`, `Tabs` (ARIA tablist), `.result` box with `.result__formula`.
- `util.js`: `formatBytes`, `downloadBlob` (revokes the object URL after 30 s), `downloadText`, `copyToClipboard`, `baseName`, `safeFilename`, `uniqueNamer` (dedupes ZIP entry names).
- CSS classes: `.stack`, `.row`, `.grid-2`, `.field`, `.input`, `.select`, `.textarea(--code)`, `.btn(--primary|--sm|--lg|--danger|--ghost)`, `.file-list/.file-item`, `.badge`, `.stats/.stat`.

### 1.5 Output file naming
Always descriptive and safe: `photo-compressed.jpg`, `logo-400x300.webp`, `merged.pdf`, `report-pages-1-3.pdf`, `report-split.zip`, `qr-code-wifi.png`, `formatted.json`, `converted-text.txt`. Use `safeFilename()` on anything derived from the user's filename.

---

## PART 2 - SEO & ADS SPECIFICATION (apply to every page)

### 2.1 Config entry for each tool (`config/tools.php`)
| Field | Rule |
|---|---|
| key (slug) | lowercase-hyphenated main keyword, e.g. `image-compressor` |
| `name` | Short display name |
| `category` | One of the keys in `config/categories.php` |
| `icon` | One of the names in `app/Support/Icon.php` |
| `popular` | `true` shows it in "Popular tools" |
| `updated` | `YYYY-MM-DD`, used for sitemap `lastmod` and schema `dateModified` |
| `title` | ≤ 60 characters, main keyword first, benefit words ("Free", "Online"). Brand is appended automatically only when it still fits in 65. |
| `description` | 140-160 characters, contains the main keyword + a benefit + "free"/"no sign up" |
| `h1` | The exact phrase people search for |
| `tagline` | One sentence under the H1 and on tool cards |
| `keywords` | 4-6 target phrases (used for site search, not for a meta keywords tag) |
| `intro` | 2-4 sentences, keyword in the first sentence |
| `steps` | 3-5 "How to use" steps |
| `features` | 4-6 short bullet points |
| `content` | 1-3 sections `{heading, body}` answering related questions (unique text, never copied) |
| `faqs` | 4-5 real questions `{q, a}`; shown on the page AND output as FAQPage schema |
| `related` | 2-4 slugs for internal linking |

### 2.2 What every page already outputs (keep it that way)
`<html lang="en">`, one `<h1>`, `<title>`, meta description, `robots` (noindex on 404s), canonical from `APP_URL`, Open Graph + Twitter card with the 1200×630 image, JSON-LD (Organization, WebSite, BreadcrumbList, plus WebApplication + FAQPage on tools, ItemList on home, CollectionPage on categories), visible breadcrumbs, related tools, category sidebar, footer links to every tool, favicon set and web manifest. `/sitemap.xml`, `/robots.txt` (blocks all outside production) and `/ads.txt` (from `ADSENSE_CLIENT`) are generated dynamically.

### 2.3 Ad slots
Positions: `header` (under the title), `below_tool` (best earner), `sidebar` (desktop only, 600px tall), `in_content` (after the first article section), `footer`. Each reserves its height with `min-height` to avoid layout shift. Include with `@include('partials.ad', ['position' => 'below_tool'])`. Placeholders appear only when `APP_ENV=local` and no AdSense client is set.

---

## PART 3 - COMPLETE TOOL SPECIFICATIONS (current 13 tools)

Each spec lists: URL · category · target keywords → purpose → inputs & options → exact processing logic → outputs → validation & error messages → edge cases → acceptance tests.

---

### 3.1 Word Counter
**URL** `/word-counter` · **Category** Text Tools · **Keywords** word counter, character counter, word count, reading time calculator
**Files** `tools/WordCounter.jsx`, logic `lib/text.js` (`textStats`, `keywordDensity`, `formatDuration`)

**Purpose:** Live statistics about any text.

**Inputs:** one textarea (no length limit). Buttons: Copy, Clear (disabled when empty).

**Logic:**
- *Words:* split on whitespace; strip leading/trailing punctuation from each token; count tokens containing at least one Unicode letter or number (`\p{L}\p{N}`). "It's" and "well-known" = 1 word each; a lone "-" is not a word; accented and non-Latin words count.
- *Characters:* count grapheme clusters with `Intl.Segmenter` (emoji like 👍🏽 = 1), fallback `Array.from`. *Characters without spaces:* same after removing all whitespace.
- *Sentences:* split on `. ! ? …` followed by whitespace or end; count parts containing a letter/number ("1.5" does not split).
- *Paragraphs:* split on blank lines; count non-empty parts. *Lines:* number of line breaks + 1 (0 when empty).
- *Reading time:* words ÷ 238 wpm; *speaking time:* words ÷ 150 wpm; rounded up to seconds; formatted "0 sec", "45 sec", "2 min 5 sec", "1 hr 1 min".
- *Top keywords:* lowercase words, skip words < 3 letters, pure numbers and ~130 English stop words; top 10 by count (ties alphabetical); show count and % of total words (1 decimal).
- Use `useDeferredValue` so typing stays smooth with huge texts.

**Outputs:** 5 stat tiles (Words, Characters, Characters no spaces, Sentences, Paragraphs), a line with reading/speaking time and lines, keyword chips.

**Acceptance:** `"Hello world. This is SEO text!\n\nSEO matters."` → 8 words, 3 sentences, 2 paragraphs, "seo 2" keyword. Empty or whitespace-only → all zeros.

---

### 3.2 Case Converter
**URL** `/case-converter` · **Category** Text Tools · **Keywords** case converter, uppercase to lowercase, title case converter, sentence case, camelcase converter
**Files** `tools/CaseConverter.jsx`, logic `lib/text.js` (`convertCase`, `CASES`)

**Inputs:** textarea; 11 buttons (disabled while empty); Copy, Download .txt, Clear. The last used case button is highlighted until the text is edited.

**Conversions (in place on the textarea):**
- UPPERCASE / lowercase - `toLocaleUpperCase/LowerCase` (handles é, ü, ß→SS).
- **Title Case** - per line; capitalise every word except small words (a, an, the, and, but, or, nor, for, so, yet, as, at, by, in, of, off, on, per, to, up, via, vs) unless first or last word of the line; capitalise each part of hyphenated words ("Well-Known").
- **Sentence case** - lowercase everything, capitalise the first letter after start, `.`, `!`, `?` or a new line; standalone "i" → "I".
- **camelCase / PascalCase / snake_case / kebab-case / CONSTANT_CASE** - per line: split camel humps (`helloWorld` → hello world, `XMLHttpRequest` → xml http request) and any non-alphanumeric separators, then join.
- **aLtErNaTiNg** - alternate lower/upper on letters only. **InVeRsE** - swap the case of each character.

**Outputs:** updated textarea, word/character count, `converted-text.txt` download.

**Acceptance:** "the lord of the rings" → Title "The Lord of the Rings" → snake "the_lord_of_the_rings"; "HELLO THERE. how ARE you? i am fine!" → Sentence "Hello there. How are you? I am fine!".

---

### 3.3 Password Generator
**URL** `/password-generator` · **Category** Generators · **Keywords** password generator, strong password generator, random password generator
**Files** `tools/PasswordGenerator.jsx`, logic `lib/password.js`

**Inputs:** length slider 4-128 (default 16) + number box (typing is free; only valid 4-128 values apply; the box resets on blur); checkboxes Uppercase, Lowercase, Numbers, Symbols (`!@#$%^&*()-_=+[]{};:,.<>?/~`), Exclude similar characters (removes `i l 1 L o O 0 I |`). All four types on by default.

**Logic:**
- Randomness only from `crypto.getRandomValues`, unbiased via rejection sampling (`randomInt(max)`). Never `Math.random`.
- Pick 1 guaranteed character from each selected set, fill the rest from the combined pool, then Fisher-Yates shuffle with the crypto RNG.
- Regenerate automatically whenever any option changes and on page load.
- Entropy bits = `length × log2(poolSize)`. Strength: < 40 Very weak (red), 40+ Weak, 60+ Good, 80+ Strong, 100+ Excellent (dark green); coloured meter bar.

**Outputs:** read-only field (selects all on focus), ↻ New and Copy buttons, strength text and bits.

**Validation:** no character type selected → error "Select at least one character type.", Generate and ↻ disabled, meter empty.

**Acceptance:** length always exact; every selected type present even at length 4; excluded characters never appear; only-numbers → `^[0-9]{n}$`.

---

### 3.4 QR Code Generator
**URL** `/qr-code-generator` · **Category** Generators · **Keywords** qr code generator, free qr code generator, wifi qr code, qr code maker
**Files** `tools/QrCodeGenerator.jsx`, logic `lib/qr.js`, library `qrcode`

**Types (tabs) and payloads:**
| Type | Fields | Payload |
|---|---|---|
| URL | url | adds `https://` if no scheme |
| Text | text | as typed |
| Wi-Fi | ssid, security (WPA/WEP/none), password, hidden | `WIFI:T:WPA;S:<ssid>;P:<pw>;H:true;;` with `\ ; , : "` escaped by `\`; no `P:` when no password |
| Email | email, subject, body | `mailto:to?subject=…&body=…` (URI-encoded) |
| Phone | phone | `tel:+digits` (keeps only digits and +) |
| SMS | phone, message | `SMSTO:+digits:message` |

**Options (collapsible):** QR colour (default #000000), background (#ffffff), size 128-1024 px (step 32, default 512), error correction L/M/Q/H (default M), margin 0/1/2/4/6/8 modules (default 4).

**Logic:** live preview rendered to a canvas with `QRCode.toCanvas` whenever payload or options change (cancel stale renders). PNG download = `canvas.toBlob` at the chosen size; SVG download = `QRCode.toString({type:'svg'})`.

**Validation & warnings:** empty/invalid fields show a hint in the preview area and disable downloads ("Enter a website address.", "Enter the Wi-Fi password, or choose \"No password\".", "Enter a valid email address.", "Enter a valid phone number."). Too much data → "That is too much data for one QR code…". WCAG contrast < 3 → "colours are too similar" warning; light-on-dark → "may not scan" warning; margin < 2 → warning.

**Acceptance:** "example.com" gives a 512×512 PNG and a valid SVG; Wi-Fi with `Cafe;Guest` escapes to `Cafe\;Guest`; 5,000 characters of text shows the too-much-data error.

---

### 3.5 Image Compressor
**URL** `/image-compressor` · **Category** Image Tools · **Keywords** image compressor, compress image, compress image to 100kb, reduce image size, compress jpg
**Files** `tools/ImageCompressor.jsx`, helpers `lib/image.js`, `jszip`

**Inputs:** Dropzone (multiple) accepting JPG, PNG, WebP; max 30 images per batch, 50 MB each. Mode tabs: **Quality** (slider 10-100 %, default 75) or **Target size** (KB number, default 100, min 5). Output format: Same as original / JPG / WebP / PNG. Optional max width (px).

**Logic (per image, processed one at a time to limit memory):**
1. Decode with an `<img>` from an object URL (EXIF orientation applied by the browser).
2. Output type: "same" keeps JPG/PNG/WebP; WebP falls back to JPG (with a note) when the browser can't encode WebP (old Safari).
3. Dimensions: limit to max width (keeping aspect ratio) and to 10,000 px per side.
4. Draw with high-quality smoothing, halving in steps for big reductions; JPG gets a white background (no black transparency).
5. **Quality mode:** encode once at the chosen quality. If the result is not smaller than the original, the format is unchanged and no max width is set, keep the original file and label it "Already optimised".
6. **Target mode:** for JPG/WebP binary-search quality between 0.05 and 0.95 (7 steps) for the highest quality under the target; if even 0.05 is too big, shrink dimensions by 20 % and retry (up to 14 rounds, min 16 px). For PNG only shrink dimensions. If the target is impossible, return the smallest version with the note "Could not reach the target size…".

**Outputs:** list rows with thumbnail, name, original size → new size, dimensions, green "−NN %" badge (or grey "+NN %"), notes, Download and ✕ buttons; summary "N images: before → after (NN % smaller)"; "Download all (ZIP)" when 2+ are done (`compressed-images.zip`, duplicate names become "name (2).jpg"); Clear all. Changing settings after compressing shows "Settings changed. [Re-compress all]".

**Validation:** non-image files → error listing the file names; > 50 MB → skipped with a warning; > 30 files → extra files ignored with a warning; decode failure → red error on that row only.

**Acceptance:** 7 MB 3000×2000 JPG at 75 % → ~75 % smaller; target 100 KB → output ≤ 100 KB; ZIP of 3 images contains 3 files.

---

### 3.6 Image Resizer & Converter
**URL** `/image-resizer` · **Category** Image Tools · **Keywords** image resizer, resize image, png to jpg, jpg to png, webp to jpg
**Files** `tools/ImageResizer.jsx`, helpers `lib/image.js`

**Inputs:** one image (JPG, PNG, WebP, GIF, BMP; max 50 MB). Tabs: **By pixels** (width, height, "Lock aspect ratio" on by default) or **By percentage** (slider 5-200 %). Save as JPG/PNG/WebP (defaults to the original format, PNG for GIF/BMP). Quality slider 10-100 % (hidden for PNG, default 90).

**Logic:** with the lock on, editing width recalculates height = round(w × h₀ / w₀) and vice versa. Render with the same `renderImage` pipeline as the compressor. Any change to settings clears the previous result so the user never downloads a stale image.

**Outputs:** preview (original, then the resized result on a checkerboard background), success bar "Resized to W × H px · size" with "Download image" → `name-WxH.ext`. "Choose another image" resets.

**Validation:** width/height < 1 → "Enter a width and height of at least 1 pixel."; > 10,000 → "The maximum size is 10,000 pixels per side." (button disabled); PNG → JPG shows "transparent areas become white".

**Acceptance:** 800×600 PNG, width 400 → height 300, WebP output named `logo-400x300.webp` with a valid RIFF/WEBP header.

---

### 3.7 Merge PDF
**URL** `/merge-pdf` · **Category** PDF Tools · **Keywords** merge pdf, combine pdf, join pdf files, pdf merger
**Files** `tools/MergePdf.jsx`, helpers `lib/pdf.js` (`loadPdf`, `buildPdf`, `isPdf`), `pdf-lib`

**Inputs:** Dropzone (multiple, `.pdf`), up to 50 files, 200 MB each. Each row shows its position number, name, size and page count, with ↑ ↓ reorder and ✕ remove.

**Logic:** each file is parsed with `PDFDocument.load` as soon as it's added (shows "reading…"). Merge creates a new document and `copyPages` from each file in list order. No watermark and no added pages.

**Outputs:** "Done! Your merged PDF has N pages (size)." + "Download merged PDF" → `merged.pdf`. Any change to the list clears the result.

**Validation:** encrypted → "…is password-protected. Remove the password first…"; corrupt/fake → "…could not be read. It may be damaged or not a real PDF."; non-PDF → rejected with names; Merge is disabled until there are 2+ readable files, nothing is still loading, and no red files remain ("Remove the files marked in red to continue."); 1 file → "Add at least one more PDF to merge."

**Acceptance:** 3-page + 2-page PDFs merge to 5 pages in the chosen order with the original page sizes kept.

---

### 3.8 Split PDF
**URL** `/split-pdf` · **Category** PDF Tools · **Keywords** split pdf, extract pages from pdf, separate pdf pages, pdf splitter
**Files** `tools/SplitPdf.jsx`, logic `lib/pdfRanges.js` (`parseRanges`, `rangesToIndexes`, `rangeLabel`), `pdf-lib`, `jszip`

**Inputs:** one PDF (200 MB max). Mode tabs: **Extract pages** (ranges → one PDF), **Split by ranges** (each range → its own PDF), **Split every page**. Ranges input pre-filled with `1-3` (or `1`).

**Range syntax:** comma or semicolon separated; `5`, `1-3`, `8-` or `8-end` (to last page), `-4` (from page 1); en/em dashes accepted; spaces ignored. Extract mode keeps the typed order and removes duplicate pages.

**Errors:** empty → "Enter the pages you want, for example 1-3, 5."; `0` → "Page numbers start at 1."; beyond last page → "This PDF only has N pages. \"x\" is out of range."; `5-2` → "…is backwards. Write the smaller page number first, like 2-5."; letters → "…is not a valid page or range…". The Split button is disabled while the range is invalid.

**Outputs:** extract → `name-pages-2-3_5.pdf` (or `name-extracted.pdf` when the label is long); multiple files → `name-split.zip` containing `name-pages-1-2.pdf`, `name-page-4.pdf`, …; a single resulting file downloads directly as PDF. Summary text "1 PDF with 3 pages" / "5 PDFs in a ZIP file".

**Acceptance:** 5-page PDF: "2-3, 5" → 3 pages; ranges "1-2, 3-5" → ZIP with 2 PDFs; every page → ZIP with 5 PDFs.

---

### 3.9 Age Calculator
**URL** `/age-calculator` · **Category** Calculators · **Keywords** age calculator, calculate age, date of birth calculator, how old am i
**Files** `tools/AgeCalculator.jsx`, logic `lib/date.js`

**Inputs:** Date of birth (date input), "Age at the date of" (defaults to today; if cleared, today is used).

**Logic (time-zone safe - dates are plain {y, m, d}, day numbers via `Date.UTC`):**
- Total completed months = (Δyears × 12 + Δmonths), minus 1 if the month-anniversary is after the target date. Month-anniversary day = min(birth day, days in that month) (31 Jan → 28/29 Feb).
- years = floor(months / 12), months = months % 12, days = target − last month-anniversary.
- Totals: months, weeks (+ remaining days), days, hours (days × 24).
- Weekday of birth; next birthday (29 Feb → 28 Feb in non-leap years) with weekday, days until and age turning. On the birthday: "🎉 Happy birthday! Turning N today."

**Validation:** invalid date → "Please enter a valid date of birth."; year < 1000 → "Please enter a 4-digit year."; birth after target → "The date of birth must be on or before the \"age at\" date." No DOB → info hint.

**Acceptance:** 1990-05-15 at 2026-09-29 → 36 years, 4 months, 14 days, born on a Tuesday; 2004-02-29 at 2026-03-01 → 22 years, 0 months, 1 day; brute-force test over 3 years of dates never gives negative values.

---

### 3.10 Percentage Calculator
**URL** `/percentage-calculator` · **Category** Calculators · **Keywords** percentage calculator, percent calculator, percentage change calculator, percentage increase calculator
**Files** `tools/PercentageCalculator.jsx`, logic `lib/percent.js`

Five independent calculator cards, each live-updating with the formula shown under the answer:
| Card | Formula | Example (default values) |
|---|---|---|
| What is X% of Y? | X/100 × Y | 15% of 200 = 30 |
| X is what % of Y? | X/Y × 100 | 30 of 120 = 25% |
| % increase/decrease from A to B | (B − A)/\|A\| × 100 → "25% increase" / "20% decrease" / "0% (no change)" | 80 → 100 = 25% increase |
| X is Y% of what? | X ÷ (Y/100) | 25 is 20% of 125 |
| Increase/decrease N by P% | N × (1 ± P/100), plus the difference | 50 + 20% = 60 |

**Input parsing:** text inputs with `inputMode="decimal"`; accept `1,250.5`, `15%`, `-3`, `.5`, `1e3`; invalid text → red border (`aria-invalid`) and no result. Results rounded to 6 decimals without float noise (0.1 + 0.2 = 0.3), thousands separators, never "-0".

**Division by zero messages:** "The second number cannot be 0…", "The starting value cannot be 0 - percentage change from 0 is undefined.", "The percentage cannot be 0…".

---

### 3.11 JSON Formatter & Validator
**URL** `/json-formatter` · **Category** Developer Tools · **Keywords** json formatter, json validator, json beautifier, format json, json minify
**Files** `tools/JsonFormatter.jsx`, logic `lib/json.js`

**Inputs:** code textarea (no spellcheck/autocorrect), Sample and Clear buttons, indent select (2 spaces / 4 spaces / Tabs), "Sort keys A-Z" (deep, arrays keep order).

**Actions:** Format / Beautify, Minify, Validate (all disabled when input is empty).

**Logic:** `JSON.parse` then `JSON.stringify(value, null, indent)`. On error, find the line/column from the engine message ("line X column Y" or "position N" converted by counting newlines; end-of-input → last position) and add a hint: trailing comma before `}`/`]` → "Remove the trailing comma before this bracket."; single quotes → "must use double quotes"; bare words → "Keys and text values must be wrapped in double quotes."; `/` → "Comments are not allowed in JSON."

**Outputs:** success notice "Valid JSON ✓ Formatted · size", read-only result textarea with Copy, Download (`formatted.json`) and "Use as input".

**Acceptance:** `{"a":1,"b":[1,2]}` → 2-space pretty output; `{\n  "a": 1,\n}` → error mentioning line 3 and trailing comma.

---

### 3.12 Base64 Encoder & Decoder
**URL** `/base64-encoder-decoder` · **Category** Developer Tools · **Keywords** base64 encode, base64 decode, base64 converter, image to base64
**Files** `tools/Base64Tool.jsx`, logic `lib/base64.js`

**Text tab:** input textarea; Encode ↓, Decode ↓, "URL-safe" checkbox, Clear; output textarea with Copy and Swap ↑.
- Encode: `TextEncoder` (UTF-8) → bytes → `btoa` in 32 KB chunks; URL-safe replaces `+`→`-`, `/`→`_` and strips `=`.
- Decode: strip whitespace and any `data:…;base64,` prefix, accept URL-safe characters, restore padding; reject illegal characters ("…contains characters outside A-Z, a-z, 0-9, +, / and =") and impossible lengths ("…the length is wrong (it may be cut off)"). Decode with a fatal UTF-8 decoder; if the bytes aren't text, show them anyway with the warning "the result is binary data".

**File tab:** any file up to 10 MB → raw Base64 (URL-safe toggle) and a `data:<mime>;base64,…` URL, each with Copy; image preview for images; size before → after.

**Acceptance:** "Hello 👋 café" round-trips exactly; `%%%` shows the invalid error; a PNG's data URL equals the file's real Base64.

---

### 3.13 What Is My IP
**URL** `/what-is-my-ip` · **Category** Developer Tools · **Keywords** what is my ip, my ip address, ip address lookup, check my ip
**Files** `tools/WhatIsMyIp.jsx`, `app/Http/Controllers/IpController.php`, route `GET /api/ip` (throttled 60/min)

**Logic:** the server passes `$request->ip()` into the page (`data-props`), so the IP shows instantly and is also in the HTML. Trusted proxies come from `TRUSTED_PROXIES` (default `*`) so Cloudflare/load balancers report the real visitor IP. "↻ Refresh" calls `/api/ip` (`Cache-Control: no-store`), which returns `{ip, version}`. The client shows IPv4/IPv6 (contains ":" = IPv6), browser + major version (Edge, Opera, Samsung, Firefox, Chrome, Safari), OS, device type, screen resolution, language, time zone (`Intl`), cookies enabled, full user agent. Nothing is stored.

**Errors:** network failure → "Could not refresh your IP address. Check your connection and try again."

---

## PART 4 - NEXT TOOLS (all free, browser-only) - specs ready to build

Use Part 1-2 rules. Keep the same file pattern.

1. **Unit Converter** `/unit-converter` - length, weight, temperature, area, volume, speed, data size; from/to selects + swap; exact factors table; temperature via formulas; up to 10 significant digits.
2. **Lorem Ipsum Generator** `/lorem-ipsum-generator` - paragraphs/sentences/words count (1-100), "Start with Lorem ipsum" option, copy.
3. **Text Diff Checker** `/text-diff-checker` - two textareas, line/word diff with the `diff` (jsdiff) library, added = green, removed = red, side-by-side and inline views.
4. **JPG to PDF** `/jpg-to-pdf` - multiple images → one PDF with pdf-lib (`embedJpg`/`embedPng`; convert WebP via canvas), page size A4/Letter/Fit image, orientation, margin, reorder.
5. **PDF to JPG** `/pdf-to-jpg` - render pages with `pdfjs-dist` to canvas, choose DPI (72/150/300), download page images or ZIP.
6. **Rotate PDF / Add Page Numbers / Watermark PDF** - pdf-lib `setRotation`, `drawText` with position/size/opacity options.
7. **Image to Text (OCR)** `/image-to-text` - `tesseract.js` (host the language data in `/public` to avoid external CDNs), language select, copy/download .txt, progress bar.
8. **HEIC to JPG** `/heic-to-jpg` - `heic2any`, batch, quality, ZIP.
9. **Barcode Generator** `/barcode-generator` - `JsBarcode` (CODE128, EAN-13, UPC, CODE39), validation per format, PNG/SVG download.
10. **Hash Generator** `/hash-generator` - MD5 (small library) + SHA-1/256/384/512 via `crypto.subtle.digest`, text and file input, uppercase toggle, compare-hash field.
11. **UUID Generator** `/uuid-generator` - `crypto.randomUUID()`, 1-500 at once, with/without hyphens, uppercase, copy all.
12. **Colour Converter** `/color-converter` - HEX ↔ RGB ↔ HSL with picker, contrast ratio vs white/black, copy CSS values.
13. **Invoice Generator** `/invoice-generator` - form (from/to, items, tax, discount, currency, logo), live preview, PDF via pdf-lib, data kept only in memory.
14. **BMI / EMI / GPA / Discount / Date Difference calculators** - same card pattern as the Percentage Calculator, formulas shown, full validation.
15. **Meta Tag Generator / Robots.txt Generator** - form → generated code with copy, character counters (title 60, description 160).

**Acceptance for every new tool:** works offline after load, no console errors, every invalid input has a friendly message, 375 px mobile layout has no horizontal scroll, Vitest tests for its logic, PHPUnit test passes for the new page (the existing `test_every_tool_page_renders_with_complete_seo` covers it automatically).

---

## PART 5 - PROMPT TEMPLATES

**Add a tool:**
> Using the master prompt, build the **[Tool name]** from Part 4 (#N). Give me: the `config/tools.php` entry with full SEO content and 4-5 FAQs, `resources/js/tools/[Name].jsx`, any logic in `resources/js/lib/[name].js` with Vitest tests, and the line to add to `resources/js/tools/index.js`. Follow every rule in Parts 1-2.

**Improve design:**
> Using the master prompt, redesign `resources/css/app.css` and the Blade layout for a modern look (keep all class names used by the React tools, keep ad slot heights, keep one H1, keep performance - no heavy frameworks or web fonts over 2 files).

**Fix a bug:**
> Using the master prompt, the **[Tool]** does **[what happens]** when I **[steps]**. Expected: **[expected]**. Find the cause, fix it, and add a test that would have caught it.
