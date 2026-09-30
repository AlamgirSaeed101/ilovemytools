import { useEffect, useRef, useState } from 'react';
import { coinStats, flipCoins } from '../lib/random.js';
import { useReducedMotion, useShortcuts } from '../lib/motion.js';
import { formatNumber, t } from '../lib/i18n.js';

const FLIP_MS = 1700;
const LAND_AT = 0.72; // share of the animation spent in the air before the first bounce
// Thin discs stacked between the two faces give the coin a visible metal edge.
const EDGE = [-4.5, -3.5, -2.5, -1.5, -0.5, 0.5, 1.5, 2.5, 3.5, 4.5];
const COUNTS = [1, 2, 5, 10, 25, 100];
const label = (side) => (side === 'heads' ? t('Heads') : t('Tails'));
// First letter shown on the coin (translators give the local initial, e.g. C for "cara").
const initial = (side) => (side === 'heads' ? t('H') : t('T'));

export default function CoinFlip() {
    const reduced = useReducedMotion();
    const [count, setCount] = useState(1);
    const [rotation, setRotation] = useState(0); // degrees around X (end over end); 0 = heads up
    const [tosses, setTosses] = useState(0);
    const [flipping, setFlipping] = useState(false);
    const [last, setLast] = useState(null); // array of results from the latest flip
    const [history, setHistory] = useState([]); // every single coin result, oldest first
    const timer = useRef();
    const coinRef = useRef(null);
    const tossRef = useRef(null);
    const shadowRef = useRef(null);

    /**
     * A real toss: the coin rises (slowing down), falls (speeding up), tumbles
     * end over end the whole time, then bounces and wobbles to rest on the result.
     */
    function animateToss(from, to) {
        const coin = coinRef.current;
        const toss = tossRef.current;
        const shadow = shadowRef.current;
        if (!coin?.animate || !toss || !shadow) return;
        const up = 'cubic-bezier(0.2, 0.7, 0.4, 1)'; // decelerating rise
        const down = 'cubic-bezier(0.6, 0, 0.8, 0.5)'; // accelerating fall
        const half = LAND_AT / 2;

        coin.animate(
            [
                { transform: `rotateX(${from}deg)`, easing: 'cubic-bezier(0.25, 0.6, 0.35, 1)' },
                { transform: `rotateX(${to - 10}deg)`, offset: LAND_AT, easing: 'ease-out' },
                { transform: `rotateX(${to + 16}deg)`, offset: LAND_AT + 0.08, easing: 'ease-in-out' },
                { transform: `rotateX(${to - 7}deg)`, offset: LAND_AT + 0.16, easing: 'ease-in-out' },
                { transform: `rotateX(${to + 2}deg)`, offset: LAND_AT + 0.23 },
                { transform: `rotateX(${to}deg)` },
            ],
            { duration: FLIP_MS },
        );
        toss.animate(
            [
                { transform: 'translateY(0) scale(1)', easing: up },
                { transform: 'translateY(-96px) scale(1.14)', offset: half, easing: down },
                { transform: 'translateY(0) scale(1)', offset: LAND_AT, easing: up },
                { transform: 'translateY(-14px) scale(1.02)', offset: LAND_AT + 0.08, easing: down },
                { transform: 'translateY(0) scale(1)', offset: LAND_AT + 0.16 },
                { transform: 'translateY(0) scale(1)' },
            ],
            { duration: FLIP_MS },
        );
        shadow.animate(
            [
                { transform: 'scale(1)', opacity: 1, easing: up },
                { transform: 'scale(0.45)', opacity: 0.35, offset: half, easing: down },
                { transform: 'scale(1)', opacity: 1, offset: LAND_AT, easing: up },
                { transform: 'scale(0.85)', opacity: 0.8, offset: LAND_AT + 0.08, easing: down },
                { transform: 'scale(1)', opacity: 1, offset: LAND_AT + 0.16 },
                { transform: 'scale(1)', opacity: 1 },
            ],
            { duration: FLIP_MS },
        );
    }

    useEffect(() => () => clearTimeout(timer.current), []);

    function flip() {
        if (flipping) return;
        const results = flipCoins(count);
        if (count === 1) {
            // 7-9 full turns (varied so every toss looks different), landing with the result face up.
            const from = rotation;
            const turns = 7 + (tosses % 3);
            const to = Math.ceil(from / 360) * 360 + turns * 360 + (results[0] === 'tails' ? 180 : 0);
            setRotation(to);
            if (!reduced) animateToss(from, to);
        }
        setTosses((n) => n + 1);
        setFlipping(true);
        setLast(null);
        clearTimeout(timer.current);
        timer.current = setTimeout(() => {
            setFlipping(false);
            setLast(results);
            setHistory((h) => [...h, ...results].slice(-1000));
        }, reduced || count > 1 ? (reduced ? 0 : 500) : FLIP_MS);
    }

    useShortcuts({ f: flip, ' ': flip, enter: flip });

    const stats = coinStats(history);
    const headsPct = stats.total ? Math.round((stats.heads / stats.total) * 100) : 50;

    return (
        <div className="stack">
            <div className="field">
                <span className="field__label" id="coin-count">{t('Coins per flip')}</span>
                <div className="seg" role="radiogroup" aria-labelledby="coin-count">
                    {COUNTS.map((c) => (
                        <button key={c} type="button" role="radio" aria-checked={count === c} onClick={() => { setCount(c); setLast(null); }} disabled={flipping}>
                            {c}
                        </button>
                    ))}
                </div>
            </div>

            {count === 1 ? (
                <div className="coin-stage" onClick={flip} role="presentation">
                    <div className={`coin-toss${flipping && !reduced ? ' is-tossing' : ''}`} ref={tossRef}>
                        <div className="coin" ref={coinRef} data-rotation={rotation} style={{ transform: `rotateX(${rotation}deg)` }}>
                            <div className="coin__face coin__face--heads"><span>{initial('heads')}</span><small>{label('heads')}</small></div>
                            {EDGE.map((z) => (
                                <i key={z} className="coin__edge" style={{ transform: `translateZ(${z}px)` }} />
                            ))}
                            <div className="coin__face coin__face--tails"><span>{initial('tails')}</span><small>{label('tails')}</small></div>
                        </div>
                    </div>
                    <div className="coin-shadow" ref={shadowRef} aria-hidden="true" />
                </div>
            ) : (
                <div className="coin-grid" aria-hidden={flipping}>
                    {(last ?? Array.from({ length: count }, () => null)).map((side, i) => (
                        <span
                            key={`${tosses}-${i}`}
                            className={`mini-coin${side ? ` mini-coin--${side} pop-in` : ' is-spinning'}`}
                            style={{ animationDelay: side && !reduced ? `${Math.min(i * 12, 600)}ms` : undefined }}
                            title={side ? label(side) : undefined}
                        >
                            {side ? initial(side) : ''}
                        </span>
                    ))}
                </div>
            )}

            <div className="dice-result" aria-live="polite" data-testid="coin-result">
                {flipping && <span className="dice-result__rolling">{t('Flipping…')}</span>}
                {!flipping && last && last.length === 1 && (
                    <strong className="dice-result__total pop-in" key={tosses}>{last[0] === 'heads' ? t('Heads!') : t('Tails!')}</strong>
                )}
                {!flipping && last && last.length > 1 && (
                    <span className="pop-in" key={tosses}>
                        <strong className="dice-result__total">{formatNumber(last.filter((s) => s === 'heads').length)}</strong> {t('heads')} ·{' '}
                        <strong className="dice-result__total">{formatNumber(last.filter((s) => s === 'tails').length)}</strong> {t('tails')}
                    </span>
                )}
                {!flipping && !last && <span className="dice-result__hint">{t('Press Flip, tap the coin, or press F')}</span>}
            </div>

            <button type="button" className="btn btn--primary btn--lg btn--block" onClick={flip} disabled={flipping}>
                {flipping ? t('Flipping…') : count === 1 ? t('Flip the coin') : t('Flip {count} coins', { count })}
            </button>

            {stats.total > 0 && (
                <div className="coin-stats">
                    <div className="stats">
                        <div className="stat"><span className="stat__value" data-testid="heads-total">{stats.heads}</span><span className="stat__label">{t('Heads')}</span></div>
                        <div className="stat"><span className="stat__value" data-testid="tails-total">{stats.tails}</span><span className="stat__label">{t('Tails')}</span></div>
                        <div className="stat"><span className="stat__value">{stats.total}</span><span className="stat__label">{t('Total flips')}</span></div>
                        <div className="stat">
                            <span className="stat__value">{stats.streak.length}</span>
                            <span className="stat__label">{stats.streak.side === 'heads' ? t('Heads streak') : t('Tails streak')}</span>
                        </div>
                    </div>
                    <div className="split-bar" role="img" aria-label={t('{heads}% heads, {tails}% tails', { heads: headsPct, tails: 100 - headsPct })}>
                        <span className="split-bar__heads" style={{ width: `${headsPct}%` }}>{headsPct}% {initial('heads')}</span>
                        <span className="split-bar__tails">{100 - headsPct}% {initial('tails')}</span>
                    </div>
                    <div className="row row--between">
                        <div className="coin-trail" aria-label={t('Last flips')}>
                            {history.slice(-24).map((side, i) => (
                                <span key={history.length - 24 + i} className={`trail-dot trail-dot--${side}`} title={label(side)}>{initial(side)}</span>
                            ))}
                        </div>
                        <button type="button" className="btn btn--ghost btn--sm" onClick={() => { setHistory([]); setLast(null); }} disabled={flipping}>
                            {t('Reset stats')}
                        </button>
                    </div>
                </div>
            )}
        </div>
    );
}
