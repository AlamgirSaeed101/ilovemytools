// Read and fill AcroForm fields already in a PDF. pdf-lib is imported by the caller
// only when a file is opened, so the editor page does not download it up front.
// This module only writes values into fields the file already has; creating new
// fields is in pdfFormCreate.js.

export class PdfFormError extends Error {
    constructor(code, detail = '') {
        super(code);
        this.name = 'PdfFormError';
        this.code = code;
        this.detail = detail;
    }
}

function safe(fn, fallback) {
    try {
        return fn();
    } catch {
        return fallback;
    }
}

function isEncrypted(error) {
    return error?.name === 'EncryptedPDFError' || /encrypt/i.test(error?.message || '');
}

function kindOf(field, kinds) {
    if (field instanceof kinds.PDFTextField) return 'text';
    if (field instanceof kinds.PDFCheckBox) return 'checkbox';
    if (field instanceof kinds.PDFDropdown) return 'dropdown';
    if (field instanceof kinds.PDFRadioGroup) return 'radio';
    if (field instanceof kinds.PDFOptionList) return 'optionlist';
    return 'unsupported';
}

function describeField(field, kinds) {
    const name = safe(() => field.getName(), '');
    const type = kindOf(field, kinds);
    const readOnly = safe(() => field.isReadOnly(), false);
    if (!name || type === 'unsupported') {
        return { name, type: 'unsupported', readOnly, multiline: false, multi: false, value: '', options: [] };
    }
    if (type === 'text') {
        return {
            name,
            type,
            readOnly,
            multiline: safe(() => field.isMultiline(), false),
            multi: false,
            value: safe(() => field.getText() ?? '', ''),
            options: [],
        };
    }
    if (type === 'checkbox') {
        return {
            name,
            type,
            readOnly,
            multiline: false,
            multi: false,
            value: safe(() => field.isChecked(), false),
            options: [],
        };
    }
    const options = safe(() => field.getOptions(), []);
    if (type === 'optionlist') {
        const selected = safe(() => field.getSelected(), []);
        return {
            name,
            type,
            readOnly,
            multiline: false,
            multi: safe(() => field.isMultiselect(), false),
            value: Array.isArray(selected) ? selected : [],
            options,
        };
    }
    const selected = safe(() => field.getSelected(), type === 'dropdown' ? [] : undefined);
    const value = Array.isArray(selected) ? (selected[0] ?? '') : (selected ?? '');
    return { name, type, readOnly, multiline: false, multi: false, value, options };
}

async function loadDocument(bytes) {
    const pdfLib = await import('pdf-lib');
    let doc;
    try {
        doc = await pdfLib.PDFDocument.load(bytes, { updateMetadata: false });
    } catch (error) {
        if (isEncrypted(error)) throw new PdfFormError('encrypted');
        throw new PdfFormError('unreadable');
    }
    return { doc, pdfLib };
}

/** Plain descriptions of every AcroForm field. An empty list means the PDF has no fillable fields. */
export async function readFormFields(bytes) {
    const { doc, pdfLib } = await loadDocument(bytes);
    const kinds = pdfLib;
    let fields;
    try {
        fields = doc.getForm().getFields();
    } catch (error) {
        if (isEncrypted(error)) throw new PdfFormError('encrypted');
        return [];
    }
    return fields.map((field) => describeField(field, kinds)).filter((field) => field.name);
}

// pdf-lib throws ExceededMaxLengthError ("... exceeds the max length (5) ...") when the text is
// longer than the field's /MaxLen.
function isTooLong(error) {
    return error?.name === 'ExceededMaxLengthError' || /max\s*(?:imum)?\s*length/i.test(error?.message || '');
}

function applyText(field, name, value) {
    const text = value == null ? '' : String(value);
    try {
        field.setText(text);
    } catch (error) {
        if (isTooLong(error)) throw new PdfFormError('too-long', name);
        throw error;
    }
}

function applyChoice(field, name, value) {
    const options = field.getOptions();
    if (value == null || value === '') {
        field.clear();
        return;
    }
    if (options.includes(String(value))) {
        field.select(String(value));
        return;
    }
    // A radio button shown on the page reports its own "on" state name (what pdf.js reads), which
    // differs from the option label when the group has an /Opt list. Map it back by position.
    const onValues = safe(() => field.acroField.getOnValues?.() ?? [], []);
    const index = onValues.findIndex((onValue) => safe(() => onValue.decodeText(), '') === String(value));
    if (index === -1 || !options[index]) throw new PdfFormError('bad-option', name);
    field.select(options[index]);
}

function applyOptionList(field, name, value) {
    const picked = (Array.isArray(value) ? value : value ? [value] : []).map(String).filter(Boolean);
    const options = new Set(field.getOptions());
    if (picked.some((option) => !options.has(option))) throw new PdfFormError('bad-option', name);
    if (picked.length === 0) field.clear();
    else field.select(picked);
}

function applyValues(form, values, kinds) {
    for (const field of form.getFields()) {
        const described = describeField(field, kinds);
        if (!described.name || described.type === 'unsupported' || described.readOnly) continue;
        if (!Object.prototype.hasOwnProperty.call(values, described.name)) continue;
        const value = values[described.name];
        if (described.type === 'text') applyText(field, described.name, value);
        else if (described.type === 'checkbox') {
            if (value) field.check();
            else field.uncheck();
        } else if (described.type === 'optionlist') applyOptionList(field, described.name, value);
        else applyChoice(field, described.name, value);
    }
}

async function refreshAppearances(doc, form) {
    const { StandardFonts } = await import('pdf-lib');
    try {
        form.updateFieldAppearances(await doc.embedFont(StandardFonts.Helvetica));
        return;
    } catch {
        // Helvetica is WinAnsi only. A later font covers the letters it cannot draw.
    }
    try {
        const { default: fontkit } = await import('@pdf-lib/fontkit');
        doc.registerFontkit(fontkit);
        const res = await fetch('/fonts/dejavu/DejaVuSans.ttf');
        if (!res.ok) return;
        const font = await doc.embedFont(await res.arrayBuffer(), { subset: true });
        form.updateFieldAppearances(font);
    } catch {
        // The values are already stored. A reader can still show them from the field data.
    }
}

/**
 * Write `values` (keyed by field name) into the form and return the saved PDF bytes.
 * Read-only, signature and other unsupported fields are left as they are.
 * `flatten` draws the answers onto the page and removes the fields.
 */
export async function fillPdfForm(bytes, values, { flatten = false } = {}) {
    const { doc, pdfLib } = await loadDocument(bytes);
    let form;
    try {
        form = doc.getForm();
        applyValues(form, values ?? {}, pdfLib);
        await refreshAppearances(doc, form);
        if (flatten) form.flatten();
    } catch (error) {
        if (error instanceof PdfFormError) throw error;
        if (isEncrypted(error)) throw new PdfFormError('encrypted');
        throw new PdfFormError('failed');
    }
    return doc.save();
}

// ---------------------------------------------------------------------------------------------
// Working on the editor's already loaded documents (Edit PDF's Forms tab). The functions above
// take raw bytes; these take the pdf-lib PDFDocument / pdf.js document the editor already has, so
// form values end up in the same saved file as every other edit.

/** Plain descriptions of every AcroForm field of an already loaded pdf-lib `doc` (same shape as readFormFields). */
export async function listFormFields(doc) {
    const pdfLib = await import('pdf-lib');
    let fields;
    try {
        fields = doc.getForm().getFields();
    } catch (error) {
        if (isEncrypted(error)) throw new PdfFormError('encrypted');
        return [];
    }
    return fields.map((field) => describeField(field, pdfLib)).filter((field) => field.name);
}

function sameValue(a, b) {
    if (Array.isArray(a) || Array.isArray(b)) return JSON.stringify(a ?? []) === JSON.stringify(b ?? []);
    if (typeof a === 'boolean' || typeof b === 'boolean') return !!a === !!b;
    return String(a ?? '') === String(b ?? '');
}

/**
 * Writes `values` (keyed by field name) into the fields of an already loaded pdf-lib `doc`, in
 * place. Only fields whose value really changed are touched, so untouched fields keep the
 * appearance the PDF's author gave them. Returns the number of fields changed. Throws
 * PdfFormError ('too-long', 'bad-option') for a value the field can't take.
 */
export async function applyFormValues(doc, values) {
    const pdfLib = await import('pdf-lib');
    const form = doc.getForm();
    const changed = {};
    for (const field of form.getFields()) {
        const described = describeField(field, pdfLib);
        if (!described.name || described.type === 'unsupported' || described.readOnly) continue;
        if (!Object.prototype.hasOwnProperty.call(values ?? {}, described.name)) continue;
        if (sameValue(values[described.name], described.value)) continue;
        changed[described.name] = values[described.name];
    }
    const count = Object.keys(changed).length;
    if (count === 0) return 0;
    applyValues(form, changed, pdfLib);
    await refreshAppearances(doc, form);
    return count;
}

/** Redraws the appearance of every field whose value changed (Helvetica, or DejaVu Sans for other letters). */
export async function refreshFormAppearances(doc) {
    await refreshAppearances(doc, doc.getForm());
}

function widgetType(annotation) {
    switch (annotation.fieldType) {
        case 'Tx':
            return 'text';
        case 'Btn':
            if (annotation.pushButton) return null;
            return annotation.radioButton ? 'radio' : 'checkbox';
        case 'Ch':
            return annotation.combo ? 'dropdown' : 'optionlist';
        default:
            return null; // Signature fields and anything else can't be filled here.
    }
}

/**
 * Where the fillable fields of page `pageNumber` (1-based) sit, read with pdf.js from the editor's
 * render document: one entry per widget, `{ id, name, type: 'text'|'checkbox'|'radio'|'dropdown'|
 * 'optionlist', rectPdf: {x, y, width, height}, readOnly, multiline, maxLength, onValue, options,
 * multi }`. `onValue` is a radio button's own value; `options` are a choice field's labels.
 * Hidden widgets, push buttons and signature fields are left out.
 */
export async function readFormWidgets(renderDoc, pageNumber) {
    if (!renderDoc) return [];
    const page = await renderDoc.getPage(pageNumber);
    const annotations = await page.getAnnotations({ intent: 'display' });
    const widgets = [];
    for (const annotation of annotations ?? []) {
        if (annotation.subtype !== 'Widget' || !annotation.fieldName || annotation.hidden) continue;
        const type = widgetType(annotation);
        if (!type || !Array.isArray(annotation.rect) || annotation.rect.length !== 4) continue;
        const [x1, y1, x2, y2] = annotation.rect;
        widgets.push({
            id: annotation.id ?? `${annotation.fieldName}#${widgets.length}`,
            name: annotation.fieldName,
            type,
            rectPdf: { x: Math.min(x1, x2), y: Math.min(y1, y2), width: Math.abs(x2 - x1), height: Math.abs(y2 - y1) },
            readOnly: !!annotation.readOnly,
            multiline: !!annotation.multiLine,
            maxLength: annotation.maxLen > 0 ? annotation.maxLen : undefined,
            onValue: type === 'radio' ? (annotation.buttonValue ?? '') : type === 'checkbox' ? (annotation.exportValue ?? 'Yes') : undefined,
            options: Array.isArray(annotation.options) ? annotation.options.map((option) => option.displayValue ?? option.exportValue ?? '') : [],
            multi: !!annotation.multiSelect,
        });
    }
    return widgets;
}
