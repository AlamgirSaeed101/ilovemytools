# Search Console & Analytics data log

This file tracks what the daily routine sees from the Windsor.ai `searchconsole` and
`googleanalytics4` connectors (rule 2 of `docs/ROUTINE.md`). One dated entry per run with
real data; entries note when there isn't enough data yet rather than guessing.

<!-- One entry per run, newest first -->

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
