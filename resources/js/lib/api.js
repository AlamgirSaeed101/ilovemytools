// Data layer for the React app. The first page's data is embedded in the HTML
// by Laravel (<script id="boot-data">); everything else comes from /api/*.
// Responses are cached in memory so navigating back and forth is instant.

export class NotFoundError extends Error {
    constructor(message = 'Not found') {
        super(message);
        this.name = 'NotFoundError';
        this.status = 404;
    }
}

function readBoot() {
    if (typeof document === 'undefined') return {};
    try {
        return JSON.parse(document.getElementById('boot-data')?.textContent || '{}');
    } catch {
        return {};
    }
}

const boot = readBoot();
const cache = new Map();

if (boot.page?.data && boot.page.slug) {
    cache.set(`${boot.page.type}:${boot.page.slug}`, boot.page.data);
}

/** The page type Laravel rendered (e.g. "notfound"), used once on first load. */
export const initialPage = boot.page ?? null;

let site = boot.site ?? null;

export async function getJson(url) {
    const res = await fetch(url, { headers: { Accept: 'application/json' } });
    if (res.status === 404) throw new NotFoundError();
    if (!res.ok) throw new Error(`The server responded with ${res.status}. Please try again.`);
    return res.json();
}

function cached(key, load) {
    if (cache.has(key)) return cache.get(key);
    const promise = load().then(
        (data) => {
            cache.set(key, data);
            return data;
        },
        (error) => {
            cache.delete(key);
            throw error;
        },
    );
    cache.set(key, promise);
    return promise;
}

/** Site settings, categories and the tool list (always embedded, fetched as a fallback). */
export async function loadSite() {
    if (!site) site = await getJson('/api/site');
    return site;
}

export function getSite() {
    if (!site) throw new Error('Site data has not been loaded yet.');
    return site;
}

/** ?locale=xx for non-default languages, so the API answers in the page's language. */
function localeQuery() {
    return site && site.locale && site.locale !== site.defaultLocale ? `?locale=${encodeURIComponent(site.locale)}` : '';
}

export function loadTool(slug) {
    return cached(`tool:${slug}`, () => getJson(`/api/tools/${encodeURIComponent(slug)}${localeQuery()}`));
}

export function loadCategory(slug) {
    return cached(`category:${slug}`, () => getJson(`/api/categories/${encodeURIComponent(slug)}${localeQuery()}`));
}
