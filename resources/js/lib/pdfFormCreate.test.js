import { PDFDocument } from 'pdf-lib';
import { describe, expect, it } from 'vitest';
import {
    addFormFields,
    applyFormsToDocument,
    FormCreateError,
    newFormElement,
    nextFieldName,
    parseOptions,
    toFieldSpec,
    uniqueFieldName,
    validateFormFieldSpecs,
    workingCopy,
} from './pdfFormCreate.js';
import { buildEditedPdf } from './pdfEdit.js';
import { readFormFields } from './pdfForms.js';

const rect = (x, y, width = 120, height = 20) => ({ x, y, width, height });

async function blankDoc(pages = 1) {
    const doc = await PDFDocument.create();
    for (let i = 0; i < pages; i++) doc.addPage([400, 600]);
    return doc;
}

async function formDoc() {
    const doc = await blankDoc();
    const form = doc.getForm();
    const name = form.createTextField('full_name');
    name.addToPage(doc.getPage(0), rect(50, 500));
    const agree = form.createCheckBox('agree');
    agree.addToPage(doc.getPage(0), rect(50, 450, 16, 16));
    return doc;
}

const byName = (fields) => Object.fromEntries(fields.map((field) => [field.name, field]));

describe('names', () => {
    it('numbers default names per kind, skipping names already used', () => {
        expect(nextFieldName('text', [])).toBe('Text field 1');
        expect(nextFieldName('checkbox', ['Checkbox 1', 'Checkbox 2'])).toBe('Checkbox 3');
        expect(nextFieldName('radio', new Set())).toBe('Radio group 1');
    });

    it('makes a name unique by adding a number', () => {
        expect(uniqueFieldName('email', [])).toBe('email');
        expect(uniqueFieldName('email', ['email', 'email 2'])).toBe('email 3');
        expect(uniqueFieldName('  ', [])).toBe('Field');
    });

    it('reads dropdown options one per line', () => {
        expect(parseOptions('UK\n US \n\nUK\r\nDE')).toEqual(['UK', 'US', 'DE']);
        expect(parseOptions(undefined)).toEqual([]);
    });
});

describe('newFormElement', () => {
    it('centres a clicked field on the point at its default size', () => {
        const el = newFormElement('text', { x: 200, y: 100 }, { existingNames: ['Text field 1'] });
        expect(el).toMatchObject({ type: 'formfield', kind: 'text', name: 'Text field 2', x: 120, y: 88, width: 160, height: 24 });
    });

    it('makes a dragged checkbox square and keeps it inside the page', () => {
        const el = newFormElement('checkbox', { x: 390, y: 10, width: 40, height: 20 }, { bounds: { width: 400, height: 600 } });
        expect(el).toMatchObject({ width: 20, height: 20, x: 380, y: 10, checked: false });
    });

    it('adds a second radio button to the group of the last one, with its own value', () => {
        const first = { id: 1, ...newFormElement('radio', { x: 50, y: 50 }) };
        const second = newFormElement('radio', { x: 50, y: 80 }, { elements: [first] });
        expect(second.name).toBe(first.name);
        expect(first.exportValue).toBe('Option 1');
        expect(second.exportValue).toBe('Option 2');
    });

    it('gives a stamp no name', () => {
        const el = newFormElement('checkmark', { x: 50, y: 50 });
        expect(el.name).toBeUndefined();
        expect(el.kind).toBe('checkmark');
    });
});

describe('validateFormFieldSpecs', () => {
    it('accepts radio buttons that share a group name', () => {
        const specs = [
            { kind: 'radio', name: 'size', exportValue: 'S' },
            { kind: 'radio', name: 'size', exportValue: 'M' },
        ];
        expect(validateFormFieldSpecs(specs)).toEqual({ ok: true });
    });

    it('refuses empty names, duplicates, short dropdowns and repeated radio values', () => {
        expect(validateFormFieldSpecs([{ kind: 'text', name: ' ' }])).toMatchObject({ ok: false, reason: 'empty' });
        expect(validateFormFieldSpecs([{ kind: 'text', name: 'a' }], ['a'])).toMatchObject({ ok: false, reason: 'duplicate', name: 'a' });
        expect(validateFormFieldSpecs([{ kind: 'text', name: 'a' }, { kind: 'checkbox', name: 'a' }])).toMatchObject({ reason: 'duplicate' });
        expect(validateFormFieldSpecs([{ kind: 'dropdown', name: 'd', options: ['x'] }])).toMatchObject({ reason: 'options', name: 'd' });
        expect(
            validateFormFieldSpecs([
                { kind: 'radio', name: 'r', exportValue: 'A' },
                { kind: 'radio', name: 'r', exportValue: 'A' },
            ])
        ).toMatchObject({ reason: 'radio-value', name: 'r' });
    });
});

describe('addFormFields', () => {
    it('creates text, text area, checkbox, radio and dropdown fields that can be read back and filled', async () => {
        const doc = await blankDoc();
        const created = addFormFields(doc, [
            { kind: 'text', name: 'email', page: 0, rectPdf: rect(50, 500), required: true, fontSize: 12, value: 'a@b.c' },
            { kind: 'textarea', name: 'notes', page: 0, rectPdf: rect(50, 420, 200, 60) },
            { kind: 'checkbox', name: 'agree', page: 0, rectPdf: rect(50, 380, 16, 16), checked: true },
            { kind: 'radio', name: 'size', exportValue: 'S', page: 0, rectPdf: rect(50, 340, 16, 16) },
            { kind: 'radio', name: 'size', exportValue: 'M', page: 0, rectPdf: rect(80, 340, 16, 16), checked: true },
            { kind: 'dropdown', name: 'country', page: 0, rectPdf: rect(50, 300), options: ['UK', 'US'], value: 'US' },
        ]);
        expect(created).toEqual(['email', 'notes', 'agree', 'size', 'country']);

        const fields = byName(await readFormFields(await doc.save()));
        expect(fields.email).toMatchObject({ type: 'text', value: 'a@b.c', multiline: false });
        expect(fields.notes).toMatchObject({ type: 'text', multiline: true, value: '' });
        expect(fields.agree).toMatchObject({ type: 'checkbox', value: true });
        expect(fields.size).toMatchObject({ type: 'radio', value: 'M', options: ['S', 'M'] });
        expect(fields.country).toMatchObject({ type: 'dropdown', value: 'US', options: ['UK', 'US'] });
        expect(doc.getForm().getTextField('email').isRequired()).toBe(true);
    });

    it('creates an empty signature field', async () => {
        const doc = await blankDoc();
        addFormFields(doc, [{ kind: 'signature', name: 'sign_here', page: 0, rectPdf: rect(50, 100, 150, 40) }]);
        const saved = await PDFDocument.load(await doc.save());
        expect(saved.getForm().getSignature('sign_here').acroField.getWidgets()).toHaveLength(1);
    });

    it('draws stamps as page content without creating any field', async () => {
        const doc = await blankDoc();
        const before = doc.getPage(0).node.Contents();
        expect(addFormFields(doc, [
            { kind: 'checkmark', page: 0, rectPdf: rect(50, 50, 14, 14) },
            { kind: 'bullet', page: 0, rectPdf: rect(80, 50, 10, 10) },
        ])).toEqual([]);
        expect(doc.getForm().getFields()).toHaveLength(0);
        expect(doc.getPage(0).node.Contents()).not.toBe(before);
    });

    it('throws a FormCreateError instead of creating a duplicate', async () => {
        const doc = await formDoc();
        expect(() => addFormFields(doc, [{ kind: 'text', name: 'full_name', page: 0, rectPdf: rect(0, 0) }])).toThrow(FormCreateError);
    });
});

describe('toFieldSpec', () => {
    it('turns an element into a spec with parsed options', () => {
        const spec = toFieldSpec({ type: 'formfield', kind: 'dropdown', name: ' country ', page: 1, optionsText: 'UK\nUS', required: true, fontSize: '10' }, rect(1, 2));
        expect(spec).toMatchObject({ kind: 'dropdown', name: 'country', page: 1, options: ['UK', 'US'], required: true, fontSize: 10, rectPdf: rect(1, 2) });
    });

    it('reads elements saved with the older fieldType key', () => {
        expect(toFieldSpec({ fieldType: 'checkbox', name: 'x', page: 0 }, rect(0, 0)).kind).toBe('checkbox');
    });
});

describe('one save pipeline', () => {
    it('saves filled values, new fields and other edits into one PDF', async () => {
        const doc = await formDoc();
        const blob = await buildEditedPdf(doc, [{ type: 'whiteout', page: 0, rectPdf: rect(10, 10, 30, 30) }], {
            beforeSave: (work) =>
                applyFormsToDocument(work, {
                    values: { full_name: 'Ada', agree: true },
                    specs: [{ kind: 'text', name: 'city', page: 0, rectPdf: rect(50, 300), value: 'Paris' }],
                }),
        });
        const fields = byName(await readFormFields(new Uint8Array(await blob.arrayBuffer())));
        expect(fields.full_name.value).toBe('Ada');
        expect(fields.agree.value).toBe(true);
        expect(fields.city.value).toBe('Paris');
    });

    it('leaves fields whose value did not change alone', async () => {
        const doc = await formDoc();
        const ap = doc.getForm().getTextField('full_name').acroField.getWidgets()[0].getNormalAppearance();
        await applyFormsToDocument(doc, { values: { full_name: '', agree: false } });
        expect(doc.getForm().getTextField('full_name').acroField.getWidgets()[0].getNormalAppearance()).toBe(ap);
    });

    it('flattens: the fields are gone and the values are drawn on the page', async () => {
        const doc = await formDoc();
        await applyFormsToDocument(doc, {
            values: { full_name: 'Grace' },
            specs: [
                { kind: 'checkbox', name: 'new_box', page: 0, rectPdf: rect(50, 200, 16, 16), checked: true },
                { kind: 'signature', name: 'sig', page: 0, rectPdf: rect(50, 100, 100, 30) },
            ],
            flatten: true,
        });
        const saved = await doc.save();
        expect(await readFormFields(saved)).toEqual([]);
        const reloaded = await PDFDocument.load(saved);
        const xObjects = reloaded.getPage(0).node.Resources().lookup((await import('pdf-lib')).PDFName.of('XObject'));
        expect(xObjects.keys().length).toBeGreaterThanOrEqual(2);
    });

    it('works on a separate copy, so saving twice does not fail on duplicate names', async () => {
        const doc = await blankDoc();
        for (let i = 0; i < 2; i++) {
            const work = await workingCopy(doc);
            await applyFormsToDocument(work, { specs: [{ kind: 'text', name: 'once', page: 0, rectPdf: rect(10, 10) }] });
        }
        expect(doc.getForm().getFields()).toHaveLength(0);
    });
});
