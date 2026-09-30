import { describe, expect, it } from 'vitest';
import { CONVERTIBLE_TYPES, convertedName, EXTENSIONS } from './image.js';
import { safeFilename } from './util.js';

describe('convertedName', () => {
    it('swaps the extension for the target format', () => {
        expect(convertedName('holiday.webp', 'image/png')).toBe('holiday.png');
        expect(convertedName('logo.PNG', 'image/jpeg')).toBe('logo.jpg');
        expect(convertedName('scan.jpeg', 'image/webp')).toBe('scan.webp');
    });

    it('keeps dots inside the name and handles names without an extension', () => {
        expect(convertedName('my.photo.v2.png', 'image/jpeg')).toBe('my.photo.v2.jpg');
        expect(convertedName('screenshot', 'image/png')).toBe('screenshot.png');
    });

    it('falls back to a sensible name and extension', () => {
        expect(convertedName('', 'image/png')).toBe('image.png');
        expect(convertedName('.png', 'image/jpeg')).toBe('image.jpg');
        expect(convertedName('photo.gif', 'image/unknown')).toBe('photo.jpg');
    });

    it('runs the result through a filename sanitiser', () => {
        expect(convertedName('a/b:c.webp', 'image/png', safeFilename)).toBe(safeFilename('a/b:c.png'));
    });
});

describe('converter formats', () => {
    it('accepts the formats browsers can decode', () => {
        expect(CONVERTIBLE_TYPES).toEqual(expect.arrayContaining(['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/bmp']));
    });

    it('has an extension for every output format', () => {
        for (const type of ['image/jpeg', 'image/png', 'image/webp']) expect(EXTENSIONS[type]).toBeTruthy();
    });
});
