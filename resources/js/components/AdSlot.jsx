import { useEffect, useRef } from 'react';
import { getSite } from '../lib/api.js';
import { t } from '../lib/i18n.js';

/**
 * Ad slot. Positions: header, below_tool, sidebar, in_content, footer
 * (slot IDs come from .env via config/site.php). Space is reserved with
 * min-height so ads never make the page jump (CLS).
 *
 * Renders a real AdSense unit when the client and slot ID are set, a grey
 * placeholder while designing locally, and nothing otherwise. Give the slot
 * a `key` that changes per page so a fresh unit is requested on navigation.
 */
export default function AdSlot({ position }) {
    const { ads } = getSite();
    const slot = ads.slots?.[position] || '';
    const live = Boolean(ads.client && slot);
    const pushed = useRef(false);

    useEffect(() => {
        if (!live || pushed.current) return;
        pushed.current = true;
        try {
            (window.adsbygoogle = window.adsbygoogle || []).push({});
        } catch {
            // Ad blockers or a not-yet-loaded script: the page works without ads.
        }
    }, [live]);

    if (!live && !ads.placeholders) return null;

    return (
        <aside className={`ad ad--${position}`} aria-label={t('Advertisement')}>
            <span className="ad__label">{t('Advertisement')}</span>
            {live ? (
                <ins
                    className="adsbygoogle"
                    style={{ display: 'block' }}
                    data-ad-client={ads.client}
                    data-ad-slot={slot}
                    data-ad-format={position === 'sidebar' ? 'vertical' : 'auto'}
                    data-full-width-responsive="true"
                />
            ) : (
                <div className="ad__placeholder">{t('Ad space')} ({position})</div>
            )}
        </aside>
    );
}
