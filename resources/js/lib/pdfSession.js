// Auto-saves Edit PDF's in-progress session - the file and every element added or edited - to
// IndexedDB, so a refresh, a closed tab or a crash resumes exactly where it was left. There is
// only ever one saved session: a new save overwrites the last one. Nothing here ever leaves the
// device; it is the same file and elements the editor already holds in memory.
const DB_NAME = 'ilovemytools-edit-pdf';
const STORE = 'session';
const KEY = 'current';

function openDb() {
    return new Promise((resolve, reject) => {
        if (typeof indexedDB === 'undefined') {
            reject(new Error('IndexedDB is not available.'));
            return;
        }
        const req = indexedDB.open(DB_NAME, 1);
        req.onupgradeneeded = () => req.result.createObjectStore(STORE);
        req.onsuccess = () => resolve(req.result);
        req.onerror = () => reject(req.error);
    });
}

function runTx(db, mode, action) {
    return new Promise((resolve, reject) => {
        const tx = db.transaction(STORE, mode);
        const store = tx.objectStore(STORE);
        const request = action(store);
        tx.oncomplete = () => resolve(request?.result);
        tx.onerror = () => reject(tx.error);
        tx.onabort = () => reject(tx.error);
    });
}

async function withStore(mode, action) {
    const db = await openDb();
    try {
        return await runTx(db, mode, action);
    } finally {
        db.close();
    }
}

/** Saves the current session (the file's bytes, every element, the page and mode), replacing any previous one. */
export function saveSession(session) {
    return withStore('readwrite', (store) => store.put(session, KEY));
}

/** The last saved session, or null when there isn't one. */
export function loadSession() {
    return withStore('readonly', (store) => store.get(KEY)).then((result) => result ?? null);
}

/** Deletes the saved session: called once the edited PDF is downloaded, or the user discards it. */
export function clearSession() {
    return withStore('readwrite', (store) => store.delete(KEY));
}

/** Rebuilds the File a saved session was made from, so it can be handed back to the editor. */
export function fileFromSession(session) {
    return new File([session.fileBytes], session.fileName, { type: session.fileType || 'application/pdf' });
}

/** Whether the editor holds anything that a refresh, a closed tab or a new upload would lose. */
export function hasUnsavedChanges(elements) {
    return elements.length > 0;
}
