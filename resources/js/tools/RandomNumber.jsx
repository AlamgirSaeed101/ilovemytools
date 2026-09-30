import { useEffect, useRef, useState } from 'react';
import CopyButton from '../components/CopyButton.jsx';
import { Notice } from '../components/ui.jsx';
import { MAX_NUMBERS, randomNumbers } from '../lib/random.js';
import { useReducedMotion } from '../lib/motion.js';
import { formatNumber, t, tn } from '../lib/i18n.js';
import { parseLocaleInteger } from '../lib/numbers.js';

const REVEAL_MS = 800;

const PRESETS = [
    { label: () => '1 – 10', min: 1, max: 10, count: 1, unique: false, sort: false },
    { label: () => '1 – 100', min: 1, max: 100, count: 1, unique: false, sort: false },
    { label: () => t('Dice (1 – 6)'), min: 1, max: 6, count: 1, unique: false, sort: false },
    { label: () => t('Lottery 6 of 49'), min: 1, max: 49, count: 6, unique: true, sort: true },
    { label: () => t('5 of 1 – {max}', { max: formatNumber(1000) }), min: 1, max: 1000, count: 5, unique: true, sort: false },
];

// Whole numbers typed in any style: 1000, 1,000, 1.000 or 1 000.
const toInt = (value) => parseLocaleInteger(value);

export default function RandomNumber() {
    const reduced = useReducedMotion();
    const [form, setForm] = useState({ min: '1', max: '100', count: '1', unique: false, sort: false });
    const [result, setResult] = useState(null); // { values, id }
    const [display, setDisplay] = useState(null); // number shown during the reveal
    const [revealing, setRevealing] = useState(false);
    const [error, setError] = useState('');
    const [history, setHistory] = useState([]);
    const timers = useRef([]);

    const clearTimers = () => {
        timers.current.forEach((id) => clearTimeout(id) || clearInterval(id));
        timers.current = [];
    };
    useEffect(() => clearTimers, []);

    const set = (key) => (e) => setForm((f) => ({ ...f, [key]: e.target.type === 'checkbox' ? e.target.checked : e.target.value }));

    function generate(values = form) {
        clearTimers();
        const min = toInt(values.min);
        const max = toInt(values.max);
        const count = toInt(values.count);
        let numbers;
        try {
            if (Number.isNaN(min) || Number.isNaN(max)) throw new Error(t('Enter whole numbers for the minimum and maximum.'));
            if (Number.isNaN(count)) throw new Error(t('Enter how many numbers you want.'));
            numbers = randomNumbers({ min, max, count, unique: values.unique, sort: values.sort });
        } catch (e) {
            setError(e.message);
            setResult(null);
            return;
        }
        setError('');
        const id = Date.now();

        if (numbers.length === 1 && !reduced) {
            // Slot-machine style reveal: fast random digits that slow down, then the real result.
            setRevealing(true);
            setResult(null);
            const spinId = setInterval(() => setDisplay(min + Math.floor(Math.random() * (max - min + 1))), 55);
            timers.current.push(spinId);
            timers.current.push(
                setTimeout(() => {
                    clearInterval(spinId);
                    setRevealing(false);
                    setDisplay(numbers[0]);
                    setResult({ values: numbers, id });
                    setHistory((h) => [numbers[0], ...h].slice(0, 15));
                }, REVEAL_MS),
            );
        } else {
            setRevealing(false);
            setDisplay(numbers.length === 1 ? numbers[0] : null);
            setResult({ values: numbers, id });
            if (numbers.length === 1) setHistory((h) => [numbers[0], ...h].slice(0, 15));
        }
    }

    function applyPreset(p) {
        const next = { min: String(p.min), max: String(p.max), count: String(p.count), unique: p.unique, sort: p.sort };
        setForm(next);
        generate(next);
    }

    const single = revealing || (result && result.values.length === 1);

    return (
        <div className="stack">
            <div className="chips chips--left" role="group" aria-label={t('Presets')}>
                {PRESETS.map((p) => (
                    <button key={p.min + '-' + p.max + '-' + p.count} type="button" className="chip" onClick={() => applyPreset(p)} disabled={revealing}>
                        {p.label()}
                    </button>
                ))}
            </div>

            <form
                className="stack"
                onSubmit={(e) => {
                    e.preventDefault();
                    generate();
                }}
            >
                <div className="rng-fields">
                    <div className="field">
                        <label className="field__label" htmlFor="rng-min">{t('Minimum')}</label>
                        <input id="rng-min" className="input" inputMode="numeric" value={form.min} onChange={set('min')} autoComplete="off" />
                    </div>
                    <div className="field">
                        <label className="field__label" htmlFor="rng-max">{t('Maximum')}</label>
                        <input id="rng-max" className="input" inputMode="numeric" value={form.max} onChange={set('max')} autoComplete="off" />
                    </div>
                    <div className="field">
                        <label className="field__label" htmlFor="rng-count">{t('How many')}</label>
                        <input id="rng-count" className="input" type="number" min={1} max={MAX_NUMBERS} inputMode="numeric" value={form.count} onChange={set('count')} />
                    </div>
                </div>
                <div className="row">
                    <label className="check"><input type="checkbox" checked={form.unique} onChange={set('unique')} /> {t('No duplicates')}</label>
                    <label className="check"><input type="checkbox" checked={form.sort} onChange={set('sort')} /> {t('Sort low to high')}</label>
                </div>
                <button type="submit" className="btn btn--primary btn--lg btn--block" disabled={revealing}>
                    {revealing ? t('Picking…') : t('Generate')}
                </button>
            </form>

            <Notice type="error">{error}</Notice>

            {single && display !== null && (
                <div className={`rng-big${revealing ? ' is-revealing' : ' is-final'}`} aria-live="polite">
                    <span className="rng-big__value" data-testid="rng-value" key={revealing ? 'spin' : result?.id}>
                        {formatNumber(display)}
                    </span>
                </div>
            )}

            {result && result.values.length > 1 && (
                <div className="field">
                    <div className="row row--between">
                        <span className="field__label">{tn('{count} number', '{count} numbers', result.values.length)}</span>
                        <CopyButton text={result.values.join(', ')} className="btn btn--sm btn--primary" label={t('Copy all')} />
                    </div>
                    <ul className="rng-list" data-testid="rng-list" aria-live="polite">
                        {result.values.map((v, i) => (
                            <li key={`${result.id}-${i}`} className="pop-in" style={{ animationDelay: reduced ? undefined : `${Math.min(i * 25, 800)}ms` }}>
                                {formatNumber(v)}
                            </li>
                        ))}
                    </ul>
                </div>
            )}

            {history.length > 1 && (
                <p className="field__hint" style={{ margin: 0 }}>
                    {t('Previous:')} {history.slice(1).map((v) => formatNumber(v)).join(', ')}
                </p>
            )}
        </div>
    );
}
