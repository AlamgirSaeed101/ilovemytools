import { useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import { Notice } from '../components/ui.jsx';
import { isPdf, loadPdf } from '../lib/pdf.js';
import { decryptPdf } from '../lib/qpdf.js';
import { baseName, downloadBlob, formatBytes, safeFilename } from '../lib/util.js';
import { t, tn } from '../lib/i18n.js';
import { PDFDocument } from 'pdf-lib';

export default function UnlockPdf() {
    const [file, setFile] = useState(null);
    const [checking, setChecking] = useState(false);
    const [password, setPassword] = useState('');
    const [showPassword, setShowPassword] = useState(false);
    const [error, setError] = useState('');
    const [working, setWorking] = useState(false);
    const [result, setResult] = useState(null);

    async function openFile([picked]) {
        setError('');
        setResult(null);
        setPassword('');
        setFile(null);
        setChecking(true);
        try {
            await loadPdf(picked);
            setError(t('"{name}" does not have a password. There is nothing to unlock.', { name: picked.name }));
        } catch (e) {
            if (e.isEncrypted) {
                setFile(picked);
            } else {
                setError(e.message);
            }
        } finally {
            setChecking(false);
        }
    }

    async function unlock() {
        if (!file || !password || working) return;
        setWorking(true);
        setError('');
        try {
            const bytes = await file.arrayBuffer();
            const decrypted = await decryptPdf(new Uint8Array(bytes), password);
            const doc = await PDFDocument.load(decrypted, { ignoreEncryption: true });
            const blob = new Blob([decrypted], { type: 'application/pdf' });
            setResult({ blob, pages: doc.getPageCount(), name: safeFilename(`${baseName(file.name)}-unlocked.pdf`) });
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
                    title={t('Drop a password-protected PDF here or click to choose')}
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
                    <strong>{file.name}</strong> · {formatBytes(file.size)}
                </p>
                <button type="button" className="btn btn--sm" onClick={() => openFile([])}>{t('Choose another PDF')}</button>
            </div>

            <div className="field">
                <label className="field__label" htmlFor="unlock-pw">{t('PDF password')}</label>
                <div className="row">
                    <input
                        id="unlock-pw"
                        className="input"
                        type={showPassword ? 'text' : 'password'}
                        autoComplete="off"
                        value={password}
                        onChange={(e) => { setPassword(e.target.value); setResult(null); setError(''); }}
                        placeholder={t('Enter the PDF\'s password')}
                    />
                    <button type="button" className="btn btn--sm" onClick={() => setShowPassword((v) => !v)}>
                        {showPassword ? t('Hide') : t('Show')}
                    </button>
                </div>
                <p className="field__hint">{t('You must know the password - this tool does not crack or guess passwords.')}</p>
            </div>

            <Notice type="error">{error}</Notice>

            {result ? (
                <div className="notice notice--success row row--between">
                    <span>{t('Done! Your PDF has {pages} ({size}), with no password.', { pages: tn('{count} page', '{count} pages', result.pages), size: formatBytes(result.blob.size) })}</span>
                    <button type="button" className="btn btn--primary" onClick={() => downloadBlob(result.blob, result.name)}>{t('Download unlocked PDF')}</button>
                </div>
            ) : (
                <button type="button" className="btn btn--primary btn--lg" onClick={unlock} disabled={working || !password}>
                    {working ? t('Unlocking…') : t('Unlock PDF')}
                </button>
            )}
        </div>
    );
}
