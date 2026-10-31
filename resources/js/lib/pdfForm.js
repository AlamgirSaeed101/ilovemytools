// Filling in a PDF's existing AcroForm fields (Edit PDF's "Fill form" tab). pdf-lib reads and
// writes the fields directly; this file only turns that into a flat list the editor can render
// as overlay inputs on top of the page preview, and turns the answers back into field values.
import { PDFCheckBox, PDFDropdown, PDFRadioGroup, PDFTextField } from 'pdf-lib';
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
