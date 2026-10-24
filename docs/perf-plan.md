# Mobile performance plan (owner priority, target 95+ on mobile PageSpeed)

## Diagnosis (24 Oct 2026, Lighthouse mobile on the live site, run from this PC)

| Page | Perf | TBT | Main thread | Style + layout |
|---|---|---|---|---|
| Home | 42 | 1.3 s | 9.2 s | 4.9 s |
| Edit PDF | 36 | 1.8 s | 11.3 s | 5.1 s |
| Word counter | 70 | 0.25 s | 4.1 s | 2.0 s |
| Merge PDF | 61 | 0.43 s | 5.7 s | |
| Image compressor | 65 | 0.44 s | 6.0 s | |

Accessibility, best practices and SEO are 100 everywhere; CLS is 0.
(Local runs are harsher than Google's PageSpeed because this PC's CPU is slow; compare like with like.)

Cause: Laravel sends the full page, then `resources/js/app.jsx` calls `createRoot` and React
re-renders the whole page (header, article, FAQ, sidebar, footer) over it, so the phone lays out
everything twice and runs ~1.4-2 s of script. The page also inlines 120 KB of CSS.

## Stage 1: skip off-screen rendering (CSS) - in progress
`content-visibility: auto` on the tool article, related/guides sections, lower home sections and the
footer (app.css `.cv-auto`). Expected: most of the style/layout time goes away.

## Stage 2: islands instead of a full re-render
Keep Laravel's HTML. Mount React only where it's needed:
1. Tool panel: render the tool component into `.tool-panel` (its own root), no router needed.
2. Header: small root (or vanilla JS) for search palette, theme toggle, category menus, language
   menu and mobile menu; the server header must then render the same markup.
3. Footer newsletter, back-to-top, adblock notice: lazy islands mounted on idle/interaction.
4. Internal links become normal page loads (server pages are fast); drop the client router.
Each step: same visual output, all 100 Playwright tests green, re-measure, deploy separately.

## Stage 3: trim the rest
- Inline only critical CSS (~15 KB) and load the rest non-blocking.
- Self-host the Plus Jakarta Sans subset (removes the Google Fonts round trip).
- Split app.js (110 KB) so pages only load what they use.
