import { Suspense, useCallback, useEffect, useRef, useState } from 'react';
import { Link, useLoaderData } from 'react-router';
import AdSlot from '../components/AdSlot.jsx';
import Breadcrumbs from '../components/Breadcrumbs.jsx';
import ErrorBoundary from '../components/ErrorBoundary.jsx';
import { track } from '../lib/analytics.js';
import Icon from '../components/Icon.jsx';
import { IconTile, ToolGrid } from '../components/ToolCard.jsx';
import tools from '../tools/index.js';
import { getSite } from '../lib/api.js';
import { formatDate, t } from '../lib/i18n.js';
import { useMeta } from '../lib/meta.js';
import { addRecent } from '../lib/recent.js';

function ToolLoading({ name }) {
    return (
        <div className="tool-loading" role="status">
            <span className="spinner" aria-hidden="true" /> {t('Loading {name}…', { name })}
        </div>
    );
}

const badges = [
    ['gift', 'Free'],
    ['shield', 'Runs in your browser'],
    ['zap', 'No sign up'],
];

/** "Done! What next?" card shown once a tool has produced a result. */
function NextSteps({ tools: next }) {
    return (
        <section className="next-steps animate-pop mt-5 rounded-2xl border border-line bg-surface-2 p-4 sm:p-5" aria-labelledby="next-steps-heading" aria-live="polite">
            <h2 id="next-steps-heading" className="m-0 mb-3 flex items-center gap-2 text-[1.05rem] font-bold [&_svg]:text-success">
                <Icon name="check" /> {t('Done! What would you like to do next?')}
            </h2>
            <ul className="m-0 grid list-none gap-2 p-0 sm:grid-cols-3">
                {next.map((x) => (
                    <li key={x.slug}>
                        <Link className="flex h-full items-center gap-2.5 rounded-xl border border-line bg-surface px-3 py-2.5 text-[0.9rem] font-semibold text-ink no-underline transition-colors hover:border-line-strong" to={`/${x.slug}`}>
                            <IconTile icon={x.icon} size="sm" />
                            {x.name}
                        </Link>
                    </li>
                ))}
            </ul>
        </section>
    );
}

export default function ToolPage() {
    const tool = useLoaderData();
    const site = getSite();
    const category = site.categories.find((c) => c.slug === tool.category);
    const Tool = tools[tool.slug];

    // Count the first interaction with the tool on each page view as "tool_use" in Analytics.
    const used = useRef(false);
    // After a download or copy, suggest what to do next instead of letting the visit end there.
    const [done, setDone] = useState(false);
    useEffect(() => {
        used.current = false;
        setDone(false);
        const onDone = () => setDone(true);
        window.addEventListener('tool:done', onDone);
        return () => window.removeEventListener('tool:done', onDone);
    }, [tool.slug]);
    const markUse = useCallback(() => {
        if (used.current) return;
        used.current = true;
        track('tool_use');
    }, []);
    const siblings = (category?.tools ?? []).map((slug) => site.tools.find((x) => x.slug === slug)).filter(Boolean);
    const related = tool.related.map((slug) => site.tools.find((x) => x.slug === slug)).filter(Boolean);

    useMeta({ ...tool.meta, path: `/${tool.slug}` }, site.url);
    useEffect(() => addRecent(tool.slug), [tool.slug]);

    return (
        <div className="shell" style={{ '--accent': category?.accent, '--accent2': category?.accent2 }}>
            <Breadcrumbs
                items={[
                    { name: category?.name ?? t('Tools'), to: `/category/${tool.category}` },
                    { name: tool.name, to: `/${tool.slug}` },
                ]}
            />

            <header className="mb-6 flex items-start gap-3 sm:gap-[1.1rem]">
                <IconTile icon={tool.icon} size="lg" />
                <div className="min-w-0">
                    <h1 className="m-0 mb-1 text-[clamp(1.6rem,4vw,2.5rem)] font-extrabold tracking-tight [overflow-wrap:anywhere] hyphens-auto">{tool.h1}</h1>
                    <p className="m-0 text-[1.08rem] text-ink-2">{tool.tagline}</p>
                    <ul className="mt-3 flex list-none flex-wrap gap-1.5 p-0">
                        {badges.map(([icon, label]) => (
                            <li key={label} className="inline-flex items-center gap-1.5 rounded-full border border-line bg-surface px-2.5 py-1 text-[0.8rem] font-semibold text-ink-2 [&_svg]:text-success">
                                <Icon name={icon} /> {t(label)}
                            </li>
                        ))}
                    </ul>
                </div>
            </header>

            <AdSlot key={`${tool.slug}-header`} position="header" />

            <div className="grid items-start gap-8 lg:grid-cols-[minmax(0,1fr)_290px]">
                <div className="min-w-0">
                    <section className="tool-panel" aria-label={tool.name} onPointerDownCapture={markUse} onInputCapture={markUse} onDropCapture={markUse}>
                        {Tool ? (
                            <ErrorBoundary key={tool.slug}>
                                <Suspense fallback={<ToolLoading name={tool.name} />}>
                                    <Tool {...(tool.props ?? {})} />
                                </Suspense>
                            </ErrorBoundary>
                        ) : (
                            <p className="notice notice--error">{t('This tool is not available right now.')}</p>
                        )}
                    </section>
                    <p className="mt-3.5 mb-0 flex items-center justify-center gap-2 text-center text-[0.85rem] text-muted [&_svg]:text-success">
                        <Icon name="shield" />{' '}
                        {tool.server
                            ? t('This tool asks our server to fetch the address you enter. We don’t store the address or the results.')
                            : t('Private: this tool runs in your browser. Your data is never uploaded.')}
                    </p>

                    {done && related.length > 0 && <NextSteps tools={related.slice(0, 3)} />}

                    <AdSlot key={`${tool.slug}-below`} position="below_tool" />

                    <article className="prose tool-article">
                        <h2>{t('What is the {name} tool?', { name: tool.name })}</h2>
                        <p className="tool-intro">{tool.intro}</p>
                        {tool.updated && (
                            <p className="text-sm text-muted">
                                <time dateTime={tool.updated}>{t('Last updated: {date}', { date: formatDate(tool.updated) })}</time>
                            </p>
                        )}

                        {tool.steps.length > 0 && (
                            <>
                                <h2 id="how-to">{t('How to use the {name} tool', { name: tool.name })}</h2>
                                <ol className="steps">
                                    {tool.steps.map((step) => (
                                        <li key={step}>{step}</li>
                                    ))}
                                </ol>
                            </>
                        )}

                        {tool.features.length > 0 && (
                            <>
                                <h2>{t('Features')}</h2>
                                <ul className="checklist">
                                    {tool.features.map((feature) => (
                                        <li key={feature}>
                                            <Icon name="check" /> {feature}
                                        </li>
                                    ))}
                                </ul>
                            </>
                        )}

                        {tool.content.map((section, i) => (
                            <div key={section.heading}>
                                <h2>{section.heading}</h2>
                                <p>{section.body}</p>
                                {i === 0 && <AdSlot key={`${tool.slug}-in-content`} position="in_content" />}
                            </div>
                        ))}

                        {tool.table && (
                            <div className="table-wrap">
                                <table className="compare-table">
                                    <caption>{tool.table.caption}</caption>
                                    <thead>
                                        <tr>
                                            {tool.table.headers.map((h) => (
                                                <th key={h} scope="col">
                                                    {h}
                                                </th>
                                            ))}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {tool.table.rows.map((row) => (
                                            <tr key={row.join('|')}>
                                                {row.map((cell, i) =>
                                                    i === 0 ? (
                                                        <th key={i} scope="row">
                                                            {cell}
                                                        </th>
                                                    ) : (
                                                        <td key={i}>{cell}</td>
                                                    ),
                                                )}
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        )}

                        {tool.faqs.length > 0 && (
                            <>
                                <h2 id="faq">{t('Frequently asked questions')}</h2>
                                <div className="faq">
                                    {tool.faqs.map((faq, i) => (
                                        <details className="faq__item" key={faq.q} open={i === 0}>
                                            <summary>
                                                <h3 className="faq__q">{faq.q}</h3>
                                                <Icon name="chevron" className="icon faq__chev" />
                                            </summary>
                                            <p>{faq.a}</p>
                                        </details>
                                    ))}
                                </div>
                            </>
                        )}

                        {tool.sources?.length > 0 && (
                            <>
                                <h2 id="sources">{t('Sources')}</h2>
                                <ul className="sources">
                                    {tool.sources.map((s) => (
                                        <li key={s.url}>
                                            <a href={s.url} target="_blank" rel="noopener noreferrer">
                                                {s.title}
                                            </a>
                                        </li>
                                    ))}
                                </ul>
                            </>
                        )}
                    </article>

                    {related.length > 0 && (
                        <section className="my-11" aria-labelledby="related-heading">
                            <h2 id="related-heading" className="m-0 mb-4 text-[1.35rem] font-bold">
                                {t('Related tools')}
                            </h2>
                            <ToolGrid tools={related} />
                        </section>
                    )}
                </div>

                <aside aria-label={t('More tools')}>
                    <div className="sticky top-[calc(var(--header-h)+20px)] grid gap-4">
                        <nav className="rounded-card border border-line bg-surface p-[1.1rem] shadow-hair" aria-labelledby="side-heading">
                            <h2 id="side-heading" className="m-0 mb-2.5 text-[0.78rem] font-bold tracking-wider text-muted uppercase">
                                {t('More in {category}', { category: category?.name ?? t('Tools') })}
                            </h2>
                            <ul className="m-0 mb-2.5 list-none p-0">
                                {siblings.map((x) => (
                                    <li key={x.slug}>
                                        <Link
                                            className="flex items-center gap-2.5 rounded-[10px] px-2.5 py-2 text-[0.93rem] font-medium text-ink-2 no-underline hover:bg-surface-2 hover:text-ink aria-[current]:bg-accent/10 aria-[current]:font-bold aria-[current]:text-ink [&_svg]:text-accent-ink"
                                            to={`/${x.slug}`}
                                            aria-current={x.slug === tool.slug ? 'page' : undefined}
                                        >
                                            <Icon name={x.icon} /> {x.name}
                                        </Link>
                                    </li>
                                ))}
                            </ul>
                            <Link className="inline-flex items-center gap-1.5 px-2.5 py-1 text-[0.9rem] font-semibold no-underline" to="/">
                                {t('All free tools')} <Icon name="arrow" className="icon rtl:-scale-x-100" />
                            </Link>
                        </nav>
                        <AdSlot key={`${tool.slug}-sidebar`} position="sidebar" />
                    </div>
                </aside>
            </div>
        </div>
    );
}
