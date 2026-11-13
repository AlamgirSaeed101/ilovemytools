// The pure (no pdf-lib) half of creating form fields in Edit PDF: the 'formfield' element the
// editor shows while a field is being drawn, default names, and the checks run before saving.
// Kept apart from pdfFormCreate.js so the editor can use it without downloading pdf-lib.

/** Real AcroForm field kinds a user can draw. */
export const FIELD_KINDS = ['text', 'textarea', 'checkbox', 'radio', 'dropdown', 'signature'];
/** Drawn marks that are not fields. */
export const STAMP_KINDS = ['checkmark', 'bullet'];

/** Default on-page size (canvas px) when a field is placed with a click or the "Add to page" button. */
export const DEFAULT_SIZES = {
    text: { width: 160, height: 24 },
    textarea: { width: 200, height: 64 },
    checkbox: { width: 18, height: 18 },
    radio: { width: 18, height: 18 },
    dropdown: { width: 140, height: 24 },
    signature: { width: 180, height: 50 },
    checkmark: { width: 18, height: 18 },
    bullet: { width: 12, height: 12 },
};

const NAME_PREFIX = {
    text: 'Text field',
    textarea: 'Text area',
    checkbox: 'Checkbox',
    radio: 'Radio group',
    dropdown: 'Dropdown',
    signature: 'Signature',
};

export class FormCreateError extends Error {
    constructor(reason, name = '') {
        super(`form-${reason}`);
        this.name = 'FormCreateError';
        this.reason = reason;
        this.fieldName = name;
    }
}

export const isStampKind = (kind) => STAMP_KINDS.includes(kind);

/** The kind of a 'formfield' element; elements saved by an older version used `fieldType`. */
export const kindOf = (el) => el.kind ?? el.fieldType ?? 'text';

/** `base`, or `base 2`, `base 3`... - the first one not in `used` (a Set or array of names). */
export function uniqueFieldName(base, used) {
    const taken = used instanceof Set ? used : new Set(used);
    const clean = String(base ?? '').trim() || 'Field';
    if (!taken.has(clean)) return clean;
    let n = 2;
    while (taken.has(`${clean} ${n}`)) n += 1;
    return `${clean} ${n}`;
}

/** The first "Text field N" / "Checkbox N" / ... name for `kind` not already in `used`. */
export function nextFieldName(kind, used) {
    const taken = used instanceof Set ? used : new Set(used);
    const prefix = NAME_PREFIX[kind] ?? 'Field';
    let n = 1;
    while (taken.has(`${prefix} ${n}`)) n += 1;
    return `${prefix} ${n}`;
}

/** One option per line -> a trimmed, de-duplicated, non-empty list. */
export function parseOptions(text) {
    return [...new Set(String(text ?? '').split(/\r?\n/).map((option) => option.trim()).filter(Boolean))];
}

/**
 * A new 'formfield' element (without id/page) of `kind`. `box` is either a dragged rect
 * `{x, y, width, height}` or a click point `{x, y}` (the field is then centred on it at its default
 * size). `existingNames` are the PDF's own field names; `elements` the editor's elements, so names
 * stay unique. A radio button joins the group of the last radio button placed, as a new option.
 */
export function newFormElement(kind, box, { existingNames = [], elements = [], bounds = null } = {}) {
    const size = DEFAULT_SIZES[kind] ?? DEFAULT_SIZES.text;
    let rect = box.width ? { x: box.x, y: box.y, width: box.width, height: box.height } : { x: box.x - size.width / 2, y: box.y - size.height / 2, ...size };
    if ((kind === 'checkbox' || kind === 'radio' || isStampKind(kind)) && box.width) {
        // A square mark: use the dragged box's smaller side.
        const side = Math.max(8, Math.min(rect.width, rect.height));
        rect = { ...rect, width: side, height: side };
    }
    if (bounds) {
        const width = Math.min(rect.width, bounds.width);
        const height = Math.min(rect.height, bounds.height);
        rect = { x: Math.min(Math.max(0, rect.x), bounds.width - width), y: Math.min(Math.max(0, rect.y), bounds.height - height), width, height };
    }
    if (isStampKind(kind)) return { type: 'formfield', kind, color: '#111827', ...rect };

    const fields = elements.filter((el) => el.type === 'formfield' && !isStampKind(kindOf(el)));
    const used = new Set([...existingNames, ...fields.map((el) => el.name)]);
    const base = { type: 'formfield', kind, required: false, fontSize: 0, value: '', ...rect };
    if (kind === 'radio') {
        const lastRadio = [...fields].reverse().find((el) => kindOf(el) === 'radio');
        if (lastRadio) {
            const inGroup = fields.filter((el) => kindOf(el) === 'radio' && el.name === lastRadio.name);
            const values = new Set(inGroup.map((el) => el.exportValue));
            return { ...base, name: lastRadio.name, exportValue: uniqueFieldName(`Option ${inGroup.length + 1}`, values), checked: false };
        }
        return { ...base, name: nextFieldName(kind, used), exportValue: 'Option 1', checked: false };
    }
    if (kind === 'checkbox') return { ...base, name: nextFieldName(kind, used), checked: false };
    if (kind === 'dropdown') return { ...base, name: nextFieldName(kind, used), optionsText: '' };
    return { ...base, name: nextFieldName(kind, used) };
}

/** A 'formfield' element (canvas px) -> the PDF-space spec addFormFields() takes. */
export function toFieldSpec(el, rectPdf) {
    const kind = kindOf(el);
    const options = kind === 'dropdown' ? parseOptions(el.optionsText ?? (Array.isArray(el.options) ? el.options.join('\n') : '')) : [];
    return {
        kind,
        name: String(el.name ?? '').trim(),
        page: el.page,
        rectPdf,
        options,
        multiline: kind === 'textarea' || !!el.multiline,
        required: !!el.required,
        fontSize: Number(el.fontSize) || 0,
        value: el.value ?? '',
        checked: !!el.checked,
        exportValue: String(el.exportValue ?? '').trim(),
        color: el.color,
    };
}

/**
 * Checks new field specs before anything is written. Returns `{ ok: true }` or `{ ok: false,
 * reason, name }`: 'empty' (a field without a name), 'duplicate' (two fields, or a field and one
 * already in the PDF, share a name; radio buttons of one group share theirs on purpose),
 * 'options' (a dropdown with fewer than two options), 'radio-value' (a radio button without its
 * own value, or two buttons of a group with the same value).
 */
export function validateFormFieldSpecs(specs, existingNames = []) {
    const existing = new Set(existingNames);
    const kindByName = new Map();
    const radioValues = new Map();
    for (const spec of specs) {
        if (isStampKind(spec.kind)) continue;
        const name = String(spec.name ?? '').trim();
        if (!name) return { ok: false, reason: 'empty' };
        if (existing.has(name)) return { ok: false, reason: 'duplicate', name };
        const earlier = kindByName.get(name);
        if (earlier && !(earlier === 'radio' && spec.kind === 'radio')) return { ok: false, reason: 'duplicate', name };
        kindByName.set(name, spec.kind);
        if (spec.kind === 'dropdown' && (spec.options ?? []).length < 2) return { ok: false, reason: 'options', name };
        if (spec.kind === 'radio') {
            const values = radioValues.get(name) ?? new Set();
            if (!spec.exportValue || values.has(spec.exportValue)) return { ok: false, reason: 'radio-value', name };
            values.add(spec.exportValue);
            radioValues.set(name, values);
        }
    }
    return { ok: true };
}
