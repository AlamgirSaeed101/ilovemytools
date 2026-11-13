// Creating new form fields in Edit PDF's Forms tab, and the one form step of the save pipeline.
// A new field starts life as a 'formfield' element on the page preview (canvas pixels, like every
// other element); on save it becomes a `spec` in PDF space and addFormFields() creates the real
// AcroForm field with pdf-lib. Check-mark and bullet "stamps" are plain drawings for PDFs that have
// no form at all (a scanned or printed form): they mark a box without creating a field.
// pdf-lib is imported statically: this whole module is only loaded when a PDF is saved.
import { PDFDocument, rgb } from 'pdf-lib';
import { createSignatureField } from './pdfForm.js';
import { applyFormValues, refreshFormAppearances } from './pdfForms.js';
import { hexToRgb01 } from './pdfOverlay.js';
import { FormCreateError, isStampKind, validateFormFieldSpecs } from './pdfFormElements.js';

export {
    DEFAULT_SIZES,
    FIELD_KINDS,
    FormCreateError,
    isStampKind,
    kindOf,
    newFormElement,
    nextFieldName,
    parseOptions,
    STAMP_KINDS,
    toFieldSpec,
    uniqueFieldName,
    validateFormFieldSpecs,
} from './pdfFormElements.js';

const FIELD_BORDER = { borderWidth: 1, borderColor: rgb(0.45, 0.45, 0.45) };

function drawStamp(page, spec) {
    const { x, y, width, height } = spec.rectPdf;
    const { r, g, b } = hexToRgb01(spec.color || '#111827');
    const color = rgb(r, g, b);
    if (spec.kind === 'bullet') {
        page.drawEllipse({ x: x + width / 2, y: y + height / 2, xScale: width / 2, yScale: height / 2, color });
        return;
    }
    const thickness = Math.max(1, Math.min(width, height) * 0.14);
    const at = (u, v) => ({ x: x + u * width, y: y + v * height });
    page.drawLine({ start: at(0.12, 0.5), end: at(0.4, 0.18), thickness, color });
    page.drawLine({ start: at(0.4, 0.18), end: at(0.9, 0.86), thickness, color });
}

/**
 * Creates every spec in `doc` (in place): text fields (single or multi-line), checkboxes, radio
 * groups (specs with the same name are the buttons of one group), dropdowns and empty signature
 * fields, each with its widget at `rectPdf` on page `page`; and draws the check-mark / bullet
 * stamps. A spec: `{ kind, name, page, rectPdf: {x, y, width, height}, options?, multiline?,
 * required?, fontSize?, value?, checked?, exportValue? }`. Throws FormCreateError when the specs
 * don't pass validateFormFieldSpecs(). Returns the names of the fields created.
 */
export function addFormFields(doc, specs, { existingNames } = {}) {
    if (!specs?.length) return [];
    const form = doc.getForm();
    const names = existingNames ?? form.getFields().map((field) => field.getName());
    const check = validateFormFieldSpecs(specs, names);
    if (!check.ok) throw new FormCreateError(check.reason, check.name);

    const created = [];
    const groups = new Map();
    for (const spec of specs) {
        const page = doc.getPage(spec.page);
        if (isStampKind(spec.kind)) {
            drawStamp(page, spec);
            continue;
        }
        const box = { ...spec.rectPdf, ...FIELD_BORDER };
        let field;
        if (spec.kind === 'signature') {
            createSignatureField(doc, spec.name, page, spec.rectPdf);
            created.push(spec.name);
            continue;
        } else if (spec.kind === 'checkbox') {
            field = form.createCheckBox(spec.name);
            field.addToPage(page, box);
            if (spec.checked) field.check();
        } else if (spec.kind === 'radio') {
            field = groups.get(spec.name);
            if (!field) {
                field = form.createRadioGroup(spec.name);
                groups.set(spec.name, field);
                created.push(spec.name);
            }
            field.addOptionToPage(spec.exportValue, page, box);
            if (spec.checked) field.select(spec.exportValue);
        } else if (spec.kind === 'dropdown') {
            field = form.createDropdown(spec.name);
            field.addOptions(spec.options);
            field.addToPage(page, box);
            if (spec.value && spec.options.includes(spec.value)) field.select(spec.value);
        } else {
            field = form.createTextField(spec.name);
            if (spec.multiline || spec.kind === 'textarea') field.enableMultiline();
            field.addToPage(page, box);
            // Set after addToPage, so letters Helvetica lacks are drawn by refreshFormAppearances() instead.
            if (spec.value) field.setText(String(spec.value));
        }
        if (spec.fontSize > 0 && typeof field.setFontSize === 'function') field.setFontSize(spec.fontSize);
        if (spec.required) field.enableRequired();
        if (spec.kind !== 'radio') created.push(spec.name);
    }
    return created;
}

/**
 * The form step of Edit PDF's save, run on the same pdf-lib document as every other edit: writes
 * the changed `values` into the PDF's own fields, creates the new fields in `specs`, redraws the
 * field appearances and, with `flatten`, draws every field into the page and removes the form.
 */
export async function applyFormsToDocument(doc, { values = {}, specs = [], flatten = false } = {}) {
    const existingNames = doc.getForm().getFields().map((field) => field.getName());
    await applyFormValues(doc, values);
    // A flattened form can't be signed later, so an empty signature field would only be a box.
    const toCreate = flatten ? specs.filter((spec) => spec.kind !== 'signature') : specs;
    const created = addFormFields(doc, toCreate, { existingNames });
    if (created.length) await refreshFormAppearances(doc);
    if (flatten && doc.getForm().getFields().length) flattenForm(doc);
}

function flattenForm(doc) {
    const form = doc.getForm();
    try {
        form.flatten();
        return;
    } catch {
        // pdf-lib can't flatten a widget without an appearance (an empty signature box, say).
    }
    for (const field of form.getFields()) {
        const drawable = field.acroField.getWidgets().every((widget) => {
            try {
                return !!widget.getNormalAppearance();
            } catch {
                return false;
            }
        });
        if (!drawable) form.removeField(field);
    }
    try {
        form.flatten();
    } catch {
        throw new FormCreateError('flatten');
    }
}

/** A separate copy of `doc` to save into, so saving twice never creates the same field twice. */
export async function workingCopy(doc) {
    return PDFDocument.load(await doc.save(), { updateMetadata: false });
}
