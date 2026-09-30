import { useCallback, useEffect, useState } from 'react';
import CopyButton from '../components/CopyButton.jsx';
import { Notice } from '../components/ui.jsx';
import { t } from '../lib/i18n.js';

function detectBrowser(ua) {
    const rules = [
        [/Edg\/([\d.]+)/, 'Microsoft Edge'],
        [/OPR\/([\d.]+)/, 'Opera'],
        [/SamsungBrowser\/([\d.]+)/, 'Samsung Internet'],
        [/Firefox\/([\d.]+)/, 'Firefox'],
        [/CriOS\/([\d.]+)/, 'Chrome'],
        [/Chrome\/([\d.]+)/, 'Chrome'],
        [/Version\/([\d.]+).*Safari/, 'Safari'],
    ];
    for (const [re, name] of rules) {
        const m = re.exec(ua);
        if (m) return `${name} ${m[1].split('.')[0]}`;
    }
    return t('Unknown browser');
}

function detectOs(ua) {
    if (/Windows NT 10/.test(ua)) return 'Windows 10 / 11';
    if (/Windows/.test(ua)) return 'Windows';
    if (/iPhone|iPad|iPod/.test(ua)) return 'iOS / iPadOS';
    if (/Android ([\d.]+)/.test(ua)) return `Android ${/Android ([\d.]+)/.exec(ua)[1]}`;
    if (/Mac OS X/.test(ua)) return 'macOS';
    if (/CrOS/.test(ua)) return 'ChromeOS';
    if (/Linux/.test(ua)) return 'Linux';
    return t('Unknown');
}

export const ipVersion = (ip) => (ip.includes(':') ? 'IPv6' : 'IPv4');

export default function WhatIsMyIp({ ip: initialIp = '', endpoint = '/api/ip' }) {
    const [ip, setIp] = useState(initialIp);
    const [loading, setLoading] = useState(!initialIp);
    const [error, setError] = useState('');
    const [device, setDevice] = useState(null);

    useEffect(() => {
        const ua = navigator.userAgent;
        let timeZone = '';
        try {
            timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone || '';
        } catch {
            timeZone = '';
        }
        setDevice({
            browser: detectBrowser(ua),
            os: detectOs(ua),
            type: /Mobi|Android|iPhone/.test(ua) ? t('Mobile') : /iPad|Tablet/.test(ua) ? t('Tablet') : t('Desktop'),
            screen: `${window.screen.width} × ${window.screen.height} px`,
            language: navigator.language || '—',
            timeZone: timeZone || '—',
            cookies: navigator.cookieEnabled ? t('Enabled') : t('Disabled'),
            userAgent: ua,
        });
    }, []);

    const refresh = useCallback(async () => {
        setLoading(true);
        setError('');
        try {
            // A unique URL each time, so a CDN/firewall cache in front of the site can never
            // hand one visitor's IP to another.
            const url = `${endpoint}${endpoint.includes('?') ? '&' : '?'}_=${Date.now().toString(36)}${Math.random().toString(36).slice(2)}`;
            const res = await fetch(url, { headers: { Accept: 'application/json' }, cache: 'no-store' });
            if (!res.ok) throw new Error(`Server responded with ${res.status}`);
            const data = await res.json();
            setIp(String(data.ip || ''));
        } catch {
            setError(t('Could not look up your IP address. Check your connection and try again.'));
        } finally {
            setLoading(false);
        }
    }, [endpoint]);

    // Always ask on load: an IP embedded in the HTML could come from a cached copy of the page.
    useEffect(() => {
        refresh();
    }, [refresh]);

    return (
        <div className="stack">
            <div className="ip-hero">
                <p className="ip-hero__label">{t('Your public IP address')}</p>
                <p className="ip-hero__value" aria-live="polite" data-testid="ip-value">{ip || (loading ? t('Looking up…') : t('Unknown'))}</p>
                <div className="row" style={{ justifyContent: 'center' }}>
                    {ip && <span className="badge badge--success">{ipVersion(ip)}</span>}
                    <CopyButton text={ip} className="btn btn--primary btn--sm" label={t('Copy IP')} />
                    <button type="button" className="btn btn--sm" onClick={refresh} disabled={loading}>{loading ? t('Refreshing…') : `↻ ${t('Refresh')}`}</button>
                </div>
            </div>

            <Notice type="error">{error}</Notice>

            {device && (
                <table className="kv">
                    <caption className="sr-only">{t('Your browser and device details')}</caption>
                    <tbody>
                        <tr><th scope="row">{t('Browser')}</th><td>{device.browser}</td></tr>
                        <tr><th scope="row">{t('Operating system')}</th><td>{device.os}</td></tr>
                        <tr><th scope="row">{t('Device type')}</th><td>{device.type}</td></tr>
                        <tr><th scope="row">{t('Screen resolution')}</th><td>{device.screen}</td></tr>
                        <tr><th scope="row">{t('Language')}</th><td>{device.language}</td></tr>
                        <tr><th scope="row">{t('Time zone')}</th><td>{device.timeZone}</td></tr>
                        <tr><th scope="row">{t('Cookies')}</th><td>{device.cookies}</td></tr>
                        <tr><th scope="row">{t('User agent')}</th><td style={{ fontFamily: 'var(--mono)', fontSize: '.85rem' }}>{device.userAgent}</td></tr>
                    </tbody>
                </table>
            )}
        </div>
    );
}
