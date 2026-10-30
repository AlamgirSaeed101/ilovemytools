# C · Google Search Console analysis: sc-domain:ilovemytools.store
Source: `../ilovemytools-audit-2026-10-30/gsc/BASELINE.md`, collected 30 Oct 2026 (PKT) by a sibling session from the GSC UI. **Only the figures below were measured.** Everything else is marked *Pending / Not verified, need a GSC export*.
The property has data from **about 30 Sep 2026** only, so the 16-month, 6-month and year-over-year comparisons aren't possible yet.

## 1. Performance baseline
| Range | Clicks | Impressions | CTR | Avg position |
|---|---|---|---|---|
| About 3 months (30 Sep–26 Oct 2026) | 18 | 3.42K | 0.5% | 33.5 |
| 28 days (1–27 Oct 2026) | 18 | 3.38K | 0.5% | 33.7 |
| Last 7 days | Pending / Not verified | | | |
| Previous-period comparisons | Not possible (property too new) | | | |

Totals: **878 queries** and **391 pages** have impressions. Clicks are sparse, and many top-impression queries show 0 clicks.

## 2. Quick wins (measured positions; impressions are for the baseline range)
| Query / page | Position | Impressions | Clicks | Target URL | Action |
|---|---|---|---|---|---|
| bulk domain authority check | 5.4 | 66 | not shown in baseline | /domain-authority-checker | Title test (E §1). Add an "OpenPageRank vs Moz DA vs Ahrefs DR" comparison table above the fold. CSV sample. |
| bulk domain authority checker | 7.6 | 49 | not shown | /domain-authority-checker | Same as above |
| free bulk domain authority checker | 12.9 | 23 | not shown | /domain-authority-checker | Put "free" + "100 domains" in the H1 and intro |
| mass domain authority checker | 12.4 | 20 | not shown | /domain-authority-checker | Add the "mass / bulk" synonym naturally in an H2 |
| **/domain-authority-checker (page)** | **14.6** | **277** | **0** | — | The top-priority page. Internal links from `/category/developer-tools`, `/broken-link-checker`, `/domain-age-checker` and the homepage. |
| avif to webp | **3.8** | 18 | not shown | /avif-to-webp | Already top 5. Sharpen the snippet ("lossless option?", batch up to 30, alpha kept). |
| wörter zähle | 8.2 | 29 | not shown | /de/word-counter | Native German FAQ: compounds, "z. B.", hyphens; how Word counts vs this tool |
| wortzähler online | 16.7 | 36 | not shown | /de/word-counter | Title already contains "Wortzähler Online". Add depth and internal links from DE guides. |
| jpg verkleinern online | 13.6 | 20 | not shown | /de/image-compressor | The title has "Bild verkleinern". Add "JPG verkleinern" to an H2, plus a KB-target example. |
| pdf zusammenfügen online | 14.8 | 18 | not shown | /de/merge-pdf | Add "kostenlos ohne Anmeldung" (autocomplete-verified) to the H1 or intro |
| i love desbloquear pdf | 9.2 | 17 | not shown | /es/unlock-pdf | A brand-confusion query (iLovePDF). Don't target the competitor's brand; improve the generic "desbloquear pdf" copy. |
| **/de/image-compressor (page)** | 17.3 | 137 | 0 | — | German content depth + links from /de/compress-pdf and /de/image-resizer |
| **/category/calculators (page)** | **8.9** | 121 | 0 | — | Page 1 with 0 clicks: the title and description don't match (E §1). Rewrite. |
| /de/what-is-my-ip (page) | 64.9 | 333 | not shown | — | Very competitive head. Low priority; leave as is. |

## 3. Countries and devices
| Country | Clicks |
|---|---|
| Germany | 5 |
| Italy | 3 |
| Taiwan | 3 |
| Austria | 2 |
| Pakistan | 2 |
| US / Brazil / Mexico | 1 each |

| Device | Clicks | Impressions |
|---|---|---|
| Mobile | 10 | 1,222 |
| Desktop | 8 | 2,134 |
| Tablet | 0 | 69 |

Reading: **German is the leading market so far** (per the parent's summary, Germany also leads impressions). Prioritise the DE locale for on-page work. zh-Hant (Taiwan) earns clicks despite thin content, which makes the case for expanding zh (D, P2 → raised to P1).

## 4. Indexing
| Status | Count | Note |
|---|---|---|
| Indexed | 384 | |
| Not indexed | 309 | Totals may still reflect the old 686-URL sitemap |
| – Crawled, currently not indexed | **259** | Need examples: export the list and classify it by locale/tool |
| – Discovered, currently not indexed | 31 | |
| – Page with redirect | 19 | Validation **Started** |
| Sitemap | Last read 30 Oct 2026, **Success, 462 discovered** | |
| Manual actions / Security issues | Pending / Not verified | Check Security & Manual Actions |
| Duplicate / alternate canonical | Pending / Not verified | |

## 5. Pending: need a GSC export (do not fill by guessing)
| Analysis | Needed export | Status |
|---|---|---|
| Top queries by clicks / impressions | Performance → Queries CSV (3 months) | Pending / Not verified |
| Position buckets 4–10, 11–20, 21–50 | Same CSV | Pending (partial list above) |
| Pages with impressions but no clicks (full list) | Performance → Pages CSV | Pending (3 pages known) |
| Query→page mapping / cannibalisation | Query+Page export (API or Looker Studio) | Pending / Not verified |
| Declines / gains | Needs 2 comparable periods (available after about Dec 2026) | Not possible yet |
| Crawled-not-indexed examples | Indexing → Pages → reason → export | Pending / Not verified |

## 6. Measurement plan
- Snapshot every Monday (PKT) into `I-DASHBOARD.md`: clicks, impressions, CTR, position, indexed count, and the positions of the 14 quick-win rows above.
- Compare each quick-win page on matched 28-day windows before and after its change. Record the deploy date in the dashboard change log.
