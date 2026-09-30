import { isRouteErrorResponse, Link, useRouteError } from 'react-router';
import Icon from '../components/Icon.jsx';
import { ToolGrid } from '../components/ToolCard.jsx';
import { getSite } from '../lib/api.js';
import { t } from '../lib/i18n.js';
import { useMeta } from '../lib/meta.js';

const code = 'm-0 bg-linear-135 from-brand to-brand-2 bg-clip-text text-[clamp(4.5rem,14vw,8rem)] leading-none font-black tracking-tighter text-transparent';

export default function NotFound() {
    const site = getSite();
    useMeta({ title: `${t('Page not found')} | ${site.name}`, description: t('The page you are looking for could not be found.'), noindex: true }, site.url);

    return (
        <div className="shell shell--narrow">
            <div className="pt-16 pb-4 text-center">
                <p className={code}>404</p>
                <h1 className="my-2 text-[2rem]">{t('Page not found')}</h1>
                <p className="text-ink-2">{t("Sorry, we couldn't find that page. It may have moved, or the link may be wrong.")}</p>
                <Link className="btn btn--primary btn--lg" to="/">
                    {t('Browse all free tools')} <Icon name="arrow" className="icon rtl:-scale-x-100" />
                </Link>
            </div>

            <section className="my-11" aria-labelledby="popular-404">
                <h2 id="popular-404" className="m-0 mb-4 text-[1.35rem] font-bold">
                    {t('Popular tools')}
                </h2>
                <ToolGrid tools={site.tools.filter((x) => x.popular).slice(0, 6)} />
            </section>
        </div>
    );
}

/** Route error element: 404s show the Not Found page, anything else a retry message. */
export function RouteError() {
    const error = useRouteError();
    if (error?.status === 404 || (isRouteErrorResponse(error) && error.status === 404)) return <NotFound />;

    return (
        <div className="shell shell--narrow">
            <div className="pt-16 pb-4 text-center">
                <p className={code}>{t('Oops')}</p>
                <h1 className="my-2 text-[2rem]">{t('Something went wrong')}</h1>
                <p className="text-ink-2">{t('This page could not be loaded. Check your connection and try again.')}</p>
                <button type="button" className="btn btn--primary btn--lg" onClick={() => window.location.reload()}>
                    {t('Try again')}
                </button>
            </div>
        </div>
    );
}
