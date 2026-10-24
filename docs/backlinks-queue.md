# Backlink sites queue

Free places that link to the site itself (directories, tool lists, launch sites, business and social
profiles). Separate from guest posting (docs/outreach/). The backlink researcher routine adds 10 new
sites a day; Claude submits the `ready` ones in Chrome when the owner says "listings"; sites that need
an account wait until the owner signs up (Claude never creates accounts).

Copy for every form: docs/launch/listing-kit.md. Curated software directories (AlternativeTo and similar) decline 'collections of tools': there, submit ILoveMyTools PDF Editor (/edit-pdf) as the product. Never pay, never buy a "skip the queue" or badge, never
add a fake address, never post the same link twice on one site.

Status: `ready` (no account needed) · `needs sign-up` · `submitted <date>` · `live <date> (dofollow|nofollow)` · `rejected` · `skip (<reason>)`

| Added | Site | Market | Submit URL | Account? | Link type | Status |
|---|---|---|---|---|---|---|
| 2026-10-24 | Puromarketing (Herramientas de Marketing) | ES | https://www.puromarketing.com/herramientas-marketing/nuevo | Yes, free signup ("regístrate gratis") | not stated | site unreachable from Chrome on 24 Oct (connection error); retry later |
| 2026-10-24 | EvaluandoSoftware (directorio) | AR (LatAm, Spanish-language B2B software consultancy) | https://www.evaluandosoftware.com/pre-registro/ | No login; pre-registration form, a rep then validates and lists the company | not stated | submitted 2026-10-24 (pre-registration confirmed; a rep contacts the owner to validate) |
| 2026-10-24 | ComparaSoftware | MX (LatAm, Spanish/Portuguese B2B software marketplace, HQ Santiago de Chile) | https://comparasoftware.lovable.app/registro (linked from comparasoftware.com's "Publica tu software" / "Regístrate como fabricante") | Yes, free signup (email + password) | not stated | needs sign-up (registration form shown on 24 Oct; email + password) |
| 2026-10-24 | CazaProducto ("the PH for LATAM") | LatAm (regional product-launch directory) | https://www.cazaproducto.com/productos/new | Yes, sign up ("No waitlist. No credit card.") | not stated | needs sign-up (owner not signed in on 24 Oct; email + password only) |
| 2026-10-24 | SoftwareSuggest | International (free vendor listing, business email required, not gmail/outlook) | https://www.softwaresuggest.com/vendors | Yes, free signup | not stated | needs sign-up (vendor portal login shown on 24 Oct; business email required) |
| 2026-10-24 | LaunchFree.io (The Runway) | International | https://launchfree.io/submit.html | No login; 4-step form + verification challenge, ~24h review | not stated | submitted 2026-10-24 (free dofollow, ~24h review) |
| 2026-10-24 | SmolLaunch | International | https://smollaunch.com/submit | Yes, free plan but signup required to finish | not stated | product created 2026-10-24; launch parked: Free Verified needs their badge on the homepage (do after the page freeze ends 2026-11-20, earliest week Dec 28); Basic Free needs 3 upvotes on other products and gives no authority, skipped |
| 2026-10-24 | PitchWall | International | https://pitchwall.co/submit (select the Free Launch plan) | Yes, sign in with Google/GitHub/Microsoft/Discord | not stated | submitted 2026-10-24 (free plan, DR 70 dofollow, 30+ day queue; skip the $49/$99 upgrade) |

**Note on today's run (2026-10-24, Spain + Latin America day):** only 8 sites passed verification, not 10, and only 4 of the 8 are genuinely Spain/LatAm-specific (short of the 6 minimum). Extensive searching (Spanish-language startup maps, national startup directories, "herramientas online gratis" lists, software-comparison marketplaces, AI-tool directories, GitHub "awesome" lists, business directories) turned up mostly: sites requiring a physical street address (skipped per rules), paid-only listings (ToolMage $69, SimilarLabs $9.99, aitoolly, SoftDoit "no se ofrece como servicio gratuito independiente"), AI-only directories with an unclear or no non-AI policy (WhatTheAI, ToolMage — both also 404/paid), dead or repurposed domains (SpainStartupMap is now a casino-review site; WebRamientas returns 503; StartupWiki/Startupeable's directory is archived since 2021), or sites with no official submission process found (Contxto, LatamList, StartupBlink and StackShare returned HTTP 403 to the fetcher). A 2026 survey cited in docs/backlinks.md already found only 21 of 341 "free" directories are actually account-free, which matches today's experience. Recommend next run try a logged-in browser session for the Cloudflare-blocked sites (StartupBlink, StackShare, GoodFirms, Capterra/GetApp network, TrustRadius) rather than the raw fetcher.
