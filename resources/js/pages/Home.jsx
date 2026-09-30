import { useState } from 'react';
import { Link } from 'react-router';
import AdSlot from '../components/AdSlot.jsx';
import Icon from '../components/Icon.jsx';
import { accentFor, IconTile } from '../components/ToolCard.jsx';
import { getSite } from '../lib/api.js';
import { formatNumber, t } from '../lib/i18n.js';
import { useMeta } from '../lib/meta.js';

const WAYS = [
    { icon: 'shield', title: 'Private by design', text: 'Files and text are processed on your own device. Nothing is uploaded, stored or shared.', to: '/privacy-policy' },
    { icon: 'zap', title: 'Works on any device', text: 'Chrome, Safari, Edge or Firefox on a phone, tablet or computer. No app to install.', to: '/about' },
    { icon: 'gift', title: 'Free, with no limits', text: 'No accounts, no daily caps and no watermarks. Use every tool as often as you like.', to: '/about' },
];

const PROMISE = [
    'Your PDFs, photos and documents never leave your browser',
    'No sign up, no email address, no watermarks on your files',
    'Instant results - no waiting in an upload or download queue',
];

const sectionTitle = 'm-0 mb-8 text-center text-[clamp(1.6rem,3.2vw,2.2rem)] font-extrabold tracking-tight';

/** Large vertical tool card used in the home page grid. */
function ToolTile({ tool }) {
    return (
        <Link
            className="tool-card flex min-h-[180px] flex-col items-start rounded-2xl border border-line bg-surface px-3.5 py-4 text-ink no-underline transition duration-200 ease-snap hover:-translate-y-0.5 hover:border-accent/45 hover:text-ink hover:shadow-card hover:ring-4 hover:ring-accent/10 sm:min-h-[220px] sm:px-[1.4rem] sm:py-6"
            to={`/${tool.slug}`}
            style={{ '--accent': accentFor(tool.category) }}
        >
            <span className="mb-3 sm:mb-[1.1rem]">
                <IconTile icon={tool.icon} size="lg" />
            </span>
            <span className="mb-1.5 text-[0.98rem] font-bold tracking-tight sm:text-[1.12rem]">{tool.name}</span>
            <span className="text-[0.8rem] leading-relaxed text-muted sm:text-[0.9rem]">{tool.tagline}</span>
        </Link>
    );
}

export default function Home() {
    const site = getSite();
    useMeta({ ...site.meta.home, path: '/' }, site.url);

    const [category, setCategory] = useState('all');
    const tools = category === 'all' ? site.tools : site.tools.filter((x) => x.category === category);
    const pill =
        'cursor-pointer rounded-full border border-line-strong bg-transparent px-4 py-[0.45rem] text-[0.9rem] font-semibold text-ink transition-colors hover:border-ink-2 aria-pressed:border-ink aria-pressed:bg-ink aria-pressed:text-canvas';

    return (
        <>
            <section className="bg-[radial-gradient(55%_80%_at_50%_0%,color-mix(in_srgb,var(--brand)_14%,transparent)_0%,transparent_70%)] pt-9 pb-8 text-center sm:pt-[3.25rem]">
                <div className="shell">
                    <h1 className="mx-auto mb-3.5 max-w-[1000px] text-[clamp(1.9rem,4.4vw,2.9rem)] font-black tracking-tight">
                        {t('All the free online tools you need, in one place')}
                    </h1>
                    <p className="mx-auto mb-7 max-w-[800px] text-[clamp(1rem,1.8vw,1.2rem)] text-ink-2">
                        {t('Every tool you need for PDFs, images, text, maths and code, right in your browser. All are 100% free and private: merge PDFs, compress images, count words, make QR codes and more in just a few clicks.')}
                    </p>

                    <div className="flex flex-wrap justify-center gap-2" role="group" aria-label={t('Filter by category')}>
                        <button type="button" className={pill} aria-pressed={category === 'all'} onClick={() => setCategory('all')}>
                            {t('All')}
                        </button>
                        {site.categories.map((c) => (
                            <button key={c.slug} type="button" className={pill} aria-pressed={category === c.slug} onClick={() => setCategory(c.slug)}>
                                {c.name}
                            </button>
                        ))}
                    </div>
                </div>
            </section>

            <div className="shell">
                <section aria-label={t('Tools')}>
                    <div className="tile-grid mt-2 grid grid-cols-2 gap-2.5 sm:grid-cols-[repeat(auto-fill,minmax(210px,1fr))] sm:gap-4">
                        {tools.map((tool) => (
                            <ToolTile key={tool.slug} tool={tool} />
                        ))}
                        <Link
                            className="flex min-h-[180px] flex-col items-start rounded-2xl border border-dashed border-brand/45 bg-brand/10 px-3.5 py-4 text-ink no-underline transition-colors hover:border-brand hover:bg-brand/15 hover:text-ink sm:min-h-[220px] sm:px-[1.4rem] sm:py-6"
                            to="/contact"
                        >
                            <span className="mb-1.5 text-[0.98rem] font-bold sm:text-[1.12rem]">{t('Suggest a tool')}</span>
                            <span className="text-[0.8rem] leading-relaxed text-muted sm:text-[0.9rem]">{t('Missing something you need? Tell us which free tool we should build next.')}</span>
                            <span className="mt-auto inline-flex items-center gap-1.5 pt-4 text-[0.88rem] font-bold text-brand">
                                {t('Send an idea')} <Icon name="arrow" className="icon rtl:-scale-x-100" />
                            </span>
                        </Link>
                    </div>
                </section>

                <AdSlot key="home-header" position="header" />

                <section className="mt-[4.5rem] mb-12" aria-labelledby="ways-heading">
                    <h2 id="ways-heading" className={sectionTitle}>
                        {t('Work your way')}
                    </h2>
                    <div className="grid grid-cols-[repeat(auto-fit,minmax(260px,1fr))] gap-5">
                        {WAYS.map((way) => (
                            <Link
                                key={way.title}
                                className="group relative flex min-h-[200px] flex-col gap-2 rounded-2xl border border-line bg-surface p-7 text-ink no-underline transition duration-200 ease-snap hover:-translate-y-0.5 hover:border-line-strong hover:text-ink hover:shadow-card"
                                to={way.to}
                            >
                                <span className="mb-2" style={{ '--accent': 'var(--brand)' }}>
                                    <IconTile icon={way.icon} />
                                </span>
                                <span className="text-[1.15rem] font-bold">{t(way.title)}</span>
                                <span className="pe-6 text-[0.95rem] text-muted">{t(way.text)}</span>
                                <Icon name="arrow" className="icon absolute end-6 bottom-6 size-5 -rotate-45 text-muted transition group-hover:text-brand rtl:rotate-[-135deg]" />
                            </Link>
                        ))}
                    </div>
                </section>

                <AdSlot key="home-in-content" position="in_content" />
            </div>

            <section className="my-12" aria-labelledby="promise-heading">
                <div className="shell">
                    <div className="grid items-center gap-8 rounded-[28px] border border-brand/30 bg-[radial-gradient(70%_90%_at_100%_50%,color-mix(in_srgb,var(--brand-2)_28%,transparent),transparent_70%),linear-gradient(135deg,color-mix(in_srgb,var(--brand)_22%,var(--surface)),color-mix(in_srgb,var(--brand-2)_12%,var(--surface)))] p-[clamp(2rem,5vw,4rem)] md:grid-cols-[1.4fr_1fr]">
                        <div>
                            <h2 id="promise-heading" className="m-0 mb-5 text-[clamp(1.6rem,3.2vw,2.3rem)] font-extrabold tracking-tight">
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
                            <Link className="btn btn--primary btn--lg" to="/privacy-policy">
                                <Icon name="shield" /> {t('Our privacy promise')}
                            </Link>
                        </div>
                        <div className="hidden place-items-center md:grid" aria-hidden="true">
                            <span className="grid size-44 place-items-center rounded-full bg-[radial-gradient(circle_at_30%_30%,color-mix(in_srgb,var(--brand)_60%,white),var(--brand)_55%,var(--brand-2))] text-white shadow-[0_30px_80px_-20px_color-mix(in_srgb,var(--brand)_80%,transparent),inset_0_-10px_30px_rgb(0_0_0/0.2)] [&_svg]:size-[72px]">
                                <Icon name="lock" />
                            </span>
                        </div>
                    </div>
                </div>
            </section>

            <section className="pt-8 pb-4 text-center" aria-labelledby="trusted-heading">
                <div className="shell">
                    <h2 id="trusted-heading" className={`${sectionTitle} mb-4`}>
                        {t('Free tools people can trust')}
                    </h2>
                    <p className="mx-auto mb-8 max-w-[760px] text-[1.08rem] text-ink-2">
                        {t('{name} is a free web app for everyday tasks with PDFs, images, text and data. Every tool runs in your browser, so your work stays private and results appear instantly.', { name: site.name })}
                    </p>
                    <ul className="m-0 flex list-none flex-wrap justify-center gap-4 p-0">
                        {[
                            [formatNumber(site.tools.length), 'free tools'],
                            ['0', 'files uploaded'],
                            ['100%', 'in your browser'],
                        ].map(([value, label]) => (
                            <li key={label} className="min-w-[170px] rounded-2xl border border-line bg-surface px-6 py-4 font-semibold text-muted">
                                <strong className="block text-[2rem] font-black tracking-tight text-ink">{value}</strong>
                                {t(label)}
                            </li>
                        ))}
                    </ul>
                </div>
            </section>
        </>
    );
}
