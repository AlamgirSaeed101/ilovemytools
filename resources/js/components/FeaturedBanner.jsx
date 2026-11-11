// "Featured website" banner on the home page, between the introduction and the first tools section.
// Same markup and classes as resources/views/partials/featured-banner.blade.php (the no-JS copy).
// The copy is English on every language, so it is marked lang="en".
export const FEATURED = {
    label: 'FEATURED WEBSITE',
    heading: 'Discover NashemanBot',
    description: 'Explore NashemanBot on its official website.',
    button: 'Visit NashemanBot',
    domain: 'nashemanbot.io',
    url: 'https://nashemanbot.io/',
};

export function FeaturedArt() {
    return (
        <svg className="feature-banner__art" viewBox="0 0 240 180" width="240" height="180" aria-hidden="true" focusable="false">
            <defs>
                <linearGradient id="fb-a" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0" stopColor="#5eead4" />
                    <stop offset="1" stopColor="#38bdf8" />
                </linearGradient>
            </defs>
            <circle cx="150" cy="90" r="78" fill="none" stroke="#ffffff" strokeOpacity="0.12" strokeWidth="2" />
            <circle cx="150" cy="90" r="54" fill="none" stroke="#ffffff" strokeOpacity="0.18" strokeWidth="2" strokeDasharray="6 8" />
            <rect x="96" y="52" width="108" height="76" rx="22" fill="url(#fb-a)" fillOpacity="0.9" />
            <rect x="114" y="72" width="72" height="10" rx="5" fill="#0b1736" fillOpacity="0.55" />
            <rect x="114" y="92" width="48" height="10" rx="5" fill="#0b1736" fillOpacity="0.35" />
            <path d="M118 128 l-10 20 l26 -20 z" fill="#38bdf8" fillOpacity="0.9" />
            <circle cx="52" cy="42" r="10" fill="#5eead4" fillOpacity="0.55" />
            <circle cx="214" cy="30" r="6" fill="#ffffff" fillOpacity="0.4" />
            <rect x="30" y="118" width="36" height="36" rx="10" fill="#ffffff" fillOpacity="0.1" transform="rotate(-14 48 136)" />
            <g fill="#ffffff" fillOpacity="0.28">
                <circle cx="206" cy="146" r="2.5" />
                <circle cx="218" cy="146" r="2.5" />
                <circle cx="230" cy="146" r="2.5" />
                <circle cx="206" cy="158" r="2.5" />
                <circle cx="218" cy="158" r="2.5" />
                <circle cx="230" cy="158" r="2.5" />
            </g>
        </svg>
    );
}

export default function FeaturedBanner() {
    return (
        <section className="feature-banner" aria-labelledby="feature-banner-heading" lang="en">
            <div className="feature-banner__body">
                <p className="feature-banner__label">{FEATURED.label}</p>
                <h2 id="feature-banner-heading" className="feature-banner__title">
                    {FEATURED.heading}
                </h2>
                <p className="feature-banner__text">{FEATURED.description}</p>
                <div className="feature-banner__actions">
                    <a className="feature-banner__button" href={FEATURED.url} target="_blank" rel="noopener noreferrer">
                        {FEATURED.button} <span aria-hidden="true">↗</span>
                        <span className="sr-only"> (opens in a new tab)</span>
                    </a>
                    <span className="feature-banner__domain">{FEATURED.domain}</span>
                </div>
            </div>
            <FeaturedArt />
        </section>
    );
}
