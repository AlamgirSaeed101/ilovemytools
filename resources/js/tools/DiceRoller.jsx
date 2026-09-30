import { useEffect, useRef, useState } from 'react';
import { DICE_SIDES, MAX_DICE, rollDice } from '../lib/random.js';
import { useReducedMotion, useShortcuts } from '../lib/motion.js';
import { t, tn } from '../lib/i18n.js';

const ROLL_MS = 1100;

// Which pip cells (3x3 grid, 0-8) are filled for each face of a six-sided die.
const PIPS = { 1: [4], 2: [2, 6], 3: [2, 4, 6], 4: [0, 2, 6, 8], 5: [0, 2, 4, 6, 8], 6: [0, 2, 3, 5, 6, 8] };

// Cube rotation that brings each face to the front (faces: front 1, right 2, top 3, bottom 4, left 5, back 6).
const FACE_ROTATION = { 1: [0, 0], 2: [0, -90], 3: [-90, 0], 4: [90, 0], 5: [0, 90], 6: [0, 180] };
const FACE_PLACEMENT = { 1: 'rotateY(0deg)', 2: 'rotateY(90deg)', 3: 'rotateX(90deg)', 4: 'rotateX(-90deg)', 5: 'rotateY(-90deg)', 6: 'rotateY(180deg)' };

function Face({ value }) {
    return (
        <div className={`cube__face cube__face--${value}`} style={{ transform: `${FACE_PLACEMENT[value]} translateZ(var(--half))` }}>
            {Array.from({ length: 9 }, (_, i) => (
                <span key={i} className={PIPS[value].includes(i) ? 'pip' : 'pip pip--off'} />
            ))}
        </div>
    );
}

/** A 3D six-sided die. `spin` grows by whole turns on every roll so it always tumbles. */
function Cube({ value, spin, rolling, reduced }) {
    const [x, y] = FACE_ROTATION[value];
    return (
        <div className={`cube-wrap${rolling ? ' is-rolling' : ''}`}>
            <div className="cube-tilt">
                <div
                    className="cube"
                    style={{
                        transform: `rotateX(${x + spin.x * 360}deg) rotateY(${y + spin.y * 360}deg)`,
                        transitionDuration: reduced ? '0ms' : `${ROLL_MS}ms`,
                    }}
                >
                    {[1, 2, 3, 4, 5, 6].map((v) => (
                        <Face key={v} value={v} />
                    ))}
                </div>
            </div>
            <div className="cube-shadow" aria-hidden="true" />
        </div>
    );
}

const SHAPES = { 4: 'd4', 8: 'd8', 10: 'd10', 12: 'd12', 20: 'd20', 100: 'd100' };

/** Other dice: a shaped token that tumbles while the number flickers, then settles. */
function PolyDie({ sides, value, rolling, reduced }) {
    const [shown, setShown] = useState(value);
    useEffect(() => {
        if (!rolling || reduced) {
            setShown(value);
            return undefined;
        }
        // Purely visual flicker while tumbling; the real result is already decided.
        const id = setInterval(() => setShown(1 + Math.floor(Math.random() * sides)), 70);
        return () => clearInterval(id);
    }, [rolling, value, sides, reduced]);

    return (
        <div className={`poly-die poly-die--${SHAPES[sides] || 'd100'}${rolling ? ' is-rolling' : ''}`}>
            <span className="poly-die__value">{shown}</span>
            <span className="poly-die__label">d{sides}</span>
        </div>
    );
}

export default function DiceRoller() {
    const reduced = useReducedMotion();
    const [count, setCount] = useState(2);
    const [sides, setSides] = useState(6);
    const [values, setValues] = useState([6, 6]);
    const [spins, setSpins] = useState(() => Array.from({ length: MAX_DICE }, () => ({ x: 0, y: 0 })));
    const [rolling, setRolling] = useState(false);
    const [result, setResult] = useState(null); // { values, total, sides }
    const [history, setHistory] = useState([]);
    const timer = useRef();

    useEffect(() => () => clearTimeout(timer.current), []);

    function roll() {
        if (rolling) return;
        const next = rollDice(count, sides);
        setValues(next.values);
        // Each die tumbles a different number of turns, so they don't move in lockstep.
        setSpins((s) => s.map((spin, i) => ({ x: spin.x + 2 + ((i * 7 + history.length) % 3), y: spin.y + 2 + ((i * 5 + history.length) % 2) })));
        setRolling(true);
        setResult(null);
        clearTimeout(timer.current);
        timer.current = setTimeout(() => {
            setRolling(false);
            setResult(next);
            setHistory((h) => [next, ...h].slice(0, 12));
        }, reduced ? 0 : ROLL_MS);
    }

    useShortcuts({ r: roll, ' ': roll, enter: roll });

    function changeCount(n) {
        const c = Math.max(1, Math.min(MAX_DICE, n));
        setCount(c);
        setResult(null);
        setValues((v) => Array.from({ length: c }, (_, i) => Math.min(v[i] ?? sides, sides)));
    }

    function changeSides(s) {
        setSides(s);
        setResult(null);
        setValues((v) => v.map(() => s));
    }

    return (
        <div className="stack">
            <div className="dice-controls">
                <div className="field">
                    <span className="field__label" id="dice-type">{t('Type of dice')}</span>
                    <div className="seg" role="radiogroup" aria-labelledby="dice-type">
                        {DICE_SIDES.map((s) => (
                            <button key={s} type="button" role="radio" aria-checked={sides === s} onClick={() => changeSides(s)} disabled={rolling}>
                                d{s}
                            </button>
                        ))}
                    </div>
                </div>
                <div className="field">
                    <span className="field__label" id="dice-count">{t('Number of dice')}</span>
                    <div className="stepper" role="group" aria-labelledby="dice-count">
                        <button type="button" onClick={() => changeCount(count - 1)} disabled={count <= 1 || rolling} aria-label={t('Fewer dice')}>−</button>
                        <output aria-live="polite" data-testid="dice-count">{count}</output>
                        <button type="button" onClick={() => changeCount(count + 1)} disabled={count >= MAX_DICE || rolling} aria-label={t('More dice')}>+</button>
                    </div>
                </div>
            </div>

            <div className={`dice-stage${sides === 6 ? ' dice-stage--3d' : ''}`} onClick={roll} role="presentation">
                {values.map((v, i) =>
                    sides === 6 ? (
                        <Cube key={i} value={v} spin={spins[i]} rolling={rolling} reduced={reduced} />
                    ) : (
                        <PolyDie key={`${sides}-${i}`} sides={sides} value={v} rolling={rolling} reduced={reduced} />
                    ),
                )}
            </div>

            <div className="dice-result" aria-live="polite" data-testid="dice-result">
                {rolling && <span className="dice-result__rolling">{t('Rolling…')}</span>}
                {!rolling && result && (
                    <span className="pop-in" key={history.length}>
                        {result.values.length > 1 && <span className="dice-result__sum">{result.values.join(' + ')} = </span>}
                        <strong className="dice-result__total">{result.total}</strong>
                    </span>
                )}
                {!rolling && !result && <span className="dice-result__hint">{t('Press Roll, tap the dice, or press R')}</span>}
            </div>

            <button type="button" className="btn btn--primary btn--lg btn--block" onClick={roll} disabled={rolling}>
                {rolling ? t('Rolling…') : tn('Roll {count} die', 'Roll {count} dice', count)}
            </button>

            {history.length > 0 && (
                <div className="field">
                    <div className="row row--between">
                        <span className="field__label">{t('Roll history')}</span>
                        <button type="button" className="btn btn--ghost btn--sm" onClick={() => setHistory([])}>{t('Clear')}</button>
                    </div>
                    <ol className="history" reversed>
                        {history.map((h, i) => (
                            <li key={history.length - i} className={i === 0 ? 'history__item is-new' : 'history__item'}>
                                <span className="history__meta">{h.values.length}d{h.sides}</span>
                                <span className="history__values">{h.values.join(', ')}</span>
                                <strong>{h.total}</strong>
                            </li>
                        ))}
                    </ol>
                </div>
            )}
        </div>
    );
}
