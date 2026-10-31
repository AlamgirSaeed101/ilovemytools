import { PDFDocument, StandardFonts } from 'pdf-lib';
import { describe, expect, it } from 'vitest';
import { buildFilledFormPdf, readFormFields } from './pdfForm.js';

async function docWithFields() {
    const doc = await PDFDocument.create();
    const font = await doc.embedFont(StandardFonts.Helvetica);
    const page = doc.addPage([400, 400]);
    const form = doc.getForm();

    const name = form.createTextField('name');
    name.addToPage(page, { x: 50, y: 300, width: 200, height: 20, font });

    const agree = form.createCheckBox('agree');
    agree.addToPage(page, { x: 50, y: 250, width: 20, height: 20 });

    const country = form.createDropdown('country');
    country.addOptions(['UK', 'US', 'DE']);
    country.addToPage(page, { x: 50, y: 200, width: 100, height: 20, font });

    const plan = form.createRadioGroup('plan');
    plan.addOptionToPage('free', page, { x: 50, y: 150, width: 16, height: 16 });
    plan.addOptionToPage('pro', page, { x: 50, y: 120, width: 16, height: 16 });

    return { doc, page, font };
}

describe('readFormFields', () => {
    it('reads text, checkbox, dropdown and radio fields with their page and rect', async () => {
        const { doc } = await docWithFields();
        const fields = readFormFields(doc);

        const text = fields.find((f) => f.name === 'name');
        expect(text).toMatchObject({ type: 'text', page: 0, value: '', multiline: false });
        // pdf-lib's default 1pt border widens the widget rect by half a point on each side.
        expect(text.rectPdf).toMatchObject({ x: 49.5, y: 299.5, width: 201, height: 21 });

        const check = fields.find((f) => f.name === 'agree');
        expect(check).toMatchObject({ type: 'checkbox', value: false });

        const dropdown = fields.find((f) => f.name === 'country');
        expect(dropdown).toMatchObject({ type: 'dropdown', value: '', options: ['UK', 'US', 'DE'] });

        const radios = fields.filter((f) => f.name === 'plan');
        expect(radios).toHaveLength(2);
        expect(radios.map((r) => r.onValue).sort()).toEqual(['free', 'pro']);
        expect(radios.every((r) => r.type === 'radio')).toBe(true);
    });

    it('returns an empty list for a PDF with no AcroForm fields', async () => {
        const doc = await PDFDocument.create();
        doc.addPage([200, 200]);
        expect(readFormFields(doc)).toEqual([]);
    });
});

describe('buildFilledFormPdf', () => {
    it('writes text, checkbox, dropdown and radio values, leaving other fields untouched', async () => {
        const { doc } = await docWithFields();
        const blob = await buildFilledFormPdf(doc, { name: 'Jane Doe', agree: true, country: 'DE', plan: 'pro' });
        const bytes = new Uint8Array(await blob.arrayBuffer());

        const reloaded = await PDFDocument.load(bytes);
        const form = reloaded.getForm();
        expect(form.getTextField('name').getText()).toBe('Jane Doe');
        expect(form.getCheckBox('agree').isChecked()).toBe(true);
        expect(form.getDropdown('country').getSelected()).toEqual(['DE']);
        expect(form.getRadioGroup('plan').getSelected()).toBe('pro');
    });

    it('unchecks a checkbox and clears a dropdown/radio group when given a falsy value', async () => {
        const { doc } = await docWithFields();
        doc.getForm().getCheckBox('agree').check();
        doc.getForm().getDropdown('country').select('UK');
        doc.getForm().getRadioGroup('plan').select('free');

        const blob = await buildFilledFormPdf(doc, { agree: false, country: '', plan: '' });
        const reloaded = await PDFDocument.load(new Uint8Array(await blob.arrayBuffer()));
        const form = reloaded.getForm();
        expect(form.getCheckBox('agree').isChecked()).toBe(false);
        expect(form.getDropdown('country').getSelected()).toEqual([]);
        expect(form.getRadioGroup('plan').getSelected()).toBeUndefined();
    });

    it('leaves a field out of `values` exactly as it was', async () => {
        const { doc } = await docWithFields();
        doc.getForm().getTextField('name').setText('Unchanged');
        const blob = await buildFilledFormPdf(doc, { agree: true });
        const reloaded = await PDFDocument.load(new Uint8Array(await blob.arrayBuffer()));
        expect(reloaded.getForm().getTextField('name').getText()).toBe('Unchanged');
    });
});
