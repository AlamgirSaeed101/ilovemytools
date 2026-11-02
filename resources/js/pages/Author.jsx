import { Link } from 'react-router';
import Breadcrumbs from '../components/Breadcrumbs.jsx';
import { getSite } from '../lib/api.js';
import { t } from '../lib/i18n.js';
import { useMeta } from '../lib/meta.js';
import NotFound from './NotFound.jsx';

// The founder's author page (/about/m-alamgir-saeed), indexed in English only.
// Same content as resources/views/pages/author.blade.php.
export default function Author() {
    const site = getSite();
    const author = site.author;
    useMeta({ ...(author?.meta ?? {}), path: author?.path, englishOnly: true }, site.url);
    if (!author) return <NotFound />;
    const name = author.name;

    return (
        <div className="shell shell--narrow">
            <Breadcrumbs items={[{ name: t('About Us'), to: '/about' }, { name, to: author.path }]} />
            <article className="prose page-article" lang="en">
                <h1>{name}</h1>
                <p className="lead">Founder and developer of {site.name}, based in Islamabad, Pakistan.</p>
                <p>
                    {name} is a full-stack developer. He founded {site.name} in {site.founded} and builds and maintains every tool on the site: {site.tools.length} free online tools for PDFs, images, text, calculations and developers, available in{' '}
                    {site.locales.length} languages.
                </p>
                <p>The file tools run in your browser with open-source libraries such as PDF.js and pdf-lib, so your files are never uploaded. Before every release, automated tests open every tool in every language and check real results.</p>

                <h2>Guides by {name}</h2>
                <ul>
                    {(site.guides ?? []).map((g) => (
                        <li key={g.slug}>
                            {/* Guides are English only, so link the English URL from every language. */}
                            <a href={`/guides/${g.slug}`}>{g.title}</a> - {g.description}
                        </li>
                    ))}
                </ul>

                {author.profiles.length > 0 && (
                    <>
                        <h2>Profiles</h2>
                        <ul>
                            {author.profiles.map((p) => (
                                <li key={p.url}>
                                    <a href={p.url} rel="me noopener noreferrer" target="_blank">
                                        {p.label}
                                    </a>
                                </li>
                            ))}
                        </ul>
                    </>
                )}

                <p>
                    Found a mistake in a guide or a tool? Tell us on the <Link to="/contact">contact page</Link> and it will be corrected.
                </p>
            </article>
        </div>
    );
}
