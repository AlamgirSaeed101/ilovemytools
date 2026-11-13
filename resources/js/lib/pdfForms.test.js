import { PDFDocument } from 'pdf-lib';
import { describe, expect, it } from 'vitest';
import { PdfFormError, applyFormValues, fillPdfForm, listFormFields, readFormFields, readFormWidgets } from './pdfForms.js';

async function sampleForm() {
    const doc = await PDFDocument.create();
    const page = doc.addPage([400, 600]);
    const form = doc.getForm();

    const name = form.createTextField('full_name');
    name.setText('Ada');
    name.addToPage(page, { x: 50, y: 520, width: 200, height: 24 });

    const notes = form.createTextField('notes');
    notes.enableMultiline();
    notes.setMaxLength(5);
    notes.addToPage(page, { x: 50, y: 460, width: 200, height: 48 });

    const locked = form.createTextField('locked');
    locked.setText('keep');
    locked.enableReadOnly();
    locked.addToPage(page, { x: 50, y: 420, width: 200, height: 24 });

    const agree = form.createCheckBox('agree');
    agree.addToPage(page, { x: 50, y: 380, width: 18, height: 18 });

    const country = form.createDropdown('country');
    country.addOptions(['US', 'UK']);
    country.select('US');
    country.addToPage(page, { x: 50, y: 330, width: 120, height: 24 });

    const color = form.createRadioGroup('color');
    color.addOptionToPage('Red', page, { x: 50, y: 280, width: 16, height: 16 });
    color.addOptionToPage('Blue', page, { x: 90, y: 280, width: 16, height: 16 });
    color.select('Red');

    const langs = form.createOptionList('langs');
    langs.addOptions(['English', 'Spanish']);
    langs.enableMultiselect();
    langs.select(['English']);
    langs.addToPage(page, { x: 50, y: 180, width: 140, height: 50 });

    return doc.save();
}

describe('readFormFields', () => {
    it('describes text, checkbox, dropdown, radio and option-list fields', async () => {
        const fields = await readFormFields(await sampleForm());
        const byName = Object.fromEntries(fields.map((field) => [field.name, field]));

        expect(byName.full_name).toMatchObject({ type: 'text', value: 'Ada', readOnly: false, multiline: false });
        expect(byName.notes).toMatchObject({ type: 'text', multiline: true, value: '' });
        expect(byName.locked).toMatchObject({ type: 'text', readOnly: true, value: 'keep' });
        expect(byName.agree).toMatchObject({ type: 'checkbox', value: false });
        expect(byName.country).toMatchObject({ type: 'dropdown', value: 'US', options: ['US', 'UK'] });
        expect(byName.color).toMatchObject({ type: 'radio', value: 'Red', options: ['Red', 'Blue'] });
        expect(byName.langs).toMatchObject({ type: 'optionlist', multi: true, value: ['English'], options: ['English', 'Spanish'] });
    });

    it('returns no fields for a PDF that is not a form', async () => {
        const doc = await PDFDocument.create();
        doc.addPage();
        expect(await readFormFields(await doc.save())).toEqual([]);
    });

    it('rejects a file that is not a PDF', async () => {
        await expect(readFormFields(new Uint8Array([1, 2, 3]))).rejects.toMatchObject({ code: 'unreadable' });
    });
});

describe('fillPdfForm', () => {
    it('writes each field and leaves read-only text unchanged', async () => {
        const out = await fillPdfForm(await sampleForm(), {
            full_name: 'Ada Lovelace',
            notes: 'Hello',
            locked: 'changed',
            agree: true,
            country: 'UK',
            color: 'Blue',
            langs: ['English', 'Spanish'],
        });
        const fields = await readFormFields(out);
        const byName = Object.fromEntries(fields.map((field) => [field.name, field]));

        expect(byName.full_name.value).toBe('Ada Lovelace');
        expect(byName.notes.value).toBe('Hello');
        expect(byName.locked.value).toBe('keep');
        expect(byName.agree.value).toBe(true);
        expect(byName.country.value).toBe('UK');
        expect(byName.color.value).toBe('Blue');
        expect(byName.langs.value).toEqual(['English', 'Spanish']);
    });

    it('clears a dropdown when the value is empty', async () => {
        const out = await fillPdfForm(await sampleForm(), { country: '' });
        const country = (await readFormFields(out)).find((field) => field.name === 'country');
        expect(country.value).toBe('');
    });

    it('refuses a value the field does not offer', async () => {
        await expect(fillPdfForm(await sampleForm(), { country: 'FR' })).rejects.toBeInstanceOf(PdfFormError);
        await expect(fillPdfForm(await sampleForm(), { country: 'FR' })).rejects.toMatchObject({ code: 'bad-option', detail: 'country' });
    });

    it('refuses text longer than the field allows', async () => {
        await expect(fillPdfForm(await sampleForm(), { notes: 'too long' })).rejects.toMatchObject({ code: 'too-long', detail: 'notes' });
    });

    it('flattens the form so the fields are gone and the answer remains', async () => {
        const out = await fillPdfForm(await sampleForm(), { full_name: 'Grace' }, { flatten: true });
        expect(await readFormFields(out)).toEqual([]);
        const doc = await PDFDocument.load(out);
        const text = doc.getPages()[0].node.Contents();
        expect(text).toBeTruthy();
    });
});

describe('applyFormValues', () => {
    it('fills the fields of an already loaded document in place', async () => {
        const doc = await PDFDocument.load(await sampleForm());
        const changed = await applyFormValues(doc, { full_name: 'Ada L', agree: true, color: 'Blue', country: 'US' });
        expect(changed).toBe(3); // country was already US
        const fields = Object.fromEntries((await listFormFields(doc)).map((field) => [field.name, field]));
        expect(fields.full_name.value).toBe('Ada L');
        expect(fields.agree.value).toBe(true);
        expect(fields.color.value).toBe('Blue');
    });

    it('maps a radio button "on" state name back to its option', async () => {
        const doc = await PDFDocument.load(await sampleForm());
        const group = doc.getForm().getRadioGroup('color');
        const onValue = group.acroField.getOnValues()[1].decodeText();
        await applyFormValues(doc, { color: onValue });
        expect(group.getSelected()).toBe('Blue');
    });

    it('refuses text longer than the field allows', async () => {
        const doc = await PDFDocument.load(await sampleForm());
        await expect(applyFormValues(doc, { notes: 'too long' })).rejects.toMatchObject({ code: 'too-long', detail: 'notes' });
    });
});

describe('readFormWidgets', () => {
    const fakeDoc = (annotations) => ({ getPage: async () => ({ getAnnotations: async () => annotations }) });

    it('turns pdf.js widget annotations into positioned fields', async () => {
        const widgets = await readFormWidgets(
            fakeDoc([
                { subtype: 'Widget', id: '1R', fieldName: 'name', fieldType: 'Tx', rect: [50, 500, 250, 524], maxLen: 10, multiLine: false },
                { subtype: 'Widget', id: '2R', fieldName: 'agree', fieldType: 'Btn', checkBox: true, exportValue: 'Yes', rect: [50, 380, 68, 398] },
                { subtype: 'Widget', id: '3R', fieldName: 'color', fieldType: 'Btn', radioButton: true, buttonValue: 'Red', rect: [50, 280, 66, 296] },
                { subtype: 'Widget', id: '4R', fieldName: 'country', fieldType: 'Ch', combo: true, options: [{ exportValue: 'us', displayValue: 'US' }], rect: [50, 330, 170, 354] },
                { subtype: 'Widget', id: '5R', fieldName: 'go', fieldType: 'Btn', pushButton: true, rect: [0, 0, 10, 10] },
                { subtype: 'Widget', id: '6R', fieldName: 'sig', fieldType: 'Sig', rect: [0, 0, 10, 10] },
                { subtype: 'Widget', id: '7R', fieldName: 'hidden', fieldType: 'Tx', hidden: true, rect: [0, 0, 10, 10] },
                { subtype: 'Link', id: '8R', rect: [0, 0, 10, 10] },
            ])
        );
        expect(widgets.map((w) => w.name)).toEqual(['name', 'agree', 'color', 'country']);
        expect(widgets[0]).toMatchObject({ type: 'text', rectPdf: { x: 50, y: 500, width: 200, height: 24 }, maxLength: 10 });
        expect(widgets[1]).toMatchObject({ type: 'checkbox', onValue: 'Yes' });
        expect(widgets[2]).toMatchObject({ type: 'radio', onValue: 'Red' });
        expect(widgets[3]).toMatchObject({ type: 'dropdown', options: ['US'] });
    });

    it('returns nothing without a render document', async () => {
        expect(await readFormWidgets(null, 1)).toEqual([]);
    });
});
