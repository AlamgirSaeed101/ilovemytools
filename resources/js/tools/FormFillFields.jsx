import { Notice } from '../components/ui.jsx';
import { t } from '../lib/i18n.js';

function fieldId(index) {
    return `pdf-form-field-${index}`;
}

/**
 * The list of fields already in the PDF. The parent owns the values and the fill action.
 */
export default function FormFillFields({ status, fields, values, flatten, blocked, onChange, onFlatten }) {
    if (status === 'loading') {
        return <p className="field__hint">{t('Reading form fields…')}</p>;
    }

    if (status === 'empty') {
        return (
            <Notice type="info">
                {t('This PDF has no fillable form fields. A scanned form is only a picture, so use Edit text or Add text to write on it.')}
            </Notice>
        );
    }

    if (status !== 'ready') return null;

    return (
        <div className="stack" style={{ marginTop: '0.7rem' }}>
            {blocked && (
                <Notice type="warn">
                    {t('Save or remove your other edits before filling the form. Filling uses the original file, not the edits on the page.')}
                </Notice>
            )}
            {fields.map((field, index) => {
                const id = fieldId(index);
                if (field.type === 'unsupported') {
                    return (
                        <p key={id} className="field__hint">
                            {field.name}: {t('This field cannot be filled in the browser.')}
                        </p>
                    );
                }
                if (field.type === 'checkbox') {
                    return (
                        <label key={id} className="check" htmlFor={id}>
                            <input
                                id={id}
                                type="checkbox"
                                checked={!!values[field.name]}
                                disabled={field.readOnly}
                                onChange={(e) => onChange(field.name, e.target.checked)}
                            />
                            {field.name}
                        </label>
                    );
                }
                if (field.type === 'dropdown' || field.type === 'radio' || (field.type === 'optionlist' && !field.multi)) {
                    return (
                        <div key={id} className="field">
                            <label className="field__label" htmlFor={id}>{field.name}</label>
                            <select
                                id={id}
                                className="select"
                                value={values[field.name] ?? ''}
                                disabled={field.readOnly}
                                onChange={(e) => onChange(field.name, e.target.value)}
                            >
                                <option value="">{t('No option selected')}</option>
                                {field.options.map((option) => (
                                    <option key={option} value={option}>{option}</option>
                                ))}
                            </select>
                        </div>
                    );
                }
                if (field.type === 'optionlist') {
                    const selected = Array.isArray(values[field.name]) ? values[field.name] : [];
                    return (
                        <div key={id} className="field">
                            <label className="field__label" htmlFor={id}>{field.name}</label>
                            <select
                                id={id}
                                className="select"
                                multiple
                                size={Math.min(6, Math.max(2, field.options.length))}
                                value={selected}
                                disabled={field.readOnly}
                                onChange={(e) => onChange(field.name, [...e.target.selectedOptions].map((option) => option.value))}
                            >
                                {field.options.map((option) => (
                                    <option key={option} value={option}>{option}</option>
                                ))}
                            </select>
                            <p className="field__hint">{t('Hold Ctrl or Command to select more than one.')}</p>
                        </div>
                    );
                }
                const Input = field.multiline ? 'textarea' : 'input';
                return (
                    <div key={id} className="field">
                        <label className="field__label" htmlFor={id}>{field.name}</label>
                        <Input
                            id={id}
                            className={field.multiline ? 'textarea' : 'input'}
                            value={values[field.name] ?? ''}
                            disabled={field.readOnly}
                            rows={field.multiline ? 3 : undefined}
                            onChange={(e) => onChange(field.name, e.target.value)}
                        />
                    </div>
                );
            })}
            <label className="check">
                <input type="checkbox" checked={flatten} onChange={(e) => onFlatten(e.target.checked)} />
                {t('Flatten the form so the answers cannot be changed')}
            </label>
        </div>
    );
}

export function formErrorText(error) {
    if (error?.code === 'encrypted') return t('This PDF is password-protected. Unlock it first, then fill the form.');
    if (error?.code === 'unreadable') return t('This PDF could not be opened.');
    if (error?.code === 'too-long') return t('{name} is longer than this field allows.', { name: error.detail || '' });
    if (error?.code === 'bad-option') return t('{name} does not include that choice.', { name: error.detail || '' });
    return t('Could not fill this form. The file may use a form feature this tool does not support.');
}
