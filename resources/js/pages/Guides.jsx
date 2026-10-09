import { Link, useLoaderData } from 'react-router';
import Breadcrumbs from '../components/Breadcrumbs.jsx';
import { getSite } from '../lib/api.js';
import { formatDate } from '../lib/i18n.js';
import { useMeta } from '../lib/meta.js';

// Hand-written English guides (/guides, /guides/:slug). Content comes from config/guides.php.

export function GuideIndex() {
    const site = getSite();
    useMeta({ title: `Guides - How to Get More Out of Free Online Tools | ${site.name}`, description: 'Practical, step-by-step guides on PDFs, images and writing.', path: '/guides' }, site.url);
    return (
        <div className="shell shell--narrow">
            <Breadcrumbs items={[{ name: 'Guides', to: '/guides' }]} />
            <article className="prose page-article">
                <h1>Guides</h1>
                <p className="lead">Practical, step-by-step guides written by {site.founder || site.name}: how to get files to the right size, pick the right format and finish everyday tasks faster.</p>
                {(site.guides ?? []).map((g) => (
                    <div key={g.slug}>
                        <h2>
                            <Link to={`/guides/${g.slug}`}>{g.title}</Link>
                        </h2>
                        <p>{g.description}</p>
                    </div>
                ))}
            </article>
        </div>
    );
}

export function GuideArticle() {
    const guide = useLoaderData();
    const site = getSite();
    useMeta({ ...guide.meta, path: `/guides/${guide.slug}` }, site.url);
    return (
        <div className="shell shell--narrow">
            <Breadcrumbs items={[{ name: 'Guides', to: '/guides' }, { name: guide.title, to: `/guides/${guide.slug}` }]} />
            <article className="prose page-article guide-article">
                <h1>{guide.title}</h1>
                <p className="text-sm text-muted">
                    By <Link to="/about">{guide.author}</Link> · Updated <time dateTime={guide.updated}>{formatDate(guide.updated)}</time>
                </p>
                <p className="lead">{guide.intro}</p>
                {guide.sections.map((s) => (
                    <section key={s.heading}>
                        <h2>{s.heading}</h2>
                        {(s.paragraphs ?? []).map((p) => (
                            <p key={p.slice(0, 40)}>{p}</p>
                        ))}
                        {s.list && (
                            <ul>
                                {s.list.map((item) => (
                                    <li key={item}>{item}</li>
                                ))}
                            </ul>
                        )}
                        {s.table && (
                            <div className="table-wrap">
                                <table className="compare-table">
                                    <thead>
                                        <tr>
                                            {s.table.headers.map((h) => (
                                                <th key={h} scope="col">{h}</th>
                                            ))}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {s.table.rows.map((row) => (
                                            <tr key={row[0]}>
                                                {row.map((cell, i) => (i === 0 ? <th key={i} scope="row">{cell}</th> : <td key={i}>{cell}</td>))}
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        )}
                    </section>
                ))}
                {guide.tool && (
                    <p>
                        <Link className="btn btn--primary" to={`/${guide.tool.slug}`}>
                            Try the free {guide.tool.name}
                        </Link>
                    </p>
                )}
                {guide.faqs.length > 0 && (
                    <>
                        <h2>Frequently asked questions</h2>
                        {guide.faqs.map((f) => (
                            <div key={f.q}>
                                <h3>{f.q}</h3>
                                <p>{f.a}</p>
                            </div>
                        ))}
                    </>
                )}
                {guide.sources.length > 0 && (
                    <>
                        <h2>Sources</h2>
                        <ul className="sources">
                            {guide.sources.map((s) => (
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
        </div>
    );
}
