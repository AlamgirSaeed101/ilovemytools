# I · SEO dashboard: metric definitions and baseline
Baseline source: `ilovemytools-audit-2026-10-30/gsc/BASELINE.md` (GSC UI, read 30 Oct 2026). Only numbers shown there are filled in; everything else is **Pending** or **Not verified**.

## A. Search Console (Google)
| Metric | Definition | Baseline | Source/date | Cadence |
|---|---|---|---|---|
| Clicks | Clicks from Google Search to the property | 18 (≈3 mo, 30 Sep–26 Oct); 18 (28 d, 1–27 Oct) | GSC Performance | Weekly |
| Impressions | Times a URL appeared in results | 3.42K (≈3 mo); 3.38K (28 d) | GSC | Weekly |
| CTR | Clicks ÷ impressions | 0.5% | GSC | Weekly |
| Avg. position | Mean top position across impressions | 33.5 (≈3 mo); 33.7 (28 d) | GSC | Weekly |
| Queries with impressions | Distinct queries | 878 | GSC | Monthly |
| Pages with impressions | Distinct URLs | 391 | GSC | Monthly |
| Indexed pages | Page indexing → Indexed | 384 | GSC | Weekly |
| Not indexed | Page indexing → Not indexed | 309 (Crawled-not-indexed 259; Discovered 31; Redirect 19, validation started) | GSC | Weekly |
| Sitemap | Status / discovered URLs | Success / 462 (last read 30 Oct) | GSC | Weekly |
| Clicks by country | Top countries | DE 5, IT 3, TW 3, AT 2, PK 2, US 1, BR 1, MX 1 | GSC | Monthly |
| Device split | Clicks / impressions | Mobile 10 / 1,222; Desktop 8 / 2,134; Tablet 0 / 69 | GSC | Monthly |
| Quick-win set (10 queries, C) | Position + CTR per query | See C-GSC-ANALYSIS.md | GSC | Weekly |
| Core Web Vitals | Good/NI/Poor URLs | Pending (not exported) | GSC CWV | Monthly |
| Links report | External linking sites | Pending (not exported) | GSC Links | Monthly |

## B. Other channels
| Metric | Definition | Baseline | Status |
|---|---|---|---|
| Bing clicks/impressions | Bing WMT performance | Not verified | Pending export |
| Bing indexed pages | Bing WMT | Not verified | Pending |
| Organic sessions | GA4 organic search sessions | Not verified | GA4 access not provided |
| Tool usage events | GA4 events per tool (if tracked) | Not verified | Pending |
| AdSense RPM | Revenue per 1,000 page views | Not verified | Owner-only; optional |

## C. Off-page and AI visibility
| Metric | Definition | Baseline | Status |
|---|---|---|---|
| Outreach attempts | Submissions/emails sent by the owner | 0 (30 Oct) | Drafts in F |
| Live links | Links confirmed live on the page (URL + date) | Not verified | Count after submissions |
| Indexed links | Live links whose page is in Google (site: or URL inspection) | Not verified | – |
| Referring domains | GSC Links "top linking sites" count | Pending | GSC export |
| DR/DA | Third-party authority | Not verified | No Ahrefs/Moz (B4) |
| AI mentions | Prompts where the brand is named (of 72) | Not tested | E §5 |
| AI citations | Prompts where an ilovemytools.store URL is cited | Not tested | E §5 |
| Brand-fact consistency | Profiles showing 54 tools + correct URL | Not consistent (54/52/48/50+) | E §4 |

## D. Change log (record every deploy so results can be attributed)
| Date (PKT) | Change | URLs | Prompt/ticket | Verified live? |
|---|---|---|---|---|
| 30 Oct 2026 | Sitemap cleanup + resubmit; ko/pl/ur noindex; IndexNow | site-wide | audit | Yes |
| | | | | |

## E. Weekly log template
| Week of | Clicks | Impr. | CTR | Avg pos | Indexed | Crawled-not-indexed | Quick wins with clicks (/10) | New live links | Notes |
|---|---|---|---|---|---|---|---|---|---|
| 26 Oct 2026 (baseline) | 18 (28 d) | 3.38K (28 d) | 0.5% | 33.7 | 384 | 259 | Not verified (per-query clicks not exported) | 0 | Baseline |
| 2 Nov 2026 | | | | | | | | | |
| 9 Nov 2026 | | | | | | | | | |
| 2026-10-30 evening | Owner shipped commit 7cc4d6e (P0 titles/llms/AVIF FAQ); deploy pending live CDN. DA title frozen until ~27 Nov. |
