import { t } from './i18n.js';
// Build the text encoded in a QR code for each QR type.

// Wi-Fi QR format: WIFI:T:WPA;S:MyNetwork;P:secret;H:false;;
// Special characters \ ; , : " must be escaped with a backslash.
export function escapeWifi(value) {
    return String(value).replace(/([\\;,:"])/g, '\\$1');
}

export function normalizeUrl(url) {
    const trimmed = url.trim();
    if (trimmed === '') return '';
    if (/^[a-z][a-z0-9+.-]*:/i.test(trimmed)) return trimmed;
    return `https://${trimmed}`;
}

export function buildQrPayload(type, f) {
    switch (type) {
        case 'url': {
            const url = normalizeUrl(f.url || '');
            if (!url) return { error: t('Enter a website address.') };
            return { payload: url };
        }
        case 'text': {
            if (!(f.text || '').trim()) return { error: t('Enter some text.') };
            return { payload: f.text };
        }
        case 'wifi': {
            if (!(f.ssid || '').trim()) return { error: t('Enter the Wi-Fi network name (SSID).') };
            const enc = f.encryption || 'WPA';
            if (enc !== 'nopass' && !(f.password || '')) return { error: t('Enter the Wi-Fi password, or choose "No password".') };
            const parts = [`T:${enc}`, `S:${escapeWifi(f.ssid)}`];
            if (enc !== 'nopass') parts.push(`P:${escapeWifi(f.password)}`);
            if (f.hidden) parts.push('H:true');
            return { payload: `WIFI:${parts.join(';')};;` };
        }
        case 'email': {
            const to = (f.email || '').trim();
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(to)) return { error: t('Enter a valid email address.') };
            const params = [];
            if (f.subject) params.push(`subject=${encodeURIComponent(f.subject)}`);
            if (f.body) params.push(`body=${encodeURIComponent(f.body)}`);
            return { payload: `mailto:${to}${params.length ? `?${params.join('&')}` : ''}` };
        }
        case 'phone': {
            const phone = (f.phone || '').replace(/[^\d+]/g, '');
            if (phone.replace(/\+/g, '').length < 3) return { error: t('Enter a valid phone number.') };
            return { payload: `tel:${phone}` };
        }
        case 'sms': {
            const phone = (f.phone || '').replace(/[^\d+]/g, '');
            if (phone.replace(/\+/g, '').length < 3) return { error: t('Enter a valid phone number.') };
            return { payload: `SMSTO:${phone}:${f.message || ''}` };
        }
        default:
            return { error: t('Unknown QR code type.') };
    }
}

/** WCAG relative luminance contrast ratio between two #rrggbb colours. */
export function contrastRatio(hexA, hexB) {
    const lum = (hex) => {
        const n = hex.replace('#', '');
        const rgb = [0, 2, 4].map((i) => parseInt(n.slice(i, i + 2), 16) / 255);
        const [r, g, b] = rgb.map((c) => (c <= 0.03928 ? c / 12.92 : ((c + 0.055) / 1.055) ** 2.4));
        return 0.2126 * r + 0.7152 * g + 0.0722 * b;
    };
    const [a, b] = [lum(hexA), lum(hexB)];
    return (Math.max(a, b) + 0.05) / (Math.min(a, b) + 0.05);
}

export function luminance(hex) {
    return contrastRatio(hex, '#000000');
}
