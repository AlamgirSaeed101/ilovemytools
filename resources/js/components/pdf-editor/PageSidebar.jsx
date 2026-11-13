import { useEffect, useRef, useState } from 'react';
import { t, tn } from '../../lib/i18n.js';
import { deletePage, duplicatePage, insertBlank, movePage, rotatePage } from '../../lib/pdfPageOps.js';
import { isSideways } from '../../lib/pdfPageView.js';

// Small line icons drawn for this panel (24x24, stroked with the current text colour).
const ICONS = {
    rotateLeft: <path d="M4 4v5h5M4.6 13.5A8 8 0 1 0 6.3 6.3L4 9" />,
    rotateRight: <path d="M20 4v5h-5M19.4 13.5A8 8 0 1 1 17.7 6.3L20 9" />,
    copy: (
        <>
            <rect x="8" y="8" width="12" height="13" rx="2" />
            <path d="M16 8V5a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h2" />
        </>
    ),
    trash: <path d="M4 7h16M10 11v6M14 11v6M6 7l1 13h10l1-13M9 7V4h6v3" />,
    more: (
        <>
            <circle cx="5" cy="12" r="1.2" />
            <circle cx="12" cy="12" r="1.2" />
            <circle cx="19" cy="12" r="1.2" />
        </>
    ),
    plus: <path d="M12 5v14M5 12h14" />,
    undo: <path d="M9 14 4 9l5-5M4 9h11a5 5 0 0 1 0 10h-3" />,
};

function Glyph({ name }) {
    return (
        <svg className="page-sidebar__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" aria-hidden="true" focusable="false">
            {ICONS[name]}
        </svg>
    );
}

function IconButton({ icon, label, onClick, disabled, danger }) {
    return (
        <button type="button" className={`page-sidebar__btn${danger ? ' is-danger' : ''}`} onClick={onClick} disabled={disabled} aria-label={label} title={label}>
            <Glyph name={icon} />
        </button>
    );
}

/**
 * A small pop-up list of actions behind an icon button; closes on a choice, a click outside,
 * Escape or scrolling. It is placed against the window (position: fixed) so the scrolling page
 * list never clips it.
 */
function Menu({ icon, label, title, children }) {
    const [open, setOpen] = useState(null);
    const ref = useRef(null);

    function toggle(e) {
        if (open) {
            setOpen(null);
            return;
        }
        const r = e.currentTarget.getBoundingClientRect();
        const width = 224;
        setOpen({ top: r.bottom + 4, left: Math.max(8, Math.min(r.left, window.innerWidth - width - 8)) });
    }

    useEffect(() => {
        if (!open) return undefined;
        const onPointerDown = (e) => {
            if (!ref.current?.contains(e.target)) setOpen(null);
        };
        const onKeyDown = (e) => {
            if (e.key !== 'Escape') return;
            setOpen(null);
            ref.current?.querySelector('button')?.focus();
        };
        const onScroll = (e) => {
            if (!ref.current?.contains(e.target)) setOpen(null);
        };
        document.addEventListener('pointerdown', onPointerDown);
        document.addEventListener('keydown', onKeyDown);
        window.addEventListener('scroll', onScroll, true);
        return () => {
            document.removeEventListener('pointerdown', onPointerDown);
            document.removeEventListener('keydown', onKeyDown);
            window.removeEventListener('scroll', onScroll, true);
        };
    }, [open]);

    return (
        <div className="page-sidebar__more" ref={ref}>
            <button type="button" className="page-sidebar__btn" aria-label={label} title={title ?? label} aria-haspopup="true" aria-expanded={Boolean(open)} onClick={toggle}>
                <Glyph name={icon} />
            </button>
            {open && (
                <div className="page-sidebar__menu" style={{ top: open.top, left: open.left }} onClick={() => setOpen(null)}>
                    {children}
                </div>
            )}
        </div>
    );
}

/** The page's picture: its thumbnail turned by the page map's rotation, or a white sheet for a blank page. */
function PageThumb({ entry, thumb, size }) {
    const sideways = isSideways(entry.rotation);
    if (entry.blank) {
        const ratio = sideways ? size.width / size.height : size.height / size.width;
        return <span className="page-sidebar__blank" style={{ aspectRatio: `1 / ${ratio}` }} aria-hidden="true" />;
    }
    if (!thumb?.url) return <span className="page-sidebar__loading">{t('Loading…')}</span>;
    return (
        <img
            src={thumb.url}
            alt=""
            draggable={false}
            style={entry.rotation ? { transform: `rotate(${entry.rotation}deg)${sideways ? ' scale(0.75)' : ''}` } : undefined}
        />
    );
}

/**
 * Edit PDF's page panel: a thumbnail of every page (a column beside the page on wide screens, a
 * strip above it on phones). Click a page to show it; drag it, or use Alt+arrow keys, to move it;
 * rotate, duplicate, delete it, or insert a blank page or another PDF's pages around it. Every
 * change is a new page map passed to `onChange` (see pdfPageOps.js).
 */
export default function PageSidebar({ pageMap, thumbFor, sizeOf, current, onSelect, onChange, onInsertPdf, onUndo, canUndo, continuous, onContinuousChange }) {
    const [dragFrom, setDragFrom] = useState(null);
    const [dropAt, setDropAt] = useState(null);
    const [busy, setBusy] = useState(false);
    const listRef = useRef(null);
    const fileRef = useRef(null);
    const insertAt = useRef(0);
    const count = pageMap.length;

    // Keeps the page on screen visible in the list (without scrolling the whole page).
    useEffect(() => {
        const list = listRef.current;
        const item = list?.children[current];
        if (!item) return;
        if (list.scrollHeight > list.clientHeight + 1) {
            const top = item.offsetTop - list.offsetTop;
            if (top < list.scrollTop || top + item.offsetHeight > list.scrollTop + list.clientHeight) list.scrollTop = top - 8;
        }
        if (list.scrollWidth > list.clientWidth + 1) {
            const left = item.offsetLeft - list.offsetLeft;
            if (left < list.scrollLeft || left + item.offsetWidth > list.scrollLeft + list.clientWidth) list.scrollLeft = left - 8;
        }
    }, [current, count]);

    const blankSizeNear = (index) => {
        const size = sizeOf(Math.max(0, Math.min(index, count - 1)));
        return [size.width, size.height];
    };

    function pickPdf(position) {
        insertAt.current = position;
        fileRef.current?.click();
    }

    async function onPdfPicked(e) {
        const file = e.target.files?.[0];
        e.target.value = '';
        if (!file) return;
        setBusy(true);
        try {
            await onInsertPdf(file, insertAt.current);
        } finally {
            setBusy(false);
        }
    }

    function move(from, to) {
        if (to < 0 || to >= count) return;
        onChange(movePage(pageMap, from, to));
        onSelect(to);
    }

    function onDrop(e, index) {
        e.preventDefault();
        if (dragFrom !== null && dragFrom !== index) move(dragFrom, index);
        setDragFrom(null);
        setDropAt(null);
    }

    function onThumbKeyDown(e, index) {
        if (!e.altKey) return;
        if (e.key === 'ArrowUp' || e.key === 'ArrowLeft') {
            e.preventDefault();
            move(index, index - 1);
        } else if (e.key === 'ArrowDown' || e.key === 'ArrowRight') {
            e.preventDefault();
            move(index, index + 1);
        }
        requestAnimationFrame(() => listRef.current?.querySelector('.page-sidebar__thumb[aria-current="true"]')?.focus());
    }

    return (
        <section className="page-sidebar" aria-label={t('Pages')}>
            <div className="page-sidebar__head">
                <span className="page-sidebar__title">{tn('{count} page', '{count} pages', count)}</span>
                <span className="page-sidebar__tools">
                    <IconButton icon="undo" label={t('Undo page change')} onClick={onUndo} disabled={!canUndo} />
                    <Menu icon="plus" label={t('Add pages')}>
                        <button type="button" onClick={() => { onChange(insertBlank(pageMap, count, blankSizeNear(count - 1))); onSelect(count); }}>
                            {t('Add a blank page at the end')}
                        </button>
                        <button type="button" onClick={() => pickPdf(count)}>{t('Add pages from another PDF')}</button>
                    </Menu>
                </span>
            </div>
            {onContinuousChange && (
                <label className="check page-sidebar__view">
                    <input type="checkbox" checked={continuous} onChange={(e) => onContinuousChange(e.target.checked)} /> {t('Show all pages (scroll)')}
                </label>
            )}
            {busy && <p className="field__hint page-sidebar__status" role="status">{t('Reading PDF…')}</p>}

            <ol className="page-sidebar__list" ref={listRef}>
                {pageMap.map((entry, i) => {
                    const number = i + 1;
                    return (
                        <li
                            key={entry.id}
                            className={`page-sidebar__item${i === current ? ' is-selected' : ''}${dropAt === i && dragFrom !== i ? ' is-drop-target' : ''}${dragFrom === i ? ' is-dragging' : ''}`}
                            role="group"
                            aria-label={t('Page {number}', { number })}
                            draggable
                            onDragStart={(e) => {
                                setDragFrom(i);
                                e.dataTransfer.effectAllowed = 'move';
                                e.dataTransfer.setData('text/plain', String(i));
                            }}
                            onDragOver={(e) => {
                                if (dragFrom === null) return;
                                e.preventDefault();
                                e.dataTransfer.dropEffect = 'move';
                                if (dropAt !== i) setDropAt(i);
                            }}
                            onDragLeave={() => dropAt === i && setDropAt(null)}
                            onDrop={(e) => onDrop(e, i)}
                            onDragEnd={() => {
                                setDragFrom(null);
                                setDropAt(null);
                            }}
                        >
                            <button
                                type="button"
                                className="page-sidebar__thumb"
                                onClick={() => onSelect(i)}
                                onKeyDown={(e) => onThumbKeyDown(e, i)}
                                aria-current={i === current ? 'true' : undefined}
                                aria-label={t('Go to page {number}', { number })}
                                aria-keyshortcuts="Alt+ArrowUp Alt+ArrowDown"
                            >
                                <PageThumb entry={entry} thumb={thumbFor(entry)} size={sizeOf(i)} />
                            </button>
                            <span className="page-sidebar__number" aria-hidden="true">{number}</span>
                            <div className="page-sidebar__actions">
                                <IconButton icon="rotateLeft" label={t('Rotate page {number} left', { number })} onClick={() => onChange(rotatePage(pageMap, i, -90))} />
                                <IconButton icon="rotateRight" label={t('Rotate page {number} right', { number })} onClick={() => onChange(rotatePage(pageMap, i, 90))} />
                                <IconButton icon="copy" label={t('Duplicate page {number}', { number })} onClick={() => onChange(duplicatePage(pageMap, i))} />
                                <IconButton icon="trash" danger label={t('Delete page {number}', { number })} onClick={() => onChange(deletePage(pageMap, i))} disabled={count <= 1} />
                                <Menu icon="more" label={t('More actions for page {number}', { number })} title={t('More actions')}>
                                    <button type="button" disabled={i === 0} onClick={() => move(i, i - 1)}>{t('Move up')}</button>
                                    <button type="button" disabled={i === count - 1} onClick={() => move(i, i + 1)}>{t('Move down')}</button>
                                    <button type="button" onClick={() => { onChange(insertBlank(pageMap, i, blankSizeNear(i))); onSelect(i); }}>{t('Insert blank page before')}</button>
                                    <button type="button" onClick={() => { onChange(insertBlank(pageMap, i + 1, blankSizeNear(i))); onSelect(i + 1); }}>{t('Insert blank page after')}</button>
                                    <button type="button" onClick={() => pickPdf(i + 1)}>{t('Insert pages from a PDF after')}</button>
                                </Menu>
                            </div>
                        </li>
                    );
                })}
            </ol>

            <input
                ref={fileRef}
                type="file"
                accept=".pdf,application/pdf"
                hidden
                data-testid="insert-pdf-input"
                aria-label={t('Choose a PDF to insert')}
                onChange={onPdfPicked}
            />
        </section>
    );
}
