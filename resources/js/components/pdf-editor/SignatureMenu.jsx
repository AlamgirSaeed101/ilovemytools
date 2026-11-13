// The Sign tool's panel in the PDF editor: signatures and initials saved on this device, a panel
// to create a new one (draw, type or upload), and the controls to place the picked one.
// Saved signatures live only in this browser's IndexedDB and only when the user opts in.
import { useEffect, useRef, useState } from 'react';
import { Tabs } from '../ui.jsx';
import { t } from '../../lib/i18n.js';
import { canvasToPngImage } from '../../lib/imageUtils.js';
import { createSignatureStore } from '../../lib/signatureStore.js';
import { DrawPad, TypePad, UploadPad } from './SignaturePads.jsx';

let sharedStore = null;
function store() {
    sharedStore ??= createSignatureStore();
    return sharedStore;
}

/**
 * `picked`: the signature currently being placed ({ bytes, dataUrl, width, height, kind, id? }) or null.
 * `onPick(sig)`: a signature was created or chosen from the saved list. `onPlace()`: place it in the
 * middle of the page (clicking the page places it at the pointer instead). `addDate`/`onAddDateChange`:
 * the optional date stamp under each placed signature. `onError(message)`.
 */
export default function SignatureMenu({ picked, onPick, onPlace, addDate, onAddDateChange, onError }) {
    const [saved, setSaved] = useState([]);
    const [storeReady, setStoreReady] = useState(false);
    const [storeAvailable, setStoreAvailable] = useState(true);
    const [creating, setCreating] = useState(false);
    const [kind, setKind] = useState('signature');
    const [padMode, setPadMode] = useState('draw');
    const [remember, setRemember] = useState(false);
    const creatorRef = useRef(null);

    useEffect(() => {
        let cancelled = false;
        store()
            .list()
            .then((rows) => !cancelled && setSaved(rows))
            .catch(() => !cancelled && setStoreAvailable(false))
            .finally(() => !cancelled && setStoreReady(true));
        return () => {
            cancelled = true;
        };
    }, []);

    const showCreator = creating || (storeReady && saved.length === 0 && !picked);

    useEffect(() => {
        if (creating) creatorRef.current?.querySelector('[role="tab"][aria-selected="true"]')?.focus();
    }, [creating]);

    async function onPadUse(canvas) {
        try {
            const image = await canvasToPngImage(canvas);
            let sig = { ...image, kind };
            if (remember && storeAvailable) {
                try {
                    const record = await store().save({ kind, bytes: image.bytes, width: image.width, height: image.height });
                    sig = { ...sig, id: record.id };
                    setSaved(await store().list());
                } catch {
                    onError(t('Could not save the signature on this device. You can still use it now.'));
                }
            }
            onPick(sig);
            setCreating(false);
        } catch {
            onError(t('Could not create the signature image.'));
        }
    }

    async function removeSaved(id) {
        if (!window.confirm(t('Delete this saved signature from this device?'))) return;
        try {
            await store().remove(id);
            setSaved(await store().list());
            if (picked?.id === id) onPick(null);
        } catch {
            onError(t('Could not delete the saved signature.'));
        }
    }

    return (
        <div className="stack" style={{ marginTop: '0.7rem' }}>
            {saved.length > 0 && (
                <div className="field">
                    <span className="field__label">{t('Your saved signatures')}</span>
                    <ul className="signature-saved" aria-label={t('Your saved signatures')}>
                        {saved.map((sig, i) => (
                            <li key={sig.id} className={`signature-saved__item${picked?.id === sig.id ? ' is-selected' : ''}`}>
                                <button
                                    type="button"
                                    className="signature-saved__pick"
                                    aria-pressed={picked?.id === sig.id}
                                    aria-label={sig.kind === 'initials' ? t('Use saved initials {number}', { number: i + 1 }) : t('Use saved signature {number}', { number: i + 1 })}
                                    onClick={() => onPick(sig)}
                                >
                                    <img src={sig.dataUrl} alt="" />
                                    <span className="signature-saved__kind">{sig.kind === 'initials' ? t('Initials') : t('Signature')}</span>
                                </button>
                                <button type="button" className="signature-saved__delete" aria-label={t('Delete saved signature {number}', { number: i + 1 })} onClick={() => removeSaved(sig.id)}>
                                    ×
                                </button>
                            </li>
                        ))}
                    </ul>
                    {!showCreator && (
                        <div className="row">
                            <button type="button" className="btn btn--sm" onClick={() => setCreating(true)}>{t('Create a new signature')}</button>
                        </div>
                    )}
                </div>
            )}

            {showCreator ? (
                <div className="field signature-creator" ref={creatorRef} role="group" aria-label={t('Create your signature')}>
                    <span className="field__label">{t('1. Create your signature')}</span>
                    <div className="row" role="radiogroup" aria-label={t('What to create')}>
                        <label className="check">
                            <input type="radio" name="signature-kind" checked={kind === 'signature'} onChange={() => setKind('signature')} /> {t('Full signature')}
                        </label>
                        <label className="check">
                            <input type="radio" name="signature-kind" checked={kind === 'initials'} onChange={() => setKind('initials')} /> {t('Initials')}
                        </label>
                    </div>
                    <div style={{ marginTop: '0.6rem' }}>
                        <Tabs
                            label={t('Signature type')}
                            value={padMode}
                            onChange={setPadMode}
                            tabs={[
                                { id: 'draw', label: t('Draw') },
                                { id: 'type', label: t('Type') },
                                { id: 'upload', label: t('Upload') },
                            ]}
                        />
                    </div>
                    <div style={{ marginTop: '0.7rem' }}>
                        {padMode === 'draw' && <DrawPad onUse={onPadUse} />}
                        {padMode === 'type' && <TypePad onUse={onPadUse} />}
                        {padMode === 'upload' && <UploadPad onUse={onPadUse} onError={() => onError(t('Please choose a PNG, JPG or WebP image.'))} />}
                    </div>
                    {storeAvailable && (
                        <>
                            <label className="check" style={{ marginTop: '0.6rem' }}>
                                <input type="checkbox" checked={remember} onChange={(e) => setRemember(e.target.checked)} /> {t('Remember on this device')}
                            </label>
                            <p className="field__hint">{t('Saved only in this browser, never uploaded. You can delete it at any time.')}</p>
                        </>
                    )}
                    {(saved.length > 0 || picked) && (
                        <div className="row">
                            <button type="button" className="btn btn--sm btn--ghost" onClick={() => setCreating(false)}>{t('Cancel')}</button>
                        </div>
                    )}
                </div>
            ) : (
                saved.length === 0 && (
                    <div className="row">
                        <button type="button" className="btn btn--sm" onClick={() => setCreating(true)}>{t('Create a different signature')}</button>
                    </div>
                )
            )}

            {picked && (
                <p className="field__hint" aria-live="polite">
                    {t('Signature ready.')} <img src={picked.dataUrl} alt={t('Signature preview')} style={{ height: '28px', verticalAlign: 'middle' }} />
                </p>
            )}

            <span className="field__label">{t('2. Place it on the page')}</span>
            <div className="pdf-editor__toolbar">
                <label className="row" style={{ gap: '0.4rem' }}>
                    <input type="checkbox" checked={addDate} onChange={(e) => onAddDateChange(e.target.checked)} />
                    {t("Add today's date under the signature")}
                </label>
                <button type="button" className="btn btn--primary btn--sm" disabled={!picked} onClick={onPlace}>
                    {t('Add signature to this page')}
                </button>
                {picked && <span className="field__hint" style={{ margin: 0 }}>{t('Or click anywhere on the page to place it there, as many times as you need.')}</span>}
            </div>
        </div>
    );
}
