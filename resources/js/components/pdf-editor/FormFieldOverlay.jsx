import { pdfRectToCanvasRect } from '../../lib/pdfOverlay.js';
import { t } from '../../lib/i18n.js';

const stop = (e) => e.stopPropagation();

/**
 * Live inputs laid exactly over the PDF's own form fields on the page preview, so a form is filled
 * where it is printed. `widgets` come from pdfForms.readFormWidgets() (one per widget, PDF space);
 * `fields` (optional, from pdfForms.listFormFields) supply the option labels pdf-lib will accept.
 * `values` is keyed by field name; `onChange(name, value)` reports an edit. With `interactive`
 * false the fields are only outlined (while new fields are being drawn on the page).
 */
export default function FormFieldOverlay({ widgets, fields = [], values, onChange, scale, pageHeight, interactive = true }) {
    const fieldByName = new Map(fields.map((field) => [field.name, field]));
    return widgets.map((w) => {
        const r = pdfRectToCanvasRect(w.rectPdf, scale, pageHeight);
        const style = { left: r.x, top: r.y, width: r.width, height: r.height, ...(interactive ? null : { pointerEvents: 'none', opacity: 0.55 }) };
        const fontSize = Math.max(8, Math.min(16, (w.multiline ? 12 * scale : r.height * 0.62)));
        const field = fieldByName.get(w.name);
        const readOnly = w.readOnly || field?.readOnly || !interactive;
        const common = { style, disabled: readOnly, onPointerDown: stop, tabIndex: interactive ? undefined : -1, 'data-field': w.name };

        if (w.type === 'text') {
            const Tag = w.multiline ? 'textarea' : 'input';
            return (
                <Tag
                    key={w.id} {...common}
                    className="pdf-editor__forminput"
                    style={{ ...style, fontSize }}
                    type={w.multiline ? undefined : 'text'}
                    value={values[w.name] ?? ''}
                    maxLength={w.maxLength}
                    onChange={(e) => onChange(w.name, e.target.value)}
                    aria-label={t('Fill in {name}', { name: w.name })}
                />
            );
        }
        if (w.type === 'checkbox') {
            return (
                <input
                    key={w.id} {...common}
                    type="checkbox"
                    className="pdf-editor__formcheck"
                    checked={!!values[w.name]}
                    onChange={(e) => onChange(w.name, e.target.checked)}
                    aria-label={t('Checkbox: {name}', { name: w.name })}
                />
            );
        }
        if (w.type === 'radio') {
            const value = w.onValue;
            const options = field?.options ?? [];
            // The value pdf-lib knows the button by: its label when the group lists them, else its "on" name.
            const checked = values[w.name] === value || (options.includes(values[w.name]) && options.indexOf(values[w.name]) === widgetIndex(widgets, w));
            return (
                <input
                    key={w.id} {...common}
                    type="radio"
                    name={`pdf-form-${w.name}`}
                    className="pdf-editor__formcheck"
                    checked={checked}
                    onChange={() => onChange(w.name, value)}
                    aria-label={t('{name}: {value}', { name: w.name, value })}
                />
            );
        }
        const options = field?.options?.length ? field.options : w.options;
        if (w.type === 'optionlist' && (field?.multi ?? w.multi)) {
            const selected = Array.isArray(values[w.name]) ? values[w.name] : [];
            return (
                <select
                    key={w.id} {...common}
                    multiple
                    className="pdf-editor__forminput"
                    style={{ ...style, fontSize }}
                    value={selected}
                    onChange={(e) => onChange(w.name, [...e.target.selectedOptions].map((option) => option.value))}
                    aria-label={t('Select {name}', { name: w.name })}
                >
                    {options.map((o) => <option key={o} value={o}>{o}</option>)}
                </select>
            );
        }
        const current = Array.isArray(values[w.name]) ? (values[w.name][0] ?? '') : (values[w.name] ?? '');
        return (
            <select
                key={w.id} {...common}
                className="pdf-editor__forminput"
                style={{ ...style, fontSize }}
                value={current}
                onChange={(e) => onChange(w.name, w.type === 'optionlist' ? (e.target.value ? [e.target.value] : []) : e.target.value)}
                aria-label={t('Select {name}', { name: w.name })}
            >
                <option value="">{t('Choose a value')}</option>
                {options.map((o) => <option key={o} value={o}>{o}</option>)}
            </select>
        );
    });
}

/** Position of a radio widget among the widgets of its group on this page (best effort for /Opt groups). */
function widgetIndex(widgets, widget) {
    return widgets.filter((w) => w.name === widget.name).indexOf(widget);
}
