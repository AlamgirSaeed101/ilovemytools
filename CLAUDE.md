# ILoveTools (ilovemytools.store)

Free online tools site: Laravel 12 (PHP 8.3) serves SEO pages and a small JSON API; React 19 + React Router + Tailwind v4 (Vite) runs the tools in the browser. Languages: en (root), es, pt, fr, de, it (URL prefix `/es/...`).

- How the project is built, SEO rules and tool specs: `TOOLS_SPEC_PROMPT.md`
- Daily improvement routine, rules and backlog: `docs/ROUTINE.md`
- Deploys only through GitHub Actions (`.github/workflows/deploy.yml`) after all tests pass. Never SSH to the server or touch secrets.

Commands:
- `npm run build` · `npm test` (Vitest) · `php artisan test` (PHPUnit) · `npx playwright test` (e2e, needs a build and Chrome)
- `node scripts/i18n-extract.mjs` regenerates `lang/keys.json` after adding `t('...')` strings.
