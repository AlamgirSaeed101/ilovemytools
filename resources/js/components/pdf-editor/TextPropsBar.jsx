import { useEffect, useId, useState } from 'react';
import { Notice } from '../ui.jsx';
import { t } from '../../lib/i18n.js';

const SIZE_PRESETS = [8, 9, 10, 11, 12, 14, 16, 18, 20, 24, 28, 32, 36, 48, 64, 72];
const LINE_HEIGHTS = [1, 1.15, 1.2, 1.5, 2];
const ALIGNMENTS = [
    { id: 'left', label: () => t('Align left'), lines: [[2, 14], [2, 10], [2, 14], [2, 8]] },
    { id: 'center', label: () => t('Align centre'), lines: [[2, 14], [4, 12], [2, 14], [5, 11]] },
    { id: 'right', label: () => t('Align right'), lines: [[2, 14], [6, 14], [2, 14], [8, 14]] },
];

function AlignIcon({ lines }) {
    return (
        <svg width="16" height="16" viewBox="0 0 16 16" aria-hidden="true" focusable="false">
            {lines.map(([x1, x2], i) => (
                <line key={i} x1={x1} x2={x2} y1={3 + i * 3.5} y2={3 + i * 3.5} stroke="currentColor" strokeWidth="1.6" strokeLinecap="round" />
            ))}
        </svg>
    );
}

/**
 * Font family, size, colour, bold, italic, alignment and line spacing for the selected text (an
 * edit of the PDF's own text, or added text). `value`: { family, size, color, bold, italic, align,
 * lineHeight }; `onChange(changes)` gets only what changed. "Original font" is offered when the PDF
 * embeds the text's font (`originalFontAvailable`); `originalStyle` ({ bold, italic }) is that
 * font's own style, so switching away from it can warn that a similar font will be used.
 */
export default function TextPropsBar({ value, onChange, originalFontAvailable = false, originalStyle = null }) {
    const id = useId();
    const [sizeDraft, setSizeDraft] = useState(String(Math.round((value.size ?? 12) * 10) / 10));
    useEffect(() => setSizeDraft(String(Math.round((value.size ?? 12) * 10) / 10)), [value.size]);

    const families = [
        ...(originalFontAvailable ? [{ id: 'original', label: t('Original font') }] : []),
        { id: 'sans', label: t('Sans-serif') },
        { id: 'serif', label: t('Serif') },
        { id: 'mono', label: t('Monospace') },
    ];
    const family = value.family === 'original' && !originalFontAvailable ? 'sans' : value.family ?? 'sans';
    const lineHeight = Math.round((value.lineHeight ?? 1.2) * 100) / 100;
    const bold = Boolean(value.bold);
    const italic = Boolean(value.italic);
    const styleChanged = originalStyle && family === 'original' && (bold !== Boolean(originalStyle.bold) || italic !== Boolean(originalStyle.italic));

    function changeSize(raw) {
        setSizeDraft(raw);
        const size = Number(raw);
        if (Number.isFinite(size) && size >= 4 && size <= 200) onChange({ size });
    }

    return (
        <>
            <div className="pdf-editor__textprops" role="group" aria-label={t('Text properties')}>
                <select className="select" value={family} onChange={(e) => onChange({ family: e.target.value })} aria-label={t('Font')}>
                    {families.map((f) => (
                        <option key={f.id} value={f.id}>{f.label}</option>
                    ))}
                </select>
                <input
                    className="input pdf-editor__textprops-size"
                    type="number"
                    min={4}
                    max={200}
                    step={0.5}
                    list={`${id}-sizes`}
                    value={sizeDraft}
                    onChange={(e) => changeSize(e.target.value)}
                    onBlur={() => setSizeDraft(String(Math.round((value.size ?? 12) * 10) / 10))}
                    aria-label={t('Font size')}
                />
                <datalist id={`${id}-sizes`}>
                    {SIZE_PRESETS.map((s) => <option key={s} value={s} />)}
                </datalist>
                <input type="color" value={value.color ?? '#000000'} onChange={(e) => onChange({ color: e.target.value })} aria-label={t('Text colour')} />
                <span className="pdf-editor__textprops-group">
                    <button type="button" className={`btn btn--sm pdf-editor__textprops-btn${bold ? ' is-active' : ''}`} aria-pressed={bold} onClick={() => onChange({ bold: !bold })} title={t('Bold')} aria-label={t('Bold')}>
                        <strong aria-hidden="true">B</strong>
                    </button>
                    <button type="button" className={`btn btn--sm pdf-editor__textprops-btn${italic ? ' is-active' : ''}`} aria-pressed={italic} onClick={() => onChange({ italic: !italic })} title={t('Italic')} aria-label={t('Italic')}>
                        <em aria-hidden="true" style={{ fontFamily: 'Georgia, serif' }}>I</em>
                    </button>
                </span>
                <span className="pdf-editor__textprops-group" role="group" aria-label={t('Alignment')}>
                    {ALIGNMENTS.map((a) => (
                        <button
                            key={a.id}
                            type="button"
                            className={`btn btn--sm pdf-editor__textprops-btn${(value.align ?? 'left') === a.id ? ' is-active' : ''}`}
                            aria-pressed={(value.align ?? 'left') === a.id}
                            onClick={() => onChange({ align: a.id })}
                            title={a.label()}
                            aria-label={a.label()}
                        >
                            <AlignIcon lines={a.lines} />
                        </button>
                    ))}
                </span>
                <select
                    className="select pdf-editor__textprops-lh"
                    value={String(lineHeight)}
                    onChange={(e) => onChange({ lineHeight: Number(e.target.value) })}
                    aria-label={t('Line spacing')}
                >
                    {[...new Set([...LINE_HEIGHTS, lineHeight])]
                        .sort((a, b) => a - b)
                        .map((lh) => (
                            <option key={lh} value={String(lh)}>
                                {t('Line spacing {value}', { value: lh })}
                            </option>
                        ))}
                </select>
            </div>
            {styleChanged && <Notice type="warn">{t('The PDF’s own font has no bold or italic version for this text, so a similar standard font is used.')}</Notice>}
        </>
    );
}
