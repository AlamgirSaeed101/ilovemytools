import { useRef, useState } from 'react';
import { Link } from 'react-router';
import AdSlot from '../components/AdSlot.jsx';
import Icon from '../components/Icon.jsx';
import ToolCard, { categoryOf } from '../components/ToolCard.jsx';
import { getSite } from '../lib/api.js';
import { formatNumber, t, tn } from '../lib/i18n.js';
import { useMeta } from '../lib/meta.js';

const PROMISE = [
    'Your PDFs, photos and documents never leave your browser',
    'No sign up, no email address, no watermarks on your files',
    'Instant results - no waiting in an upload or download queue',
];

// Order of the category cards and filter pills (busiest first).
const CATEGORY_ORDER = ['pdf-tools', 'image-tools', 'text-tools', 'calculators', 'developer-tools', 'generators', 'games', 'time-tools'];
const POPULAR_LIMIT = 15;

const eyebrow = 'm-0 mb-1.5 text-[0.72rem] font-extrabold tracking-[0.14em] text-brand uppercase';
const sectionTitle = 'm-0 text-[clamp(1.6rem,3vw,2.1rem)] font-extrabold tracking-tight';
const gradient = { background: 'linear-gradient(135deg, var(--accent), var(--accent2, var(--accent)))' };

const byOrder = (a, b) => CATEGORY_ORDER.indexOf(a.slug) - CATEGORY_ORDER.indexOf(b.slug);

/** A white "floating" icon bubble used in the hero decoration. */
function Bubble({ icon, category, className = '' }) {
    const c = categoryOf(category);
    return (
        <span
            className={`absolute grid place-items-center rounded-full bg-white shadow-[0_10px_24px_-10px_rgb(15_23_42/0.35)] [&_svg]:size-1/2 ${className}`}
            style={c ? { color: c.accent } : undefined}
        >
            <Icon name={icon} />
        </span>
    );
}

/** The decorative cards around the hero (desktop only). Every figure on them is true for this site. */
function HeroDecoration({ site }) {
    return (
        <div className="pointer-events-none absolute inset-0 hidden lg:block" aria-hidden="true">
            {/* Left: icon bubbles card joined to the "100%" card */}
            <div className="absolute top-24 -start-10 h-56 w-72 rounded-[36px] bg-[linear-gradient(135deg,#dbeafe,#e0e7ff)] dark:opacity-80">
                <Bubble icon="pdf" category="pdf-tools" className="top-7 start-16 size-20" />
                <Bubble icon="image" category="image-tools" className="top-6 start-40 size-11" />
                <Bubble icon="qr" category="generators" className="top-20 start-52 size-14" />
                <Bubble icon="text" category="text-tools" className="top-32 start-12 size-12" />
                <Bubble icon="calculator" category="calculators" className="top-36 start-32 size-10" />
                <Bubble icon="dice" category="games" className="top-36 start-48 size-9" />
            </div>
            <div className="absolute top-[17rem] start-28 h-48 w-56 rounded-[36px] bg-[linear-gradient(160deg,#ccfbf1,#d1fae5)] p-5 dark:opacity-80">
                <div className="grid h-full place-items-center rounded-2xl bg-white p-3 text-center shadow-[0_12px_28px_-14px_rgb(15_23_42/0.35)]">
                    <div>
                        <span className="flex items-center justify-center gap-1.5 text-[2rem] leading-none font-extrabold text-slate-900">
                            <span className="text-blue-600 [&_svg]:size-7">
                                <Icon name="shield" />
                            </span>
                            100%
                        </span>
                        <span className="mt-2 block text-[0.62rem] leading-tight font-extrabold tracking-wider text-slate-500 uppercase">{t('Files stay on your device')}</span>
                    </div>
                </div>
            </div>

            {/* Right: "$0" card joined to the languages card */}
            <div className="absolute top-20 -end-10 h-60 w-64 rounded-[36px] bg-[linear-gradient(135deg,#ffedd5,#fecaca)] p-6 dark:opacity-80">
                <div className="ms-auto me-6 mt-4 grid w-36 place-items-center rounded-2xl bg-white px-3 py-5 text-center shadow-[0_12px_28px_-14px_rgb(15_23_42/0.35)]">
                    <span className="text-[2.2rem] leading-none font-extrabold text-slate-900">$0</span>
                    <span className="mt-2 block text-[0.6rem] leading-tight font-extrabold tracking-wider text-slate-500 uppercase">{t('Always free for everyone')}</span>
                </div>
            </div>
            <div className="absolute top-[17.5rem] end-24 h-48 w-64 rounded-[36px] bg-[linear-gradient(160deg,#fef3c7,#fde68a)] p-5 dark:opacity-80">
                <div className="grid h-full place-items-center rounded-2xl bg-white p-3 text-center shadow-[0_12px_28px_-14px_rgb(15_23_42/0.35)]">
                    <div>
                        <span className="block text-[0.6rem] leading-tight font-extrabold tracking-wider text-slate-500 uppercase">
                            {tn('Available in {count} language', 'Available in {count} languages', site.locales.length)}
                        </span>
                        <span className="mt-2.5 flex flex-wrap justify-center gap-1">
                            {site.locales.map((l) => (
                                <span key={l.code} className="rounded-md bg-slate-100 px-1.5 py-0.5 text-[0.62rem] font-extrabold text-slate-700 uppercase">
                                    {l.code}
                                </span>
                            ))}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default function Home() {
    const site = getSite();
    useMeta({ ...site.meta.home, path: '/' }, site.url);

    const categories = [...site.categories].sort(byOrder);
    const [category, setCategory] = useState('all');
    const [showAll, setShowAll] = useState(false);
    const scroller = useRef(null);

    const sorted = [...site.tools].sort((a, b) => Number(b.popular) - Number(a.popular));
    const filtered = category === 'all' ? sorted : site.tools.filter((x) => x.category === category);
    const tools = category === 'all' && !showAll ? filtered.slice(0, POPULAR_LIMIT) : filtered;

    const scrollCards = (dir) => {
        const el = scroller.current;
        if (!el) return;
        const rtl = document.documentElement.dir === 'rtl' ? -1 : 1;
        el.scrollBy({ left: dir * rtl * Math.max(260, el.clientWidth * 0.8), behavior: 'smooth' });
    };

    const featured = (c) => {
        const list = c.tools.map((slug) => site.tools.find((x) => x.slug === slug)).filter(Boolean);
        return list.find((x) => x.popular) || list[0];
    };

    return (
        <>
            {/* ---------- Hero ---------- */}
            <section className="relative overflow-hidden bg-[linear-gradient(180deg,var(--bg-grad-1),var(--bg))] pt-12 pb-14 sm:pt-16 lg:min-h-[500px]">
                <div className="shell relative">
                    <HeroDecoration site={site} />
                    <div className="relative mx-auto max-w-[760px] text-center">
                        <h1 className="m-0 mb-4 text-[clamp(2rem,5vw,3.4rem)] leading-[1.1] font-extrabold tracking-tight text-balance [hyphens:auto] [overflow-wrap:anywhere]">
                            {t('Free Online Tools for PDF, Image & Text')}
                        </h1>
                        <p className="mx-auto mb-7 max-w-[520px] text-[clamp(1rem,1.6vw,1.12rem)] leading-relaxed text-ink-2">
                            {t('Access {count} free online tools. 100% free, private and secure.', { count: formatNumber(site.tools.length) })}
                        </p>
                        <a
                            href="#popular"
                            className="inline-flex items-center gap-2 rounded-full bg-[linear-gradient(135deg,#10b981,#16a34a)] px-7 py-3.5 text-[0.95rem] font-bold text-white no-underline shadow-[0_14px_30px_-12px_rgb(22_163_74/0.7)] transition hover:-translate-y-0.5 hover:text-white hover:shadow-[0_18px_34px_-12px_rgb(22_163_74/0.8)]"
                        >
                            {t('Explore Tools')} <Icon name="arrow" className="icon size-4 rtl:-scale-x-100" />
                        </a>

                        {/* Centre card */}
                        <div className="relative mx-auto mt-12 max-w-[440px] overflow-hidden rounded-[28px] bg-[linear-gradient(135deg,#3b82f6,#2563eb_55%,#1d4ed8)] px-7 py-7 text-white shadow-[0_24px_50px_-20px_rgb(37_99_235/0.75)]">
                            <span className="mx-auto mb-3 grid size-11 place-items-center rounded-xl bg-white/20 ring-1 ring-white/30 [&_svg]:size-5">
                                <Icon name="lock" />
                            </span>
                            <p className="m-0 mb-2 text-[1.15rem] font-extrabold">{t('Private in-browser engine')}</p>
                            <p className="m-0 text-[0.86rem] leading-relaxed text-white/85">
                                {t('Every tool runs inside your browser, so your files are never uploaded and results appear instantly.')}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <div className="shell">
                <AdSlot key="home-header" position="header" />

                {/* ---------- Browse tools (category cards) ---------- */}
                <section className="mt-10" aria-labelledby="browse-heading">
                    <div className="mb-5 flex items-end justify-between gap-4">
                        <div>
                            <p className={eyebrow}>{t('Our solutions')}</p>
                            <h2 id="browse-heading" className={sectionTitle}>
                                {t('Browse Tools')}
                            </h2>
                        </div>
                        <a href="#popular" className="inline-flex items-center gap-1 text-[0.75rem] font-extrabold tracking-wider text-muted uppercase no-underline hover:text-brand">
                            {t('All tools')} <Icon name="arrow" className="icon size-3.5 rtl:-scale-x-100" />
                        </a>
                    </div>

                    <div ref={scroller} className="-mx-1 flex snap-x snap-mandatory gap-4 overflow-x-auto scroll-smooth px-1 pt-1 pb-4 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                        {categories.map((c) => {
                            const top = featured(c);
                            return (
                                <article
                                    key={c.slug}
                                    className="browse-card w-[78%] shrink-0 snap-start overflow-hidden rounded-2xl border border-line bg-surface shadow-hair transition duration-200 hover:-translate-y-1 hover:shadow-card sm:w-[calc((100%-2rem)/3)] lg:w-[calc((100%-4rem)/5)]"
                                    style={{ '--accent': c.accent, '--accent2': c.accent2 }}
                                >
                                    <Link to={`/category/${c.slug}`} className="relative block h-40 p-4 text-white no-underline hover:text-white" style={gradient}>
                                        <span className="absolute -end-6 -top-8 size-28 rounded-full bg-white/10" aria-hidden="true" />
                                        <span className="flex items-start justify-between">
                                            <span className="grid size-10 place-items-center rounded-xl bg-white/20 ring-1 ring-white/35 [&_svg]:size-5">
                                                <Icon name={c.icon} />
                                            </span>
                                            <span className="rounded-full bg-white/20 px-2.5 py-1 text-[0.62rem] font-extrabold tracking-wider uppercase ring-1 ring-white/30">
                                                {tn('{count} tool', '{count} tools', c.tools.length)}
                                            </span>
                                        </span>
                                        <span className="absolute inset-x-4 bottom-4 flex items-end justify-between gap-2">
                                            <span className="min-w-0">
                                                <span className="block truncate text-[1.12rem] font-extrabold">{c.short || c.name}</span>
                                                <span className="block truncate text-[0.75rem] text-white/85 italic">{c.subtitle}</span>
                                            </span>
                                            <span className="grid size-8 shrink-0 place-items-center rounded-lg bg-white/20 ring-1 ring-white/35 [&_svg]:size-4">
                                                <Icon name="arrow" className="icon rtl:-scale-x-100" />
                                            </span>
                                        </span>
                                    </Link>
                                    {top && (
                                        <div className="flex items-center justify-between gap-2 px-4 py-3">
                                            <span className="text-[0.62rem] font-extrabold tracking-wider text-muted uppercase">{t('Featured:')}</span>
                                            <Link to={`/${top.slug}`} className="truncate text-[0.78rem] font-extrabold no-underline" style={{ color: c.accent }}>
                                                {top.name}
                                            </Link>
                                        </div>
                                    )}
                                </article>
                            );
                        })}
                    </div>
                    <div className="flex justify-end gap-2">
                        <button type="button" onClick={() => scrollCards(-1)} aria-label={t('Previous')} className="grid size-9 cursor-pointer place-items-center rounded-full border border-line bg-surface text-ink shadow-hair hover:bg-surface-2">
                            <Icon name="arrow" className="icon size-4 rotate-180 rtl:rotate-0" />
                        </button>
                        <button type="button" onClick={() => scrollCards(1)} aria-label={t('Next')} className="grid size-9 cursor-pointer place-items-center rounded-full border border-line bg-surface text-ink shadow-hair hover:bg-surface-2">
                            <Icon name="arrow" className="icon size-4 rtl:rotate-180" />
                        </button>
                    </div>
                </section>

                {/* ---------- Stats (true figures only) ---------- */}
                <section className="mt-8 rounded-2xl border border-brand/15 bg-[linear-gradient(90deg,var(--bg-grad-1),color-mix(in_srgb,var(--bg-grad-1)_60%,var(--surface)))] px-4 py-6" aria-label={t('About')}>
                    <ul className="m-0 grid list-none grid-cols-2 gap-y-5 p-0 text-center md:grid-cols-4">
                        {[
                            [formatNumber(site.tools.length), t('free tools')],
                            [formatNumber(site.locales.length), t('Languages')],
                            ['0', t('files uploaded')],
                            ['100%', t('Free')],
                        ].map(([value, label]) => (
                            <li key={label}>
                                <strong className="block text-[clamp(1.6rem,3vw,2.1rem)] leading-none font-extrabold tracking-tight text-brand">{value}</strong>
                                <span className="mt-1.5 block text-[0.66rem] font-extrabold tracking-[0.14em] text-muted uppercase">{label}</span>
                            </li>
                        ))}
                    </ul>
                </section>

                {/* ---------- Popular tools ---------- */}
                <section id="popular" className="mt-14 scroll-mt-24" aria-labelledby="popular-heading">
                    <p className={eyebrow}>{t('Most used')}</p>
                    <h2 id="popular-heading" className={`${sectionTitle} mb-6`}>
                        {t('Popular Tools')}
                    </h2>

                    <div className="mb-7 flex justify-center">
                        <div className="inline-flex max-w-full flex-wrap justify-center gap-1 rounded-2xl border border-line bg-surface-2 p-1.5" role="group" aria-label={t('Filter by category')}>
                            <button
                                type="button"
                                aria-pressed={category === 'all'}
                                onClick={() => setCategory('all')}
                                className="inline-flex cursor-pointer items-center gap-2 rounded-xl border-0 bg-transparent px-3 py-2 text-[0.85rem] font-semibold text-ink-2 transition hover:text-ink aria-pressed:bg-surface aria-pressed:text-ink aria-pressed:shadow-soft"
                            >
                                <span className="grid size-6 place-items-center rounded-md bg-slate-800 text-white [&_svg]:size-3.5">
                                    <Icon name="grid" />
                                </span>
                                {t('All tools')}
                            </button>
                            {categories.map((c) => (
                                <button
                                    key={c.slug}
                                    type="button"
                                    aria-pressed={category === c.slug}
                                    onClick={() => setCategory(c.slug)}
                                    className="inline-flex cursor-pointer items-center gap-2 rounded-xl border-0 bg-transparent px-3 py-2 text-[0.85rem] font-semibold text-ink-2 transition hover:text-ink aria-pressed:bg-surface aria-pressed:text-ink aria-pressed:shadow-soft"
                                    style={{ '--accent': c.accent, '--accent2': c.accent2 }}
                                    aria-label={c.name}
                                >
                                    <span className="grid size-6 place-items-center rounded-md text-white [&_svg]:size-3.5" style={gradient}>
                                        <Icon name={c.icon} />
                                    </span>
                                    {c.short || c.name}
                                </button>
                            ))}
                        </div>
                    </div>

                    <div className="tile-grid grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-4 lg:grid-cols-5">
                        {tools.map((tool) => (
                            <ToolCard key={tool.slug} tool={tool} />
                        ))}
                    </div>

                    {category === 'all' && !showAll && filtered.length > POPULAR_LIMIT && (
                        <div className="mt-8 text-center">
                            <button
                                type="button"
                                onClick={() => setShowAll(true)}
                                className="inline-flex cursor-pointer items-center gap-2 rounded-xl border-0 bg-slate-900 px-6 py-3 text-[0.78rem] font-extrabold tracking-wider text-white uppercase shadow-card transition hover:-translate-y-0.5 hover:bg-slate-800 dark:bg-white dark:text-slate-900"
                            >
                                {t('View all {count} tools', { count: formatNumber(filtered.length) })} <Icon name="arrow" className="icon size-4 rtl:-scale-x-100" />
                            </button>
                        </div>
                    )}
                </section>

                <AdSlot key="home-in-content" position="in_content" />

                {/* ---------- Privacy promise ---------- */}
                <section className="my-14" aria-labelledby="promise-heading">
                    <div className="grid items-center gap-8 rounded-[28px] border border-line bg-[linear-gradient(135deg,var(--bg-grad-1),var(--bg-grad-2))] p-[clamp(1.75rem,5vw,3.5rem)] md:grid-cols-[1.4fr_1fr]">
                        <div className="min-w-0">
                            <p className={eyebrow}>{t('Privacy first')}</p>
                            <h2 id="promise-heading" className="m-0 mb-5 text-[clamp(1.5rem,3vw,2.1rem)] font-extrabold tracking-tight">
                                {t('Your files stay on your device')}
                            </h2>
                            <ul className="m-0 mb-7 grid list-none gap-3 p-0 text-ink-2">
                                {PROMISE.map((item) => (
                                    <li key={item} className="flex items-start gap-2.5">
                                        <span className="mt-0.5 grid size-5 shrink-0 place-items-center rounded-full bg-success-soft text-success [&_svg]:size-3.5">
                                            <Icon name="check" />
                                        </span>
                                        {t(item)}
                                    </li>
                                ))}
                            </ul>
                            <Link className="btn btn--primary btn--lg max-w-full whitespace-normal text-center" to="/privacy-policy">
                                <Icon name="shield" /> {t('Our privacy promise')}
                            </Link>
                        </div>
                        <div className="hidden place-items-center md:grid" aria-hidden="true">
                            <span className="grid size-40 place-items-center rounded-[36px] bg-[linear-gradient(135deg,#3b82f6,#2563eb)] text-white shadow-[0_30px_60px_-24px_rgb(37_99_235/0.8)] [&_svg]:size-16">
                                <Icon name="lock" />
                            </span>
                        </div>
                    </div>
                </section>

                <section className="mb-6 text-center" aria-labelledby="trusted-heading">
                    <h2 id="trusted-heading" className={`${sectionTitle} mb-4`}>
                        {t('Free tools people can trust')}
                    </h2>
                    <p className="mx-auto max-w-[760px] text-[1.05rem] text-ink-2">
                        {t('{name} is a free web app for everyday tasks with PDFs, images, text and data. Every tool runs in your browser, so your work stays private and results appear instantly.', { name: site.name })}
                    </p>
                </section>
            </div>
        </>
    );
}
