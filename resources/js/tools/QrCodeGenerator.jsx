import { useEffect, useMemo, useRef, useState } from 'react';
import QRCode from 'qrcode';
import { Notice, Tabs } from '../components/ui.jsx';
import { buildQrPayload, contrastRatio, luminance } from '../lib/qr.js';
import { downloadBlob } from '../lib/util.js';
import { formatNumber, t } from '../lib/i18n.js';

const TYPES = [
    { id: 'url', label: 'URL' },
    { id: 'text', label: 'Text' },
    { id: 'wifi', label: 'Wi-Fi' },
    { id: 'email', label: 'Email' },
    { id: 'phone', label: 'Phone' },
    { id: 'sms', label: 'SMS' },
];

function Field({ id, label, children, hint }) {
    return (
        <div className="field">
            <label className="field__label" htmlFor={id}>{label}</label>
            {children}
            {hint && <span className="field__hint">{hint}</span>}
        </div>
    );
}

export default function QrCodeGenerator() {
    const [type, setType] = useState('url');
    const [fields, setFields] = useState({ url: '', text: '', ssid: '', password: '', encryption: 'WPA', hidden: false, email: '', subject: '', body: '', phone: '', message: '' });
    const [size, setSize] = useState(512);
    const [dark, setDark] = useState('#000000');
    const [light, setLight] = useState('#ffffff');
    const [level, setLevel] = useState('M');
    const [margin, setMargin] = useState(4);
    const [renderError, setRenderError] = useState('');
    const canvasRef = useRef(null);

    const set = (key) => (e) => setFields((f) => ({ ...f, [key]: e.target.type === 'checkbox' ? e.target.checked : e.target.value }));
    const { payload, error: inputError } = useMemo(() => buildQrPayload(type, fields), [type, fields]);
    const ratio = contrastRatio(dark, light);
    const inverted = luminance(dark) > luminance(light);

    const qrOptions = useMemo(
        () => ({ width: size, margin, errorCorrectionLevel: level, color: { dark, light } }),
        [size, margin, level, dark, light],
    );

    useEffect(() => {
        const canvas = canvasRef.current;
        if (!canvas) return;
        if (!payload) {
            const ctx = canvas.getContext('2d');
            ctx?.clearRect(0, 0, canvas.width, canvas.height);
            setRenderError('');
            return;
        }
        let cancelled = false;
        QRCode.toCanvas(canvas, payload, qrOptions)
            .then(() => !cancelled && setRenderError(''))
            .catch((e) => {
                if (cancelled) return;
                setRenderError(/too big|amount of data/i.test(e.message)
                    ? t('That is too much data for one QR code. Please shorten the text or use a lower error correction level.')
                    : t('Could not create the QR code: {message}', { message: e.message }));
            });
        return () => {
            cancelled = true;
        };
    }, [payload, qrOptions]);

    const ready = Boolean(payload) && !renderError;

    function downloadPng() {
        canvasRef.current?.toBlob((blob) => blob && downloadBlob(blob, `qr-code-${type}.png`), 'image/png');
    }

    async function downloadSvg() {
        try {
            const svg = await QRCode.toString(payload, { ...qrOptions, type: 'svg' });
            downloadBlob(new Blob([svg], { type: 'image/svg+xml' }), `qr-code-${type}.svg`);
        } catch (e) {
            setRenderError(t('Could not create the SVG: {message}', { message: e.message }));
        }
    }

    return (
        <div className="stack">
            <Tabs tabs={TYPES.map((x) => ({ ...x, label: t(x.label) }))} value={type} onChange={setType} label={t('QR code type')} />

            <div className="grid-2" style={{ alignItems: 'start' }}>
                <div className="stack">
                    {type === 'url' && (
                        <Field id="qr-url" label={t('Website URL')} hint={t('https:// is added automatically if you leave it out.')}>
                            <input id="qr-url" className="input" type="url" inputMode="url" placeholder="https://example.com" value={fields.url} onChange={set('url')} />
                        </Field>
                    )}
                    {type === 'text' && (
                        <Field id="qr-text" label={t('Text')}>
                            <textarea id="qr-text" className="textarea" style={{ minHeight: 140 }} placeholder={t('Any text…')} value={fields.text} onChange={set('text')} />
                        </Field>
                    )}
                    {type === 'wifi' && (
                        <>
                            <Field id="qr-ssid" label={t('Network name (SSID)')}>
                                <input id="qr-ssid" className="input" value={fields.ssid} onChange={set('ssid')} placeholder="MyHomeWiFi" autoComplete="off" />
                            </Field>
                            <Field id="qr-enc" label={t('Security')}>
                                <select id="qr-enc" className="select" value={fields.encryption} onChange={set('encryption')}>
                                    <option value="WPA">WPA / WPA2 / WPA3</option>
                                    <option value="WEP">WEP</option>
                                    <option value="nopass">{t('No password')}</option>
                                </select>
                            </Field>
                            {fields.encryption !== 'nopass' && (
                                <Field id="qr-pass" label={t('Password')}>
                                    <input id="qr-pass" className="input" value={fields.password} onChange={set('password')} autoComplete="off" />
                                </Field>
                            )}
                            <label className="check">
                                <input type="checkbox" checked={fields.hidden} onChange={set('hidden')} /> {t('Hidden network')}
                            </label>
                        </>
                    )}
                    {type === 'email' && (
                        <>
                            <Field id="qr-email" label={t('Email address')}>
                                <input id="qr-email" className="input" type="email" value={fields.email} onChange={set('email')} placeholder="name@example.com" />
                            </Field>
                            <Field id="qr-subject" label={t('Subject (optional)')}>
                                <input id="qr-subject" className="input" value={fields.subject} onChange={set('subject')} />
                            </Field>
                            <Field id="qr-body" label={t('Message (optional)')}>
                                <textarea id="qr-body" className="textarea" style={{ minHeight: 90 }} value={fields.body} onChange={set('body')} />
                            </Field>
                        </>
                    )}
                    {(type === 'phone' || type === 'sms') && (
                        <Field id="qr-phone" label={t('Phone number')} hint={t('Include the country code, e.g. +44 7700 900123')}>
                            <input id="qr-phone" className="input" type="tel" value={fields.phone} onChange={set('phone')} placeholder="+1 555 123 4567" />
                        </Field>
                    )}
                    {type === 'sms' && (
                        <Field id="qr-sms" label={t('Message (optional)')}>
                            <textarea id="qr-sms" className="textarea" style={{ minHeight: 90 }} value={fields.message} onChange={set('message')} />
                        </Field>
                    )}

                    <details>
                        <summary style={{ cursor: 'pointer', fontWeight: 600 }}>{t('Customise colours, size and quality')}</summary>
                        <div className="stack" style={{ marginTop: '1rem' }}>
                            <div className="grid-2">
                                <Field id="qr-dark" label={t('QR colour')}>
                                    <input id="qr-dark" className="input input--color" type="color" value={dark} onChange={(e) => setDark(e.target.value)} />
                                </Field>
                                <Field id="qr-light" label={t('Background')}>
                                    <input id="qr-light" className="input input--color" type="color" value={light} onChange={(e) => setLight(e.target.value)} />
                                </Field>
                            </div>
                            <Field id="qr-size" label={t('Size: {size} × {size} px', { size: formatNumber(size) })}>
                                <input id="qr-size" className="range" type="range" min={128} max={1024} step={32} value={size} onChange={(e) => setSize(Number(e.target.value))} />
                            </Field>
                            <div className="grid-2">
                                <Field id="qr-level" label={t('Error correction')}>
                                    <select id="qr-level" className="select" value={level} onChange={(e) => setLevel(e.target.value)}>
                                        <option value="L">{t('Low (7%)')}</option>
                                        <option value="M">{t('Medium (15%)')}</option>
                                        <option value="Q">{t('Quartile (25%)')}</option>
                                        <option value="H">{t('High (30%)')}</option>
                                    </select>
                                </Field>
                                <Field id="qr-margin" label={t('Margin')}>
                                    <select id="qr-margin" className="select" value={margin} onChange={(e) => setMargin(Number(e.target.value))}>
                                        {[0, 1, 2, 4, 6, 8].map((m) => (
                                            <option key={m} value={m}>{m === 4 ? t('{count} modules (recommended)', { count: m }) : t('{count} modules', { count: m })}</option>
                                        ))}
                                    </select>
                                </Field>
                            </div>
                        </div>
                    </details>
                </div>

                <div className="stack">
                    <div className="qr-preview" aria-live="polite">
                        <canvas ref={canvasRef} role="img" aria-label={ready ? t('QR code preview') : t('Empty QR code preview')} style={{ display: ready ? 'block' : 'none' }} />
                        {!ready && <p className="qr-preview__empty">{renderError ? t('No preview') : inputError || t('Your QR code will appear here.')}</p>}
                    </div>
                    <Notice type="error">{renderError}</Notice>
                    {ratio < 3 && <Notice type="warn">{t('The colours are too similar - many phones will not be able to scan this code.')}</Notice>}
                    {ratio >= 3 && inverted && <Notice type="warn">{t('Light-on-dark QR codes do not scan on some phones. A dark code on a light background is safest.')}</Notice>}
                    {margin < 2 && <Notice type="warn">{t('A small margin can make the code hard to scan when printed on a busy background.')}</Notice>}
                    <div className="row">
                        <button type="button" className="btn btn--primary" onClick={downloadPng} disabled={!ready}>{t('Download PNG')}</button>
                        <button type="button" className="btn" onClick={downloadSvg} disabled={!ready}>{t('Download SVG')}</button>
                    </div>
                </div>
            </div>
        </div>
    );
}
