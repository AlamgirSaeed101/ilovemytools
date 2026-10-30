import { afterEach, beforeEach, describe, expect, it } from 'vitest';
import { clearSession, fileFromSession, hasUnsavedChanges, loadSession, saveSession } from './pdfSession.js';

// A minimal in-memory stand-in for IndexedDB, just enough of the API pdfSession.js uses
// (open/transaction/objectStore/get/put/delete, the onupgradeneeded/onsuccess/onerror and
// oncomplete/onerror events). Real browsers are covered by the Playwright e2e test.
function installFakeIndexedDB() {
    const databases = new Map();

    class FakeRequest {
        result = undefined;
        error = null;
        onsuccess = null;
        onerror = null;
        onupgradeneeded = null;
        _succeed(result) {
            this.result = result;
            queueMicrotask(() => this.onsuccess?.({ target: this }));
        }
    }

    class FakeStore {
        constructor(map) {
            this.map = map;
        }
        get(key) {
            const req = new FakeRequest();
            queueMicrotask(() => req._succeed(this.map.get(key)));
            return req;
        }
        put(value, key) {
            const req = new FakeRequest();
            this.map.set(key, value);
            queueMicrotask(() => req._succeed(key));
            return req;
        }
        delete(key) {
            const req = new FakeRequest();
            this.map.delete(key);
            queueMicrotask(() => req._succeed(undefined));
            return req;
        }
    }

    class FakeTx {
        constructor(map) {
            this.map = map;
            this.oncomplete = null;
            this.onerror = null;
            this.onabort = null;
            // A macrotask, so it only fires after every request's microtask (issued synchronously
            // right after the transaction is created) has already resolved - matching how a real
            // transaction only completes once its requests are done.
            setTimeout(() => this.oncomplete?.(), 0);
        }
        objectStore() {
            return new FakeStore(this.map);
        }
    }

    class FakeDb {
        stores = new Map();
        createObjectStore(name) {
            this.stores.set(name, new Map());
        }
        transaction(name) {
            return new FakeTx(this.stores.get(name));
        }
        close() {}
    }

    globalThis.indexedDB = {
        open(name) {
            const req = new FakeRequest();
            queueMicrotask(() => {
                let db = databases.get(name);
                const isNew = !db;
                if (isNew) {
                    db = new FakeDb();
                    databases.set(name, db);
                }
                req.result = db;
                if (isNew) req.onupgradeneeded?.({ target: req });
                req._succeed(db);
            });
            return req;
        },
    };
}

describe('hasUnsavedChanges', () => {
    it('is false with no elements and true once there is at least one', () => {
        expect(hasUnsavedChanges([])).toBe(false);
        expect(hasUnsavedChanges([{ type: 'text' }])).toBe(true);
    });
});

describe('fileFromSession', () => {
    it('rebuilds a File with the saved name, type and bytes', async () => {
        const bytes = new Uint8Array([1, 2, 3, 4]);
        const file = fileFromSession({ fileBytes: bytes.buffer, fileName: 'notes.pdf', fileType: 'application/pdf' });
        expect(file.name).toBe('notes.pdf');
        expect(file.type).toBe('application/pdf');
        expect(new Uint8Array(await file.arrayBuffer())).toEqual(bytes);
    });

    it('falls back to application/pdf when no type was saved', () => {
        const file = fileFromSession({ fileBytes: new ArrayBuffer(0), fileName: 'a.pdf' });
        expect(file.type).toBe('application/pdf');
    });
});

describe('saveSession / loadSession / clearSession', () => {
    beforeEach(() => installFakeIndexedDB());
    afterEach(() => {
        delete globalThis.indexedDB;
    });

    it('has nothing saved until a session is stored', async () => {
        expect(await loadSession()).toBeNull();
    });

    it('round-trips a saved session and overwrites it on a second save', async () => {
        const first = { fileName: 'a.pdf', fileType: 'application/pdf', fileBytes: new ArrayBuffer(2), elements: [{ type: 'text' }], currentPage: 0, mode: 'edittext' };
        await saveSession(first);
        expect(await loadSession()).toEqual(first);

        const second = { ...first, fileName: 'b.pdf', elements: [{ type: 'text' }, { type: 'highlight' }], currentPage: 1 };
        await saveSession(second);
        expect(await loadSession()).toEqual(second);
    });

    it('clears the saved session', async () => {
        await saveSession({ fileName: 'a.pdf', fileBytes: new ArrayBuffer(0), elements: [], currentPage: 0, mode: 'edittext' });
        await clearSession();
        expect(await loadSession()).toBeNull();
    });
});
