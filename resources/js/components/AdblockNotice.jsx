import { useEffect, useRef, useState } from 'react';
import Icon from './Icon.jsx';
import { getSite } from '../lib/api.js';
import { t } from '../lib/i18n.js';

// A website cannot switch off a visitor's ad blocker (extensions run outside the page),
// so we detect it and block the site until the visitor allows ads and reloads (owner's choice).
// Search engine crawlers never see it: Google demotes pages hidden behind interstitials.
const BOTS = /bot|crawl|spider|slurp|lighthouse|headlesschrome|google-inspectiontool|bingpreview|facebookexternalhit|embedly/i;

/** True when the AdSense script failed to load or a bait element named like an ad was hidden. */
function detectBlocker() {
    if (window.__adsBlocked) return Promise.resolve(true);
    const bait = document.createElement('div');
    bait.className = 'adsbox ad-banner ad-placement textads banner-ads';
    bait.setAttribute('aria-hidden', 'true');
    bait.style.cssText = 'position:absolute;left:-9999px;top:-9999px;width:2px;height:2px;';
    bait.innerHTML = '&nbsp;';
    document.body.appendChild(bait);
    return new Promise((resolve) => {
        setTimeout(() => {
            const style = getComputedStyle(bait);
            const hidden = bait.offsetHeight === 0 || style.display === 'none' || style.visibility === 'hidden' || !bait.isConnected;
            bait.remove();
            resolve(hidden || Boolean(window.__adsBlocked));
        }, 200);
    });
}

export default function AdblockNotice() {
    const [open, setOpen] = useState(false);
    const dialogRef = useRef(null);

    useEffect(() => {
        // Only when real ads are configured, and well after the page has loaded.
        if (!getSite().ads?.client || BOTS.test(navigator.userAgent)) return;
        let cancelled = false;
        const timer = setTimeout(() => {
            detectBlocker().then((blocked) => !cancelled && blocked && setOpen(true));
        }, 3000);
        return () => {
            cancelled = true;
            clearTimeout(timer);
        };
    }, []);

    useEffect(() => {
        if (!open) return undefined;
        dialogRef.current?.focus();
        // The page behind the wall can't be scrolled or used.
        const previous = document.body.style.overflow;
        document.body.style.overflow = 'hidden';
        return () => {
            document.body.style.overflow = previous;
        };
    }, [open]);

    if (!open) return null;

    return (
        <div className="fixed inset-0 z-[90] grid place-items-center bg-[rgb(15_23_42/0.7)] p-4 backdrop-blur-sm">
            <div
                ref={dialogRef}
                className="w-full max-w-[440px] rounded-[24px] bg-surface p-6 text-center shadow-2xl outline-none sm:p-8"
                role="dialog"
                aria-modal="true"
                aria-labelledby="adblock-title"
                aria-describedby="adblock-text"
                tabIndex={-1}
                data-testid="adblock-notice"
            >
                <span className="mx-auto mb-4 grid size-14 place-items-center rounded-2xl bg-[linear-gradient(135deg,#3b82f6,#7c3aed)] text-white [&_svg]:size-7" aria-hidden="true">
                    <Icon name="shield" />
                </span>
                <h2 id="adblock-title" className="m-0 mb-2 text-[1.35rem] font-extrabold">
                    {t('Please turn off your ad blocker')}
                </h2>
                <p id="adblock-text" className="m-0 mb-4 text-ink-2">
                    {t('Ads are how we keep every tool free, with no sign up and no limits. Your files still never leave your device.')}
                </p>
                <ol className="m-0 mb-6 list-none space-y-1.5 rounded-xl bg-surface-2 p-4 text-left text-[0.92rem] text-ink-2">
                    <li>1. {t('Click the ad blocker icon in your browser toolbar.')}</li>
                    <li>2. {t('Choose "Pause on this site" or "Allow ads on this site".')}</li>
                    <li>3. {t('Reload the page.')}</li>
                </ol>
                <button className="btn btn--primary btn--lg w-full rounded-full" type="button" onClick={() => window.location.reload()}>
                    {t("I've turned it off - reload")}
                </button>
            </div>
        </div>
    );
}
