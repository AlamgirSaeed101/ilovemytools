import { Link } from 'react-router';
import { t } from '../lib/i18n.js';

/** items: [{ name, to }] - Home is added first, the last item is the current page. */
export default function Breadcrumbs({ items }) {
    const crumbs = [{ name: t('Home'), to: '/' }, ...items];
    return (
        <nav className="mt-6 mb-4 text-[0.87rem]" aria-label={t('Breadcrumb')}>
            <ol className="m-0 flex list-none flex-wrap items-center gap-1.5 p-0">
                {crumbs.map((crumb, i) => (
                    <li key={crumb.to} className="inline-flex items-center gap-1.5 text-muted">
                        {i > 0 && (
                            <span className="text-line-strong" aria-hidden="true">
                                /
                            </span>
                        )}
                        {i === crumbs.length - 1 ? (
                            <span className="font-semibold text-ink" aria-current="page">
                                {crumb.name}
                            </span>
                        ) : (
                            <Link className="text-muted no-underline hover:text-brand" to={crumb.to}>
                                {crumb.name}
                            </Link>
                        )}
                    </li>
                ))}
            </ol>
        </nav>
    );
}
