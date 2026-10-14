# Backlink outreach: roundup articles

Maintained by the backlink-prospector routine (docs/ROUTINE.md rule 16). The routine finds and drafts;
**the owner reviews and sends every email himself**. Status: `new` (drafted, not sent) · `sent <date>` (owner
marks it) · `followed-up <date>` · `linked (dofollow|nofollow) <date>` · `declined` · `skip` (paid listing, dead, competitor).

| Added | Article | Site authority | Their links | Contact | Pitch tool | Status |
|---|---|---|---|---|---|---|
| 2026-10-14 | [72 Free Online Tools for Teachers in 2025](https://www.growthengineering.co.uk/?p=39292) | skip (Semrush: no API units) | unknown (page fetch blocked, see note) | contact@growthengineering.co.uk | word-counter | new |
| 2026-10-14 | [Top Tools for Remote Study](https://hud.libguides.com/studyingonline/toptools) (University of Huddersfield Library) | skip (Semrush: no API units) | unknown (page fetch blocked, see note) | library@hud.ac.uk | merge-pdf | new |

Note (2026-10-14 run): WebFetch and `curl` were blocked by this session's network egress policy for every domain tested (403/DNS failure, including a plain `https://example.com` sanity check), so pages could not be fetched to verify live links, dofollow/nofollow, or find author contacts. Only 2 prospects could be fully sourced this run (contact emails confirmed via their own published contact pages through WebSearch). The remaining ~8 candidates found (dev.to PDF/student-tools posts, Guru99 background-remover roundup, Cult of Pedagogy's "6 Ed Tech Tools to Try in 2026", PolyU Library's "Online Tools for Assignment" guide, Gigwise's remove.bg alternatives) were dropped: no verifiable public contact email could be found without fetching their pages, and several lacked a confirmed 2025-2026 publish/update date. Re-run once the environment's network policy allows outbound fetches to arbitrary sites.
