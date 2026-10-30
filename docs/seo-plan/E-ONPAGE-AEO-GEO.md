# E · On-page, AEO and GEO
All recommendations describe what the site **already does** (verified from page copy on 30 Oct 2026). Before publishing, re-check each claim against the code (e.g. batch limits, local vs server processing). Ship via `D-TECH-IMPLEMENTATION.md` Prompt 3 (Blocker B1: no repo access here).

## 1. Title / meta rewrites: priority pages (GSC-driven first)
| URL | Current title (live) | Proposed title (≤60) | Proposed meta description (≤160) | Why |
|---|---|---|---|---|
| /domain-authority-checker | Bulk Domain Authority Checker - 100 Free, No Sign-Up | Bulk Domain Authority Checker: Check 100 Sites Free | Check the authority of up to 100 domains at once, free and without sign-up. OpenPageRank score, global rank and referring domains, with CSV export. | 277 impr., position 14.6, 0 clicks. Searchers ask "bulk … check"; "100 Free" reads oddly. |
| /category/calculators | Age, Loan, Mortgage & Compound Interest Calculators | Free Online Calculators: Age, Percentage, Loan & Mortgage | Free calculators for age, percentages, tips, loans, mortgages and compound interest. Instant results with the formula and working shown. No sign-up. | Position 8.9, 0 clicks. The title and description don't match. |
| /avif-to-webp | AVIF to WebP Converter - Free Online, Batch \| ILoveMyTools | AVIF to WebP Converter: Free, Batch, Keeps Transparency | Convert AVIF to WebP free in your browser. Batch up to 30 images, transparency kept, ZIP download. Nothing is uploaded, no sign-up. | Already position 3.8. Sharpen the differentiators. |
| /de/word-counter | Wortzähler Online: Wörter zählen, Zeichen & mehr | Wortzähler online: Wörter zählen kostenlos, ohne Anmeldung | Wörter, Zeichen, Sätze und Lesezeit sofort zählen – kostenlos, ohne Anmeldung, direkt im Browser. Dein Text verlässt dein Gerät nicht. | Positions 8.2/16.7. "ohne Anmeldung" is autocomplete-verified. |
| /de/merge-pdf | PDF zusammenfügen: PDF-Dateien online kostenlos kombinieren | PDF zusammenfügen: kostenlos, online & ohne Anmeldung | PDF-Dateien kostenlos zu einem Dokument zusammenfügen – Reihenfolge ändern, kein Wasserzeichen, keine Anmeldung. Nichts wird hochgeladen. | Position 14.8. Matches the "kostenlos ohne anmeldung" completion. |
| /de/image-compressor | Bild verkleinern online: JPG & PNG Größe reduzieren | JPG verkleinern online: Bild komprimieren auf KB-Größe | JPG, PNG und WebP kostenlos verkleinern – auch auf eine Zielgröße wie 100 KB. Ohne Anmeldung, nichts verlässt dein Gerät. | 137 impr., position 17.3, 0 clicks. Query "jpg verkleinern online" at 13.6. |
| /image-compressor | Image Compressor - Compress JPG, PNG & WebP Online | Compress Image to 100KB, 50KB or Any Size: Free, No Upload | Compress JPG, PNG and WebP to an exact size like 100KB or 50KB, free in your browser. No upload, no sign-up, no watermark. | Targets the long-tail "compress image to N kb" cluster |
| /merge-pdf | Merge PDF - Combine PDF Files Online Free \| ILoveMyTools | Merge PDF Without Uploading: Free, Private, No Sign-Up | Combine PDF files into one in your browser. Reorder files, no upload, no watermark and no sign-up needed. | Privacy niche. The head term is unwinnable short-term. |

Rules: test one page at a time, and keep each change for at least 28 days before judging it. No clickbait, and no claims the code doesn't support. Record the deploy date in `I-DASHBOARD.md`.

## 2. Tool-page template (H2 pattern) for all 54 tools
1. **H1** = tool name + core keyword (already in place).
2. Intro (40–60 words) = **the direct answer**: what it does, free/no sign-up, local or server processing.
3. Tool UI above the fold (already in place).
4. `H2 How to [task] (3 steps)`: ordered list that matches the UI exactly.
5. `H2 [Task] without uploading: how your files stay private`: explain local processing and how to verify it (DevTools → Network). For server tools, state what's sent and that it isn't stored.
6. `H2 Features and limits`: real limits (file count, size, formats, batch 30, etc.).
7. `H2 [Comparison/problem question]` (e.g. "Does converting AVIF to WebP lose quality?").
8. `H2 Frequently asked questions`: 4–6 real questions taken from autocomplete/PAA (see B).
9. `H2 Sources`, Related tools, Read the guide (already in place).

## 3. AEO answer blocks (place as the first paragraph under the matching H2; accurate as of the live copy)
| Question | Answer block (40–60 words) | Page |
|---|---|---|
| How do I merge PDF files for free? | Open ILoveMyTools Merge PDF, add your PDFs, drag them into order and press Merge. The combined PDF downloads straight away, with no sign-up and no watermark. Files are processed in your browser, so they aren't uploaded to a server. | /merge-pdf |
| Can I merge PDFs without uploading them? | Yes. Browser-based tools like ILoveMyTools Merge PDF read the files on your device and build the merged PDF locally. You can check this yourself: open your browser's developer tools, go to the Network tab, merge your files, and confirm no request carries your PDF. | /merge-pdf |
| How do I compress an image to 100KB? | Open the Image Compressor, add your JPG, PNG or WebP, choose a target size of 100 KB and download the result. The tool adjusts compression until the file fits under the limit (match this sentence to the real algorithm). Forms usually mean 100 KB = 102,400 bytes. | /image-compressor |
| How do I convert WebP to PNG? | Drop WebP files into the WebP to PNG converter and download the PNGs, individually or as a ZIP. PNG is lossless and keeps transparency, so the result looks the same but is usually larger than the WebP. | /webp-to-png |
| How can I resize an image without losing too much quality? | Resize down, not up, keep the aspect ratio, and export at the exact pixel size you need. Use PNG for graphics and high-quality JPG or WebP for photos. Upscaling can't add detail that isn't there. | /image-resizer |
| How can I count words online? | Paste or type your text into the Word Counter. It instantly shows words, characters with and without spaces, sentences, paragraphs and reading time. The counting happens in your browser, so the text isn't sent anywhere. | /word-counter |
| How do I format JSON? | Paste JSON into the JSON Formatter and choose Format to indent it, or Minify to strip whitespace. Invalid JSON is flagged so you can fix missing commas or quotes (confirm the error-message behaviour in code). | /json-formatter |
| How can I generate a QR code? | Enter a URL, text or Wi-Fi details into the QR Code Generator, then download the code as an image. Static QR codes don't expire, because the data is stored in the pattern itself. Test-scan it before printing. | /qr-code-generator |
| Are browser-based PDF tools private? | They can be, if processing really happens on your device. Check that the site says files aren't uploaded, look at the Network tab while using it, and prefer tools that work offline once loaded. Server-based tools have to upload your file to process it. | /guides (new: G-01) |
| How do I check domain authority in bulk for free? | Paste up to 100 domains into the Bulk Domain Authority Checker. It returns each site's OpenPageRank (0–10), global rank and referring domains, which you can sort and export as CSV. OpenPageRank isn't Moz DA or Ahrefs DR, but it measures a similar idea. | /domain-authority-checker |

Schema: keep FAQPage, HowTo and Speakable **only where the visible content matches**. Google shows no HowTo rich results and limits FAQ rich results to authoritative gov/health sites. The schema is for parsing and AEO, not for SERP features.

## 4. GEO entity checklist
| # | Item | Status (30 Oct 2026) | Action |
|---|---|---|---|
| 1 | Organization JSON-LD (name, url, logo, founder, sameAs) on every page | ✅ In place | Keep |
| 2 | WebSite JSON-LD | ✅ | Keep |
| 3 | One canonical brand description (≤160 chars) used everywhere | ⚠️ Inconsistent tool counts (54/52/48/50+) | Use: "ILoveMyTools offers 54 free online tools for PDF, image, text, developer and everyday tasks. No sign-up; file tools run in your browser." |
| 4 | Tool count consistent across llms.txt, LinkedIn, dev.to, Crunchbase, Product Hunt, deepnlp, CircleSaaS | ❌ | Update all to 54. Fix the Product Hunt slug `ilovetools-3`. |
| 5 | Accurate processing claims (local vs server) | ❌ llms.txt overclaims | D2 |
| 6 | Visible privacy policy, explicit about ads/AdSense cookies | ✅ /privacy-policy (review the AdSense wording) | Review |
| 7 | Author/founder page with credentials | ❌ | D10 |
| 8 | Cited external sources on tool pages | ✅ (MDN, RFCs, NIST, ISO…) | Keep |
| 9 | AI crawlers allowed in robots.txt | ✅ GPTBot, OAI-SearchBot, ClaudeBot, PerplexityBot, Google-Extended… | Keep |
| 10 | llms.txt (optional experiment, not a proven ranking factor) | ✅ live, ⚠️ inaccurate | D2 |
| 11 | Third-party mentions (reviews, listicles, communities) | ❌ almost none | F-BACKLINKS |
| 12 | Bing indexing (feeds Copilot and ChatGPT search) | ✅ Bing WMT + IndexNow | Monitor the Bing index count |
| 13 | Wikidata entity | Not yet (notability) | Revisit after independent coverage |
| 14 | Original data assets that AI can cite (benchmarks) | ❌ | G-02, G-03 |

## 5. AI visibility test baseline (to fill in; nothing tested yet, Blocker B7)
Protocol: a fresh/logged-out session where possible. Record the location (PK, or VPN country) and the date (PKT). Repeat monthly with the same prompts.

| # | Prompt |
|---|---|
| 1 | What are the best free online PDF tools? |
| 2 | Free private image compressor that doesn't upload my photos |
| 3 | Secure browser-based PDF merger |
| 4 | Free WebP to PNG converter |
| 5 | Best free word counter |
| 6 | Online tools without signup for PDF and images |
| 7 | How do I compress an image to 100KB? |
| 8 | Bulk domain authority checker free |
| 9 | AVIF to WebP converter online |
| 10 | Wortzähler online kostenlos ohne Anmeldung |
| 11 | What is ILoveMyTools? (brand-fact check: tool count, privacy claims) |
| 12 | Merge PDF without uploading |

| Date (PKT) | Engine / model | Location | Prompt # | ILoveMyTools mentioned? | Cited URL | Position in answer | Competitors mentioned | Notes |
|---|---|---|---|---|---|---|---|---|
| | Google AI Overviews | | 1 | | | | | |
| | Google AI Mode | | 1 | | | | | |
| | ChatGPT search | | 1 | | | | | |
| | Perplexity | | 1 | | | | | |
| | Gemini | | 1 | | | | | |
| | Bing Copilot | | 1 | | | | | |
(Copy the 6 engine rows for each prompt: 72 rows per monthly run.)
