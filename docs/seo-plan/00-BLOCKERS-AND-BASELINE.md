# 00 · Blockers and baseline: ILoveMyTools (https://ilovemytools.store/)
Research date: **Fri 30 Oct 2026 (Asia/Karachi, PKT, UTC+5)**. Pack built on the Grok Bot box.
Rule for the whole pack: **no invented search volumes, KD, DR, clicks or rankings.** Anything we did not measure says **"Not verified"**.

## 1. Blockers (read first)
| # | Blocker | Effect | What unblocks it | Status |
|---|---|---|---|---|
| B1 | **No site source repo on this machine. No GoDaddy/hosting write access.** | No code change could be made or deployed from here. Every fix ships as a Claude-ready prompt plus file-level instructions (see `D-TECH-IMPLEMENTATION.md`). | The owner runs the prompts in the real repo (Claude.ai / Claude Code), or grants repo + deploy access. | Open |
| B2 | **GSC: baseline only.** A sibling session exported a summary (`../ilovemytools-audit-2026-10-30/gsc/BASELINE.md`). There is no full query×page CSV, no 16-month history (the property only has data from about 30 Sep 2026), and no per-URL Inspection. | Quick wins come from the baseline list. Cannibalisation and decline analysis are only partial. | Export Performance → Queries + Pages + Countries + Devices as CSV (last 3 months), and Indexing → Pages → "Crawled – currently not indexed" examples. | Partial |
| B3 | **No Ahrefs, Semrush or Keyword Planner access.** | **Volume and Difficulty are "Not verified"** for every keyword. Demand evidence comes from Google/Bing autocomplete plus **Google Trends relative interest** (measured 30 Oct 2026). | Keyword Planner (free with a Google Ads account) or a Semrush/Ahrefs trial. Then fill the `volume` and `difficulty` columns in `B-top100.csv`. | Open |
| B4 | **No backlink index.** | DR, referring-domain count and existing backlinks are **unknown**. | Ahrefs Webmaster Tools (free for verified owners) or Bing WMT → Backlinks. | Open |
| B5 | **No CrUX field data** (the PSI API quota was exhausted during the audit). | Core Web Vitals are lab numbers only (Lighthouse on the box). | PSI web UI, or GSC → Core Web Vitals once there is enough traffic. | Open |
| B6 | **Outreach and submissions are not sent.** Each one is an external action that needs the owner's approval and accounts. | The 20 emails and the directory submissions are drafts. | The owner sends from their own mailbox and submits with their own accounts. | Drafted |
| B7 | **No AI-assistant test accounts were used.** | The AI visibility baseline table is blank, ready to fill. | Run the prompts in `E-ONPAGE-AEO-GEO.md §5` and record the results. | Template ready |

## 2. Already done (before or during this pack)
- Full technical crawl and audit of 462 sitemap URLs: 0 broken links, 0 broken images, 0 invalid JSON-LD (`../ilovemytools-audit-2026-10-30/FINDINGS.md`).
- IndexNow is live. The key file `/04a72c039825434292d3a51b4891960d.txt` returns 200.
- Sitemaps resubmitted in GSC and Bing. GSC sitemap last read 30 Oct 2026: **Success, 462 discovered**.
- Locale policy is in place. **en + es/pt/fr/de/it/zh** are indexable with reciprocal hreflang. **ko/pl/ur** are `noindex, follow` and out of the sitemap.
- The sitemap was cleaned from about 686 to 462 URLs. Redirecting `/{locale}/guides/*` URLs were removed.
- GSC "Page with redirect" validation: **Started** (19 URLs).

## 3. Baseline (measured; source shown)
| Metric | Value | Source / date |
|---|---|---|
| Sitemap URLs | 462 (EN 84 + 63 × 6 locales) | Crawl, 30 Oct 2026 |
| EN tool pages | **54** (verified against the sitemap and homepage) | Crawl |
| Guides | 16 EN | Crawl |
| HTTP 200 / broken | 462 / 0 | Crawl |
| GSC clicks (about 3 months, 30 Sep–26 Oct 2026) | **18** | GSC baseline |
| GSC impressions (same range) | **3.42K** | GSC baseline |
| GSC CTR | **0.5%** | GSC baseline |
| GSC average position | **33.5** | GSC baseline |
| GSC 28 days (1–27 Oct) | 18 clicks / 3.38K impressions / 0.5% / 33.7 | GSC baseline |
| Queries with data | 878 | GSC baseline |
| Pages with data | 391 | GSC baseline |
| Indexed / Not indexed | **384 / 309** (Crawled-not-indexed 259, Discovered 31, Page with redirect 19) | GSC baseline (may still reflect the old 686-URL sitemap) |
| Top click countries | DE 5, IT 3, TW 3, AT 2, PK 2, US 1, BR 1, MX 1 | GSC baseline |
| Devices | Mobile 10 clicks / 1,222 impr. · Desktop 8 / 2,134 · Tablet 0 / 69 | GSC baseline |
| Lighthouse (lab, mobile) | Home: Perf 93 / A11y 100 / BP 100 / SEO 100. `/merge-pdf`: 95/100/100/100 | Box Lighthouse 12 |
| TTFB (average across sitemap) | 0.87 s | Crawl |
| HTML weight | about 240 KB raw (about 125 KB inline CSS) | Crawl |
| Referring domains / DR | **Not verified** | B4 |
| Off-page score (judgement) | 2/10 | FINDINGS |
| Visibility score (judgement) | 2/10 | FINDINGS |

## 4. Files in this pack
`A-SEO-AUDIT.md` · `B-KEYWORD-RESEARCH.md` (+ `B-top100.csv`, `B-candidates-appendix.csv`) · `C-GSC-ANALYSIS.md` · `D-TECH-IMPLEMENTATION.md` · `E-ONPAGE-AEO-GEO.md` · `F-BACKLINKS.md` · `G-CONTENT-30.md` · `H-90-DAY-ROADMAP.md` · `I-DASHBOARD.md` · `data/` (raw autocomplete JSON, Trends JSON, prospect status checks, scripts).

## Canvas Page
https://cursor.com/canvas/store-9c3657ac-c8aa-4d23-96b5-34b95eb688fb/7bf1a97c-ecb1-4c7e-90e6-b3f58a33dff3
