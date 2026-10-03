import { useEffect, useRef, useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import { Notice } from '../components/ui.jsx';
import { exportResult, hasWebGpu, MODELS, removeBackground } from '../lib/bgRemoval.js';
import { CONVERTIBLE_TYPES, imageTypeOf, MAX_FILE_BYTES } from '../lib/image.js';
import { baseName, downloadBlob, formatBytes, safeFilename } from '../lib/util.js';
import { formatNumber, t } from '../lib/i18n.js';

const BACKGROUNDS = [
    ['transparent', 'Transparent'],
    ['#ffffff', 'White'],
    ['custom', 'Colour'],
];

/** Checkerboard behind transparent previews. */
const CHECKER = {
    backgroundColor: '#fff',
    backgroundImage: 'linear-gradient(45deg,#e2e8f0 25%,transparent 25%),linear-gradient(-45deg,#e2e8f0 25%,transparent 25%),linear-gradient(45deg,transparent 75%,#e2e8f0 75%),linear-gradient(-45deg,transparent 75%,#e2e8f0 75%)',
    backgroundSize: '20px 20px',
    backgroundPosition: '0 0,0 10px,10px -10px,-10px 0',
};

export default function BackgroundRemover() {
    const gpu = hasWebGpu();
    const [mode, setMode] = useState('fast');
    const [file, setFile] = useState(null);
    const [original, setOriginal] = useState('');
    const [cutout, setCutout] = useState(null);
    const [preview, setPreview] = useState('');
    const [status, setStatus] = useState({ step: 'idle', progress: 0 });
    const [error, setError] = useState('');
    const [bg, setBg] = useState('transparent');
    const [custom, setCustom] = useState('#2563eb');
    const run = useRef(0);

    const fill = bg === 'transparent' ? null : bg === 'custom' ? custom : bg;

    // Object URLs are revoked when replaced.
    useEffect(() => () => original && URL.revokeObjectURL(original), [original]);
    useEffect(() => () => preview && URL.revokeObjectURL(preview), [preview]);

    useEffect(() => {
        if (!cutout) return;
        let alive = true;
        exportResult(cutout, { background: fill }).then((blob) => alive && setPreview(URL.createObjectURL(blob)));
        return () => {
            alive = false;
        };
    }, [cutout, fill]);

    const process = async (f, m = mode) => {
        const id = ++run.current;
        setError('');
        setCutout(null);
        setPreview('');
        setStatus({ step: 'loading', progress: 0 });
        try {
            const canvas = await removeBackground(f, m, {
                onProgress: (p) => id === run.current && setStatus({ step: p < 1 ? 'loading' : 'working', progress: p }),
            });
            if (id !== run.current) return;
            setCutout(canvas);
            setStatus({ step: 'done', progress: 1 });
        } catch (e) {
            if (id !== run.current) return;
            console.warn(e);
            setStatus({ step: 'idle', progress: 0 });
            setError(
                m === 'hq'
                    ? t('High quality mode could not run on this device. Please try Fast mode.')
                    : t('Sorry, the background could not be removed. Please try another image or reload the page.'),
            );
        }
    };

    const onFiles = ([f]) => {
        if (f.size > MAX_FILE_BYTES) {
            setError(t('"{name}" is larger than {max}.', { name: f.name, max: formatBytes(MAX_FILE_BYTES) }));
            return;
        }
        setFile(f);
        setOriginal(URL.createObjectURL(f));
        process(f);
    };

    const download = async () => {
        const blob = await exportResult(cutout, { background: fill });
        downloadBlob(blob, safeFilename(`${baseName(file.name)}-no-bg.png`));
    };

    const busy = status.step === 'loading' || status.step === 'working';
    const model = MODELS[mode];

    return (
        <div className="stack">
            <div className="field">
                <span className="field__label">{t('Quality')}</span>
                <div className="row" role="radiogroup" aria-label={t('Quality')}>
                    {[
                        ['fast', t('Fast'), t('{size} model · works on every device', { size: formatBytes(MODELS.fast.bytes) })],
                        ['hq', t('High quality'), gpu ? t('{size} one-time download · sharper hair and edges', { size: formatBytes(MODELS.hq.bytes) }) : t('Needs a browser with WebGPU (Chrome or Edge)')],
                    ].map(([key, label, hint]) => (
                        <button
                            key={key}
                            type="button"
                            role="radio"
                            aria-checked={mode === key}
                            disabled={busy || (key === 'hq' && !gpu)}
                            onClick={() => {
                                setMode(key);
                                if (file) process(file, key);
                            }}
                            className={`btn ${mode === key ? 'btn--primary' : ''} flex-col !items-start text-start`}
                        >
                            <span>{label}</span>
                            <span className="text-[0.75rem] font-medium opacity-80">{hint}</span>
                        </button>
                    ))}
                </div>
            </div>

            <Dropzone
                accept="image/jpeg,image/png,image/webp,image/avif,.jpg,.jpeg,.png,.webp,.avif"
                isAccepted={(f) => CONVERTIBLE_TYPES.includes(imageTypeOf(f))}
                onReject={() => setError(t('Please choose a JPG, PNG, WebP or AVIF image.'))}
                onFiles={onFiles}
                title={t('Drop an image here or click to choose')}
                hint={t('JPG, PNG, WebP or AVIF · max 50 MB · your image is never uploaded')}
                compact={Boolean(file)}
            />

            <Notice type="error">{error}</Notice>

            {busy && (
                <div className="result" role="status" aria-live="polite" data-testid="bg-status">
                    <p className="m-0 mb-2 font-bold">
                        {status.step === 'loading'
                            ? t('Loading the AI model… {percent}%', { percent: formatNumber(Math.round(status.progress * 100)) })
                            : t('Removing the background…')}
                    </p>
                    <div className="h-2 overflow-hidden rounded-full bg-surface-2">
                        <div className="h-full rounded-full bg-brand transition-[width]" style={{ width: `${status.step === 'loading' ? Math.round(status.progress * 100) : 100}%` }} />
                    </div>
                    {status.step === 'loading' && mode === 'hq' && <p className="mt-2 mb-0 text-[0.85rem] text-muted">{t('The model is saved in your browser, so next time it starts instantly.')}</p>}
                </div>
            )}

            {file && (
                <div className="grid gap-3 sm:grid-cols-2">
                    <figure className="m-0">
                        <figcaption className="field__label">{t('Original')}</figcaption>
                        <img src={original} alt={t('Original')} className="block max-h-[420px] w-full rounded-xl border border-line object-contain" />
                    </figure>
                    <figure className="m-0">
                        <figcaption className="field__label">{t('Background removed')}</figcaption>
                        <div className="grid min-h-[160px] place-items-center overflow-hidden rounded-xl border border-line" style={CHECKER}>
                            {preview ? (
                                <img src={preview} alt={t('Background removed')} className="block max-h-[420px] w-full object-contain" data-testid="bg-result" />
                            ) : (
                                <span className="p-4 text-muted">{busy ? t('Working…') : ''}</span>
                            )}
                        </div>
                    </figure>
                </div>
            )}

            {cutout && (
                <>
                    <div className="field">
                        <span className="field__label">{t('Background')}</span>
                        <div className="row">
                            {BACKGROUNDS.map(([value, label]) => (
                                <button key={value} type="button" className={`btn btn--sm ${bg === value ? 'btn--primary' : ''}`} aria-pressed={bg === value} onClick={() => setBg(value)}>
                                    {t(label)}
                                </button>
                            ))}
                            {bg === 'custom' && (
                                <input type="color" className="input input--color" value={custom} onChange={(e) => setCustom(e.target.value)} aria-label={t('Background colour')} />
                            )}
                        </div>
                    </div>
                    <div className="row">
                        <button type="button" className="btn btn--primary btn--lg" onClick={download}>
                            {t('Download PNG')}
                        </button>
                        <span className="field__hint">{t('{width} × {height} px', { width: cutout.width, height: cutout.height })} · {model.size === 1024 ? t('High quality') : t('Fast')}</span>
                    </div>
                </>
            )}
        </div>
    );
}
