// ILoveMyTools service worker: makes the site installable and lets the browser-only tools work
// offline once they have been opened.
//
// - Hashed build files (/build/...), fonts, images and models: cache first (their names change
//   whenever their content does, so a cached copy is never stale).
// - Pages and the page data the app fetches (/api/site, /api/tools/..., /api/categories/...,
//   /api/guides/...): network first, falling back to the last copy when offline.
// - Everything else - other /api calls (IP lookup, link checker, contact, newsletter...), POST
//   requests and other sites (ads, analytics) - goes straight to the network and is never cached.
//
// Bump VERSION to drop every cached file on the next visit.
const VERSION = 'v1';
const STATIC = `static-${VERSION}`;
const PAGES = `pages-${VERSION}`;
const SHELL = ['/', '/site.webmanifest', '/favicon.svg', '/images/icon-192.png', '/images/logo-512.png'];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches
            .open(PAGES)
            .then((cache) => cache.addAll(SHELL))
            .catch(() => undefined)
            .then(() => self.skipWaiting()),
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches
            .keys()
            .then((keys) => Promise.all(keys.filter((key) => key !== STATIC && key !== PAGES).map((key) => caches.delete(key))))
            .then(() => self.clients.claim()),
    );
});

const isStatic = (path) => /^\/(build|fonts|images|models)\//.test(path) || /\.(?:png|svg|ico|webmanifest|woff2?)$/.test(path);
const isPageData = (path) => /^\/api\/(site|tools\/|categories\/|guides\/)/.test(path);

async function cacheFirst(request) {
    const cached = await caches.match(request);
    if (cached) return cached;
    const response = await fetch(request);
    if (response.ok && response.type === 'basic') {
        const copy = response.clone();
        caches.open(STATIC).then((cache) => cache.put(request, copy));
    }
    return response;
}

async function networkFirst(request, fallbackToHome) {
    try {
        const response = await fetch(request);
        if (response.ok && response.type === 'basic') {
            const copy = response.clone();
            caches.open(PAGES).then((cache) => cache.put(request, copy));
        }
        return response;
    } catch (error) {
        const cached = await caches.match(request, { ignoreVary: true });
        if (cached) return cached;
        if (fallbackToHome) {
            const home = await caches.match('/');
            if (home) return home;
        }
        throw error;
    }
}

self.addEventListener('fetch', (event) => {
    const { request } = event;
    if (request.method !== 'GET') return;
    const url = new URL(request.url);
    if (url.origin !== self.location.origin) return;

    if (request.mode === 'navigate') {
        event.respondWith(networkFirst(request, true));
    } else if (isPageData(url.pathname)) {
        event.respondWith(networkFirst(request, false));
    } else if (isStatic(url.pathname)) {
        event.respondWith(cacheFirst(request));
    }
});
