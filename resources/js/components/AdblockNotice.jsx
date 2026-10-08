import { useEffect, useRef, useState } from 'react';
import Icon from './Icon.jsx';
import { getSite } from '../lib/api.js';
import { t } from '../lib/i18n.js';

// A website cannot switch off a visitor's ad blocker (extensions run outside the page),
// so we detect it and ask the visitor to allow ads. They can close the request; it then stays
// away for a week on that browser, so nobody is locked out of a tool they came for.
// Search engine crawlers never see it: Google demotes pages hidden behind interstitials.
const BOTS = /bot|crawl|spider|slurp|lighthouse|headlesschrome|google-inspectiontool|bingpreview|facebookexternalhit|embedly/i;

const DISMISS_KEY = 'adblock-dismissed';
const DISMISS_DAYS = 7;

function recentlyDismissed() {
    try {
        const at = Number(localStorage.getItem(DISMISS_KEY));
        return at > 0 && Date.now() - at < DISMISS_DAYS * 86400000;
    } catch {
        return false;
    }
}

const AD_SCRIPT = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js';

/** Does the ad script download? A one-off network glitch is retried, so it never triggers the wall. */
async function scriptReachable() {
    try {
        await fetch(`${AD_SCRIPT}?probe=${Date.now()}`, { mode: 'no-cors', cache: 'no-store' });
        return true;
    } catch {
        return false;
    }
}

/** Is a decoy element named like an ad hidden by the page's blocker rules? */
function baitHidden() {
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
            resolve(hidden);
        }, 200);
    });
}

/** @returns {Promise<string[]>} which checks failed ("script", "elements"); empty when ads work. */
async function detectBlocker() {
    const reasons = [];
    if (await baitHidden()) reasons.push('elements');
    if (window.__adsBlocked && !(await scriptReachable())) reasons.push('script');
    return reasons;
}

export default function AdblockNotice() {
    const [reasons, setReasons] = useState([]);
    const open = reasons.length > 0;
    const dialogRef = useRef(null);

    useEffect(() => {
        // Only when real ads are configured, and well after the page has loaded.
        // Off until AdSense has approved the site (config site.ads.adblock_notice).
        if (!getSite().ads?.client || !getSite().ads?.adblockNotice || BOTS.test(navigator.userAgent) || recentlyDismissed()) return;
        let cancelled = false;
        const timer = setTimeout(() => {
            detectBlocker().then((found) => !cancelled && setReasons(found));
        }, 3000);
        return () => {
            cancelled = true;
            clearTimeout(timer);
        };
    }, []);

    const dismiss = () => {
        try {
            localStorage.setItem(DISMISS_KEY, String(Date.now()));
        } catch {
            // private mode: it just shows again next visit
        }
        setReasons([]);
    };

    useEffect(() => {
        if (!open) return undefined;
        dialogRef.current?.focus();
        const previous = document.body.style.overflow;
        document.body.style.overflow = 'hidden';
        const onKey = (e) => e.key === 'Escape' && dismiss();
        document.addEventListener('keydown', onKey);
        return () => {
            document.body.style.overflow = previous;
            document.removeEventListener('keydown', onKey);
        };
    }, [open]);

    if (!open) return null;

    return (
        <div className="fixed inset-0 z-[90] grid place-items-center bg-[rgb(15_23_42/0.7)] p-4 backdrop-blur-sm" onClick={(e) => e.target === e.currentTarget && dismiss()}>
            <div
                ref={dialogRef}
                className="relative w-full max-w-[440px] rounded-[24px] bg-surface p-6 text-center shadow-2xl outline-none sm:p-8"
                role="dialog"
                aria-modal="true"
                aria-labelledby="adblock-title"
                aria-describedby="adblock-text"
                tabIndex={-1}
                data-testid="adblock-notice"
            >
                <button
                    type="button"
                    className="absolute end-3 top-3 grid size-9 cursor-pointer place-items-center rounded-full border-0 bg-transparent text-muted transition-colors hover:bg-surface-2 hover:text-ink [&_svg]:size-5"
                    aria-label={t('Close')}
                    onClick={dismiss}
                >
                    <Icon name="x" />
                </button>
                <span className="mx-auto mb-4 grid size-14 place-items-center rounded-2xl bg-[linear-gradient(135deg,#3b82f6,#7c3aed)] text-white [&_svg]:size-7" aria-hidden="true">
                    <Icon name="shield" />
                </span>
                <h2 id="adblock-title" className="m-0 mb-2 text-[1.35rem] font-extrabold">
                    {t('Please turn off your ad blocker')}
                </h2>
                <p id="adblock-text" className="m-0 mb-4 text-ink-2">
                    {t('Ads are how we keep every tool free, with no sign up and no limits. Your files still never leave your device.')}
                </p>
                <ol className="m-0 mb-3 list-none space-y-1.5 rounded-xl bg-surface-2 p-4 text-start text-[0.92rem] text-ink-2">
                    <li>1. {t('Click the ad blocker icon in your browser toolbar.')}</li>
                    <li>2. {t('Choose "Pause on this site" or "Allow ads on this site".')}</li>
                    <li>3. {t('Reload the page.')}</li>
                </ol>
                <p className="m-0 mb-5 text-[0.85rem] text-muted">
                    {t('Still seeing this? Brave Shields, Opera, Edge "Strict" tracking prevention, antivirus, VPN or DNS ad blocking can also block ads.')}{' '}
                    <span className="whitespace-nowrap" data-testid="adblock-reason">
                        ({reasons.map((r) => (r === 'script' ? t('ad script blocked') : t('ad elements hidden'))).join(', ')})
                    </span>
                </p>
                <button className="btn btn--primary btn--lg w-full rounded-full" type="button" onClick={() => window.location.reload()}>
                    {t("I've turned it off - reload")}
                </button>
                <button type="button" className="mt-3 cursor-pointer border-0 bg-transparent p-1 text-[0.88rem] text-muted underline underline-offset-2 hover:text-ink" onClick={dismiss}>
                    {t('Continue without allowing ads')}
                </button>
            </div>
        </div>
    );
}
