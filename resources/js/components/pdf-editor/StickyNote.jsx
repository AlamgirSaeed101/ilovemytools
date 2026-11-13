import { useEffect, useRef, useState } from 'react';
import { t } from '../../lib/i18n.js';

export const NOTE_SIZE = 24;
export const NOTE_COLORS = ['#facc15', '#fb923c', '#4ade80', '#60a5fa', '#f472b6'];
const COLOR_NAMES = { '#facc15': () => t('Yellow'), '#fb923c': () => t('Orange'), '#4ade80': () => t('Green'), '#60a5fa': () => t('Blue'), '#f472b6': () => t('Pink') };
const ICONS = [
    { id: 'Comment', label: () => t('Comment') },
    { id: 'Note', label: () => t('Note') },
    { id: 'Help', label: () => t('Help') },
    { id: 'Key', label: () => t('Key') },
    { id: 'Insert', label: () => t('Insert') },
    { id: 'Paragraph', label: () => t('Paragraph') },
];
const AUTHOR_KEY = 'edit-pdf-note-author';

/** The name last typed as a note's author, remembered in this browser for the next note. */
export function rememberedAuthor() {
    try {
        return localStorage.getItem(AUTHOR_KEY) ?? '';
    } catch {
        return '';
    }
}

function rememberAuthor(name) {
    try {
        localStorage.setItem(AUTHOR_KEY, name);
    } catch {
        // Private mode or blocked storage: the author just isn't remembered.
    }
}

/** A speech-bubble icon in the note's colour (drawn here, the same shape the saved PDF uses). */
function NoteIcon({ color }) {
    return (
        <svg width={NOTE_SIZE} height={NOTE_SIZE} viewBox="0 0 24 24" aria-hidden="true" style={{ display: 'block', pointerEvents: 'none' }}>
            <path d="M2 2h20v15H12l-6 5 1.2-5H2z" fill={color} stroke="#404040" strokeWidth="1.2" strokeLinejoin="round" />
            <path d="M5.5 6h13M5.5 9.5h13M5.5 13h9" stroke="#404040" strokeWidth="1.2" />
        </svg>
    );
}

/**
 * A sticky note on the page: an icon that can be dragged, and clicked (or Enter/Space) to open a
 * small editor for its text, author, colour and icon. A new, empty note opens straight away.
 * `el`: { x, y, color, contents, author, icon }. Saved as a /Text annotation (pdfAnnotations.js).
 */
export default function StickyNote({ el, onDragStart, onChange, onRemove }) {
    const [open, setOpen] = useState(() => !el.contents);
    const down = useRef(null);
    const textRef = useRef(null);
    const buttonRef = useRef(null);

    // Focus the text box once the note opens (a new note is ready to type into straight away). The
    // next frame as well, in case the click that placed the note moved focus after this render.
    useEffect(() => {
        if (!open) return undefined;
        textRef.current?.focus();
        const frame = requestAnimationFrame(() => {
            if (textRef.current && !textRef.current.parentElement?.contains(document.activeElement)) textRef.current.focus();
        });
        return () => cancelAnimationFrame(frame);
    }, [open]);

    function close() {
        setOpen(false);
        buttonRef.current?.focus();
    }

    const stop = (e) => e.stopPropagation();

    return (
        <div className="absolute" style={{ left: el.x, top: el.y, width: NOTE_SIZE, height: NOTE_SIZE, zIndex: open ? 5 : 2 }}>
            <button
                ref={buttonRef}
                type="button"
                className="block p-0"
                style={{ border: 0, background: 'transparent', cursor: 'move', touchAction: 'none' }}
                aria-label={el.contents ? t('Note: {text}', { text: el.contents }) : t('Empty note - open to write')}
                aria-expanded={open}
                title={el.contents || undefined}
                onPointerDown={(e) => {
                    down.current = { x: e.clientX, y: e.clientY };
                    onDragStart(e);
                }}
                onClick={(e) => {
                    const start = down.current;
                    down.current = null;
                    // A click that ended a drag doesn't toggle the editor.
                    if (start && Math.hypot(e.clientX - start.x, e.clientY - start.y) > 4) return;
                    setOpen((v) => !v);
                }}
            >
                <NoteIcon color={el.color} />
            </button>
            {open && (
                <div
                    role="dialog"
                    aria-label={t('Note')}
                    className="absolute stack"
                    style={{
                        left: NOTE_SIZE + 6,
                        top: 0,
                        width: 240,
                        gap: '.45rem',
                        padding: '.6rem',
                        background: 'var(--surface)',
                        border: '1px solid var(--border)',
                        borderRadius: 'var(--radius)',
                        boxShadow: 'var(--shadow-md, var(--shadow-sm))',
                        cursor: 'default',
                    }}
                    onPointerDown={stop}
                    onKeyDown={(e) => {
                        if (e.key === 'Escape') {
                            e.stopPropagation();
                            close();
                        }
                    }}
                >
                    <textarea
                        ref={textRef}
                        className="input"
                        rows={4}
                        value={el.contents}
                        onChange={(e) => onChange({ contents: e.target.value })}
                        placeholder={t('Write a note…')}
                        aria-label={t('Note text')}
                        style={{ resize: 'vertical', minHeight: '4.5rem' }}
                    />
                    <input
                        className="input"
                        value={el.author}
                        onChange={(e) => {
                            onChange({ author: e.target.value });
                            rememberAuthor(e.target.value);
                        }}
                        placeholder={t('Your name (optional)')}
                        aria-label={t('Author')}
                    />
                    <div className="row" style={{ gap: '.35rem' }} role="radiogroup" aria-label={t('Note colour')}>
                        {NOTE_COLORS.map((c) => (
                            <button
                                key={c}
                                type="button"
                                role="radio"
                                aria-checked={el.color === c}
                                aria-label={COLOR_NAMES[c]?.() ?? c}
                                title={COLOR_NAMES[c]?.() ?? c}
                                onClick={() => onChange({ color: c })}
                                className="rounded-full"
                                style={{ width: 20, height: 20, padding: 0, background: c, border: el.color === c ? '2px solid var(--text)' : '1px solid var(--border)' }}
                            />
                        ))}
                        <select className="select" style={{ maxWidth: '120px', marginLeft: 'auto' }} value={el.icon} onChange={(e) => onChange({ icon: e.target.value })} aria-label={t('Icon in other PDF apps')}>
                            {ICONS.map((i) => <option key={i.id} value={i.id}>{i.label()}</option>)}
                        </select>
                    </div>
                    <div className="row row--between">
                        <button type="button" className="btn btn--sm btn--ghost" onClick={onRemove}>{t('Delete note')}</button>
                        <button type="button" className="btn btn--sm btn--primary" onClick={close}>{t('Done')}</button>
                    </div>
                </div>
            )}
        </div>
    );
}
