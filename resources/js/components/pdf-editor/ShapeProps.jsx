import { t } from '../../lib/i18n.js';
import { dashPattern, shapeStyleOf } from '../../lib/pdfEditShapes.js';

export const SHAPE_KINDS = [
    { id: 'rect', label: () => t('Rectangle') },
    { id: 'ellipse', label: () => t('Ellipse') },
    { id: 'line', label: () => t('Line') },
    { id: 'arrow', label: () => t('Arrow') },
];
const DASHES = [
    { id: 'solid', label: () => t('Solid') },
    { id: 'dashed', label: () => t('Dashed') },
    { id: 'dotted', label: () => t('Dotted') },
];
const THICKNESSES = [1, 2, 3, 5, 8];

export const DEFAULT_SHAPE_PROPS = { shape: 'rect', strokeColor: '#dc2626', fillColor: '#fecaca', fill: false, thickness: 3, opacity: 1, dash: 'solid' };

export const isLineShape = (shape) => shape === 'line' || shape === 'arrow';

/** The style fields a new shape element gets from the toolbar's settings. */
export function shapeElementStyle(props) {
    return {
        strokeColor: props.strokeColor,
        fillColor: props.fill && !isLineShape(props.shape) ? props.fillColor : null,
        opacity: props.opacity,
        dash: props.dash,
        thickness: props.thickness,
    };
}

/** SVG presentation attributes for a shape element (or the drag preview), from shapeStyleOf(). */
export function shapeSvgStyle(el) {
    const look = shapeStyleOf(el);
    const dash = dashPattern(look.dash, el.thickness);
    return {
        stroke: look.strokeColor,
        fill: look.fillColor ?? 'none',
        strokeWidth: el.thickness,
        strokeDasharray: dash ? dash.join(' ') : undefined,
        opacity: look.opacity,
    };
}

/**
 * The shape tool's settings: which shape, stroke colour, fill colour or no fill, line thickness,
 * solid/dashed/dotted line and opacity. `value` is DEFAULT_SHAPE_PROPS-shaped; `onChange(patch)`.
 */
export default function ShapeProps({ value, onChange }) {
    const line = isLineShape(value.shape);
    return (
        <>
            <select className="select" style={{ maxWidth: '140px' }} value={value.shape} onChange={(e) => onChange({ shape: e.target.value })} aria-label={t('Shape')}>
                {SHAPE_KINDS.map((sh) => <option key={sh.id} value={sh.id}>{sh.label()}</option>)}
            </select>
            <label className="row" style={{ gap: '.3rem', flexWrap: 'nowrap' }}>
                <span className="field__hint" style={{ margin: 0 }}>{t('Line')}</span>
                <input type="color" value={value.strokeColor} onChange={(e) => onChange({ strokeColor: e.target.value })} aria-label={t('Line colour')} />
            </label>
            {!line && (
                <span className="row" style={{ gap: '.3rem', flexWrap: 'nowrap' }}>
                    <label className="check">
                        <input type="checkbox" checked={value.fill} onChange={(e) => onChange({ fill: e.target.checked })} /> {t('Fill')}
                    </label>
                    <input type="color" value={value.fillColor} disabled={!value.fill} onChange={(e) => onChange({ fillColor: e.target.value, fill: true })} aria-label={t('Fill colour')} />
                </span>
            )}
            <select className="select" style={{ maxWidth: '110px' }} value={value.thickness} onChange={(e) => onChange({ thickness: Number(e.target.value) })} aria-label={t('Line thickness')}>
                {THICKNESSES.map((v) => <option key={v} value={v}>{v}px</option>)}
            </select>
            <select className="select" style={{ maxWidth: '120px' }} value={value.dash} onChange={(e) => onChange({ dash: e.target.value })} aria-label={t('Line style')}>
                {DASHES.map((d) => <option key={d.id} value={d.id}>{d.label()}</option>)}
            </select>
            <label className="row" style={{ gap: '.3rem', flexWrap: 'nowrap' }}>
                <span className="field__hint" style={{ margin: 0 }}>{t('Opacity: {value}%', { value: Math.round(value.opacity * 100) })}</span>
                <input className="range" style={{ width: '90px' }} type="range" min={10} max={100} step={5} value={Math.round(value.opacity * 100)} onChange={(e) => onChange({ opacity: Number(e.target.value) / 100 })} />
            </label>
            <span className="field__hint" style={{ margin: 0 }}>{t('Drag on the page to draw the shape.')}</span>
        </>
    );
}

/**
 * Round handles on both ends of a line or arrow (canvas-space `points`, drawn inside a box whose
 * top-left is `origin`): dragging one moves just that end. Arrow keys nudge a focused handle.
 */
export function LineEndHandles({ points, origin, stageRef, canvasSize, onChange }) {
    function toCanvas(e) {
        const rect = stageRef.current.getBoundingClientRect();
        const x = ((e.clientX - rect.left) * canvasSize.width) / rect.width;
        const y = ((e.clientY - rect.top) * canvasSize.height) / rect.height;
        return { x: Math.min(Math.max(0, x), canvasSize.width), y: Math.min(Math.max(0, y), canvasSize.height) };
    }
    function start(e, index) {
        e.preventDefault();
        e.stopPropagation();
        if (!stageRef.current) return;
        const move = (ev) => onChange(points.map((p, i) => (i === index ? toCanvas(ev) : p)));
        const up = () => {
            window.removeEventListener('pointermove', move);
            window.removeEventListener('pointerup', up);
        };
        window.addEventListener('pointermove', move);
        window.addEventListener('pointerup', up);
    }
    function nudge(e, index) {
        const step = e.shiftKey ? 10 : 1;
        const delta = { ArrowLeft: [-step, 0], ArrowRight: [step, 0], ArrowUp: [0, -step], ArrowDown: [0, step] }[e.key];
        if (!delta) return;
        e.preventDefault();
        e.stopPropagation();
        onChange(points.map((p, i) => (i === index ? { x: p.x + delta[0], y: p.y + delta[1] } : p)));
    }
    return points.slice(0, 2).map((p, index) => (
        <span
            key={index}
            role="button"
            tabIndex={0}
            aria-label={index === 0 ? t('Start of the line - drag to move it') : t('End of the line - drag to move it')}
            onPointerDown={(e) => start(e, index)}
            onKeyDown={(e) => nudge(e, index)}
            className="absolute rounded-full border-2 border-white"
            style={{ left: p.x - origin.x - 7, top: p.y - origin.y - 7, width: 14, height: 14, background: 'var(--brand)', cursor: 'grab', touchAction: 'none', boxShadow: 'var(--shadow-sm)' }}
        />
    ));
}
