// Read and fill AcroForm fields already in a PDF. pdf-lib is imported by the caller
// only when a file is opened, so the editor page does not download it up front.
// Creating new fields is a later step; this module only writes values into fields
// the file already has.

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

function applyText(field, name, value) {
    const text = value == null ? '' : String(value);
    try {
        field.setText(text);
    } catch (error) {
        if (/max(?:imum)? length/i.test(error?.message || '')) throw new PdfFormError('too-long', name);
        throw error;
    }
}

function applyChoice(field, name, value) {
    const options = field.getOptions();
    if (value == null || value === '') {
        field.clear();
        return;
    }
    if (!options.includes(String(value))) throw new PdfFormError('bad-option', name);
    field.select(String(value));
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
