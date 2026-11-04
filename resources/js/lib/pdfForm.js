// Filling in a PDF's existing AcroForm fields (Edit PDF's "Fill form" tab). pdf-lib reads and
// writes the fields directly; this file only turns that into a flat list the editor can render
// as overlay inputs on top of the page preview, and turns the answers back into field values.
import { AnnotationFlags, PDFAcroSignature, PDFCheckBox, PDFDropdown, PDFRadioGroup, PDFTextField, PDFWidgetAnnotation, colorToComponents, rgb } from 'pdf-lib';
import { embedDocumentFonts } from './pdfFonts.js';

/**
 * Every fillable field in `doc`'s AcroForm, positioned by its widget's PDF-space rect.
 * A radio group yields one entry per button (same `name`, each with its own `onValue`); fields
 * with no page-anchored widget (no `/P` entry) are skipped, since there is nowhere to draw them.
 * Option lists, buttons and signature fields aren't represented here (not filled by this tool).
 */
export function readFormFields(doc) {
    const pageRefs = doc.getPages().map((page) => page.ref);
    const pageOf = (widget) => {
        const ref = widget.P();
        return ref ? pageRefs.findIndex((pageRef) => pageRef === ref) : -1;
    };
    const fields = [];
    for (const field of doc.getForm().getFields()) {
        const name = field.getName();
        const readOnly = field.isReadOnly();
        if (field instanceof PDFRadioGroup) {
            const options = field.getOptions();
            const selected = field.getSelected();
            field.acroField.getWidgets().forEach((widget, i) => {
                const page = pageOf(widget);
                if (page === -1 || !options[i]) return;
                fields.push({ id: `${name}#${i}`, name, type: 'radio', page, rectPdf: widget.getRectangle(), readOnly, onValue: options[i], value: selected });
            });
            continue;
        }
        const widget = field.acroField.getWidgets()[0];
        if (!widget) continue;
        const page = pageOf(widget);
        if (page === -1) continue;
        const common = { id: name, name, page, rectPdf: widget.getRectangle(), readOnly };
        if (field instanceof PDFTextField) {
            fields.push({ ...common, type: 'text', value: field.getText() ?? '', multiline: field.isMultiline(), maxLength: field.getMaxLength() });
        } else if (field instanceof PDFCheckBox) {
            fields.push({ ...common, type: 'checkbox', value: field.isChecked() });
        } else if (field instanceof PDFDropdown) {
            fields.push({ ...common, type: 'dropdown', value: field.getSelected()[0] ?? '', options: field.getOptions() });
        }
    }
    return fields;
}

/**
 * Writes `values` (field name -> string for text/dropdown fields, boolean for checkboxes, the
 * chosen option string for radio groups) into `doc`'s form fields and returns the finished PDF
 * as a Blob. Fields not present in `values` are left exactly as they were.
 */
export async function buildFilledFormPdf(doc, values) {
    const form = doc.getForm();
    for (const field of form.getFields()) {
        const name = field.getName();
        if (!(name in values)) continue;
        const value = values[name];
        if (field instanceof PDFTextField) field.setText(value ? String(value) : undefined);
        else if (field instanceof PDFCheckBox) (value ? field.check() : field.uncheck());
        else if (field instanceof PDFDropdown) (value ? field.select(value) : field.clear());
        else if (field instanceof PDFRadioGroup) (value ? field.select(value) : field.clear());
    }
    // pdf-lib's own default appearance update (on save) only supports Latin-1 (WinAnsi) text;
    // DejaVu Sans covers Latin Extended too, matching the font limit of Edit PDF's text editor.
    try {
        const fonts = await embedDocumentFonts(doc);
        form.updateFieldAppearances(fonts.regular);
    } catch {
        // Falls back to pdf-lib's own Helvetica appearance update on save below.
    }
    const bytes = await doc.save();
    return new Blob([bytes], { type: 'application/pdf' });
}

/**
 * Checks that every new field in `newFields` (each `{ name, fieldType?, options? }`) has a
 * non-empty name and that no two of them, or one of them and an existing field, share a name -
 * pdf-lib throws if a field with the given name already exists. A dropdown also needs at least
 * two options. Returns `{ ok: true }` or `{ ok: false, reason: 'empty' | 'duplicate' | 'options', name? }`.
 */
export function validateNewFieldNames(newFields, existingNames) {
    const seen = new Set(existingNames);
    for (const field of newFields) {
        const name = field.name.trim();
        if (!name) return { ok: false, reason: 'empty' };
        if (seen.has(name)) return { ok: false, reason: 'duplicate', name };
        seen.add(name);
        if (field.fieldType === 'dropdown' && (field.options ?? []).length < 2) return { ok: false, reason: 'options', name };
    }
    return { ok: true };
}

/**
 * Splits a comma-separated options string into a trimmed, de-duplicated, non-empty list - the
 * format the "Add fields" dropdown editor keeps while the user is typing its options.
 */
export function parseDropdownOptions(text) {
    return [...new Set(String(text ?? '').split(',').map((option) => option.trim()).filter(Boolean))];
}

/**
 * Creates a new, empty AcroForm signature field (`/FT /Sig`) named `name`, with one widget at
 * `rectPdf` on `page`. pdf-lib has no high-level `form.createSignature()` (it only supports
 * reading signature fields), so this builds the field dict and widget annotation the same way
 * pdf-lib's own `createCheckBox`/`addToPage` do, then registers both with the document's AcroForm
 * and the page's annotations. The field stays unsigned: this tool never handles certificates or
 * cryptographic signing, only places the placeholder another PDF reader can sign later.
 */
function createSignatureField(doc, name, page, rectPdf) {
    const context = doc.context;
    const fieldDict = context.obj({ FT: 'Sig', Ff: 0, Kids: [] });
    const fieldRef = context.register(fieldDict);
    const sigField = PDFAcroSignature.fromDict(fieldDict, fieldRef);
    sigField.setPartialName(name);

    const widget = PDFWidgetAnnotation.create(context, fieldRef);
    widget.setRectangle(rectPdf);
    widget.setP(page.ref);
    widget.getOrCreateAppearanceCharacteristics().setBorderColor(colorToComponents(rgb(0.45, 0.45, 0.45)));
    widget.getOrCreateBorderStyle().setWidth(1);
    widget.setFlagTo(AnnotationFlags.Print, true);
    const widgetRef = context.register(widget.dict);

    sigField.addWidget(widgetRef);
    page.node.addAnnot(widgetRef);
    doc.getForm().acroForm.addField(fieldRef);
}

/**
 * Creates new, empty AcroForm fields in `doc` - a text box, checkbox, dropdown or signature, one
 * widget each, placed at `rectPdf` on `page` - and returns the finished PDF as a Blob. `fields`:
 * an array of `{ fieldType: 'text' | 'checkbox' | 'dropdown' | 'signature', name, page, rectPdf:
 * {x, y, width, height}, options? }` (`options`, a string array, is required for a dropdown). The
 * fields are created empty; this tool's "Fill form" view can fill in the text/checkbox/dropdown
 * ones once the file is reopened (signature fields are left for the PDF's own reader to sign).
 */
export async function buildPdfWithNewFields(doc, fields) {
    const form = doc.getForm();
    for (const field of fields) {
        const page = doc.getPage(field.page);
        const box = { ...field.rectPdf, borderWidth: 1, borderColor: rgb(0.45, 0.45, 0.45) };
        if (field.fieldType === 'checkbox') form.createCheckBox(field.name).addToPage(page, box);
        else if (field.fieldType === 'dropdown') {
            const dropdown = form.createDropdown(field.name);
            dropdown.addOptions(field.options);
            dropdown.addToPage(page, box);
        } else if (field.fieldType === 'signature') createSignatureField(doc, field.name, page, field.rectPdf);
        else form.createTextField(field.name).addToPage(page, box);
    }
    const bytes = await doc.save();
    return new Blob([bytes], { type: 'application/pdf' });
}
