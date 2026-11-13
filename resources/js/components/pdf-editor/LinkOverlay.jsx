import { useEffect, useId, useRef, useState } from 'react';
import { t } from '../../lib/i18n.js';
import { normalizeLinkUrl } from '../../lib/pdfEditShapes.js';

/** What a link points at, in words: its address, or the page it jumps to. */
export function linkTargetLabel({ url, pageTarget, kind }) {
    if (pageTarget != null) return t('Go to page {number}', { number: pageTarget + 1 });
    if (url) return url;
    return kind === 'other' ? t('Other action') : t('No target');
}

/**
 * Where a link goes: a web address or a page of this document. Used by the Link tool's toolbar
 * (for new links) and by the editor of an existing link. `target`: 'url' | 'page'; `page` is 1-based.
 */
export function LinkTargetFields({ target, onTarget, url, onUrl, page, onPage, pageCount, idPrefix }) {
    const auto = useId();
    const name = `${idPrefix ?? auto}-target`;
    return (
        <>
            <span className="row" style={{ gap: '.6rem' }} role="radiogroup" aria-label={t('Link to')}>
                <label className="check">
                    <input type="radio" name={name} checked={target === 'url'} onChange={() => onTarget('url')} /> {t('Web address')}
                </label>
                <label className="check">
                    <input type="radio" name={name} checked={target === 'page'} onChange={() => onTarget('page')} disabled={pageCount < 1} /> {t('Page in this PDF')}
                </label>
            </span>
            {target === 'url' ? (
                <input className="input" style={{ maxWidth: '260px' }} value={url} onChange={(e) => onUrl(e.target.value)} placeholder="https://" aria-label={t('Link address')} inputMode="url" />
            ) : (
                <input
                    className="input"
                    type="number"
                    style={{ maxWidth: '110px' }}
                    min={1}
                    max={pageCount}
                    value={page}
                    onChange={(e) => onPage(e.target.value === '' ? '' : Math.round(Number(e.target.value)))}
                    aria-label={t('Page number (1 to {total})', { total: pageCount })}
                />
            )}
        </>
    );
}

/** A 1-based page number typed by the user -> a 0-based page index, or null when it isn't a page of the PDF. */
export function pageIndexFrom(value, pageCount) {
    const n = Number(value);
    return Number.isInteger(n) && n >= 1 && n <= pageCount ? n - 1 : null;
}

/**
 * A link the PDF already had, shown as a box over the page in the Link tool. Clicking it opens an
 * editor to change where it goes (a web address or a page of this PDF) or to remove it. `link` is
 * from readPageLinks(); `edit` the 'linkedit' element already made for it (or null); `rect` the
 * canvas-space box. `onChange(patch)` records { url, pageTarget } or { remove: true }; `onRevert`
 * drops the edit so the link stays as it was.
 */
export default function LinkOverlay({ link, edit, rect, pageCount, onChange, onRevert }) {
    const current = edit ?? link;
    const [open, setOpen] = useState(false);
    const [target, setTarget] = useState(current.pageTarget != null ? 'page' : 'url');
    const [url, setUrl] = useState(current.url ?? '');
    const [page, setPage] = useState(current.pageTarget != null ? current.pageTarget + 1 : 1);
    const [problem, setProblem] = useState('');
    const boxRef = useRef(null);
    const firstFieldRef = useRef(null);

    useEffect(() => {
        if (!open) return;
        setTarget(current.pageTarget != null ? 'page' : 'url');
        setUrl(current.url ?? '');
        setPage(current.pageTarget != null ? current.pageTarget + 1 : 1);
        setProblem('');
        firstFieldRef.current?.querySelector('input')?.focus();
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [open]);

    function close() {
        setOpen(false);
        boxRef.current?.focus();
    }

    function save() {
        if (target === 'url') {
            const normalized = normalizeLinkUrl(url);
            if (!normalized) {
                setProblem(t('Type a valid link address first, for example https://example.com'));
                return;
            }
            onChange({ url: normalized, pageTarget: null, remove: false });
        } else {
            const index = pageIndexFrom(page, pageCount);
            if (index == null) {
                setProblem(t('Choose a page from 1 to {total}.', { total: pageCount }));
                return;
            }
            onChange({ url: null, pageTarget: index, remove: false });
        }
        close();
    }

    const removed = Boolean(edit?.remove);
    const changed = Boolean(edit) && !removed;
    const accent = removed ? 'var(--danger)' : changed ? 'var(--success, #16a34a)' : '#2563eb';
    const stop = (e) => e.stopPropagation();

    return (
        <div className="absolute" style={{ left: rect.x, top: rect.y, width: rect.width, height: rect.height, zIndex: open ? 5 : 2 }} onPointerDown={stop}>
            <button
                ref={boxRef}
                type="button"
                className="block h-full w-full p-0"
                style={{
                    border: `1.5px ${removed ? 'dashed' : 'solid'} ${accent}`,
                    background: removed ? 'color-mix(in srgb, var(--danger) 10%, transparent)' : 'rgba(37, 99, 235, 0.1)',
                    borderRadius: 2,
                    cursor: 'pointer',
                }}
                title={removed ? t('Link removed') : linkTargetLabel(current)}
                aria-label={removed ? t('Removed link - open to restore it') : t('Link to {target} - open to change it', { target: linkTargetLabel(current) })}
                aria-expanded={open}
                onClick={() => setOpen((v) => !v)}
            />
            {!open && (
                <span
                    className="absolute whitespace-nowrap"
                    style={{ left: 0, top: '100%', fontSize: 10, lineHeight: 1.4, padding: '0 4px', color: '#fff', background: accent, borderRadius: 2, maxWidth: 220, overflow: 'hidden', textOverflow: 'ellipsis', pointerEvents: 'none' }}
                    aria-hidden="true"
                >
                    {removed ? t('Removed') : linkTargetLabel(current)}
                </span>
            )}
            {open && (
                <div
                    role="dialog"
                    aria-label={t('Edit link')}
                    className="absolute stack"
                    style={{ left: 0, top: 'calc(100% + 6px)', width: 280, gap: '.5rem', padding: '.6rem', background: 'var(--surface)', border: '1px solid var(--border)', borderRadius: 'var(--radius)', boxShadow: 'var(--shadow-md, var(--shadow-sm))', cursor: 'default' }}
                    onKeyDown={(e) => {
                        if (e.key === 'Escape') {
                            e.stopPropagation();
                            close();
                        } else if (e.key === 'Enter' && e.target.tagName === 'INPUT' && e.target.type !== 'radio') {
                            e.preventDefault();
                            save();
                        }
                    }}
                >
                    <div ref={firstFieldRef} className="stack" style={{ gap: '.45rem' }}>
                        <LinkTargetFields target={target} onTarget={setTarget} url={url} onUrl={setUrl} page={page} onPage={setPage} pageCount={pageCount} />
                    </div>
                    {problem && <p className="field__hint" role="alert" style={{ margin: 0, color: 'var(--danger)' }}>{problem}</p>}
                    <div className="row" style={{ gap: '.4rem' }}>
                        <button type="button" className="btn btn--sm btn--primary" onClick={save}>{removed ? t('Restore with this target') : t('Save link')}</button>
                        {!removed && (
                            <button type="button" className="btn btn--sm" onClick={() => { onChange({ remove: true }); close(); }}>{t('Remove link')}</button>
                        )}
                        {edit && (
                            <button type="button" className="btn btn--sm btn--ghost" onClick={() => { onRevert(); setOpen(false); }}>{t('Undo changes')}</button>
                        )}
                        <button type="button" className="btn btn--sm btn--ghost" onClick={close}>{t('Cancel')}</button>
                    </div>
                </div>
            )}
        </div>
    );
}
