# H · 90-day roadmap (starts Fri 30 Oct 2026, PKT)
Effort: S <½ day · M 1–3 days · L >3 days. Impact: H/M/L (judgement, not a forecast). "Owner" = site owner/developer (code changes go through the Claude prompts in D, Blocker B1).

## Already done (before day 1)
| Item | Status | Evidence |
|---|---|---|
| Full technical/on-page/AEO/GEO audit | ✅ Done 30 Oct | ilovemytools-audit-2026-10-30/FINDINGS.md |
| IndexNow key + submissions | ✅ Done | A7 |
| Sitemap cleanup (462 URLs) + resubmit | ✅ Done; GSC "Success", last read 30 Oct | gsc/BASELINE.md |
| ko/pl/ur locales set to noindex and removed from sitemap | ✅ Done | A6 |
| GSC "Page with redirect" (19) validation | ⏳ Started | gsc/BASELINE.md |

## Days 1–15 (30 Oct – 13 Nov): fix trust signals and grab the quick wins
| # | Task | Priority | Depends on | Effort | Impact | Success criteria |
|---|---|---|---|---|---|---|
| 1 | Rewrite title/meta on /domain-authority-checker (E §1) | P0 | Owner deploy | S | H | Deployed; CTR measured at +28 days (baseline 0 clicks/277 impr.) |
| 2 | Fix the /category/calculators title/description mismatch | P0 | – | S | M | Deployed; title = description topic |
| 3 | Fix llms.txt: 54 tools, local vs server claims, languages (D2) | P0 | – | S | M | llms.txt matches the sitemap and code |
| 4 | Ship Prompt 1 bundle: CSS externalised, 404 canonical/noindex, security.txt, ItemList on /guides, guide↔tool links (D1–D7) | P1 | Owner | M | M | Lighthouse/CrUX doesn't regress; HTML size drops; validators pass |
| 5 | DE quick wins: /de/word-counter, /de/merge-pdf, /de/image-compressor titles + answer blocks | P0 | Native-DE check | S | H | Deployed; DE positions tracked weekly |
| 6 | /avif-to-webp polish (pos 3.8): answer block + FAQ | P1 | – | S | M | Holds top 5; first clicks |
| 7 | Inspect 10 sample "Crawled – currently not indexed" URLs and request indexing for the strongest EN pages only | P0 | GSC access (owner) | S | M | Log the inspection results; no mass requests |
| 8 | Fix brand facts: dev.to count, deepnlp, LinkedIn, Product Hunt slug (E §4) | P1 | – | S | M | All say 54 / correct URL |
| 9 | Submit to 5 P1 directories (F rows P1, after owner approval) | P1 | Approval | S | M | 5 submissions logged; live links tracked |
| 10 | Run the AI-visibility baseline (12 prompts × 6 engines, E §5) | P1 | – | M | M | Table filled, dated |

## Days 16–30 (14 – 29 Nov): fix thin locales and publish the first assets
| # | Task | Priority | Depends on | Effort | Impact | Success criteria |
|---|---|---|---|---|---|---|
| 11 | Locale-quality pass on the 6 example crawled-not-indexed pages (e.g. /pt/stopwatch, /de/qr-code-generator): unique localized intro/FAQ, native review | P0 | Translator | M | H | Re-inspected; count of Crawled-not-indexed (259) trending down |
| 12 | zh-Hant expansion for 15 tools (Prompt 2), since TW already sends clicks | P1 | Native zh-TW reviewer | L | M | Pages live, indexed |
| 13 | Publish G-01 (privacy) and G-03 (100 KB) | P1 | Author page (D10) | M | H | Indexed; linked from tool pages |
| 14 | Build the AVIF/WebP benchmark data (G-02) | P1 | – | M | H | CSV + article published |
| 15 | Author/founder page + byline on guides | P1 | – | S | M | Person schema; linked from guides |
| 16 | 5 personalised guest-post/resource pitches (F drafts) | P2 | Approval | S | M | Sent by owner; replies logged |

## Days 31–60 (30 Nov – 29 Dec): content engine and links
| # | Task | Priority | Depends on | Effort | Impact | Success criteria |
|---|---|---|---|---|---|---|
| 17 | Publish G-04 to G-11 (2 per week) | P1 | – | L | H | 8 guides indexed; each linked to ≥2 tools |
| 18 | Awesome-list PRs (≤3, where rules fit) + Show HN with the technical write-up | P2 | G-02/G-01 live | M | M | PRs opened; merged links logged |
| 19 | Library/edu resource outreach (UNL, USC, TeachersFirst, vwsonline) | P2 | G-01 live | S | M | ≥1 positive reply |
| 20 | Re-measure GSC: CTR on edited pages vs baseline | P0 | 28 days post-deploy | S | – | Decide keep/revert per page |
| 21 | Core Web Vitals check (CrUX/PSI) after CSS externalising | P1 | Task 4 | S | M | LCP/INP/CLS "good" or improved |

## Days 61–90 (30 Dec – 28 Jan 2027): scale what worked
| # | Task | Priority | Depends on | Effort | Impact | Success criteria |
|---|---|---|---|---|---|---|
| 22 | Publish G-12 to G-20 | P2 | – | L | M | Indexed; impressions growing |
| 23 | Extend locale guides only where GSC shows locale demand (DE first) | P2 | GSC data | M | M | DE guide impressions |
| 24 | Second AI-visibility run; compare with baseline | P1 | Task 10 | M | M | Mentions/citations delta logged |
| 25 | Backlink audit (GSC Links report; a free backlink tool if available) | P2 | – | S | M | Referring domains counted (now Not verified) |
| 26 | Quarterly review: refresh keyword research with any volume tool the owner adds | P2 | Tool access | M | M | B updated with real volumes |

## 90-day success criteria (directional; no traffic is promised)
- Indexed pages up from 384 and Crawled-not-indexed down from 259 (GSC).
- The 10 quick-win queries (C) all have a measured CTR; at least half have clicks.
- ≥10 live, relevant, white-hat referring domains (verified, not "outreach sent").
- Brand facts consistent across ≥6 profiles; AI-visibility baseline + 1 re-run done.

## Owner ship log (updated 30 Oct 2026 evening PKT)
- Commit **7cc4d6e** shipped code-side P0s (DA title + bulk answer block ×10 langs; calculators meta; DE titles/intros; llms.txt 54/server/7 langs; AVIF FAQ). PHPUnit 123 + Vitest 315 pass. Deploy in progress as of editor report.
- **Live verify (this bot, ~20:30 PKT 30 Oct):** CDN still serving prior titles/llms.txt — not live yet. Re-check after deploy confirms.
- **Domain Authority title freeze:** do not change title again before **~27 Nov 2026** (28 days after this deploy). Prior title change was 23 Oct; GSC baseline through 26 Oct mostly measured older titles; page avg pos ~14.6 (page 2).
- Native German review of the three DE pages still needed (editor cannot do it).
- Brand facts off-site (dev.to 52, deepnlp 48, LinkedIn) still pending owner "fix them" go-ahead. Product Hunt slug fix already via relaunch request.
