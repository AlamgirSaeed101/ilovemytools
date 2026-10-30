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

/** Languages search engines may index (same rule as Laravel's Locale::indexable()). */
function indexableLocales(site) {
    return site.locales.filter((l) => l.code === site.defaultLocale || (site.indexable ?? site.locales.map((x) => x.code)).includes(l.code));
}

/**
 * hreflang links to this page in every indexable language (+ x-default), or none for noindex
 * pages and English-only pages (legal pages, guides), so they never point at a redirect or noindex page.
 */
function syncAlternates(siteUrl, path, noindex, englishOnly, site) {
    document.head.querySelectorAll('link[rel="alternate"][hreflang]').forEach((el) => el.remove());
    if (noindex || englishOnly || path === undefined) return;
    const canonical = document.head.querySelector('link[rel="canonical"]');
    const links = [...indexableLocales(site).map((l) => [l.hreflang, localUrl(siteUrl, path, l.code, site)]), ['x-default', localUrl(siteUrl, path, site.defaultLocale, site)]];
    for (const [hreflang, href] of links) {
        const link = document.createElement('link');
        link.rel = 'alternate';
        link.hreflang = hreflang;
        link.href = href;
        canonical ? canonical.after(link) : document.head.append(link);
    }
}

/**
 * `englishOnly`: the page is indexed in English only (legal pages, guides) - no hreflang, and its
 * copies in other languages are noindex. Languages outside site.indexable are always noindex.
 */
export function applyMeta({ title, description, path, noindex = false, englishOnly = false }, siteUrl) {
    const site = getSite();
    const isDefault = site.locale === site.defaultLocale;
    noindex = noindex || !indexableLocales(site).some((l) => l.code === site.locale) || (englishOnly && !isDefault);
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
        // A 404 is served without a canonical; add one when the visitor moves on to a real page.
        if (!document.head.querySelector('link[rel="canonical"]')) {
            const link = document.createElement('link');
            link.rel = 'canonical';
            document.head.append(link);
        }
        setMeta('link[rel="canonical"]', 'href', url);
        setMeta('meta[property="og:url"]', 'content', url);
    }
    if (siteUrl) syncAlternates(siteUrl, path, noindex, englishOnly, site);
    setMeta('meta[name="robots"]', 'content', noindex ? 'noindex, follow' : 'index, follow, max-image-preview:large');
}

export function useMeta(meta, siteUrl) {
    const { title, description, path, noindex, englishOnly } = meta;
    useEffect(() => {
        applyMeta({ title, description, path, noindex, englishOnly }, siteUrl);
    }, [title, description, path, noindex, englishOnly, siteUrl]);
}
