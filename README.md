# ILoveMyTools - free online tools that run in your browser

Live site: **https://ilovemytools.store/**

54 free online tools for PDFs, images, text, calculations and developers, in 10 languages, with no sign-up, no watermark and no daily limit. The main tool is a [PDF editor](https://ilovemytools.store/edit-pdf) that changes the text already in a PDF, in the PDF's own font.

File and text tools (Edit, Merge, Split and Compress PDF, Image Compressor, WebP/AVIF/PNG/JPG converters, Word Counter and the rest) run **entirely in the visitor's browser** with PDF.js, pdf-lib and Canvas, so files are never uploaded. The four lookup tools (Bulk Domain Authority Checker, Broken Link Checker, Domain Age Checker, What Is My IP) go through the server and say so on the page.

Stack: **Laravel 12** serves the SEO pages (full server-rendered HTML, JSON-LD, hreflang) and a small JSON API; **React 19 + React Router + Tailwind v4** (Vite) runs the tools. Guides: https://ilovemytools.store/guides

---

## 1. Requirements

| Software | Version | Needed for |
|---|---|---|
| PHP | 8.2 or newer (with `mbstring`, `xml`, `gd`) | Running the site |
| Composer | 2.x | Installing Laravel |
| Node.js | 20 or newer | Only if you change the React/CSS code |

No database is needed.

## 2. Run it on your computer

```bash
# 1. Install PHP packages (Laravel)
composer install

# 2. Create your settings file and app key
cp .env.example .env          # Windows: copy .env.example .env
php artisan key:generate

# 3. Start the site
php artisan serve
```

Open **http://localhost:8000**. The compiled React/CSS files are already in `public/build`, so you do **not** need npm just to run the site.

Grey "Ad space" boxes appear locally so you can see where ads will go. They disappear automatically in production until you add your AdSense ID.

### Changing the React tools or CSS

```bash
npm install
npm run dev      # live reload while you work (keep php artisan serve running too)
npm run build    # ALWAYS run before uploading - updates public/build
```

## 3. Run the tests

```bash
php artisan test   # 27 tests: every page, the JSON API, SEO tags, schema, sitemap, robots, ads.txt, 404s, no cookies
npm test           # 55 checks of the tool logic (word counts, dates, percentages, PDF page ranges, search...)
npm run build && npm run test:e2e   # 26 real-browser tests (your installed Chrome): every tool with real files,
                                    # navigation, search, dark mode, 404s, no-JS view and a phone layout
```

---

## 4. Project map

```
config/site.php          Brand, contact email, AdSense, Analytics, verification codes
config/tools.php         EVERY tool's SEO title, description, H1, steps, FAQs, related tools
config/categories.php    Category pages (/category/pdf-tools etc.)
routes/web.php           Page URLs (each returns the React app + SEO shell)
routes/api.php           JSON API: /api/site, /api/tools/{slug}, /api/categories/{slug}, /api/ip
app/Support/SiteData.php The JSON the React app reads (also embedded in the first page)
app/Support/Seo.php      Title, description, canonical, Open Graph, JSON-LD schema
app/Support/Ads.php      Decides when ad slots show
app/Http/Controllers/    PageController (all pages), Api\SiteController, IpController, sitemap/robots/ads.txt
resources/views/         Blade SEO shell + plain-HTML copy of each page for crawlers / no-JS
resources/js/app.jsx     React entry + routes (keep in sync with routes/web.php)
resources/js/pages/      React pages: Home, ToolPage, Category, About/Contact/Privacy/Terms, 404
resources/js/components/ Layout (header, footer, Ctrl+K palette, theme), cards, ads, UI kit
resources/js/tools/      One React component per tool
resources/js/lib/        Tool logic (pure functions, unit tested) + API client
tests/e2e/               Playwright browser tests
resources/css/app.css    All styles (colour variables at the top)
scripts/                 Brand image generator
```

### Add a new tool (3 steps)

1. Add an entry to `config/tools.php` (copy an existing one; the key is the URL slug).
2. Create `resources/js/tools/MyTool.jsx`.
3. Register it in `resources/js/tools/index.js` with the same slug, then `npm run build`.

The page, sitemap entry, breadcrumbs, schema markup, footer link and related-tool links are created automatically.

---

## 5. SEO - what's built in

- Server-rendered HTML for every page (crawlers don't need JavaScript to read the content)
- Unique `<title>` (≤ 60 chars) and meta description (140-160 chars) per page
- Canonical URLs, `robots` meta, Open Graph + Twitter cards, 1200×630 share image
- JSON-LD structured data: Organization, WebSite, BreadcrumbList, WebApplication (free offer), FAQPage, ItemList, CollectionPage
- One H1 per page, logical H2/H3 structure, visible breadcrumbs
- 400-800 words of unique helpful content per tool: intro, how-to steps, features, explainer sections, FAQs
- Internal linking: related tools, category sidebar, category pages, footer links to every tool
- `/sitemap.xml` generated automatically with `lastmod`
- `/robots.txt`: blocks everything on local/staging, allows all + links the sitemap in production
- Short keyword URLs (`/merge-pdf`, `/word-counter`), trailing-slash redirects, optional https/www redirects in `public/.htaccess`
- Fast: each tool loads only its own JavaScript, no web fonts, gzip + cache headers, ad slots reserve space (no layout shift = good Core Web Vitals)
- Mobile-friendly, accessible (labels, keyboard support, skip link), 404 pages are `noindex`
- About, Contact, Privacy Policy (with the AdSense disclosures Google requires) and Terms pages

### After you go live

1. Set `APP_ENV=production`, `APP_DEBUG=false` and `APP_URL=https://yourdomain.com` in `.env`.
2. Add the site to **Google Search Console** and **Bing Webmaster Tools**, paste the verification codes into `.env` (`GOOGLE_SITE_VERIFICATION`, `BING_SITE_VERIFICATION`) and submit `https://yourdomain.com/sitemap.xml` in both.
3. Optional: add `GA4_MEASUREMENT_ID` for Google Analytics.
4. Run `php artisan config:cache && php artisan route:cache && php artisan view:cache` after every deploy.
5. Never upload `public/hot` (it is created by `npm run dev` and makes the site load its JavaScript from your own computer). `npm run build` removes it.
6. Behind Cloudflare or a load balancer, set `TRUSTED_PROXIES` to its IP ranges so visitor IPs are correct. Leave it empty otherwise: `*` would let anyone fake their IP.

---

## 6. Ads (Google AdSense)

AdSense normally approves sites that have original content, the legal pages (included), and some traffic. Apply once you have the site live with your own domain.

1. After approval, set `ADSENSE_CLIENT=ca-pub-XXXXXXXXXXXXXXXX` in `.env`. This loads the AdSense script and creates `/ads.txt` automatically.
2. In AdSense, create **Display ad units** and paste their slot IDs:

| .env key | Where it appears |
|---|---|
| `ADSENSE_SLOT_HEADER` | Below the page title |
| `ADSENSE_SLOT_BELOW_TOOL` | Right after the tool (usually the best earner) |
| `ADSENSE_SLOT_SIDEBAR` | Desktop sidebar (hidden on mobile) |
| `ADSENSE_SLOT_IN_CONTENT` | Inside the article text |
| `ADSENSE_SLOT_FOOTER` | Above the footer |

You can also just turn on **Auto ads** in AdSense and leave the slot IDs empty.

3. **UK / EU visitors:** Google requires a certified consent (cookie) banner. The free option is AdSense → *Privacy & messaging* → *European regulations message*. No code changes are needed.

---

## 7. Deploying

**Rebrand first:** set `APP_NAME` in `.env`, update `public/site.webmanifest`, then regenerate the icons and share image:

```bash
php scripts/generate-brand-images.php "YourBrand" "Free Online Tools - Fast, Private, No Sign Up"
```

**Shared hosting (cPanel):** upload everything, point the domain's document root to the `public` folder, run `composer install --no-dev --optimize-autoloader` (or upload a `vendor` folder built on your computer), create `.env`, and make `storage/` and `bootstrap/cache/` writable.

**VPS / Laravel Forge / Ploi:** standard Laravel deploy (`composer install --no-dev`, `php artisan key:generate`, cache commands above). Put Cloudflare (free) in front for SSL and caching.

---

## 8. Privacy promise

Only "What Is My IP" sends anything about the visitor to the server (it shows them their own IP and stores nothing); the other API calls just fetch page text. The site sets no cookies and keeps no sessions. Every other tool processes files and text locally in the browser, which is both a selling point and why the site costs nothing to run as it grows.
