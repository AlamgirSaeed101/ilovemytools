// Settings for the image (or signature) last placed or touched on the page: its opacity, and
// swapping in a different picture while keeping its place and width.
import { useId, useRef } from 'react';
import { t } from '../../lib/i18n.js';
import { loadImageFile } from '../../lib/imageUtils.js';

export default function ImageControls({ element, onChange, onError }) {
    const inputRef = useRef(null);
    const id = useId();
    if (!element) return null;
    const opacityPct = Math.round((element.opacity ?? 1) * 100);

    async function replace(file) {
        if (!file) return;
        if (!/^image\/(png|jpeg|webp|gif)$/.test(file.type)) {
            onError(t('Please choose a PNG, JPG or WebP image.'));
            return;
        }
        try {
            const image = await loadImageFile(file);
            const ratio = image.height / image.width || 1;
            onChange({ dataUrl: image.dataUrl, bytes: image.bytes, format: image.format, height: element.width * ratio });
        } catch {
            onError(t('Could not read that image.'));
        }
    }

    return (
        <div className="row" role="group" aria-label={element.signature ? t('Selected signature') : t('Selected image')} style={{ gap: '0.6rem' }}>
            <label className="field__label" htmlFor={id} style={{ margin: 0 }}>
                {t('Opacity: {value}%', { value: opacityPct })}
            </label>
            <input
                id={id}
                className="range"
                type="range"
                min={10}
                max={100}
                step={5}
                value={opacityPct}
                style={{ maxWidth: '140px' }}
                onChange={(e) => onChange({ opacity: Number(e.target.value) / 100 })}
            />
            <button type="button" className="btn btn--sm" onClick={() => inputRef.current?.click()}>
                {element.signature ? t('Replace signature image') : t('Replace image')}
            </button>
            <input
                ref={inputRef}
                type="file"
                accept="image/png,image/jpeg,image/webp"
                hidden
                onChange={(e) => {
                    replace(e.target.files?.[0]);
                    e.target.value = '';
                }}
            />
        </div>
    );
}
