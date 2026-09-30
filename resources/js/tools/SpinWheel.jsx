import { useEffect, useMemo, useRef, useState } from 'react';
import { MAX_WHEEL_OPTIONS, parseOptions, randomOffset, segmentAt, wheelRotation } from '../lib/random.js';
import { randomInt } from '../lib/password.js';
import { useReducedMotion, useShortcuts } from '../lib/motion.js';
import { Notice } from '../components/ui.jsx';
import { t } from '../lib/i18n.js';

const SPIN_MS = 5200;
const COLORS = ['#6366f1', '#ec4899', '#f59e0b', '#10b981', '#3b82f6', '#ef4444', '#8b5cf6', '#14b8a6', '#f97316', '#84cc16'];
// Example entries, translated so the first view looks natural in every language.
const SAMPLE = ['Pizza', 'Burgers', 'Sushi', 'Tacos', 'Pasta', 'Salad', 'Curry', 'Ramen'];
const R = 160; // wheel radius in SVG units

function slicePath(i, n) {
    if (n === 1) return `M ${R} 0 A ${R} ${R} 0 1 1 ${R - 0.01} 0 Z`;
    const a0 = ((i / n) * 2 - 0.5) * Math.PI; // 0 = 12 o'clock, clockwise
    const a1 = (((i + 1) / n) * 2 - 0.5) * Math.PI;
    const x0 = R + R * Math.cos(a0);
    const y0 = R + R * Math.sin(a0);
    const x1 = R + R * Math.cos(a1);
    const y1 = R + R * Math.sin(a1);
    return `M ${R} ${R} L ${x0} ${y0} A ${R} ${R} 0 ${1 / n > 0.5 ? 1 : 0} 1 ${x1} ${y1} Z`;
}

const shorten = (text, max) => (Array.from(text).length > max ? `${Array.from(text).slice(0, max - 1).join('')}…` : text);

function colorFor(i, n) {
    // Avoid two neighbouring slices of the same colour where the wheel wraps around.
    const c = i % COLORS.length;
    return i === n - 1 && n > 1 && c === 0 ? COLORS[3] : COLORS[c];
}

/** A short burst of confetti pieces around the winner banner. */
function Confetti() {
    return (
        <span className="confetti" aria-hidden="true">
            {Array.from({ length: 18 }, (_, i) => (
                <i key={i} style={{ '--i': i, background: COLORS[i % COLORS.length] }} />
            ))}
        </span>
    );
}

export default function SpinWheel() {
    const reduced = useReducedMotion();
    const [text, setText] = useState(() => SAMPLE.map((s) => t(s)).join('\n'));
    const [rotation, setRotation] = useState(0);
    const [spinning, setSpinning] = useState(false);
    const [winner, setWinner] = useState(null); // { name, index, spin }
    const [removeWinner, setRemoveWinner] = useState(false);
    const [history, setHistory] = useState([]);
    const timer = useRef();

    useEffect(() => () => clearTimeout(timer.current), []);

    const options = useMemo(() => parseOptions(text), [text]);
    const n = options.length;
    const tooMany = text.split(/\r?\n/).filter((l) => l.trim()).length > MAX_WHEEL_OPTIONS;
    const fontSize = n <= 8 ? 15 : n <= 16 ? 12 : n <= 30 ? 9 : 7;
    const maxChars = n <= 8 ? 16 : n <= 16 ? 14 : 12;

    function spin() {
        if (spinning || n < 2) return;
        const index = randomInt(n);
        const next = wheelRotation(rotation, index, n, { offset: randomOffset() });
        const name = options[index];
        setWinner(null);
        setSpinning(true);
        setRotation(next);
        clearTimeout(timer.current);
        timer.current = setTimeout(() => {
            setSpinning(false);
            // Read the result from the final angle, so what you see is what you get.
            const landed = segmentAt(next, n);
            setWinner({ name: options[landed] ?? name, index: landed, spin: Date.now() });
            setHistory((h) => [options[landed] ?? name, ...h].slice(0, 10));
        }, reduced ? 0 : SPIN_MS);
    }

    useShortcuts({ s: spin, ' ': spin, enter: spin });

    // Takes the winner off the list but keeps the announcement on screen.
    function removeCurrentWinner() {
        if (!winner || winner.removed) return;
        const lines = text.split(/\r?\n/);
        let seen = -1;
        const kept = lines.filter((line) => {
            if (!line.trim()) return true;
            seen++;
            return seen !== winner.index;
        });
        setText(kept.join('\n'));
        setWinner((w) => (w ? { ...w, removed: true } : w));
    }

    // "Remove winner after spin": take it off shortly after the result shows.
    useEffect(() => {
        if (!winner || winner.removed || !removeWinner) return undefined;
        const id = setTimeout(removeCurrentWinner, reduced ? 0 : 1600);
        return () => clearTimeout(id);
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [winner, removeWinner]);

    function shuffle() {
        const list = [...options];
        for (let i = list.length - 1; i > 0; i--) {
            const j = randomInt(i + 1);
            [list[i], list[j]] = [list[j], list[i]];
        }
        setText(list.join('\n'));
        setWinner(null);
    }

    return (
        <div className="wheel-layout">
            <div className="wheel-area">
                <div className={`wheel${spinning ? ' is-spinning' : ''}`}>
                    <div className="wheel__pointer" aria-hidden="true" />
                    <svg
                        className="wheel__svg"
                        viewBox={`0 0 ${R * 2} ${R * 2}`}
                        role="img"
                        aria-label={t('Wheel with {count} entries', { count: n })}
                        style={{ transform: `rotate(${rotation}deg)`, transitionDuration: reduced || !spinning ? '0ms' : `${SPIN_MS}ms` }}
                    >
                        {n === 0 && <circle cx={R} cy={R} r={R} className="wheel__empty" />}
                        {options.map((name, i) => {
                            const mid = ((i + 0.5) / n) * 360;
                            return (
                                <g key={`${i}-${name}`} className={winner && !spinning && !winner.removed && winner.index === i ? 'wheel__slice is-winner' : 'wheel__slice'}>
                                    <path d={slicePath(i, n)} fill={colorFor(i, n)} />
                                    <text
                                        x={R}
                                        y={R}
                                        transform={`rotate(${mid - 90} ${R} ${R}) translate(${R * 0.93} 0)`}
                                        textAnchor="end"
                                        dominantBaseline="central"
                                        fontSize={fontSize}
                                    >
                                        {shorten(name, maxChars)}
                                    </text>
                                </g>
                            );
                        })}
                        <circle cx={R} cy={R} r={R - 1} className="wheel__rim" />
                    </svg>
                    <button type="button" className="wheel__hub" onClick={spin} disabled={spinning || n < 2} aria-label={t('Spin')}>
                        {t('SPIN')}
                    </button>
                </div>

                <div className="wheel-result" aria-live="polite" data-testid="wheel-result">
                    {spinning && <span className="dice-result__rolling">{t('Spinning…')}</span>}
                    {!spinning && winner && (
                        <div className="winner pop-in" key={winner.spin}>
                            {!reduced && <Confetti />}
                            <span className="winner__label">{winner.removed ? t('Picked and removed from the list') : t('The wheel picked')}</span>
                            <strong className="winner__name">{winner.name}</strong>
                        </div>
                    )}
                    {!spinning && (!winner || n < 2) && (
                        <span className="dice-result__hint">{n < 2 ? t('Add at least 2 entries to spin.') : t('Press Spin, or press S')}</span>
                    )}
                </div>
            </div>

            <div className="stack wheel-side">
                <div className="field">
                    <div className="row row--between">
                        <label className="field__label" htmlFor="wheel-entries">{t('Entries (one per line)')}</label>
                        <span className="field__hint">{n} / {MAX_WHEEL_OPTIONS}</span>
                    </div>
                    <textarea
                        id="wheel-entries"
                        className="textarea"
                        rows={9}
                        value={text}
                        disabled={spinning}
                        onChange={(e) => {
                            setText(e.target.value);
                            setWinner(null);
                        }}
                    />
                </div>
                {tooMany && <Notice type="warn">{t('Only the first {max} entries are used.', { max: MAX_WHEEL_OPTIONS })}</Notice>}
                <label className="check">
                    <input type="checkbox" checked={removeWinner} onChange={(e) => setRemoveWinner(e.target.checked)} /> {t('Remove the winner after each spin')}
                </label>
                <div className="row">
                    <button type="button" className="btn btn--primary btn--lg" onClick={spin} disabled={spinning || n < 2}>
                        {spinning ? t('Spinning…') : t('Spin the wheel')}
                    </button>
                    <button type="button" className="btn" onClick={shuffle} disabled={spinning || n < 2}>{t('Shuffle')}</button>
                    {winner && !winner.removed && !removeWinner && (
                        <button type="button" className="btn" onClick={removeCurrentWinner} disabled={spinning}>{t('Remove “{name}”', { name: shorten(winner.name, 12) })}</button>
                    )}
                    <button type="button" className="btn btn--ghost" onClick={() => { setText(''); setWinner(null); }} disabled={spinning || !text}>{t('Clear')}</button>
                </div>
                {history.length > 0 && (
                    <div className="field">
                        <span className="field__label">{t('Previous picks')}</span>
                        <ol className="pick-list">
                            {history.map((h, i) => (
                                <li key={`${history.length - i}-${h}`}>{h}</li>
                            ))}
                        </ol>
                    </div>
                )}
            </div>
        </div>
    );
}
