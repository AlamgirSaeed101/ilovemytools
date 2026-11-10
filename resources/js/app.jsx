import { createElement, lazy, StrictMode, startTransition } from 'react';
import { createRoot } from 'react-dom/client';
import { createBrowserRouter } from 'react-router';
import { RouterProvider } from 'react-router/dom';
import Layout from './components/Layout.jsx';
import { getJson, getSite, initialPage, loadCategory, loadSite, loadTool, NotFoundError } from './lib/api.js';
import { initI18n } from './lib/i18n.js';
import NotFound, { RouteError } from './pages/NotFound.jsx';

// Each kind of page is its own JavaScript file, so a tool page doesn't download the home page,
// the guides or the legal pages. start() loads the current page's file before React mounts, so the
// first render never waits on it (the server-rendered copy stays painted until then).
const loaded = {};
const track = (module, importer) => () => importer().then((m) => (loaded[module] = m));
const pageModules = {
    home: track('home', () => import('./pages/Home.jsx')),
    tool: track('tool', () => import('./pages/ToolPage.jsx')),
    category: track('category', () => import('./pages/Category.jsx')),
    info: track('info', () => import('./pages/InfoPages.jsx')),
    guides: track('guides', () => import('./pages/Guides.jsx')),
    author: track('author', () => import('./pages/Author.jsx')),
};
// Renders straight from the file once it has loaded (always true for the first page, so the first
// render never suspends); other pages suspend inside the router's navigation transition, which keeps
// the current page on screen until the next one's file arrives.
const page = (module, name = 'default') => {
    const Lazy = lazy(() => pageModules[module]().then((m) => ({ default: m[name] })));
    const Page = (props) => createElement(loaded[module]?.[name] ?? Lazy, props);
    Page.displayName = `Page(${module}.${name})`;
    return Page;
};
const Home = page('home');
const ToolPage = page('tool');
const Category = page('category');
const About = page('info', 'About');
const Contact = page('info', 'Contact');
const Privacy = page('info', 'Privacy');
const Terms = page('info', 'Terms');
const GuideIndex = page('guides', 'GuideIndex');
const GuideArticle = page('guides', 'GuideArticle');
const Author = page('author');

/** Which page file the server-rendered page needs (page types from the Laravel controllers). */
const initialModule = {
    home: 'home',
    tool: 'tool',
    category: 'category',
    about: 'info',
    contact: 'info',
    privacy: 'info',
    terms: 'info',
    guides: 'guides',
    guide: 'guides',
    author: 'author',
}[initialPage?.type];

// URLs must match routes/web.php so every page also works on a full reload.
const routes = [
    {
        element: <Layout />,
        children: [
            {
                id: 'pages',
                errorElement: <RouteError />,
                children: [
                    { index: true, element: <Home /> },
                    { path: 'about', element: <About /> },
                    { path: 'about/m-alamgir-saeed', element: <Author /> },
                    { path: 'contact', element: <Contact /> },
                    { path: 'privacy-policy', element: <Privacy /> },
                    { path: 'terms', element: <Terms /> },
                    { path: 'guides', element: <GuideIndex /> },
                    {
                        id: 'guide',
                        path: 'guides/:slug',
                        loader: ({ params }) => {
                            if (!(getSite().guides ?? []).some((g) => g.slug === params.slug)) throw new NotFoundError();
                            return getJson(`/api/guides/${params.slug}`);
                        },
                        element: <GuideArticle />,
                    },
                    {
                        id: 'category',
                        path: 'category/:slug',
                        loader: ({ params }) => loadCategory(params.slug),
                        element: <Category />,
                    },
                    {
                        id: 'tool',
                        path: ':tool',
                        loader: ({ params }) => {
                            // Unknown slugs are 404s without asking the server.
                            if (!getSite().tools.some((t) => t.slug === params.tool)) throw new NotFoundError();
                            return loadTool(params.tool);
                        },
                        element: <ToolPage />,
                    },
                    { path: '*', element: <NotFound /> },
                ],
            },
        ],
    },
];

/** Hand the page Laravel already rendered to the router, so the first paint needs no request. */
function hydrationData() {
    if (!initialPage) return undefined;
    const { type, data } = initialPage;
    if ((type === 'tool' || type === 'category' || type === 'guide') && data) return { loaderData: { [type]: data } };
    // A one-segment URL like /nope (or /es/nope) matches the tool route, which Laravel already said is a 404.
    const prefix = getSite().prefix || '';
    const path = prefix && window.location.pathname.startsWith(prefix) ? window.location.pathname.slice(prefix.length) || '/' : window.location.pathname;
    if (type === 'notfound' && /^\/[^/]+$/.test(path)) {
        // Errors are keyed by the route that renders them (the one with the errorElement).
        return { loaderData: {}, errors: { pages: new NotFoundError() } };
    }
    return undefined;
}

// Ctrl+K / Cmd+K / "/" can be pressed (by a keyboard user, or this exact sequence in a test)
// before React has mounted and attached its own listener in Layout, especially now that the
// first render runs inside startTransition and so can be deprioritised. Catch it here, as early
// as this module itself runs, and let Layout open the palette for it once it mounts.
window.__earlyPaletteIntent = false;
document.addEventListener(
    'keydown',
    (e) => {
        const mod = e.ctrlKey || e.metaKey;
        if (mod && e.key.toLowerCase() === 'k') {
            window.__earlyPaletteIntent = true;
        } else if (e.key === '/' && !mod && !e.altKey) {
            const el = e.target;
            const typing = el instanceof HTMLElement && (el.isContentEditable || /^(INPUT|TEXTAREA|SELECT)$/.test(el.tagName));
            if (!typing) window.__earlyPaletteIntent = true;
        }
    },
    { capture: true },
);

async function start() {
    const container = document.getElementById('app');
    if (!container) return;
    const [site] = await Promise.all([loadSite(), initialModule ? pageModules[initialModule]() : null]);
    initI18n(site);

    // The language prefix (/es) is the router's basename, so every <Link to="/merge-pdf">
    // stays in the current language automatically.
    const router = createBrowserRouter(routes, { basename: site.prefix || '/', hydrationData: hydrationData() });

    // Rendered as a transition so React works in small slices and yields to the browser between them:
    // the server-rendered page stays painted and responsive instead of the main thread freezing for
    // the whole render (this was the largest long task on phones).
    const root = createRoot(container);
    startTransition(() => {
        root.render(
            <StrictMode>
                <RouterProvider router={router} />
            </StrictMode>,
        );
    });
}

// Installable app + offline use of tools already opened (public/sw.js). Registered once the page has
// loaded and the browser is idle, so it never competes with the first paint. Production only: a
// service worker would serve stale files during development.
if (import.meta.env.PROD && 'serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        const register = () => navigator.serviceWorker.register('/sw.js').catch(() => undefined);
        if ('requestIdleCallback' in window) window.requestIdleCallback(register, { timeout: 10000 });
        else setTimeout(register, 3000);
    });
}

start().catch((error) => {
    // Keep the server-rendered page visible if the app cannot start.
    document.documentElement.classList.remove('js');
    console.error('The app failed to start:', error);
});
