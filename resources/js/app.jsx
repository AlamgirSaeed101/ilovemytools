import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import { createBrowserRouter } from 'react-router';
import { RouterProvider } from 'react-router/dom';
import Layout from './components/Layout.jsx';
import { getJson, getSite, initialPage, loadCategory, loadSite, loadTool, NotFoundError } from './lib/api.js';
import { initI18n } from './lib/i18n.js';
import Category from './pages/Category.jsx';
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
                // Keeps Layout (header, footer, command palette) mounted immediately on a full page
                // load while the matched page's own lazy chunk and loader are still resolving.
                HydrateFallback: () => null,
                children: [
                    { index: true, lazy: () => import('./pages/Home.jsx').then((m) => ({ Component: m.default })) },
                    { path: 'about', lazy: () => import('./pages/InfoPages.jsx').then((m) => ({ Component: m.About })) },
                    { path: 'contact', lazy: () => import('./pages/InfoPages.jsx').then((m) => ({ Component: m.Contact })) },
                    { path: 'privacy-policy', lazy: () => import('./pages/InfoPages.jsx').then((m) => ({ Component: m.Privacy })) },
                    { path: 'terms', lazy: () => import('./pages/InfoPages.jsx').then((m) => ({ Component: m.Terms })) },
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

async function start() {
    const container = document.getElementById('app');
    if (!container) return;
    const site = await loadSite();
    initI18n(site);

    // The language prefix (/es) is the router's basename, so every <Link to="/merge-pdf">
    // stays in the current language automatically.
    const router = createBrowserRouter(routes, { basename: site.prefix || '/', hydrationData: hydrationData() });

    createRoot(container).render(
        <StrictMode>
            <RouterProvider router={router} />
        </StrictMode>,
    );
}

start().catch((error) => {
    // Keep the server-rendered page visible if the app cannot start.
    document.documentElement.classList.remove('js');
    console.error('The app failed to start:', error);
});
