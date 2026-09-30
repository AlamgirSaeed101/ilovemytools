import { useCallback, useEffect, useState } from 'react';
import CopyButton from '../components/CopyButton.jsx';
import { Notice } from '../components/ui.jsx';
import { entropyBits, generatePassword, MAX_LENGTH, MIN_LENGTH, strength } from '../lib/password.js';
import { formatNumber, t } from '../lib/i18n.js';

const OPTIONS = [
    { key: 'upper', label: 'Uppercase (A-Z)' },
    { key: 'lower', label: 'Lowercase (a-z)' },
    { key: 'numbers', label: 'Numbers (0-9)' },
    { key: 'symbols', label: 'Symbols (!@#$…)' },
    { key: 'excludeSimilar', label: 'Exclude similar (l, 1, O, 0)' },
];

export default function PasswordGenerator() {
    const [options, setOptions] = useState({ length: 16, upper: true, lower: true, numbers: true, symbols: true, excludeSimilar: false });
    const [password, setPassword] = useState('');
    const [error, setError] = useState('');
    const [lengthDraft, setLengthDraft] = useState(null);

    const generate = useCallback(() => {
        try {
            setPassword(generatePassword(options));
            setError('');
        } catch (e) {
            setPassword('');
            setError(e.message);
        }
    }, [options]);

    // Regenerate whenever the options change (and on first load).
    useEffect(() => {
        generate();
    }, [generate]);

    const bits = entropyBits(options);
    const s = strength(bits);
    const noneSelected = !options.upper && !options.lower && !options.numbers && !options.symbols;

    return (
        <div className="stack">
            <div className="field">
                <label className="field__label" htmlFor="pw-output">{t('Your password')}</label>
                <div className="output-box">
                    <input
                        id="pw-output"
                        className="output-box__value"
                        style={{ border: 0, outline: 0, background: 'transparent', minWidth: 0 }}
                        value={password}
                        readOnly
                        aria-describedby="pw-strength"
                        onFocus={(e) => e.target.select()}
                    />
                    <button type="button" className="btn btn--sm" onClick={generate} disabled={noneSelected} aria-label={t('Generate a new password')}>
                        ↻ {t('New')}
                    </button>
                    <CopyButton text={password} className="btn btn--sm btn--primary" />
                </div>
            </div>

            <div>
                <div className="meter" aria-hidden="true">
                    <div className="meter__bar" style={{ width: `${noneSelected ? 0 : s.percent}%`, background: s.color }} />
                </div>
                <p id="pw-strength" className="field__hint" style={{ marginTop: '.35rem' }}>
                    {t('Strength:')} <strong style={{ color: s.color }}>{noneSelected ? '—' : s.label}</strong>
                    {!noneSelected && ` · ${t('{bits} bits of entropy', { bits: formatNumber(bits) })}`}
                </p>
            </div>

            <div className="field">
                <label className="field__label" htmlFor="pw-length">
                    {t('Length:')} <strong>{formatNumber(options.length)}</strong> {t('characters')}
                </label>
                <div className="row" style={{ flexWrap: 'nowrap' }}>
                    <input
                        id="pw-length"
                        className="range"
                        type="range"
                        min={MIN_LENGTH}
                        max={MAX_LENGTH}
                        value={options.length}
                        onChange={(e) => {
                            setLengthDraft(null);
                            setOptions((o) => ({ ...o, length: Number(e.target.value) }));
                        }}
                    />
                    <input
                        className="input"
                        style={{ width: 84 }}
                        type="number"
                        inputMode="numeric"
                        min={MIN_LENGTH}
                        max={MAX_LENGTH}
                        value={lengthDraft ?? options.length}
                        aria-label={t('Password length')}
                        onChange={(e) => {
                            // Let people type freely; only apply valid lengths.
                            setLengthDraft(e.target.value);
                            const n = Math.floor(Number(e.target.value));
                            if (e.target.value !== '' && n >= MIN_LENGTH && n <= MAX_LENGTH) {
                                setOptions((o) => ({ ...o, length: n }));
                            }
                        }}
                        onBlur={() => setLengthDraft(null)}
                    />
                </div>
            </div>

            <fieldset className="grid-2" style={{ border: 0, padding: 0, margin: 0 }}>
                <legend className="sr-only">{t('Characters to include')}</legend>
                {OPTIONS.map((opt) => (
                    <label key={opt.key} className="check">
                        <input
                            type="checkbox"
                            checked={options[opt.key]}
                            onChange={(e) => setOptions((o) => ({ ...o, [opt.key]: e.target.checked }))}
                        />
                        {t(opt.label)}
                    </label>
                ))}
            </fieldset>

            <Notice type="error">{error}</Notice>

            <button type="button" className="btn btn--primary btn--lg" onClick={generate} disabled={noneSelected}>
                {t('Generate password')}
            </button>
        </div>
    );
}
