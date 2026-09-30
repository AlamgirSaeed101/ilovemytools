import { Suspense, useEffect } from 'react';
import { Link, useLoaderData } from 'react-router';
import AdSlot from '../components/AdSlot.jsx';
import Breadcrumbs from '../components/Breadcrumbs.jsx';
import ErrorBoundary from '../components/ErrorBoundary.jsx';
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

export default function ToolPage() {
    const tool = useLoaderData();
    const site = getSite();
    const category = site.categories.find((c) => c.slug === tool.category);
    const Tool = tools[tool.slug];
    const siblings = (category?.tools ?? []).map((slug) => site.tools.find((x) => x.slug === slug)).filter(Boolean);
    const related = tool.related.map((slug) => site.tools.find((x) => x.slug === slug)).filter(Boolean);

    useMeta({ ...tool.meta, path: `/${tool.slug}` }, site.url);
    useEffect(() => addRecent(tool.slug), [tool.slug]);

    return (
        <div className="shell" style={{ '--accent': category?.accent }}>
            <Breadcrumbs
                items={[
                    { name: category?.name ?? t('Tools'), to: `/category/${tool.category}` },
                    { name: tool.name, to: `/${tool.slug}` },
                ]}
            />

            <header className="mb-6 flex items-start gap-3 sm:gap-[1.1rem]">
                <IconTile icon={tool.icon} size="lg" />
                <div>
                    <h1 className="m-0 mb-1 text-[clamp(1.75rem,4vw,2.5rem)] font-extrabold tracking-tight">{tool.h1}</h1>
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
                    <section className="tool-panel" aria-label={tool.name}>
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
                        <Icon name="shield" /> {t('Private: this tool runs in your browser. Your data is never uploaded.')}
                    </p>

                    <AdSlot key={`${tool.slug}-below`} position="below_tool" />

                    <article className="prose tool-article">
                        <h2>{t('About the {name}', { name: tool.name })}</h2>
                        <p className="tool-intro">{tool.intro}</p>
                        {tool.updated && <p className="text-sm text-muted">{t('Last updated: {date}', { date: formatDate(tool.updated) })}</p>}

                        {tool.steps.length > 0 && (
                            <>
                                <h2 id="how-to">{t('How to use the {name}', { name: tool.name })}</h2>
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
