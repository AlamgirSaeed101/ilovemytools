// Frame + floating context bar for the selected element on the page. Rendered inside the editor
// stage (in the page's own pixel space). The stage is CSS-scaled for zoom, so the bar is scaled
// back by 1/zoom to keep a constant on-screen size. Type-specific properties (colour, thickness,
// opacity...) go in as children.
import { t } from '../../lib/i18n.js';
import ToolIcon from './ToolIcon.jsx';

const BAR_GAP = 8;

/**
 * box: { x, y, width, height } of the element in stage pixels.
 * stageWidth/stageHeight: the page's size in stage pixels, so the bar stays on the page (it flips
 * above the element near the bottom, and lines up with its right edge on the right half).
 */
export default function SelectionBar({ box, stageWidth = Infinity, stageHeight = Infinity, zoom = 1, onDelete, onDuplicate, onForward, onBackward, canForward = true, canBackward = true, children }) {
    if (!box) return null;
    const inverse = 1 / (zoom || 1);
    // The bar sits below the element (above it, the rotate handle and remove button live), and
    // flips above when there is no room left at the bottom of the page.
    const below = box.y + box.height + 52 * inverse < stageHeight || box.y < 52 * inverse;
    const fromRight = Number.isFinite(stageWidth) && box.x + box.width / 2 > stageWidth / 2;
    return (
        <>
            <div className="pdf-selection" style={{ left: box.x, top: box.y, width: box.width, height: box.height }} aria-hidden="true" />
            <div
                className="pdf-selection__bar"
                role="toolbar"
                aria-label={t('Selected item')}
                onPointerDown={(e) => e.stopPropagation()}
                style={{
                    ...(fromRight ? { right: Math.max(0, stageWidth - box.x - box.width) } : { left: Math.max(0, box.x) }),
                    top: below ? box.y + box.height + BAR_GAP * inverse : box.y - BAR_GAP * inverse,
                    transform: `${below ? '' : 'translateY(-100%) '}scale(${inverse})`,
                    transformOrigin: `${fromRight ? 'right' : 'left'} ${below ? 'top' : 'bottom'}`,
                }}
            >
                {children && <div className="pdf-selection__props">{children}</div>}
                {onBackward && (
                    <button type="button" className="pdf-selection__btn" onClick={onBackward} disabled={!canBackward} aria-label={t('Send backward')} title={t('Send backward')}>
                        <ToolIcon name="backward" size={18} />
                    </button>
                )}
                {onForward && (
                    <button type="button" className="pdf-selection__btn" onClick={onForward} disabled={!canForward} aria-label={t('Bring forward')} title={t('Bring forward')}>
                        <ToolIcon name="forward" size={18} />
                    </button>
                )}
                {onDuplicate && (
                    <button type="button" className="pdf-selection__btn" onClick={onDuplicate} aria-label={t('Duplicate')} title={t('Duplicate (Ctrl+D)')}>
                        <ToolIcon name="duplicate" size={18} />
                    </button>
                )}
                {onDelete && (
                    <button type="button" className="pdf-selection__btn pdf-selection__btn--danger" onClick={onDelete} aria-label={t('Delete')} title={t('Delete (Del)')}>
                        <ToolIcon name="trash" size={18} />
                    </button>
                )}
            </div>
        </>
    );
}
