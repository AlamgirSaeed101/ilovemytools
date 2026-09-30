import { t } from './i18n.js';
// UTF-8 safe Base64 (btoa/atob alone break on emoji and non-English text).

export function bytesToBase64(bytes) {
    let binary = '';
    const chunk = 0x8000;
    for (let i = 0; i < bytes.length; i += chunk) {
        binary += String.fromCharCode.apply(null, bytes.subarray(i, i + chunk));
    }
    return btoa(binary);
}

export function base64ToBytes(base64) {
    const binary = atob(base64);
    const bytes = new Uint8Array(binary.length);
    for (let i = 0; i < binary.length; i++) bytes[i] = binary.charCodeAt(i);
    return bytes;
}

export function toUrlSafe(b64) {
    return b64.replace(/\+/g, '-').replace(/\//g, '_').replace(/=+$/, '');
}

export function encodeText(text, { urlSafe = false } = {}) {
    const b64 = bytesToBase64(new TextEncoder().encode(text));
    return urlSafe ? toUrlSafe(b64) : b64;
}

/** Accepts standard or URL-safe Base64, with or without padding, whitespace or a data: prefix. */
export function normalizeBase64(input) {
    let s = String(input).trim().replace(/^data:[^,]*;base64,/i, '').replace(/\s+/g, '');
    s = s.replace(/-/g, '+').replace(/_/g, '/');
    if (s === '') throw new Error(t('Please paste some Base64 text first.'));
    if (!/^[A-Za-z0-9+/]*={0,2}$/.test(s)) throw new Error(t('This is not valid Base64: it contains characters outside A-Z, a-z, 0-9, +, / and =.'));
    const unpadded = s.replace(/=+$/, '');
    if (unpadded.length % 4 === 1) throw new Error(t('This is not valid Base64: the length is wrong (it may be cut off).'));
    return unpadded + '='.repeat((4 - (unpadded.length % 4)) % 4);
}

export function decodeText(input) {
    const bytes = base64ToBytes(normalizeBase64(input));
    try {
        return { text: new TextDecoder('utf-8', { fatal: true }).decode(bytes), binary: false };
    } catch {
        return { text: new TextDecoder('utf-8').decode(bytes), binary: true };
    }
}
