import { describe, expect, it } from 'vitest';
import { createSignatureStore, MAX_SAVED_SIGNATURES, memoryAdapter } from './signatureStore.js';

const PNG = new Uint8Array([0x89, 0x50, 0x4e, 0x47, 0x0d, 0x0a, 0x1a, 0x0a, 1, 2, 3]);

function clock(start = 1000) {
    let time = start;
    return () => time++;
}

describe('signatureStore', () => {
    it('starts empty', async () => {
        const store = createSignatureStore(memoryAdapter());
        expect(await store.list()).toEqual([]);
    });

    it('saves a signature as PNG bytes and lists it with a data URL, newest first', async () => {
        const store = createSignatureStore(memoryAdapter(), { now: clock() });
        const first = await store.save({ kind: 'signature', bytes: PNG, width: 200, height: 80 });
        const second = await store.save({ kind: 'initials', bytes: PNG, width: 60, height: 40 });
        const listed = await store.list();
        expect(listed.map((s) => s.id)).toEqual([second.id, first.id]);
        expect(listed[0]).toMatchObject({ kind: 'initials', width: 60, height: 40 });
        expect(listed[1].dataUrl.startsWith('data:image/png;base64,')).toBe(true);
        expect(Array.from(listed[1].bytes)).toEqual(Array.from(PNG));
    });

    it('treats an unknown kind as a signature', async () => {
        const store = createSignatureStore(memoryAdapter());
        const saved = await store.save({ kind: 'other', bytes: PNG, width: 1, height: 1 });
        expect(saved.kind).toBe('signature');
    });

    it('removes a saved signature', async () => {
        const store = createSignatureStore(memoryAdapter(), { now: clock() });
        const a = await store.save({ bytes: PNG, width: 1, height: 1 });
        const b = await store.save({ bytes: PNG, width: 1, height: 1 });
        await store.remove(a.id);
        expect((await store.list()).map((s) => s.id)).toEqual([b.id]);
    });

    it('survives a new store over the same storage (a page reload)', async () => {
        const adapter = memoryAdapter();
        const saved = await createSignatureStore(adapter).save({ bytes: PNG, width: 10, height: 5 });
        const again = await createSignatureStore(adapter).list();
        expect(again.map((s) => s.id)).toEqual([saved.id]);
    });

    it('refuses to save empty bytes', async () => {
        const store = createSignatureStore(memoryAdapter());
        await expect(store.save({ bytes: new Uint8Array(), width: 1, height: 1 })).rejects.toThrow();
    });

    it('keeps only the newest signatures once the limit is reached', async () => {
        const store = createSignatureStore(memoryAdapter(), { now: clock() });
        const ids = [];
        for (let i = 0; i < MAX_SAVED_SIGNATURES + 2; i++) ids.push((await store.save({ bytes: PNG, width: 1, height: 1 })).id);
        const listed = await store.list();
        expect(listed).toHaveLength(MAX_SAVED_SIGNATURES);
        expect(listed[0].id).toBe(ids[ids.length - 1]);
        expect(listed.some((s) => s.id === ids[0])).toBe(false);
    });

    it('works with any injected storage adapter', async () => {
        const calls = [];
        const rows = new Map();
        const adapter = {
            getAll: async () => [...rows.values()],
            put: async (r) => {
                calls.push('put');
                rows.set(r.id, r);
            },
            delete: async (id) => {
                calls.push('delete');
                rows.delete(id);
            },
        };
        const store = createSignatureStore(adapter);
        const saved = await store.save({ bytes: PNG, width: 1, height: 1 });
        await store.remove(saved.id);
        expect(calls).toEqual(['put', 'delete']);
    });
});
