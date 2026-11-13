import { useEffect, useMemo, useRef } from 'react';
import { t } from '../../lib/i18n.js';
import { DEFAULT_LINE_HEIGHT, usesOwnFont, wrapLines } from '../../lib/pdfTextBlocks.js';
import './textEditor.css';

// CSS stand-ins for the fonts pdfTextEdit.fontForEdit() draws with (Helvetica, Times, Courier; DejaVu Sans beyond Latin-1).
export const FALLBACK_CSS = {
    sans: 'Helvetica, Arial, "Liberation Sans", "DejaVu Sans", sans-serif',
    serif: '"Times New Roman", Times, "Liberation Serif", serif',
    mono: '"Courier New", Courier, "Liberation Mono", monospace',
};

/** CSS font of a 'text' or 'textedit' element, matching the font the saved PDF will use. */
export function elementFontCss(el, scale) {
    const own = usesOwnFont(el);
    const family = el.family ?? (el.type === 'text' ? 'sans' : 'original');
    const fallback = family === 'original' ? el.run?.family ?? 'sans' : family;
    const bold = el.bold ?? Boolean(el.run?.bold);
    const italic = el.italic ?? Boolean(el.run?.italic);
    return {
        fontFamily: own ? el.run.cssFamily : FALLBACK_CSS[fallback] ?? FALLBACK_CSS.sans,
        fontSize: el.size * scale,
        fontWeight: own ? undefined : bold ? 700 : 400,
        fontStyle: own ? undefined : italic ? 'italic' : 'normal',
    };
}

function measurer(font) {
    const canvas = measurer.canvas ?? (measurer.canvas = document.createElement('canvas'));
    const ctx = canvas.getContext('2d');
    ctx.font = `${font.fontStyle === 'italic' ? 'italic ' : ''}${font.fontWeight === 700 ? 'bold ' : ''}${font.fontSize}px ${font.fontFamily}`;
    return (s) => ctx.measureText(s).width;
}

/** The lines, width and height (canvas px) a text element takes on screen. */
export function layoutOnScreen(el, scale) {
    const font = elementFontCss(el, scale);
    const measure = measurer(font);
    const lines = wrapLines(el.text, measure, font.fontSize, el.maxWidth ?? null);
    const natural = Math.max(0, ...lines.map((line) => measure(line)));
    const lineHeightPx = (el.lineHeight ?? DEFAULT_LINE_HEIGHT) * font.fontSize;
    return {
        font,
        lines,
        lineHeightPx,
        width: el.maxWidth ?? Math.max(16, Math.ceil(natural) + 2),
        height: Math.max(1, lines.length) * lineHeightPx,
    };
}

/**
 * The on-page editor for an edit of the PDF's own text ('textedit') or added text ('text'). Not
 * selected, it shows the laid-out text: drag it to move, click it to edit. Selected, it is a
 * textarea that grows as you type, with a move handle and a width handle (text wraps at the width).
 * An edit also keeps the old wording's spot covered (`el.covers`) wherever the new text is moved.
 */
export default function TextBlockEditor({ el, selected, scale, labels, onChange, onLayout, onSelect, onDone, onMoveStart, onResizeStart, onRotateStart, onRemove }) {
    const layout = useMemo(() => layoutOnScreen(el, scale), [el, scale]);
    const textareaRef = useRef(null);
    const downAt = useRef(null);
    const isEdit = el.type === 'textedit';
    const align = el.align ?? 'left';

    // Keeps the element's box (the shared x/y/width/height contract) in step with its laid-out text.
    useEffect(() => {
        if (Math.abs(layout.width - el.width) > 0.5 || Math.abs(layout.height - el.height) > 0.5) {
            (onLayout ?? onChange)({ width: layout.width, height: layout.height });
        }
    }, [layout.width, layout.height]); // eslint-disable-line react-hooks/exhaustive-deps

    useEffect(() => {
        if (!selected || !textareaRef.current) return;
        const area = textareaRef.current;
        area.focus({ preventScroll: true });
        area.setSelectionRange(area.value.length, area.value.length);
    }, [selected]);

    const textStyle = { ...layout.font, color: el.color, lineHeight: `${layout.lineHeightPx}px`, textAlign: align };
    const rotate = !isEdit && el.rotation ? { transform: `rotate(${el.rotation}deg)`, transformOrigin: 'center' } : null;
    const covers = isEdit ? el.covers ?? [{ x: el.x, y: el.y, width: el.width, height: el.height }] : [];

    function pointerDown(e) {
        downAt.current = { x: e.clientX, y: e.clientY };
        onMoveStart?.(e);
    }

    function click(e) {
        const start = downAt.current;
        downAt.current = null;
        if (start && Math.hypot(e.clientX - start.x, e.clientY - start.y) > 4) return; // that was a drag
        onSelect?.();
    }

    function nudge(e) {
        const step = e.shiftKey ? 10 : 1;
        const moves = { ArrowLeft: [-step, 0], ArrowRight: [step, 0], ArrowUp: [0, -step], ArrowDown: [0, step] };
        if (!moves[e.key]) return;
        e.preventDefault();
        onChange({ x: el.x + moves[e.key][0], y: el.y + moves[e.key][1] });
    }

    const box = {
        left: el.x,
        top: el.y,
        width: layout.width,
        height: layout.height,
        ...rotate,
    };
    const className = `${isEdit ? 'pdf-editor__textbox pdf-editor__textbox--edit' : 'pdf-editor__overlay pdf-editor__textbox'}${selected ? ' is-selected' : ''}${!el.text.trim() ? ' is-empty' : ''}`;

    return (
        <>
            {covers.map((c, i) => (
                <div key={i} className="pdf-editor__textcover" style={{ left: c.x, top: c.y, width: c.width, height: c.height, background: el.background }} aria-hidden="true" />
            ))}
            {selected ? (
                <div className={className} style={box} onPointerDown={(e) => e.stopPropagation()}>
                    <textarea
                        ref={textareaRef}
                        className="pdf-editor__textarea"
                        value={el.text}
                        onChange={(e) => onChange({ text: e.target.value })}
                        onKeyDown={(e) => {
                            if (e.key === 'Escape' || (e.key === 'Enter' && (e.ctrlKey || e.metaKey))) {
                                e.preventDefault();
                                onDone?.();
                            }
                        }}
                        wrap={el.maxWidth ? 'soft' : 'off'}
                        spellCheck={false}
                        aria-label={t('Edit this text')}
                        style={{ ...textStyle, height: layout.height, whiteSpace: el.maxWidth ? 'pre-wrap' : 'pre' }}
                    />
                    <button
                        type="button"
                        className="pdf-editor__textmove"
                        onPointerDown={(e) => {
                            e.stopPropagation();
                            onMoveStart?.(e);
                        }}
                        onKeyDown={nudge}
                        aria-label={t('Move this text (drag, or use the arrow keys)')}
                        title={t('Drag to move')}
                    >
                        <svg width="12" height="12" viewBox="0 0 12 12" aria-hidden="true" focusable="false">
                            {[2, 6, 10].flatMap((cx) => [3, 9].map((cy) => <circle key={`${cx}-${cy}`} cx={cy} cy={cx} r="1.2" fill="currentColor" />))}
                        </svg>
                    </button>
                    <span
                        className="pdf-editor__textwidth"
                        onPointerDown={(e) => {
                            e.stopPropagation();
                            onResizeStart?.(e);
                        }}
                        title={t('Drag to change the width (the text wraps)')}
                        aria-hidden="true"
                    />
                    {!isEdit && onRemove && (
                        <button type="button" className="pdf-editor__remove" aria-label={labels?.remove ?? t('Remove this text')} onPointerDown={(e) => e.stopPropagation()} onClick={onRemove}>
                            ×
                        </button>
                    )}
                    {!isEdit && onRotateStart && <span className="pdf-editor__rotate-handle" onPointerDown={onRotateStart} aria-hidden="true" />}
                </div>
            ) : (
                <div
                    className={className}
                    style={box}
                    onPointerDown={pointerDown}
                    onClick={click}
                    onKeyDown={(e) => {
                        if (e.key === 'Enter' || e.key === 'F2') {
                            e.preventDefault();
                            onSelect?.();
                        } else nudge(e);
                    }}
                    role="button"
                    tabIndex={0}
                    aria-label={labels?.drag ?? (el.text.trim() ? t('Edited text - click to change, drag to move') : t('Deleted text - click to type new text'))}
                >
                    <div className="pdf-editor__textlines" style={textStyle} aria-hidden="true">
                        {layout.lines.map((line, i) => (
                            <div key={i} style={{ height: layout.lineHeightPx }}>
                                {line || ' '}
                            </div>
                        ))}
                    </div>
                    {!isEdit && onRemove && (
                        <button type="button" className="pdf-editor__remove" aria-label={labels?.remove ?? t('Remove this text')} onPointerDown={(e) => e.stopPropagation()} onClick={onRemove}>
                            ×
                        </button>
                    )}
                    {!isEdit && onRotateStart && <span className="pdf-editor__rotate-handle" onPointerDown={onRotateStart} aria-hidden="true" />}
                </div>
            )}
        </>
    );
}
