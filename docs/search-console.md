# Search Console & Analytics data log

This file tracks what the daily routine sees from the Windsor.ai `searchconsole` and
`googleanalytics4` connectors (rule 2 of `docs/ROUTINE.md`). One dated entry per run with
real data; entries note when there isn't enough data yet rather than guessing.

<!-- One entry per run, newest first -->

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
