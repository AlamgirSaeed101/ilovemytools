// The Edit PDF toolbar: one row of icon + label tools above the page (grouped tools open a small
// menu), then undo/redo, find & replace, zoom, and the primary action passed in as children.
// On narrow screens the labels hide and the buttons wrap, so every tool stays reachable at 360px.
import { useEffect, useId, useRef, useState } from 'react';
import { t } from '../../lib/i18n.js';
import ToolIcon from './ToolIcon.jsx';

export const ZOOM_PRESETS = [50, 75, 100, 125, 150, 200];

/** The toolbar layout. `mode` ids match EditPdf's modes; `option` is passed along with them. */
export const TOOL_ITEMS = [
    { mode: 'select', icon: 'select', label: () => t('Select'), hint: () => t('Select, move and resize what you added') },
    {
        group: 'text',
        icon: 'text',
        label: () => t('Text'),
        items: [
            { mode: 'edittext', icon: 'edittext', label: () => t('Edit existing text') },
            { mode: 'text', icon: 'text', label: () => t('Add new text') },
        ],
    },
    { mode: 'link', icon: 'link', label: () => t('Links') },
    { mode: 'form', icon: 'forms', label: () => t('Forms') },
    { mode: 'image', icon: 'image', label: () => t('Images') },
    { mode: 'sign', icon: 'sign', label: () => t('Sign') },
    { mode: 'whiteout', icon: 'whiteout', label: () => t('Whiteout') },
    {
        group: 'annotate',
        icon: 'annotate',
        label: () => t('Annotate'),
        items: [
            { mode: 'highlight', icon: 'highlight', label: () => t('Highlight') },
            { mode: 'underline', icon: 'underline', label: () => t('Underline') },
            { mode: 'strike', icon: 'strike', label: () => t('Strikethrough') },
            { mode: 'draw', icon: 'draw', label: () => t('Draw') },
            { mode: 'note', icon: 'note', label: () => t('Sticky note') },
        ],
    },
    {
        group: 'shapes',
        icon: 'shapes',
        label: () => t('Shapes'),
        items: [
            { mode: 'shape', option: { shape: 'rect' }, icon: 'rect', label: () => t('Rectangle') },
            { mode: 'shape', option: { shape: 'ellipse' }, icon: 'ellipse', label: () => t('Ellipse') },
            { mode: 'shape', option: { shape: 'line' }, icon: 'line', label: () => t('Line') },
            { mode: 'shape', option: { shape: 'arrow' }, icon: 'arrow', label: () => t('Arrow') },
        ],
    },
    { mode: 'watermark', icon: 'watermark', label: () => t('Watermark') },
];

const isActive = (item, tool, shape) => item.mode === tool && (!item.option?.shape || item.option.shape === shape);

function ToolMenu({ item, tool, shape, onTool, modes }) {
    const [open, setOpen] = useState(false);
    const rootRef = useRef(null);
    const menuId = useId();
    const items = item.items.filter((it) => !modes || modes.includes(it.mode));
    const current = items.find((it) => isActive(it, tool, shape));

    useEffect(() => {
        if (!open) return undefined;
        const onDown = (e) => {
            if (!rootRef.current?.contains(e.target)) setOpen(false);
        };
        document.addEventListener('pointerdown', onDown);
        return () => document.removeEventListener('pointerdown', onDown);
    }, [open]);

    if (items.length === 0) return null;

    const focusItem = (index) => {
        const nodes = rootRef.current?.querySelectorAll('[role="menuitemradio"]');
        if (!nodes?.length) return;
        nodes[(index + nodes.length) % nodes.length].focus();
    };

    function openMenu(focusIndex = null) {
        setOpen(true);
        if (focusIndex !== null) requestAnimationFrame(() => focusItem(focusIndex));
    }

    function choose(it) {
        onTool(it.mode, it.option);
        setOpen(false);
        rootRef.current?.querySelector('.pdf-tool')?.focus();
    }

    function onMenuKeyDown(e) {
        const nodes = [...(rootRef.current?.querySelectorAll('[role="menuitemradio"]') ?? [])];
        const index = nodes.indexOf(document.activeElement);
        if (e.key === 'ArrowDown') focusItem(index + 1);
        else if (e.key === 'ArrowUp') focusItem(index - 1);
        else if (e.key === 'Home') focusItem(0);
        else if (e.key === 'End') focusItem(nodes.length - 1);
        else if (e.key === 'Escape' || e.key === 'Tab') {
            setOpen(false);
            if (e.key === 'Escape') rootRef.current?.querySelector('.pdf-tool')?.focus();
            if (e.key === 'Tab') return;
        } else return;
        e.preventDefault();
        e.stopPropagation();
    }

    return (
        <div className="pdf-tool-menu" ref={rootRef}>
            <button
                type="button"
                className={`pdf-tool${current ? ' is-active' : ''}`}
                aria-haspopup="menu"
                aria-expanded={open}
                aria-controls={open ? menuId : undefined}
                title={current ? `${item.label()}: ${current.label()}` : item.label()}
                onClick={() => (open ? setOpen(false) : openMenu())}
                onKeyDown={(e) => {
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        openMenu(Math.max(0, items.indexOf(current)));
                    }
                }}
            >
                <ToolIcon name={current?.icon ?? item.icon} />
                <span className="pdf-tool__label">{item.label()}</span>
                <ToolIcon name="chevron" size={14} className="pdf-tool__caret" />
            </button>
            {open && (
                <div className="pdf-tool-menu__list" role="menu" id={menuId} aria-label={item.label()} onKeyDown={onMenuKeyDown}>
                    {items.map((it) => (
                        <button
                            key={it.label()}
                            type="button"
                            role="menuitemradio"
                            aria-checked={isActive(it, tool, shape)}
                            className="pdf-tool-menu__item"
                            onClick={() => choose(it)}
                        >
                            <ToolIcon name={it.icon} size={18} />
                            <span>{it.label()}</span>
                        </button>
                    ))}
                </div>
            )}
        </div>
    );
}

export default function EditorToolbar({
    tool,
    onTool,
    shape,
    modes,
    canUndo,
    canRedo,
    onUndo,
    onRedo,
    findOpen = false,
    onFind,
    zoom,
    onZoom,
    zoomMin = ZOOM_PRESETS[0],
    zoomMax = ZOOM_PRESETS[ZOOM_PRESETS.length - 1],
    children,
}) {
    const presets = ZOOM_PRESETS.includes(zoom) ? ZOOM_PRESETS : [...ZOOM_PRESETS, zoom].sort((a, b) => a - b);
    const prevPreset = [...ZOOM_PRESETS].reverse().find((z) => z < zoom);
    const nextPreset = ZOOM_PRESETS.find((z) => z > zoom);

    return (
        <div className="pdf-toolbar" role="toolbar" aria-label={t('PDF editing tools')}>
            <div className="pdf-toolbar__tools">
                {TOOL_ITEMS.map((item) =>
                    item.group ? (
                        <ToolMenu key={item.group} item={item} tool={tool} shape={shape} onTool={onTool} modes={modes} />
                    ) : !modes || modes.includes(item.mode) ? (
                        <button
                            key={item.mode}
                            type="button"
                            className={`pdf-tool${isActive(item, tool, shape) ? ' is-active' : ''}`}
                            aria-pressed={isActive(item, tool, shape)}
                            title={item.hint ? item.hint() : item.label()}
                            onClick={() => onTool(item.mode, item.option)}
                        >
                            <ToolIcon name={item.icon} />
                            <span className="pdf-tool__label">{item.label()}</span>
                        </button>
                    ) : null
                )}
            </div>

            <div className="pdf-toolbar__side">
                <button type="button" className="pdf-tool" onClick={onUndo} disabled={!canUndo} aria-label={t('Undo')} title={t('Undo (Ctrl+Z)')}>
                    <ToolIcon name="undo" />
                    <span className="pdf-tool__label" aria-hidden="true">{t('Undo')}</span>
                </button>
                <button type="button" className="pdf-tool" onClick={onRedo} disabled={!canRedo} aria-label={t('Redo')} title={t('Redo (Ctrl+Shift+Z)')}>
                    <ToolIcon name="redo" />
                    <span className="pdf-tool__label" aria-hidden="true">{t('Redo')}</span>
                </button>
                {onFind && (
                    <button type="button" className={`pdf-tool${findOpen ? ' is-active' : ''}`} aria-pressed={findOpen} onClick={onFind} title={t('Find & replace')}>
                        <ToolIcon name="find" />
                        <span className="pdf-tool__label">{t('Find & replace')}</span>
                    </button>
                )}
                {onZoom && (
                    <div className="pdf-toolbar__zoom">
                        <button type="button" className="pdf-tool pdf-tool--icon" onClick={() => onZoom(prevPreset ?? zoomMin)} disabled={zoom <= zoomMin} aria-label={t('Zoom out')} title={t('Zoom out (-)')}>
                            <ToolIcon name="zoomOut" />
                        </button>
                        <select
                            className="pdf-toolbar__zoom-select"
                            value={zoom}
                            onChange={(e) => onZoom(e.target.value === 'fit' ? 'fit' : Number(e.target.value))}
                            aria-label={t('Zoom')}
                        >
                            {presets.map((z) => (
                                <option key={z} value={z}>{z}%</option>
                            ))}
                            <option value="fit">{t('Fit to width')}</option>
                        </select>
                        <button type="button" className="pdf-tool pdf-tool--icon" onClick={() => onZoom(nextPreset ?? zoomMax)} disabled={zoom >= zoomMax} aria-label={t('Zoom in')} title={t('Zoom in (+)')}>
                            <ToolIcon name="zoomIn" />
                        </button>
                    </div>
                )}
                {children}
            </div>
        </div>
    );
}
