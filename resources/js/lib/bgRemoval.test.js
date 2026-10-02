import { describe, expect, it } from 'vitest';
import { toMask, toTensorData } from './bgRemoval.js';

describe('background removal helpers', () => {
    it('normalises pixels into channel-first data', () => {
        // 1x1 white pixel
        const data = toTensorData(new Uint8ClampedArray([255, 255, 255, 255]), 1);
        expect(data).toHaveLength(3);
        expect(data[0]).toBeCloseTo((1 - 0.485) / 0.229, 5);
        expect(data[2]).toBeCloseTo((1 - 0.406) / 0.225, 5);
    });

    it('scales by the brightest value for U-2-Net', () => {
        const dark = toTensorData(new Uint8ClampedArray([100, 50, 0, 255]), 1, { scaleByMax: true });
        expect(dark[0]).toBeCloseTo((1 - 0.485) / 0.229, 5); // 100 is the max -> 1.0
    });

    it('turns logits into a mask with a sigmoid', () => {
        const m = toMask(new Float32Array([-10, 0, 10]), { sigmoid: true });
        expect(m[0]).toBeLessThan(2);
        expect(m[1]).toBe(128);
        expect(m[2]).toBeGreaterThan(253);
    });

    it('stretches a probability map to 0-255', () => {
        expect(Array.from(toMask(new Float32Array([0.2, 0.6, 1]), { sigmoid: false }))).toEqual([0, 128, 255]);
    });
});
