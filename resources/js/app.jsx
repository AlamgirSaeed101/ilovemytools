import { StrictMode, startTransition } from 'react';
import { createRoot } from 'react-dom/client';
import { createBrowserRouter } from 'react-router';
import { RouterProvider } from 'react-router/dom';
import Layout from './components/Layout.jsx';
import { getJson, getSite, initialPage, loadCategory, loadSite, loadTool, NotFoundError } from './lib/api.js';
import { initI18n } from './lib/i18n.js';
import Category from './pages/Category.jsx';
import Home from './pages/Home.jsx';
import { About, Contact, Privacy, Terms } from './pages/InfoPages.jsx';
import { GuideArticle, GuideIndex } from './pages/Guides.jsx';
import NotFound, { RouteError } from './pages/NotFound.jsx';
import ToolPage from './pages/ToolPage.jsx';

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
    const site = await loadSite();
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

start().catch((error) => {
    // Keep the server-rendered page visible if the app cannot start.
    document.documentElement.classList.remove('js');
    console.error('The app failed to start:', error);
});
