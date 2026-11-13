// Saved signatures and initials for the PDF editor. They are kept only in this browser's
// IndexedDB, and only when the user ticks "remember on this device"; nothing is ever uploaded.
// Each record is the signature's PNG bytes plus its size, so it can be placed again later.
import { bytesToDataUrl } from './imageUtils.js';

const DB_NAME = 'ilovemytools-signatures';
const STORE = 'signatures';
export const MAX_SAVED_SIGNATURES = 12;

/** An IndexedDB adapter: getAll(), put(record), delete(id). */
export function indexedDbAdapter() {
    function open() {
        return new Promise((resolve, reject) => {
            if (typeof indexedDB === 'undefined') {
                reject(new Error('IndexedDB is not available.'));
                return;
            }
            const req = indexedDB.open(DB_NAME, 1);
            req.onupgradeneeded = () => req.result.createObjectStore(STORE, { keyPath: 'id' });
            req.onsuccess = () => resolve(req.result);
            req.onerror = () => reject(req.error);
        });
    }
    async function run(mode, action) {
        const db = await open();
        try {
            return await new Promise((resolve, reject) => {
                const tx = db.transaction(STORE, mode);
                const request = action(tx.objectStore(STORE));
                tx.oncomplete = () => resolve(request?.result);
                tx.onerror = () => reject(tx.error);
                tx.onabort = () => reject(tx.error);
            });
        } finally {
            db.close();
        }
    }
    return {
        getAll: () => run('readonly', (store) => store.getAll()).then((rows) => rows ?? []),
        put: (record) => run('readwrite', (store) => store.put(record)),
        delete: (id) => run('readwrite', (store) => store.delete(id)),
    };
}

/** A plain in-memory adapter (tests, or a browser without IndexedDB). */
export function memoryAdapter() {
    const rows = new Map();
    return {
        getAll: async () => [...rows.values()].map((row) => ({ ...row })),
        put: async (record) => {
            rows.set(record.id, { ...record });
        },
        delete: async (id) => {
            rows.delete(id);
        },
    };
}

function newId() {
    return typeof crypto !== 'undefined' && crypto.randomUUID ? crypto.randomUUID() : `sig-${Date.now()}-${Math.random().toString(36).slice(2)}`;
}

/**
 * The saved-signature list over `adapter` (IndexedDB by default).
 * list() -> [{ id, kind: 'signature'|'initials', bytes, width, height, createdAt, dataUrl }], newest first.
 * save({ kind, bytes, width, height }) -> the saved record. remove(id).
 */
export function createSignatureStore(adapter = indexedDbAdapter(), { now = () => Date.now() } = {}) {
    function withDataUrl(row) {
        return { ...row, dataUrl: bytesToDataUrl(row.bytes, 'image/png') };
    }

    async function list() {
        const rows = await adapter.getAll();
        return rows
            .filter((row) => row && row.bytes && row.bytes.length)
            .sort((a, b) => b.createdAt - a.createdAt)
            .map(withDataUrl);
    }

    async function save({ kind = 'signature', bytes, width, height }) {
        if (!bytes || !bytes.length) throw new Error('Nothing to save.');
        const record = {
            id: newId(),
            kind: kind === 'initials' ? 'initials' : 'signature',
            bytes: new Uint8Array(bytes),
            width,
            height,
            createdAt: now(),
        };
        await adapter.put(record);
        // Keeps the list short: the oldest saved ones go first.
        const rows = (await adapter.getAll()).sort((a, b) => b.createdAt - a.createdAt);
        for (const old of rows.slice(MAX_SAVED_SIGNATURES)) await adapter.delete(old.id);
        return withDataUrl(record);
    }

    function remove(id) {
        return adapter.delete(id);
    }

    return { list, save, remove };
}
