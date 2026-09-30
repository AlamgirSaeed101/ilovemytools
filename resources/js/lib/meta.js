// Keeps <head> in sync on in-app navigation. The first page's tags are
// rendered by Laravel; these updates cover pages opened with client routing.
import { useEffect } from 'react';
import { getSite } from './api.js';

function setMeta(selector, attr, value) {
    const el = document.head.querySelector(selector);
    if (el) el.setAttribute(attr, value);
}

/** Absolute URL of a logical path ("/merge-pdf") in a language. */
function localUrl(siteUrl, path, code, site) {
    const base = siteUrl.replace(/\/$/, '');
    const prefix = code === site.defaultLocale ? '' : `/${code}`;
    if (path === '/') return prefix ? `${base}${prefix}` : `${base}/`;
    return `${base}${prefix}${path}`;
}

/** hreflang links to this page in every language (+ x-default), or none for noindex pages. */
function syncAlternates(siteUrl, path, noindex, site) {
    document.head.querySelectorAll('link[rel="alternate"][hreflang]').forEach((el) => el.remove());
    if (noindex || path === undefined) return;
    const canonical = document.head.querySelector('link[rel="canonical"]');
    const links = [...site.locales.map((l) => [l.hreflang, localUrl(siteUrl, path, l.code, site)]), ['x-default', localUrl(siteUrl, path, site.defaultLocale, site)]];
    for (const [hreflang, href] of links) {
        const link = document.createElement('link');
        link.rel = 'alternate';
        link.hreflang = hreflang;
        link.href = href;
        canonical ? canonical.after(link) : document.head.append(link);
    }
}

export function applyMeta({ title, description, path, noindex = false }, siteUrl) {
    const site = getSite();
    if (title) {
        document.title = title;
        setMeta('meta[property="og:title"]', 'content', title);
        setMeta('meta[name="twitter:title"]', 'content', title);
    }
    if (description) {
        setMeta('meta[name="description"]', 'content', description);
        setMeta('meta[property="og:description"]', 'content', description);
        setMeta('meta[name="twitter:description"]', 'content', description);
    }
    if (path !== undefined && siteUrl) {
        const url = localUrl(siteUrl, path, site.locale, site);
        setMeta('link[rel="canonical"]', 'href', url);
        setMeta('meta[property="og:url"]', 'content', url);
    }
    if (siteUrl) syncAlternates(siteUrl, path, noindex, site);
    setMeta('meta[name="robots"]', 'content', noindex ? 'noindex, follow' : 'index, follow, max-image-preview:large');
}

export function useMeta(meta, siteUrl) {
    const { title, description, path, noindex } = meta;
    useEffect(() => {
        applyMeta({ title, description, path, noindex }, siteUrl);
    }, [title, description, path, noindex, siteUrl]);
}
