import { pdfRectToCanvasRect } from '../../lib/pdfOverlay.js';

/**
 * A highlight, underline or strikethrough snapped to the text it was dragged across: one box per
 * line (its quads), drawn relative to the element's box so dragging the element moves them all.
 * `el`: { type: 'highlight' | 'markup', kind, color, quads, quadsBox, x, y, width, height };
 * `scale` and `pageHeight` turn its PDF-space quads into canvas pixels.
 */
export default function TextMarkup({ el, scale, pageHeight, label, removeLabel, onDragStart, onRemove }) {
    const origin = pdfRectToCanvasRect(el.quadsBox, scale, pageHeight);
    const kind = el.type === 'highlight' ? 'highlight' : el.kind;
    return (
        <div
            className="pdf-editor__overlay"
            style={{ left: el.x, top: el.y, width: el.width, height: el.height, borderColor: 'transparent' }}
            onPointerDown={onDragStart}
            role="button"
            tabIndex={0}
            aria-label={label}
        >
            {el.quads.map((q, i) => {
                const left = Math.min(q[0], q[4]) * scale - origin.x;
                const right = Math.max(q[2], q[6]) * scale - origin.x;
                const top = (pageHeight - Math.max(q[1], q[3])) * scale - origin.y;
                const bottom = (pageHeight - Math.min(q[5], q[7])) * scale - origin.y;
                const height = bottom - top;
                const thickness = Math.max(1.5, height * 0.07);
                const style =
                    kind === 'highlight'
                        ? { top, height, background: el.color, opacity: 0.45, mixBlendMode: 'multiply' }
                        : { top: kind === 'strike' ? top + height * 0.55 - thickness / 2 : bottom - height * 0.12 - thickness / 2, height: thickness, background: el.color };
                return <span key={i} aria-hidden="true" className="absolute" style={{ left, width: right - left, pointerEvents: 'none', ...style }} />;
            })}
            <button type="button" className="pdf-editor__remove" aria-label={removeLabel} onPointerDown={(e) => e.stopPropagation()} onClick={onRemove}>
                ×
            </button>
        </div>
    );
}
