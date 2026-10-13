# Search Console & Analytics data log

This file tracks what the daily routine sees from the Windsor.ai `searchconsole` and
`googleanalytics4` connectors (rule 2 of `docs/ROUTINE.md`). One dated entry per run with
real data; entries note when there isn't enough data yet rather than guessing.

<!-- One entry per run, newest first -->

## 2026-10-13

**Search Console (last 28 days): 1,893 impressions, 0 clicks** across 852 query/country/page
rows - the whole 28-day window had zero real clicks, not just one page. Top 10 queries by
impressions:
1. "bulk domain authority check" - 66 impr, position 5, `/domain-authority-checker`
2. "wortzähler" - 50 impr, position 53, `/de/word-counter`
3. "bulk domain authority checker" - 49 impr, position 8, `/domain-authority-checker`
4. "wortzähler online" - 36 impr, position 17, `/de/word-counter`
5. "bulk domain authority checker free" - 29 impr, position 33, `/domain-authority-checker`
6. "was ist meine öffentliche ipv4 adresse" - 29 impr, position 68, `/de/what-is-my-ip`
7. "wörter zähle" - 29 impr, position 8, `/de/word-counter`
8. "meine öffentliche ip" - 27 impr, position 77, `/de/what-is-my-ip`
9. "ilovemytools.store" (brand) - 24 impr, position 31
10. "free bulk domain authority checker" - 23 impr, position 13, `/domain-authority-checker`

Top countries by impressions: Germany 737, United States 279, Italy 240, France 153, Ukraine
67, Spain 57, Brazil 56, Poland 45, Austria 36, Switzerland 36.

Top pages by impressions: `/domain-authority-checker` 254 (pos 11), `/de/word-counter` 198
(pos 46), `/de/what-is-my-ip` 187 (pos 52), `/de/image-compressor` 135 (pos 17). Pages at
average position 5-20 with 15+ impressions: `/domain-authority-checker` (254, pos 11),
`/de/image-compressor` (135, pos 17), `/de/merge-pdf` (50, pos 13), `/de/image-resizer` (27,
pos 13), `/de/age-calculator` (26, pos 10), `/fr/age-calculator` (26, pos 5), `/es/avif-to-png`
(23, pos 7), `/de/percentage-calculator` (22, pos 14), `/es/unlock-pdf` (20, pos 11),
`/fr/image-resizer` (20, pos 13), `/de/jpg-to-pdf` (16, pos 11), `/de/delete-pdf-pages` (15,
pos 11) - no single one stands out enough over a small, mixed-variant sample to justify a
dedicated on-page change today.

**`/domain-authority-checker` CTR anomaly (first flagged 9 Oct) persists and has grown:** 254
impressions at average position 11 (several query variants at position 5-9), still **zero
clicks**. Checked this run whether it could be a technical bug rather than a wording problem:
`App\Support\Seo` defaults every tool page to `robots: index, follow` (confirmed in
`app/Support/Seo.php`) and only sets `noindex` for 404-style pages, so this isn't a noindex or
canonical misconfiguration. Could not fetch the live SERP/rendered snippet this run (outbound
HTTPS to the live domain is blocked from this sandbox). Combined with the sitewide 0-click
pattern across hundreds of near-duplicate "bulk domain authority check(er)..." phrasings at
suspiciously good, stable positions, this reads more like automated rank-tracking queries
(SEO tools checking where this page ranks) than real visitors who saw the result and chose not
to click - not something an on-page wording change would fix. Leaving the backlog item open
but not re-investigating further without real click or SERP-appearance data.

**Analytics (last 7 days): 111 sessions.** By channel: Direct 69 (highest), Unassigned 14,
Organic Search 11 (55% engaged), Referral 10, AI Assistant 6, Organic Social 1. By country:
United States 51, Pakistan 13, Germany 12, United Kingdom 5, others 1-3 each. Tool events:
`tool_use` 24, `tool_download` 1, `tool_copy` 1, `sign_up` 0.

**Read as:** Organic Search sessions (11, 55% engaged) stayed in the same small-but-real range
as 9 Oct (10 sessions, 60% engaged) - still too small to draw conclusions from, per rule 2.
Semrush keyword lookups again returned `no_api_units` (same as every recent run), so kept using
the existing bulk export for keyword data (see `docs/keywords/compound-interest-calculator.json`).
No urgent SEO fix stood out beyond the domain-authority-checker question already covered above,
so today's work is the next item in the Backlog (Compound Interest Calculator) instead.

## 2026-10-09

**Search Console (last 28 days): 1,275 impressions, 0 clicks** across the sample pulled
(573 query/country/page rows). Top 10 queries by impressions:
1. "bulk domain authority check" - 66 impr, avg position 5.4, `/domain-authority-checker`
2. "bulk domain authority checker" - 48 impr, position 6.0, `/domain-authority-checker`
3. "wortzähler" - 48 impr, position 52.9, `/de/word-counter`
4. "wortzähler online" - 30 impr, position 19.4, `/de/word-counter`
5. "bulk domain authority checker free" - 25 impr, position 24.2, `/domain-authority-checker`
6. "free bulk domain authority checker" - 21 impr, position 5.5, `/domain-authority-checker`
7. "jpg verkleinern online" - 20 impr, position 13.6, `/de/image-compressor`
8. "wörter zähle" - 19 impr, position 9.5, `/de/word-counter`
9. "avif to webp" - 18 impr, position 3.8, (AVIF converter page)
10. "mass domain authority checker" - 16 impr, position 6.6, `/domain-authority-checker`

Top countries by impressions: Germany 500, United States 199, Italy 154, France 128, Ukraine
66, Spain 44, Brazil 43, Poland 22.

**`/domain-authority-checker` stands out:** 241 impressions across 14 "bulk domain authority
..." query variants, average position **7.8** (several variants at position 2.6-6.6, squarely
good), but **zero clicks on any of them**. Title/description/H1/FAQ already lead with the
exact "bulk domain authority checker" phrase, so this doesn't look like a simple on-page
wording fix - added a backlog note to look into it on a future run (rich-result/snippet
appearance, or whether these impressions are rank-tracking bots rather than people) rather
than guessing at a change today.

Pages at average position 5-20 otherwise: `/de/merge-pdf` (29 impr, pos 11.3), `/de/image-
resizer` (27 impr, pos 12.9), `/de/age-calculator` (23 impr, pos 9.2), `/fr/age-calculator`
(22 impr, pos 5.0), `/fr/image-resizer` (20 impr, pos 13.2), `/es/avif-to-png` (16 impr, pos
7.4) - none with a large enough gap between real variant phrasing and current title/FAQ to
be worth a dedicated change yet (small sample, mixed variants).

**Analytics (last 7 days):** 175 sessions. By channel: Direct 142 (42% engaged), Organic
Search 10 (60% engaged - the first time this has read as more than a single session),
Referral 9, Unassigned 8, AI Assistant 5, Cross-network 1. By country: United States 90 (42%
engaged), Pakistan 25 (48%), Germany 23 (39%), India 7, Canada/China/Spain 3 each. Tool
events (last 7 days): `tool_use` 17, `tool_download` 3, `tool_copy` 0, `sign_up` 0.

**Read as:** Organic Search sessions (10, 60% engaged) are a real signal for the first time -
still small, but no longer a single session per rule 2. No single page/query combination here
needed an urgent SEO fix beyond the domain-authority-checker CTR question already noted
above, so today's work is the next item in the Backlog (Loan Calculator) instead.

## 2026-10-05

**Search Console now has real data for the first time** (it returned 0 rows on 2026-10-04,
too new to have propagated yet). Last 28 days: **339 impressions, 2 clicks** across 173
distinct queries (overall CTR ~0.6% - expected at these positions, not a bug).

Top 10 queries by impressions (all non-English, all 0 clicks except where noted):
1. "wortzähler online" - 15 impr, avg position 15.1, page `/de/word-counter`
2. "png größe verkleinern" - 8 impr, position 19.0, `/de/image-compressor`
3. "chronomètre en ligne" - 7 impr, position 7.9, `/fr/stopwatch`
4. "jpg verkleinern online" - 7 impr, position 13.4, `/de/image-compressor`
5. "wörter zähle" - 6 impr, position 6.0, `/de/word-counter`
6. "png verkleinern" - 6 impr, position 21.5, `/de/image-compressor`
7. "juntar pdf love gratis" - 5 impr, position 5.0, `/pt/category/pdf-tools`
8. "cronometro online" - 5 impr, position 6.6, `/it/stopwatch`
9. "altersrechner" / "jpg größe verkleinern" / "online würfel" / "schlafrechner" - 4 impr each (4-way tie)

Top countries by impressions: Italy 112 (1 click), Germany 110, United States 32, France 27,
Brazil 17, United Kingdom 3, Spain 3, Austria 3; Pakistan only 2 impressions but 1 click.

**Two clusters stand out, both German, both landing in the 5-20 position band rule 2 calls
out:**
- `/de/word-counter`: "wortzähler online" (15), "wörter zähle" (6), "wortzähler" (4), "wie
  viele wörter hat mein text" (2), "wörter online zählen" (2) - about 29 impressions, mostly
  positions 6-19. The H1 was just "Wortzähler" even though the single highest-volume query
  site-wide is "wortzähler online" - fixed today, see the Log.
- `/de/image-compressor`: a larger "verkleinern" (shrink/resize) cluster - "jpg verkleinern
  online" (7), "png größe verkleinern" (8), "png verkleinern" (6), "jpg größe verkleinern"
  (4), "png bildgröße verkleinern" (2), plus eight more 1-impression variants - about 39
  impressions, mostly positions 13-28. Noted in the backlog for a future run (not touched
  today to keep this one change focused and fully tested).

No Semrush volume/CPC data was available for these phrases (`no_api_units`, same error as
every recent run) and `docs/keywords/` has no German export, so no numbers were invented -
the real Search Console impressions above are the only evidence used for today's change.

**Analytics (last 7 days):** sessions by channel - Direct 150, Unassigned 33, Referral 6,
Organic Search 1 (still a single session - not yet a usable Organic Search signal, consistent
with rule 2). By country: United States 87 (9% engaged), Pakistan 29 (72% engaged), Germany
11, Poland 10, India/Spain 4 each, France/United Kingdom 3 each, the rest 1-2 each. By landing
page: `/` 106 sessions, everything else 1-4 sessions each (mostly `/de/*` tool pages, matching
the Search Console queries above). Tool events (last 7 days): `tool_use` 7, `tool_download` 0,
`tool_copy` 0, `sign_up` 0.

**Read as:** per rule 2, the 1-4 session-per-page/country rows are still too small to be a
demand signal on their own, but the Search Console impressions are a different, more reliable
signal (aggregated search-engine data, not a handful of visits) and they agree with each
other: the real, repeated, non-automated demand right now is non-English, mostly German,
clustered on `/de/word-counter` and `/de/image-compressor`. Today's SEO work used that.

## 2026-10-04

Both connectors are now connected (`searchconsole` account `sc-domain:ilovemytools.store`,
`googleanalytics4` account `517324997`, "ilovemytools.store") — the two owner-input backlog
items reminding to connect them on this date are now done and can be ticked.

**Search Console (last 28 days):** 0 rows returned for query/country/page/clicks/impressions/
position. Either Search Console hasn't indexed/reported any impressions yet or the connection
is too new for data to have propagated. No search queries, pages or countries to report yet.

**Analytics (last 7 days):** 100 sessions total.
- By channel: Direct 91 (engagement rate 27%), Referral 5 (0%), Unassigned 3 (0%), **Organic
  Search 1** (100% engaged, but a single session).
- By country: United States 41 (12% engaged), Pakistan 29 (62% engaged), Poland 10 (0%),
  France 3, United Kingdom 3, Germany 2, Hong Kong 2, South Korea 2, Canada/India/Ireland/
  Italy/Spain 1 each, "(not set)" 3.
- By landing page: almost all sessions (86) land on `/`; everything else (`/about`,
  `/contact`, category pages, individual tool pages) is 1-2 sessions each.
- Tool events: `tool_use` 2, `tool_download` 0, `tool_copy` 0, `sign_up` 0.

**Read as:** traffic is still almost entirely Direct, not Organic Search, and the large
majority of countries/pages show only 1-3 sessions each — per rule 2, one-session
zero-engagement visits are treated as likely automated/testing traffic rather than real
demand signal (e.g. the US figure's low 12% engagement rate alongside Pakistan's 62% on a
smaller count looks like mixed real + automated/test traffic, not a conclusion to act on).
With 0 Search Console rows and 1 Organic Search session, there isn't yet a real query, page
position or country showing actual search demand to build on. Revisit once Search Console
starts returning impressions (can take a few days to a couple of weeks after connecting) and
Organic Search sessions pass single digits.
