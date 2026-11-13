import { useEffect, useId, useRef, useState } from 'react';
import { t } from '../../lib/i18n.js';
import { isStampKind, kindOf, parseOptions } from '../../lib/pdfFormElements.js';

const FONT_SIZES = [0, 8, 9, 10, 11, 12, 14, 16, 18, 24];
const stop = (e) => e.stopPropagation();

/** Short label of a new field's kind, for the toolbar and screen readers. */
export function formKindLabel(kind) {
    switch (kind) {
        case 'textarea':
            return t('Text area');
        case 'checkbox':
            return t('Checkbox');
        case 'radio':
            return t('Radio button');
        case 'dropdown':
            return t('Dropdown');
        case 'signature':
            return t('Signature field');
        case 'checkmark':
            return t('Check mark');
        case 'bullet':
            return t('Bullet');
        default:
            return t('Text field');
    }
}

/** A user-facing message for an error thrown while saving forms (FormCreateError or pdfForms' PdfFormError), or null. */
export function formSaveErrorText(error) {
    if (error?.name === 'FormCreateError') {
        const name = error.fieldName;
        if (error.reason === 'duplicate') return t('Two fields can’t share the name "{name}". Give each field its own name.', { name });
        if (error.reason === 'options') return t('Give the dropdown "{name}" at least two options, one per line.', { name });
        if (error.reason === 'radio-value') return t('Each button of the radio group "{name}" needs its own value.', { name });
        if (error.reason === 'flatten') return t('This form could not be flattened. Save it without flattening instead.');
        return t('Give every new field a name before saving.');
    }
    if (error?.name === 'PdfFormError') {
        if (error.code === 'too-long') return t('{name} is longer than this field allows.', { name: error.detail || '' });
        if (error.code === 'bad-option') return t('{name} does not include that choice.', { name: error.detail || '' });
        if (error.code === 'encrypted') return t('This PDF is password-protected. Unlock it first, then fill the form.');
        return t('Could not fill this form. The file may use a form feature this tool does not support.');
    }
    return null;
}

function Glyph({ kind, el }) {
    if (kind === 'checkmark') {
        return (
            <svg viewBox="0 0 10 10" width="100%" height="100%" aria-hidden="true" style={{ pointerEvents: 'none' }}>
                <polyline points="1.2,5 4,8.2 9,1.4" fill="none" stroke={el.color || '#111827'} strokeWidth="1.4" strokeLinecap="round" strokeLinejoin="round" />
            </svg>
        );
    }
    if (kind === 'bullet') {
        return (
            <svg viewBox="0 0 10 10" width="100%" height="100%" aria-hidden="true" style={{ pointerEvents: 'none' }}>
                <circle cx="5" cy="5" r="5" fill={el.color || '#111827'} />
            </svg>
        );
    }
    if (kind === 'checkbox') return <span className="pdf-editor__fieldglyph" aria-hidden="true">{el.checked ? '✓' : ''}</span>;
    if (kind === 'radio') return <span className="pdf-editor__fieldglyph pdf-editor__fieldglyph--radio" aria-hidden="true">{el.checked ? '●' : ''}</span>;
    return null;
}

function FieldProperties({ el, kind, onChange, onClose }) {
    const id = useId();
    const panelRef = useRef(null);
    const options = kind === 'dropdown' ? parseOptions(el.optionsText) : [];

    useEffect(() => {
        panelRef.current?.querySelector('input, textarea, select')?.focus();
    }, []);

    return (
        <div
            ref={panelRef}
            className="pdf-editor__fieldprops"
            role="dialog"
            aria-label={t('Properties of {name}', { name: el.name || formKindLabel(kind) })}
            onPointerDown={stop}
            onKeyDown={(e) => {
                if (e.key === 'Escape') {
                    e.stopPropagation();
                    onClose();
                }
            }}
        >
            <div className="field">
                <label className="field__label" htmlFor={`${id}-name`}>{kind === 'radio' ? t('Group name') : t('Field name')}</label>
                <input id={`${id}-name`} className="input" value={el.name ?? ''} onChange={(e) => onChange({ name: e.target.value })} />
            </div>
            {kind === 'radio' && (
                <div className="field">
                    <label className="field__label" htmlFor={`${id}-value`}>{t('Value of this button')}</label>
                    <input id={`${id}-value`} className="input" value={el.exportValue ?? ''} onChange={(e) => onChange({ exportValue: e.target.value })} />
                </div>
            )}
            {kind === 'dropdown' && (
                <div className="field">
                    <label className="field__label" htmlFor={`${id}-options`}>{t('Options (one per line)')}</label>
                    <textarea id={`${id}-options`} className="textarea" rows={4} value={el.optionsText ?? ''} onChange={(e) => onChange({ optionsText: e.target.value })} />
                </div>
            )}
            {(kind === 'text' || kind === 'textarea') && (
                <div className="field">
                    <label className="field__label" htmlFor={`${id}-default`}>{t('Default value')}</label>
                    {kind === 'textarea' ? (
                        <textarea id={`${id}-default`} className="textarea" rows={2} value={el.value ?? ''} onChange={(e) => onChange({ value: e.target.value })} />
                    ) : (
                        <input id={`${id}-default`} className="input" value={el.value ?? ''} onChange={(e) => onChange({ value: e.target.value })} />
                    )}
                </div>
            )}
            {kind === 'dropdown' && (
                <div className="field">
                    <label className="field__label" htmlFor={`${id}-default`}>{t('Default value')}</label>
                    <select id={`${id}-default`} className="select" value={options.includes(el.value) ? el.value : ''} onChange={(e) => onChange({ value: e.target.value })}>
                        <option value="">{t('No option selected')}</option>
                        {options.map((option) => <option key={option} value={option}>{option}</option>)}
                    </select>
                </div>
            )}
            {(kind === 'checkbox' || kind === 'radio') && (
                <label className="check">
                    <input type="checkbox" checked={!!el.checked} onChange={(e) => onChange({ checked: e.target.checked })} />
                    {kind === 'radio' ? t('Selected by default') : t('Checked by default')}
                </label>
            )}
            {(kind === 'text' || kind === 'textarea' || kind === 'dropdown') && (
                <div className="field">
                    <label className="field__label" htmlFor={`${id}-size`}>{t('Font size')}</label>
                    <select id={`${id}-size`} className="select" value={Number(el.fontSize) || 0} onChange={(e) => onChange({ fontSize: Number(e.target.value) })}>
                        {FONT_SIZES.map((size) => <option key={size} value={size}>{size === 0 ? t('Auto') : `${size} pt`}</option>)}
                    </select>
                </div>
            )}
            {kind !== 'signature' && (
                <label className="check">
                    <input type="checkbox" checked={!!el.required} onChange={(e) => onChange({ required: e.target.checked })} />
                    {t('Required')}
                </label>
            )}
            <button type="button" className="btn btn--primary btn--sm" onClick={onClose}>{t('Done')}</button>
        </div>
    );
}

/**
 * A new form field (or a check-mark / bullet stamp) drawn on the page, before it is saved: a box
 * to drag and resize, its name, and a properties panel (name, required, default value, font size,
 * dropdown options, radio value). `el` is the editor's 'formfield' element in canvas pixels.
 */
export default function FormFieldCreator({ el, onChange, onRemove, onStartDrag }) {
    const kind = kindOf(el);
    const stamp = isStampKind(kind);
    const [open, setOpen] = useState(!!el.fresh && !stamp);
    const label = formKindLabel(kind);
    const showName = !stamp && kind !== 'checkbox' && kind !== 'radio' && el.height >= 14 && el.width >= 40;

    function close() {
        setOpen(false);
        if (el.fresh) onChange({ fresh: undefined });
    }

    return (
        <div
            className={`pdf-editor__overlay pdf-editor__overlay--field${stamp ? ' pdf-editor__overlay--stamp' : ''}${open ? ' is-selected' : ''}`}
            style={{ left: el.x, top: el.y, width: el.width, height: el.height, zIndex: open ? 4 : undefined }}
            onPointerDown={(e) => onStartDrag(e, 'move')}
            onDoubleClick={() => !stamp && setOpen(true)}
            onKeyDown={(e) => {
                if (e.target !== e.currentTarget) return;
                if (e.key === 'Enter' && !stamp) setOpen(true);
                if (e.key === 'Delete' || e.key === 'Backspace') onRemove();
            }}
            role="group"
            tabIndex={0}
            aria-label={stamp ? t('{kind} - drag to move', { kind: label }) : t('{kind} "{name}" - drag to move', { kind: label, name: el.name ?? '' })}
            title={stamp ? label : `${label}: ${el.name ?? ''}`}
        >
            {showName ? (
                <input
                    className="pdf-editor__fieldname"
                    value={el.name ?? ''}
                    onPointerDown={stop}
                    onChange={(e) => onChange({ name: e.target.value })}
                    aria-label={t('{kind} name', { kind: label })}
                />
            ) : (
                <Glyph kind={kind} el={el} />
            )}
            {!stamp && (
                <button
                    type="button"
                    className="pdf-editor__fieldprops-btn"
                    aria-label={t('Field properties')}
                    aria-expanded={open}
                    onPointerDown={stop}
                    onClick={() => (open ? close() : setOpen(true))}
                >
                    ⚙
                </button>
            )}
            <button type="button" className="pdf-editor__remove" aria-label={stamp ? t('Remove this mark') : t('Remove this field')} onPointerDown={stop} onClick={onRemove}>
                ×
            </button>
            <span className="pdf-editor__handle" onPointerDown={(e) => onStartDrag(e, 'resize')} aria-hidden="true" />
            {open && <FieldProperties el={el} kind={kind} onChange={onChange} onClose={close} />}
        </div>
    );
}

const CREATE_KINDS = ['text', 'textarea', 'checkbox', 'radio', 'dropdown', 'signature'];
const STAMPS = ['checkmark', 'bullet'];

/**
 * The Forms tab's "Add fields" tools: pick a kind, then drag on the page to draw it (or click the
 * page to drop one at its default size). "Add to page" places one in the middle of the page for
 * keyboard users. Check mark and bullet mark boxes on a PDF that has no real form fields.
 */
export function FormCreateTools({ kind, onKind, onAdd }) {
    const button = (k) => (
        <button key={k} type="button" className={`btn btn--sm${kind === k ? ' btn--primary' : ''}`} aria-pressed={kind === k} onClick={() => onKind(k)}>
            {formKindLabel(k)}
        </button>
    );
    return (
        <>
            <span className="row" role="group" aria-label={t('New form field')} style={{ gap: '0.35rem' }}>
                {CREATE_KINDS.map(button)}
            </span>
            <span className="row" role="group" aria-label={t('Marks for forms without fields')} style={{ gap: '0.35rem' }}>
                {STAMPS.map(button)}
            </span>
            <button type="button" className="btn btn--sm" onClick={onAdd}>{t('Add to page')}</button>
            <span className="field__hint" style={{ margin: 0 }}>
                {t('Drag on the page to draw the field, or click to place it. Use ⚙ to set its name, options and default value.')}
            </span>
        </>
    );
}
