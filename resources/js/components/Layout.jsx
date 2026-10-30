import { lazy, Suspense, useCallback, useEffect, useRef, useState } from 'react';
import { Link, Outlet, ScrollRestoration, useLocation, useNavigation } from 'react-router';
import AdSlot from './AdSlot.jsx';
import Icon from './Icon.jsx';
import { getSite } from '../lib/api.js';
import { t } from '../lib/i18n.js';
import { usePageMotion } from '../lib/pageMotion.js';

// Not needed for first paint, so they're kept out of the main bundle: the command palette is
// closed until opened, the newsletter form sits below the fold, and the ad-block notice only
// ever renders something after its own 3 s detection delay.
const AdblockNotice = lazy(() => import('./AdblockNotice.jsx'));
const CommandPalette = lazy(() => import('./CommandPalette.jsx'));
const NewsletterForm = lazy(() => import('./Newsletter.jsx'));
const NewsletterNotice = lazy(() => import('./Newsletter.jsx').then((m) => ({ default: m.NewsletterNotice })));

const isMac = typeof navigator !== 'undefined' && /Mac|iPhone|iPad/.test(navigator.platform || navigator.userAgent);

// Shared Tailwind class strings.
const iconBtn =
    'inline-grid size-10 place-items-center rounded-full border border-line bg-surface text-ink-2 transition-colors hover:border-line-strong hover:bg-surface-2 hover:text-ink cursor-pointer';
const navLink =
    'inline-flex h-10 shrink-0 items-center gap-1 whitespace-nowrap rounded-xl border-0 bg-transparent px-3 font-[inherit] text-[0.9rem] font-semibold text-ink-2 no-underline transition-colors hover:bg-surface-2 hover:text-ink aria-expanded:bg-surface-2 aria-expanded:text-ink [&.active]:text-brand cursor-pointer';
const tile = 'inline-grid size-7 shrink-0 place-items-center rounded-lg bg-[linear-gradient(135deg,var(--accent),var(--accent2,var(--accent)))] text-white shadow-hair [&_svg]:size-3.5';

/** Close a popup on outside click or Escape (focus returns to its button). */
function usePopup(open, setOpen, ref) {
    const location = useLocation();
    useEffect(() => setOpen(false), [location.pathname, setOpen]);
    useEffect(() => {
        if (!open) return undefined;
        const onDown = (e) => {
            if (!ref.current?.contains(e.target)) setOpen(false);
        };
        const onKey = (e) => {
            if (e.key === 'Escape') {
                setOpen(false);
                ref.current?.querySelector('button')?.focus();
            }
        };
        document.addEventListener('pointerdown', onDown);
        document.addEventListener('keydown', onKey);
        return () => {
            document.removeEventListener('pointerdown', onDown);
            document.removeEventListener('keydown', onKey);
        };
    }, [open, setOpen, ref]);
}

// Light is the default (set on <html> by Laravel); a saved choice overrides it.
function currentTheme() {
    return document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
}

function ThemeToggle() {
    const [theme, setTheme] = useState(currentTheme);

    function toggle() {
        const next = theme === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', next);
        document.querySelector('meta[name="theme-color"]')?.setAttribute('content', next === 'dark' ? '#0b1020' : '#ffffff');
        try {
            localStorage.setItem('theme', next);
        } catch {
            // not saved, but still applied for this visit
        }
        setTheme(next);
    }

    return (
        <button type="button" className={iconBtn} onClick={toggle} aria-label={theme === 'dark' ? t('Switch to light mode') : t('Switch to dark mode')} title={t('Toggle dark mode')}>
            <Icon name={theme === 'dark' ? 'sun' : 'moon'} />
        </button>
    );
}

function Logo({ name, footer = false }) {
    const h = footer ? 'h-9' : 'h-[30px] sm:h-10';
    return (
        <Link className="inline-flex shrink-0 items-center no-underline" to="/" aria-label={t('{name} home', { name })}>
            <img className={`${h} w-auto block dark:hidden`} src="/images/logo.svg?v=3" alt={name} width="1103" height="234" />
            <img className={`${h} w-auto hidden dark:block`} src="/images/logo-white.svg?v=3" alt={name} width="1103" height="234" />
        </Link>
    );
}

// Header order: the busiest categories first (the rest go under "More").
const NAV_ORDER = ['pdf-tools', 'image-tools', 'text-tools', 'calculators', 'developer-tools', 'generators', 'games', 'time-tools'];
const NAV_VISIBLE = 5;

/** One header dropdown: a category's tools, plus a link to the category page. */
const NAV_MENU_TOOLS = 5;

function CategoryMenu({ category, tools, label, children }) {
    const [open, setOpen] = useState(false);
    const ref = useRef(null);
    usePopup(open, setOpen, ref);
    const all = category ? category.tools.map((slug) => tools.find((x) => x.slug === slug)).filter(Boolean) : [];
    // At most NAV_MENU_TOOLS per menu, popular tools first; the link below leads to the whole category.
    const items = [...all].sort((a, b) => Number(b.popular) - Number(a.popular)).slice(0, NAV_MENU_TOOLS);

    return (
        <div className="relative" ref={ref} style={category ? { '--accent': category.accent, '--accent2': category.accent2 } : undefined}>
            <button type="button" className={navLink} aria-expanded={open} aria-haspopup="true" onClick={() => setOpen((o) => !o)}>
                {label} <Icon name="chevron" className={`icon size-3.5 opacity-70 transition-transform ${open ? 'rotate-180' : ''}`} />
            </button>
            {open && (
                <div className="animate-pop absolute top-full z-50 mt-2 w-72 rounded-2xl border border-line bg-surface p-2 shadow-float start-0">
                    {children ?? (
                        <>
                            <ul className="m-0 list-none p-0">
                                {items.map((x) => (
                                    <li key={x.slug}>
                                        <Link className="flex items-center gap-3 rounded-xl px-2.5 py-2 text-[0.9rem] font-semibold text-ink no-underline hover:bg-surface-2" to={`/${x.slug}`}>
                                            <span className={tile}>
                                                <Icon name={x.icon} />
                                            </span>
                                            {x.name}
                                        </Link>
                                    </li>
                                ))}
                            </ul>
                            <Link
                                className="mt-1 flex items-center justify-between rounded-xl border-t border-line px-2.5 pt-2.5 pb-1.5 text-[0.8rem] font-bold text-brand no-underline hover:text-brand-strong"
                                to={`/category/${category.slug}`}
                            >
                                {t('View all {count} tools', { count: all.length })} <Icon name="arrow" className="icon size-4 rtl:-scale-x-100" />
                            </Link>
                        </>
                    )}
                </div>
            )}
        </div>
    );
}

/** Category dropdowns in the header, in NAV_ORDER; the remaining categories sit under "More". */
function CategoryNav({ categories, tools }) {
    const ordered = [...categories].sort((a, b) => NAV_ORDER.indexOf(a.slug) - NAV_ORDER.indexOf(b.slug));
    const visible = ordered.slice(0, NAV_VISIBLE);
    const more = ordered.slice(NAV_VISIBLE);

    return (
        <>
            {visible.map((c) => (
                <CategoryMenu key={c.slug} category={c} tools={tools} label={c.short || c.name} />
            ))}
            {more.length > 0 && (
                <CategoryMenu tools={tools} label={t('More')}>
                    <ul className="m-0 list-none p-0">
                        {more.map((c) => (
                            <li key={c.slug}>
                                <Link
                                    className="flex items-center gap-3 rounded-xl px-2.5 py-2 text-[0.9rem] font-semibold text-ink no-underline hover:bg-surface-2"
                                    to={`/category/${c.slug}`}
                                    style={{ '--accent': c.accent, '--accent2': c.accent2 }}
                                >
                                    <span className={tile}>
                                        <Icon name={c.icon} />
                                    </span>
                                    <span>
                                        <span className="block">{c.name}</span>
                                        <span className="block text-[0.75rem] font-medium text-muted">{c.subtitle}</span>
                                    </span>
                                </Link>
                            </li>
                        ))}
                    </ul>
                </CategoryMenu>
            )}
        </>
    );
}

/** Link to the current page in another language (a full page load, so everything switches). */
function useLanguageHref() {
    const site = getSite();
    const location = useLocation();
    return (code) => {
        const prefix = code === site.defaultLocale ? '' : `/${code}`;
        // Guides are English only (/es/guides/... doesn't exist), so other languages go to their home page.
        if (/^\/guides(\/|$)/.test(location.pathname)) return prefix || '/';
        const path = location.pathname === '/' ? '' : location.pathname;
        return `${prefix}${path}${location.search}` || '/';
    };
}

/** Plain list of language links, used in the mobile menu and the footer. */
function LanguageLinks({ className, linkClass }) {
    const site = getSite();
    const hrefFor = useLanguageHref();
    return (
        <ul className={className} aria-label={t('Languages')}>
            {site.locales.map((l) => (
                <li key={l.code}>
                    <a
                        href={hrefFor(l.code)}
                        hrefLang={l.hreflang}
                        lang={l.code}
                        dir={l.dir}
                        aria-current={l.code === site.locale ? 'true' : undefined}
                        className={linkClass}
                    >
                        {l.native}
                    </a>
                </li>
            ))}
        </ul>
    );
}

/** Language menu. Each option is a normal link, so the new page loads fully in that language. */
function LanguageMenu() {
    const site = getSite();
    const [open, setOpen] = useState(false);
    const ref = useRef(null);
    const hrefFor = useLanguageHref();
    usePopup(open, setOpen, ref);

    const current = site.locales.find((l) => l.code === site.locale);
    // One column of native names, ordered by their English name (Arabic, Chinese, English, French…).
    const sorted = [...site.locales].sort((a, b) => a.name.localeCompare(b.name, 'en'));

    // On phones the panel is placed against the (sticky) header so it spans the screen
    // instead of hanging off the button and running past the left edge.
    return (
        <div className="max-[359px]:hidden sm:relative" ref={ref}>
            <button
                type="button"
                className="inline-flex h-10 cursor-pointer items-center gap-2 rounded-xl border border-line bg-surface px-3 text-ink-2 shadow-[0_1px_3px_rgb(15_23_42/0.06)] transition-colors hover:border-line-strong hover:text-ink md:min-w-[150px] md:px-3.5"
                aria-expanded={open}
                aria-haspopup="true"
                aria-label={t('Language: {language}', { language: current?.native ?? site.locale })}
                onClick={() => setOpen((o) => !o)}
            >
                <Icon name="globe" />
                <span className="hidden flex-1 text-start text-[0.92rem] font-medium md:inline" lang={site.locale}>
                    {current?.native ?? site.locale}
                </span>
                <Icon name="chevron" className={`icon hidden size-3.5 opacity-60 transition-transform md:inline ${open ? 'rotate-180' : ''}`} />
            </button>
            {open && (
                <div className="animate-pop absolute inset-x-3 top-full z-50 mt-2 overflow-hidden rounded-2xl border border-line bg-surface shadow-float sm:inset-x-auto sm:end-0 sm:mt-2.5 sm:w-[300px]">
                    <ul className="m-0 max-h-[min(70vh,560px)] list-none overflow-y-auto p-0" aria-label={t('Choose your language')}>
                        {sorted.map((l) => (
                            <li key={l.code} className="border-b border-line last:border-b-0">
                                <a
                                    href={hrefFor(l.code)}
                                    hrefLang={l.hreflang}
                                    lang={l.code}
                                    dir={l.dir}
                                    aria-current={l.code === site.locale ? 'true' : undefined}
                                    className="flex items-center justify-between gap-3 px-6 py-3.5 text-[0.95rem] text-ink no-underline transition-colors hover:bg-surface-2 aria-[current]:bg-surface-2"
                                >
                                    <span>{l.native}</span>
                                    {l.code === site.locale && (
                                        <span className="grid size-5 shrink-0 place-items-center rounded-full border border-muted text-muted [&_svg]:size-3" aria-hidden="true">
                                            <Icon name="check" />
                                        </span>
                                    )}
                                </a>
                            </li>
                        ))}
                    </ul>
                </div>
            )}
        </div>
    );
}

function Header({ onSearch }) {
    const site = getSite();
    const [mobileOpen, setMobileOpen] = useState(false);
    const location = useLocation();

    useEffect(() => setMobileOpen(false), [location.pathname]);

    const mobileLink = 'flex items-center gap-3 border-b border-line px-1.5 py-3 font-semibold text-ink no-underline last:border-b-0';

    return (
        <header className="sticky top-0 z-40 border-b border-line bg-surface/90 backdrop-blur-md backdrop-saturate-150">
            <div className="shell flex min-h-16 items-center gap-3 sm:gap-5">
                <Logo name={site.name} />

                <nav className="hidden min-w-0 flex-1 items-center justify-center gap-0.5 lg:flex" aria-label={t('Main')}>
                    <CategoryNav categories={site.categories} tools={site.tools} />
                </nav>

                <div className="ms-auto flex shrink-0 items-center gap-1.5 sm:gap-2">
                    <button
                        type="button"
                        className="inline-flex h-10 w-10 cursor-pointer items-center justify-center gap-2 rounded-full border border-line bg-surface-2 text-[0.88rem] font-medium text-muted transition hover:border-line-strong hover:bg-surface lg:w-auto lg:min-w-44 lg:justify-start lg:ps-3.5 lg:pe-2 xl:min-w-60"
                        onClick={onSearch}
                        aria-label={t('Search tools')}
                        aria-keyshortcuts={isMac ? 'Meta+K' : 'Control+K'}
                    >
                        <Icon name="search" />
                        <span className="hidden max-w-40 truncate lg:inline">{t('Search tools…')}</span>
                        <kbd className="kbd ms-auto hidden lg:inline-flex">{isMac ? '⌘' : 'Ctrl'} K</kbd>
                    </button>
                    <LanguageMenu />
                    <ThemeToggle />
                    <button
                        type="button"
                        className={`${iconBtn} lg:hidden`}
                        aria-expanded={mobileOpen}
                        aria-controls="mobile-nav"
                        aria-label={mobileOpen ? t('Close menu') : t('Open menu')}
                        onClick={() => setMobileOpen((o) => !o)}
                    >
                        <Icon name={mobileOpen ? 'x' : 'menu'} />
                    </button>
                </div>
            </div>

            {mobileOpen && (
                <nav id="mobile-nav" className="animate-slide-down border-t border-line bg-surface pt-2 pb-4" aria-label={t('Mobile')}>
                    <div className="shell">
                        <Link className={mobileLink} to="/">
                            <Icon name="grid" /> {t('All tools')}
                        </Link>
                        {site.categories.map((c) => (
                            <Link key={c.slug} className={mobileLink} to={`/category/${c.slug}`} style={{ '--accent': c.accent, '--accent2': c.accent2 }}>
                                <span className={tile}>
                                    <Icon name={c.icon} />
                                </span>
                                {c.name}
                            </Link>
                        ))}
                        <Link className={mobileLink} to="/about">{t('About')}</Link>
                        <Link className={mobileLink} to="/contact">{t('Contact')}</Link>
                        <p className="m-0 mt-4 mb-2 flex items-center gap-2 px-1.5 text-xs font-extrabold tracking-wider text-muted uppercase">
                            <Icon name="globe" /> {t('Language')}
                        </p>
                        <LanguageLinks
                            className="m-0 grid list-none grid-cols-2 gap-1.5 p-0"
                            linkClass="block rounded-[10px] border border-line px-3 py-2 font-semibold text-ink no-underline aria-[current]:border-brand aria-[current]:bg-brand/15 aria-[current]:text-brand"
                        />
                    </div>
                </nav>
            )}
        </header>
    );
}

function Footer() {
    const site = getSite();
    const toolsIn = (c) => c.tools.map((slug) => site.tools.find((x) => x.slug === slug)).filter(Boolean);
    const link = 'text-muted no-underline hover:text-brand [overflow-wrap:anywhere] hyphens-auto';

    return (
        <footer className="mt-12 border-t border-line bg-surface pt-10 pb-6 text-[0.92rem]">
            <div className="shell">
                <div className="rounded-2xl border border-line bg-surface-2 p-5 sm:p-6">
                    <Suspense fallback={null}>
                        <NewsletterForm compact />
                    </Suspense>
                </div>

                <div className="mt-10 grid gap-8 lg:grid-cols-[250px_1fr] lg:gap-12">
                    <div className="min-w-0">
                        <Logo name={site.name} footer />
                        <p className="mt-3 mb-4 max-w-[320px] text-muted">{t('Free online tools that run in your browser. No sign up, no uploads, no watermarks.')}</p>
                        <ul className="m-0 flex list-none flex-wrap gap-1.5 p-0">
                            {[
                                ['shield', 'Private'],
                                ['gift', 'Free'],
                                ['zap', 'Fast'],
                            ].map(([icon, label]) => (
                                <li key={label} className="inline-flex items-center gap-1 rounded-full bg-surface-2 px-2.5 py-0.5 text-[0.8rem] font-semibold text-ink-2">
                                    <Icon name={icon} /> {t(label)}
                                </li>
                            ))}
                        </ul>
                    </div>
                    {/* Columns (not a grid) so short and long categories pack without gaps. */}
                    <nav className="columns-2 gap-x-6 sm:columns-3 xl:columns-4" aria-label={t('All tools')}>
                        {site.categories.map((c) => (
                            <div key={c.slug} className="mb-6 break-inside-avoid">
                                <p className="m-0 mb-2 text-[0.8rem] font-bold tracking-wider uppercase">
                                    <Link className="text-ink no-underline hover:text-brand" to={`/category/${c.slug}`}>
                                        {c.name}
                                    </Link>
                                </p>
                                <ul className="m-0 list-none space-y-1 p-0">
                                    {toolsIn(c).map((x) => (
                                        <li key={x.slug}>
                                            <Link className={link} to={`/${x.slug}`}>
                                                {x.name}
                                            </Link>
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        ))}
                    </nav>
                </div>

                <div className="mt-4 flex flex-col gap-3 border-t border-line pt-5 lg:flex-row lg:items-center lg:justify-between">
                    <div className="flex flex-wrap items-center gap-x-4 gap-y-1.5">
                        <span className="inline-flex items-center gap-1.5 text-[0.8rem] font-bold tracking-wider text-ink uppercase">
                            <Icon name="globe" /> {t('Language')}
                        </span>
                        <LanguageLinks
                            className="m-0 flex list-none flex-wrap gap-x-3.5 gap-y-1 p-0"
                            linkClass={`${link} aria-[current]:font-bold aria-[current]:text-brand`}
                        />
                    </div>
                    <ul className="m-0 flex list-none flex-wrap gap-x-4 gap-y-1 p-0">
                        <li><Link className={link} to="/about">{t('About')}</Link></li>
                        <li><Link className={link} to="/contact">{t('Contact')}</Link></li>
                        <li><Link className={link} to="/privacy-policy">{t('Privacy Policy')}</Link></li>
                        <li><Link className={link} to="/terms">{t('Terms of Use')}</Link></li>
                        <li>
                            {/* In every language, and a plain link: guides are English only, so the router must not add a language prefix (/es/guides would redirect). */}
                            <a className={link} href="/guides">
                                {t('All guides')}
                            </a>
                        </li>
                        <li><a className={link} href="/sitemap.xml">{t('Sitemap')}</a></li>
                        {site.linkedin && (
                            <li>
                                <a className={link} href={site.linkedin} target="_blank" rel="noopener">LinkedIn</a>
                            </li>
                        )}
                        {site.productHunt && (
                            <li>
                                <a className={link} href={site.productHunt} target="_blank" rel="noopener">
                                    ★ {t('Review us on Product Hunt')}
                                </a>
                            </li>
                        )}
                    </ul>
                </div>
                {site.badges?.length > 0 && (
                    <div className="mt-4 flex flex-wrap items-center gap-3">
                        {site.badges.map((b) => (
                            <a key={b.url} className="inline-block leading-none" href={b.url} target="_blank" rel="noopener noreferrer">
                                <img className="block dark:hidden" src={b.light} alt={b.alt} height={b.height} style={{ height: b.height, width: 'auto' }} loading="lazy" />
                                <img className="hidden dark:block" src={b.dark} alt={b.alt} height={b.height} style={{ height: b.height, width: 'auto' }} loading="lazy" />
                            </a>
                        ))}
                    </div>
                )}
                <p className="mt-4 mb-0 text-[0.85rem] text-muted">
                    © {new Date().getFullYear()} {site.name}. {t('All rights reserved.')}
                </p>
            </div>
        </footer>
    );
}

/** Appears after scrolling down; smooth-scrolls back to the top. */
function BackToTop() {
    const [shown, setShown] = useState(false);
    useEffect(() => {
        const onScroll = () => setShown(window.scrollY > 700);
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
        return () => window.removeEventListener('scroll', onScroll);
    }, []);
    return (
        <button
            type="button"
            className={`back-to-top${shown ? ' is-shown' : ''}`}
            onClick={() => window.scrollTo({ top: 0, behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth' })}
            aria-label={t('Back to top')}
            tabIndex={shown ? 0 : -1}
            aria-hidden={!shown}
        >
            <Icon name="chevron" />
        </button>
    );
}

/** Thin progress bar while the next page's data loads. */
function ProgressBar() {
    const navigation = useNavigation();
    return <div className={`progress${navigation.state !== 'idle' ? ' is-active' : ''}`} aria-hidden="true" />;
}

function usePageFocus() {
    const location = useLocation();
    const first = useRef(true);
    const mainRef = useRef(null);

    useEffect(() => {
        if (first.current) {
            first.current = false;
            return;
        }
        // Move focus to the new page for keyboard and screen reader users.
        mainRef.current?.focus({ preventScroll: true });
    }, [location.pathname]);

    return mainRef;
}

/** True once the browser is idle (or after a short timeout), so heavy below-the-fold
 *  content like the full footer link grid isn't part of the first, time-critical render. */
function useIdle() {
    const [idle, setIdle] = useState(false);
    useEffect(() => {
        const ric = window.requestIdleCallback || ((cb) => setTimeout(cb, 300));
        const cic = window.cancelIdleCallback || clearTimeout;
        const id = ric(() => setIdle(true), { timeout: 1500 });
        return () => cic(id);
    }, []);
    return idle;
}

export default function Layout() {
    const [paletteOpen, setPaletteOpen] = useState(false);
    const location = useLocation();
    const mainRef = usePageFocus();
    const idle = useIdle();
    usePageMotion(location.pathname, mainRef);
    const openPalette = useCallback(() => setPaletteOpen(true), []);
    const closePalette = useCallback(() => setPaletteOpen(false), []);

    useEffect(() => {
        // Ctrl+K (or "/") may have been pressed before this effect could attach its own
        // listener below - app.jsx catches that case as early as it can and flags it here.
        if (window.__earlyPaletteIntent) {
            window.__earlyPaletteIntent = false;
            setPaletteOpen(true);
        }
        const onKey = (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                setPaletteOpen((o) => !o);
                return;
            }
            const el = e.target;
            const typing = el instanceof HTMLElement && (el.isContentEditable || /^(INPUT|TEXTAREA|SELECT)$/.test(el.tagName));
            if (e.key === '/' && !typing && !e.ctrlKey && !e.metaKey && !e.altKey) {
                e.preventDefault();
                setPaletteOpen(true);
            }
        };
        document.addEventListener('keydown', onKey);
        return () => document.removeEventListener('keydown', onKey);
    }, []);

    return (
        <>
            <a className="skip-link" href="#main">
                {t('Skip to content')}
            </a>
            <ProgressBar />
            <Header onSearch={openPalette} />
            <main id="main" className="flex-1 pb-12 outline-none" tabIndex={-1} ref={mainRef}>
                <Suspense fallback={null}>
                    <NewsletterNotice />
                </Suspense>
                <Outlet />
            </main>
            <div className="shell">
                <AdSlot key={`footer-${location.pathname}`} position="footer" />
            </div>
            {idle && <Footer />}
            <Suspense fallback={null}>
                <CommandPalette open={paletteOpen} onClose={closePalette} />
            </Suspense>
            <BackToTop />
            <Suspense fallback={null}>
                <AdblockNotice />
            </Suspense>
            <ScrollRestoration />
        </>
    );
}
