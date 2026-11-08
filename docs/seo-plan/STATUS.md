# Master SEO plan (30 Oct 2026): what is done

The plan files in this folder were written on another machine without repo access. This page
tracks what has shipped, so routines don't redo work. Update it when an item changes.

## Code (A / D / E)
| Item | Status |
|---|---|
| A21/D6 calculators title + description match | Live 30 Oct (7cc4d6e, 0cc905f) |
| A22/D12 domain-authority-checker title, "check in bulk" answer section | Live 30 Oct. Judge CTR on ~27 Nov; no title change before then |
| D12 de word-counter / merge-pdf / image-compressor titles, definition-first intros | Live 30 Oct |
| D12 avif-to-webp batch FAQ | Live 30 Oct |
| A10/D2 llms.txt: 54 tools, lookup tools named, indexed languages, Facts section | Live 30 Oct |
| A11/D3 2-4 in-text tool links per guide (`[anchor](/slug)` in config/guides.php) | Live 30 Oct |
| D4 ItemList + CollectionPage on /guides | Live 30 Oct |
| A16/D7 404 without canonical | Live 30 Oct. Payload not slimmed (inline CSS kept on purpose) |
| A17/D8 /.well-known/security.txt | Live 30 Oct |
| A14/D1 externalise inline CSS | **Not doing**: inline CSS is part of the 91-100 mobile scores; a render-blocking stylesheet would cost FCP on phones |
| A15/D5 zh-Hant content expansion (Prompt 2) | Shipped 2 Nov: 15 tools rewritten and lengthened, not reviewed by a native speaker. Other zh pages may still show 、 in page-range examples |
| A20/D10 author page with Person schema | Shipped 2 Nov: /about/m-alamgir-saeed |
| D11 nofollow on ko/pl/ur switcher links | Skipped (P3, low value) |
| D12 DE-only H2s (Prompt 3 items 3 and 5) | Open: tool content must have the same number of sections in every language (TranslationsTest) |
| D9 Sucuri cache rules | Owner (dashboard) |

## Brand facts (A9)
| Where | Status |
|---|---|
| dev.to founder post | Fixed 30 Oct: title and body say 54, update note links 3 guides. Cover image still says "33 tools" (owner: new image) |
| LinkedIn company page | Fixed 30 Oct: tagline + description say 54. Banner image still says 52 (owner: new image) |
| deepnlp.org listing (48) | Needs an account to edit (owner) |
| Product Hunt slug | Relaunch request pending moderation |
| docs/launch/listing-kit.md | Fixed 30 Oct (54, no "50+") |

## Backlinks (F) submitted 30 Oct
The Free Tools Directory, The Web Is Free, NoUploadTools (PDF Editor, AdSense disclosed,
no open-source claim), dir.im, Startup Stash. Earlier: Crunchbase, LinkedIn, Indie Hackers,
SaaSHub, Launching Next, UNL library (E7, followed up 29 Oct). AlternativeTo (E4) denied; skip.

Also 30 Oct: GitHub repo README, description (54 tools) and topics updated; Crunchbase short and long
description say 54. Outreach drafts saved in hello@ Outlook Drafts for the owner to send (sending is
blocked for Claude): E5 comparetools.io, AUArts library guide, E9 Imghippo pitch, and a decline to
Lilach Bullock's paid-link offer. Skipped: E6 vwsonline (their own tools hub, not a list), ToolMato
(sells sponsored posts), Geekboots (dofollow links are paid), Tedit Online (gambling spam on the
page), fiatjaf and pascalwengerter lists (inactive since 2019/2021), goodwebtools (a competitor's own
repo), awesome-privacy and free-for-dev (AdSense / out of scope). GitHub PR to NwabKhan/awesome-web-tools
(Bulk Domain Authority Checker, Developer Tools, with disclosure) is for the owner: forking was
blocked for Claude.

Owner only: Tech Productivity + Web Tools Weekly (DM on X/Bluesky), Ignlab Launch (form is
filled by hand; it has a "what is 6 + 3" bot check), ProductPerch and IndieDebut (sign-in),
Show HN / Reddit (maker posts himself). Guest-post pitches E9-E13 go out via "send them";
E9 needs the AVIF/WebP benchmark built first.

## Link-worthy assets (F), shipped 2 Nov
- /guides/how-to-check-if-an-online-tool-uploads-your-file
- /guides/avif-vs-webp-vs-jpg-file-size-test: measured on 24 SYNTHETIC images (say so when pitching),
  script scripts/format-benchmark.mjs, data docs/benchmarks/. Don't quote the 53-69% photo savings
  alone: at matched SSIM, WebP was larger than JPEG on photo-like images.
- Still unbuilt: exact-KB compression explainer, Moz DA vs DR vs OpenPageRank piece, words-per-page table.

## Submitted 2 Nov
NoSignupTools, OnlinesTool. Generic link directories in the queue (ExactSeek, Jayde, ActiveSearchResults,
WLD, Directory World, Cipinet, ProLinkDirectory, SoMuch, Directory-Free) are deliberately not submitted:
mass directories are against the owner's rules and carry spam risk.

## Titles changed 2 Nov (judge after 28 days, about 30 Nov; don't change them before then)
/merge-pdf, /image-compressor, /avif-to-webp titles; /domain-authority-checker description.
Earlier (30 Oct, judge about 27 Nov): /domain-authority-checker title, /de/word-counter, /de/merge-pdf,
/de/image-compressor, /category/calculators.

## Outreach sent 4 Nov (owner said "send them")
Claude can only send batches the owner approves. Sent from hello@ on 4 Nov, 30 emails (the daily limit), all
confirmed in Sent Items: Techjockey, comparetools.io, library@auarts.ca, info@imghippo.com, the decline to
Lilach Bullock, and 25 pitches from docs/outreach/prospects.md. If Imghippo says yes, the article must be
re-run on real photographs, as the pitch promises.
- Bounced, dead addresses, marked skip: redaction@droitbelge.be, mhall@tcea.org, cdrcac@uvic.ca. These were
  address failures, not spam blocks; the uvic bounce shows SPF, DKIM and DMARC passing.
- Approved, still to send (over the daily limit): andrei@updivision.com, marketing@botkeeper.com,
  wedodigitaleditor@gmail.com, jose.a@empowerly.com. Botkeeper's second idea says "covering up" account numbers;
  change it to proper redaction first.
- Not approved, stay `new`: the 9 pitches written 3 and 4 Nov.

## Audit of 2 Nov (grok page), checked against the live site
Its crawl (464 URLs, 18 guides) predates the 2 Nov deploys, so the What Is My IP badge and Merge PDF FAQ
were already fixed.
- Shipped: Guides in nav, guides on category pages, /guides lastmod, honest dates on the 6 changed tools,
  Merge PDF intro repeat (en, de), /security.txt redirect, comparison guide
  /guides/ilovemytools-vs-ilovepdf-vs-smallpdf, screenshots on the top 10 tools (English pages), Split PDF
  hint that suggested an impossible range on short PDFs.
- Product Hunt: description fixed to 54 (the audit couldn't read PH). The ilovetools-3 slug stays; the name is right.
- Already in place: ads and analytics load late. Not doing: inline CSS to a stylesheet (see above).
- Owner: Sucuri overrides the 1-year cache header with max-age=86400 on /build/assets (the origin .htaccess is
  right), so this is a Sucuri dashboard setting. Cold-page response time is Sucuri/GoDaddy too.
- Owner decision: location. Site, Crunchbase say Islamabad; LinkedIn company and founder profile say Jhelum.
- Submitted: Rankbench (/edit-pdf, nofollow ugc). Login needed: ThisTool, BetaList. Skipped: Techtools Launchpad
  (186 unreviewed bot listings a day, a mass directory), uno.directory (badge required), ToolMato (sells posts),
  Quick Tool Desk (catch-all guest posts from beauty to travel).
- Not done: llms-full.txt (optional, unproven), Developer & SEO Tools category title (audit says later), self-hosted
  font, privacy-proof video, citation checks for the Meta docs page (blocked for the extension).

## Audit of 4 Nov: priority checklist
Live 4 Nov (c1f4d33): AdSense script and meta in the head; indexed languages cut to en, de, it (first-visit
language switch still serves all translated languages); honest sitemap dates; GA4 skips Lighthouse/headless
browsers; first-hand "We tested it" notes on 15 tools (config/tool-notes.php, scripts/tool-tests.mjs,
resources/data/tool-tests.json); 11 new guides, every tool links a guide; screenshots on 52 of 54 tools;
category overviews (English); contact form; llms-full.txt.
- Traffic: about 620 of GA4's 631 "new users" match our own Lighthouse workflow (23 runs x about 9 pages x 3).
  Not confirmed inside GA4: Windsor reads are paused (free plan allows 1 account, 2 connected). Recheck in 28 days.
- Already fine: IndexNow runs on every deploy; HTTP to HTTPS 301s verified 4 Nov.
- Not done: inline CSS move (wait for speed numbers with AdSense); native review of de/it (needs a person);
  Sucuri asset cache (dashboard); entity location (owner: Islamabad or Jhelum); AdSense review request (not before
  crawled-not-indexed clearly drops). Outreach: sent 4 Nov, see above.


## Backlinks and guest posts, 7 Nov (owner: "start doing backlinking and guest posting")
From the 7 Nov grok research page (free publishing and discovery, 14 domains).
- Submitted free listings: The Tool Directory, AI Free Premium Tools (as a productivity tool, not AI).
- Sent from hello@, all in Sent Items: the 4 approved 4 Nov leftovers (Updivision, Botkeeper with redaction wording,
  EasyGrader, Empowerly) and new pitches to Sevenseventech (20 KB photo/signature for Indian forms, 1 dofollow) and
  AiWebSoft (verify a tool doesn't upload files; all links nofollow; AI use must be disclosed).
- Replies to the 4 Nov batch: America's Charities said yes, needs their Stage 1 PDF form + full draft (owner);
  Technology for Learners wants $80 (paid link, declined); e-fellows declined.
- Owner only: Jamro Tools (finished human-written article, headshot, 5 FAQs, no AI text); 10015 Product Finder and
  Capterra (sign-in); SourceForge (free profile is not a clickable link). Digital Tech Updates already said paid only (24 Oct).
- If Sevenseventech or AiWebSoft accept, the article must be written by the owner: both reject AI-written text.
- Inbox and Junk read 7 Nov night; replies sent from hello@: polite no-thanks to the three paid offers (Technology for
  Learners $80, EasyGrader $100, Lawfold price sheet), thanks to e-fellows, and America's Charities told the form and
  draft will follow. Sevenseventech's address bounced (relay denied: mailbox not hosted). Virtual Vocations (23 Oct)
  takes a finished free draft from businesses: an owner-written remote-job article could go there.
- Listings also done 7 Nov: MeWebLink, Free For NonProfits, carleslc/resources (Spanish list, Airtable form),
  NoSignups (GitHub issue #2348), OneOffTech/awesome-pdf (issue #133). Blocked: GitHub forks/PRs (owner), KillerStartups
  (community sign-up), Gründerküche (creates an account). DACHstartups is DACH-only; Leptidigital's form is gone (404).

## 8 Nov: research by region + 30 pitches
Research (agents, every page opened): UK 16, USA 42, Canada 23, AU/NZ 21, Europe 31 = 133 verified free prospects
(109 guest routes, 24 listings), all added to prospects.md / backlinks-queue.md. Short of 50 per region: the shared
web-search limit ran out, and many outlets are paid-only, local-authors-only or Cloudflare-blocked.
- Sent 8 Nov from hello@ (30, the daily limit): 4 UK, 9 USA, 6 Canada, 6 AU/NZ, 3 German, 2 Italian. Statuses in prospects.md.
- Submitted 8 Nov: KI-Suche (background remover, which really runs U-2-Net/BiRefNet in the browser). UCSD suggestion form is down.
- Next batches: the remaining `new` rows (about 79 guest + email-suggestion library guides), 30 a day.
- Owner: eSchool News / eCampus News / WP Space / TechWyse / SiteCentre reject AI-written text, so accepted articles must be
  written by the owner.
