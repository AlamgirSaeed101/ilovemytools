import { useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import { Notice } from '../components/ui.jsx';
import { isPdf, loadPdf } from '../lib/pdf.js';
import { encryptPdf } from '../lib/qpdf.js';
import { baseName, downloadBlob, formatBytes, safeFilename } from '../lib/util.js';
import { t, tn } from '../lib/i18n.js';

export default function ProtectPdf() {
    const [file, setFile] = useState(null);
    const [pageCount, setPageCount] = useState(0);
    const [checking, setChecking] = useState(false);
    const [password, setPassword] = useState('');
    const [confirm, setConfirm] = useState('');
    const [showPassword, setShowPassword] = useState(false);
    const [error, setError] = useState('');
    const [working, setWorking] = useState(false);
    const [result, setResult] = useState(null);

    async function openFile([picked]) {
        setError('');
        setResult(null);
        setPassword('');
        setConfirm('');
        setFile(null);
        setChecking(true);
        try {
            const { pageCount } = await loadPdf(picked);
            setFile(picked);
            setPageCount(pageCount);
        } catch (e) {
            setError(e.message);
        } finally {
            setChecking(false);
        }
    }

    const mismatch = confirm.length > 0 && password !== confirm;
    const canProtect = !!file && password.length > 0 && password === confirm && !working;

    async function protect() {
        if (!canProtect) return;
        setWorking(true);
        setError('');
        try {
            const bytes = await file.arrayBuffer();
            const encrypted = await encryptPdf(new Uint8Array(bytes), password);
            const blob = new Blob([encrypted], { type: 'application/pdf' });
            setResult({ blob, name: safeFilename(`${baseName(file.name)}-protected.pdf`) });
        } catch (e) {
            setError(e.message);
        } finally {
            setWorking(false);
        }
    }

    if (!file) {
        return (
            <div className="stack">
                <Dropzone
                    accept=".pdf,application/pdf"
                    isAccepted={isPdf}
                    onReject={() => setError(t('Please choose a PDF file.'))}
                    onFiles={openFile}
                    title={t('Drop a PDF here or click to choose')}
                    hint={t('One PDF file · max 200 MB')}
                />
                {checking && <Notice type="info">{t('Reading PDF…')}</Notice>}
                <Notice type="error">{error}</Notice>
            </div>
        );
    }

    return (
        <div className="stack">
            <div className="row row--between">
                <p className="field__hint" style={{ margin: 0 }}>
                    <strong>{file.name}</strong> · {formatBytes(file.size)} · {tn('{count} page', '{count} pages', pageCount)}
                </p>
                <button type="button" className="btn btn--sm" onClick={() => openFile([])}>{t('Choose another PDF')}</button>
            </div>

            <div className="grid-2">
                <div className="field">
                    <label className="field__label" htmlFor="protect-pw">{t('Choose a password')}</label>
                    <input
                        id="protect-pw"
                        className="input"
                        type={showPassword ? 'text' : 'password'}
                        autoComplete="new-password"
                        value={password}
                        onChange={(e) => { setPassword(e.target.value); setResult(null); }}
                    />
                </div>
                <div className="field">
                    <label className="field__label" htmlFor="protect-pw-confirm">{t('Confirm password')}</label>
                    <input
                        id="protect-pw-confirm"
                        className="input"
                        type={showPassword ? 'text' : 'password'}
                        autoComplete="new-password"
                        aria-invalid={mismatch}
                        value={confirm}
                        onChange={(e) => { setConfirm(e.target.value); setResult(null); }}
                    />
                </div>
            </div>

            <label className="row" style={{ gap: '0.5rem' }}>
                <input type="checkbox" checked={showPassword} onChange={(e) => setShowPassword(e.target.checked)} />
                {t('Show passwords')}
            </label>

            {mismatch && <Notice type="error">{t('Passwords do not match.')}</Notice>}
            <Notice type="error">{error}</Notice>

            {result ? (
                <div className="notice notice--success row row--between">
                    <span>{t('Done! Your PDF is protected with AES-256 encryption ({size}).', { size: formatBytes(result.blob.size) })}</span>
                    <button type="button" className="btn btn--primary" onClick={() => downloadBlob(result.blob, result.name)}>{t('Download protected PDF')}</button>
                </div>
            ) : (
                <button type="button" className="btn btn--primary btn--lg" onClick={protect} disabled={!canProtect}>
                    {working ? t('Protecting…') : t('Protect PDF')}
                </button>
            )}
        </div>
    );
}
