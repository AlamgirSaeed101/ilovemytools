import { memo, useEffect, useRef } from 'react';

export const TRUSTPILOT_SCRIPT = 'https://widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js';
const INTERACTIONS = ['pointerdown', 'keydown', 'touchstart', 'scroll'];

let scriptRequested = false;

/**
 * Adds Trustpilot's bootstrap script once per page. On load it scans the page for
 * .trustpilot-widget elements itself, so widgets present then need no extra call.
 */
export function loadTrustpilot() {
    if (scriptRequested || typeof document === 'undefined') return;
    scriptRequested = true;
    const s = document.createElement('script');
    s.async = true;
    s.src = TRUSTPILOT_SCRIPT;
    document.head.appendChild(s);
}

/**
 * Trustpilot "Review Collector" widget. The script loads only when the widget comes near the
 * screen or on the first interaction (like ads and analytics, it stays out of start-up). If the
 * script is already there (the widget re-rendered after a route or language change), the element
 * is initialised directly. The link inside is the no-JS fallback; the box height is reserved.
 */
function TrustpilotWidget({ config, locale, label }) {
    const ref = useRef(null);

    useEffect(() => {
        const el = ref.current;
        if (!el) return undefined;
        if (window.Trustpilot) {
            window.Trustpilot.loadFromElement(el);
            return undefined;
        }
        let done = false;
        const start = () => {
            if (done) return;
            done = true;
            cleanup();
            if (window.Trustpilot) window.Trustpilot.loadFromElement(el);
            else loadTrustpilot();
        };
        const observer =
            typeof IntersectionObserver !== 'undefined'
                ? new IntersectionObserver((entries) => entries.some((e) => e.isIntersecting) && start(), { rootMargin: '200px' })
                : null;
        observer?.observe(el);
        INTERACTIONS.forEach((type) => window.addEventListener(type, start, { once: true, passive: true }));
        function cleanup() {
            observer?.disconnect();
            INTERACTIONS.forEach((type) => window.removeEventListener(type, start));
        }
        return () => {
            done = true;
            cleanup();
        };
    }, []);

    return (
        <div className="mt-4 w-full max-w-[240px]">
            <div
                ref={ref}
                className="trustpilot-widget flex items-center overflow-hidden"
                data-locale={config.locales?.[locale] ?? 'en-US'}
                data-template-id={config.template_id}
                data-businessunit-id={config.business_unit_id}
                data-style-height={`${config.height}px`}
                data-style-width="100%"
                style={{ height: config.height }}
            >
                <a className="text-muted no-underline hover:text-brand" href={config.url} target="_blank" rel="noopener">
                    {label}
                </a>
            </div>
        </div>
    );
}

// Trustpilot replaces the link with its iframe, so React must not re-render the inside;
// the footer remounts it (key) when the language changes.
export default memo(TrustpilotWidget);
