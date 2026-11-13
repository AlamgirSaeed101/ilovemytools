import { Fragment, useEffect, useRef, useState } from 'react';
import { t } from '../../lib/i18n.js';
import { computeDisplayScale } from '../../lib/pdfOverlay.js';
import { stageTransform, viewSize } from '../../lib/pdfPageView.js';
import MappedPageCanvas from './MappedPageCanvas.jsx';

/** A read-only picture of a page that isn't the one being edited; clicking it makes it the current page. */
function PagePreview({ page, zoom, number, onActivate }) {
    const scale = computeDisplayScale(page.size.width, page.size.height);
    const width = page.size.width * scale;
    const height = page.size.height * scale;
    const transform = stageTransform(width, height, page.entry?.rotation, zoom);
    return (
        <>
            <div className="page-scroller__preview" style={{ width, height, transformOrigin: 'top left', transform }}>
                <MappedPageCanvas entry={page.entry} renderDoc={page.renderDoc} size={page.size} scale={scale} className="pdf-editor__canvas" />
            </div>
            <button type="button" className="page-scroller__activate" onClick={onActivate} aria-label={t('Edit page {number}', { number })} />
        </>
    );
}

function ContinuousView({ count, current, onCurrentChange, getPage, zoom, onInsertBlank, children }) {
    const rootRef = useRef(null);
    const slotRefs = useRef([]);
    const ratios = useRef(new Map());
    const fromScroll = useRef(false);
    const scrollingTo = useRef(0);
    const [near, setNear] = useState(() => new Set([current]));
    const pages = Array.from({ length: count }, (_, i) => getPage(i));
    const layoutKey = pages.map((page) => page.key).join(',');
    const currentRef = useRef(current);
    currentRef.current = current;

    // Pages are only rendered while they are on (or close to) the screen, and the most visible
    // one becomes the current page that the editing tools work on.
    useEffect(() => {
        const root = rootRef.current;
        if (!root || typeof IntersectionObserver === 'undefined') return undefined;
        const nearObserver = new IntersectionObserver(
            (entries) => {
                setNear((previous) => {
                    const next = new Set(previous);
                    for (const entry of entries) {
                        const index = Number(entry.target.dataset.index);
                        if (entry.isIntersecting) next.add(index);
                        else next.delete(index);
                    }
                    return next;
                });
            },
            { root, rootMargin: '600px 0px' }
        );
        const visibleObserver = new IntersectionObserver(
            (entries) => {
                for (const entry of entries) ratios.current.set(Number(entry.target.dataset.index), entry.intersectionRatio);
                if (Date.now() < scrollingTo.current) return;
                let best = -1;
                let bestRatio = 0;
                for (const [index, ratio] of ratios.current) {
                    if (index < count && ratio > bestRatio) {
                        best = index;
                        bestRatio = ratio;
                    }
                }
                if (best >= 0 && best !== currentRef.current) {
                    fromScroll.current = true;
                    onCurrentChange(best);
                }
            },
            { root, threshold: [0, 0.1, 0.25, 0.5, 0.75, 1] }
        );
        ratios.current = new Map();
        for (const slot of slotRefs.current.slice(0, count)) {
            if (!slot) continue;
            nearObserver.observe(slot);
            visibleObserver.observe(slot);
        }
        return () => {
            nearObserver.disconnect();
            visibleObserver.disconnect();
        };
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [layoutKey]);

    // A page picked elsewhere (the sidebar, Previous/Next) is scrolled into view.
    useEffect(() => {
        if (fromScroll.current) {
            fromScroll.current = false;
            return;
        }
        const root = rootRef.current;
        const slot = slotRefs.current[current];
        if (!root || !slot) return;
        scrollingTo.current = Date.now() + 500;
        root.scrollTo?.({ top: slot.offsetTop - root.offsetTop - 12, behavior: 'smooth' });
    }, [current]);

    const insertControl = (position) => (
        <div className="page-scroller__gap">
            <button type="button" className="btn btn--sm btn--ghost" onClick={() => onInsertBlank(position)}>
                {t('+ Insert blank page here')}
            </button>
        </div>
    );

    return (
        <div className="page-scroller" ref={rootRef} aria-label={t('All pages')}>
            {insertControl(0)}
            {pages.map((page, i) => {
                const scale = computeDisplayScale(page.size.width, page.size.height);
                const box = viewSize(page.size.width * scale, page.size.height * scale, page.entry?.rotation, zoom);
                return (
                    <Fragment key={page.key}>
                        <div
                            className={`page-scroller__slot${i === current ? ' is-current' : ''}`}
                            data-index={i}
                            ref={(el) => {
                                slotRefs.current[i] = el;
                            }}
                            style={{ height: box.height }}
                        >
                            <span className="page-scroller__label">{t('Page {number}', { number: i + 1 })}</span>
                            {i === current ? (
                                children
                            ) : (
                                <div className="page-scroller__frame" style={{ width: box.width, height: box.height }}>
                                    {near.has(i) && <PagePreview page={page} zoom={zoom} number={i + 1} onActivate={() => onCurrentChange(i)} />}
                                </div>
                            )}
                        </div>
                        {insertControl(i + 1)}
                    </Fragment>
                );
            })}
        </div>
    );
}

/**
 * Edit PDF's optional continuous view: every page in one vertical scroll, each rendered only
 * when it comes near the screen. The page being edited is the existing editing stage, passed as
 * `children` and shown in the current page's slot; the other pages are light previews, and
 * scrolling one into view makes it the current page. Between pages there is an "insert a blank
 * page here" control. When `enabled` is false, `children` is shown unchanged (one page at a time).
 *
 * `getPage(i)` returns { key, entry, renderDoc, size } for each page of the page map.
 */
export default function PageScroller({ enabled, children, ...props }) {
    if (!enabled) return children;
    return <ContinuousView {...props}>{children}</ContinuousView>;
}
