import { Link, useLoaderData } from 'react-router';
import AdSlot from '../components/AdSlot.jsx';
import Breadcrumbs from '../components/Breadcrumbs.jsx';
import Icon from '../components/Icon.jsx';
import { IconTile, ToolGrid } from '../components/ToolCard.jsx';
import { getSite } from '../lib/api.js';
import { t, tn } from '../lib/i18n.js';
import { useMeta } from '../lib/meta.js';

export default function Category() {
    const category = useLoaderData();
    const site = getSite();
    const tools = category.tools.map((slug) => site.tools.find((x) => x.slug === slug)).filter(Boolean);
    const others = site.categories.filter((c) => c.slug !== category.slug);

    useMeta({ ...category.meta, path: `/category/${category.slug}` }, site.url);

    return (
        <div className="shell">
            <Breadcrumbs items={[{ name: category.name, to: `/category/${category.slug}` }]} />

            <header className="mb-6 flex items-start gap-3 sm:gap-[1.1rem]" style={{ '--accent': category.accent }}>
                <IconTile icon={category.icon} size="lg" />
                <div>
                    <h1 className="m-0 mb-1 text-[clamp(1.75rem,4vw,2.5rem)] font-extrabold tracking-tight">{category.name}</h1>
                    <p className="m-0 text-[1.08rem] text-ink-2">{category.intro}</p>
                    <p className="mt-2 mb-0 text-[0.9rem] font-semibold text-muted">{tn('{count} free tool', '{count} free tools', tools.length)}</p>
                </div>
            </header>

            <AdSlot key={`${category.slug}-header`} position="header" />

            <section className="my-11" aria-label={category.name}>
                <ToolGrid tools={tools} />
            </section>

            <AdSlot key={`${category.slug}-in-content`} position="in_content" />

            <article className="prose tool-article my-11">
                <h2 id="compare">{t('Which tool do you need?')}</h2>
                <div className="table-wrap">
                    <table className="compare-table">
                        <thead>
                            <tr>
                                <th scope="col">{t('Tool')}</th>
                                <th scope="col">{t('What it does')}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {tools.map((tool) => (
                                <tr key={tool.slug}>
                                    <th scope="row">
                                        <Link to={`/${tool.slug}`}>{tool.name}</Link>
                                    </th>
                                    <td>{tool.tagline}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>

                {(category.content ?? []).map((section) => (
                    <div key={section.heading}>
                        <h2>{section.heading}</h2>
                        <p>{section.body}</p>
                    </div>
                ))}

                {category.faqs?.length > 0 && (
                    <>
                        <h2 id="faq">{t('Frequently asked questions')}</h2>
                        <div className="faq">
                            {category.faqs.map((faq, i) => (
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

            <section className="my-11" aria-labelledby="other-heading">
                <h2 id="other-heading" className="m-0 mb-4 text-[1.35rem] font-bold">
                    {t('Other categories')}
                </h2>
                <div className="grid grid-cols-[repeat(auto-fill,minmax(230px,1fr))] gap-3">
                    {others.map((c) => (
                        <Link
                            key={c.slug}
                            className="flex items-center gap-3 rounded-card border border-line bg-surface px-4 py-3.5 text-ink no-underline transition duration-200 hover:-translate-y-px hover:border-accent/45 hover:text-ink hover:shadow-soft"
                            to={`/category/${c.slug}`}
                            style={{ '--accent': c.accent }}
                        >
                            <IconTile icon={c.icon} />
                            <span>
                                <span className="block font-bold">{c.name}</span>
                                <span className="block text-[0.83rem] text-muted">{tn('{count} tool', '{count} tools', c.tools.length)}</span>
                            </span>
                            <Icon name="arrow" className="icon ms-auto text-muted rtl:-scale-x-100" />
                        </Link>
                    ))}
                </div>
            </section>
        </div>
    );
}
