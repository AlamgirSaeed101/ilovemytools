import { useEffect, useMemo, useState } from 'react';
import { Notice, Tabs } from '../components/ui.jsx';
import { formatNumber, numberLocale, t, tn } from '../lib/i18n.js';
import {
    bedtimesFor,
    CYCLE_MINUTES,
    DEFAULT_FALL_ASLEEP,
    formatClock,
    formatSleep,
    parseTime,
    sleepDuration,
    wakeTimesFor,
} from '../lib/sleep.js';

const MODES = [
    { id: 'wake', label: 'Wake up at…' },
    { id: 'bed', label: 'Go to bed at…' },
    { id: 'now', label: 'Sleep now' },
    { id: 'duration', label: 'Hours slept' },
];

/** 12- or 24-hour clock, as usual for the page's language. */
function prefers12h() {
    try {
        const cycle = new Intl.DateTimeFormat(numberLocale(), { hour: 'numeric' }).resolvedOptions().hourCycle;
        return cycle === 'h12' || cycle === 'h11';
    } catch {
        return true;
    }
}

const minutesNow = () => {
    const d = new Date();
    return d.getHours() * 60 + d.getMinutes();
};

// Sleep stage depth for the chart (y in SVG units): lower = deeper sleep.
const STAGE_Y = { awake: 16, rem: 38, light: 62, deep: 100 };
const STAGE_NAMES = { awake: 'Awake', rem: 'REM', light: 'Light', deep: 'Deep' };

/** Points for one ~90 min cycle. Early cycles have more deep sleep, later ones more REM. */
function cyclePoints(index, total) {
    const deep = index < 2 ? STAGE_Y.deep : index < 3 ? 88 : 74;
    const remLen = Math.min(0.35, 0.12 + index * 0.06);
    return [
        [0, STAGE_Y.light],
        [0.12, 80],
        [0.25, deep],
        [0.5 - remLen / 3, deep],
        [0.68 - remLen / 2, STAGE_Y.light],
        [1 - remLen, STAGE_Y.rem],
        [index === total - 1 ? 0.98 : 1, STAGE_Y.rem],
    ];
}

/** Animated hypnogram: falling asleep, then each 90-minute cycle, then waking up. */
function SleepChart({ start, fallAsleep, cycles, extra = 0, hour12 }) {
    const W = 600;
    const H = 124;
    const total = fallAsleep + cycles * CYCLE_MINUTES + extra;
    if (cycles < 1 || total <= 0) return null;
    const x = (min) => 44 + (min / total) * (W - 56);

    const pts = [[x(0), STAGE_Y.awake], [x(fallAsleep * 0.7), STAGE_Y.awake]];
    for (let c = 0; c < cycles; c++) {
        const c0 = fallAsleep + c * CYCLE_MINUTES;
        cyclePoints(c, cycles).forEach(([f, y]) => pts.push([x(c0 + f * CYCLE_MINUTES), y]));
    }
    const end = fallAsleep + cycles * CYCLE_MINUTES;
    if (extra > 0) pts.push([x(end + extra * 0.4), STAGE_Y.light], [x(total), STAGE_Y.light]);
    pts.push([x(total), STAGE_Y.awake]);

    const path = pts.map(([px, py], i) => `${i ? 'L' : 'M'}${px.toFixed(1)} ${py}`).join(' ');
    const key = `${start}-${fallAsleep}-${cycles}-${extra}`;

    return (
        <figure className="sleep-chart" aria-label={t('Sleep chart: {cycles} cycles from {from} to {to}', { cycles, from: formatClock(start, hour12), to: formatClock(start + total, hour12) })}>
            <svg viewBox={`0 0 ${W} ${H + 22}`} role="img" aria-hidden="true">
                {Object.entries(STAGE_Y).map(([stage, y]) => (
                    <g key={stage}>
                        <line x1="44" x2={W - 12} y1={y} y2={y} className="sleep-chart__grid" />
                        <text x="38" y={y} className="sleep-chart__stage" textAnchor="end" dominantBaseline="central">
                            {t(STAGE_NAMES[stage])}
                        </text>
                    </g>
                ))}
                {Array.from({ length: cycles }, (_, c) => (
                    <rect
                        key={c}
                        x={x(fallAsleep + c * CYCLE_MINUTES)}
                        y="6"
                        width={x(fallAsleep + (c + 1) * CYCLE_MINUTES) - x(fallAsleep + c * CYCLE_MINUTES)}
                        height={H - 4}
                        className={c % 2 ? 'sleep-chart__band' : 'sleep-chart__band sleep-chart__band--alt'}
                        style={{ animationDelay: `${c * 120}ms` }}
                    />
                ))}
                <path key={key} d={path} className="sleep-chart__line" pathLength="1" />
                <text x={x(0)} y={H + 16} className="sleep-chart__time" textAnchor="start">{formatClock(start, hour12)}</text>
                <text x={x(total)} y={H + 16} className="sleep-chart__time" textAnchor="end">{formatClock(start + total, hour12)}</text>
            </svg>
            <figcaption className="field__hint">
                {t('Illustrative sleep stages: about {cycles} cycles of {minutes} minutes, with more deep sleep early in the night and more REM (dreaming) near morning.', { cycles, minutes: CYCLE_MINUTES })}
            </figcaption>
        </figure>
    );
}

function TimeCard({ option, best, selected, onSelect, hour12, index, verb }) {
    return (
        <button
            type="button"
            className={`sleep-card${selected ? ' is-selected' : ''}`}
            onClick={onSelect}
            aria-pressed={selected}
            style={{ animationDelay: `${index * 80}ms` }}
            data-testid="sleep-option"
        >
            {best && <span className="sleep-card__badge">{best}</span>}
            <span className="sleep-card__time">{formatClock(option.time, hour12)}</span>
            <span className="sleep-card__meta">
                {verb} · {tn('{count} cycle', '{count} cycles', option.cycles)} · {formatSleep(option.sleep)}
            </span>
        </button>
    );
}

export default function SleepCalculator() {
    const [mode, setMode] = useState('wake');
    const [wake, setWake] = useState('07:00');
    const [bed, setBed] = useState('22:30');
    const [fallAsleep, setFallAsleep] = useState(DEFAULT_FALL_ASLEEP);
    const [hour12, setHour12] = useState(prefers12h);
    const [selected, setSelected] = useState(5);
    const [now, setNow] = useState(minutesNow);

    useEffect(() => {
        if (mode !== 'now') return undefined;
        setNow(minutesNow());
        const id = setInterval(() => setNow(minutesNow()), 15000);
        return () => clearInterval(id);
    }, [mode]);

    const wakeMin = parseTime(wake);
    const bedMin = parseTime(bed);

    const options = useMemo(() => {
        if (mode === 'wake') return wakeMin === null ? [] : bedtimesFor(wakeMin, { fallAsleep });
        if (mode === 'bed') return bedMin === null ? [] : wakeTimesFor(bedMin, { fallAsleep });
        if (mode === 'now') return wakeTimesFor(now, { fallAsleep });
        return [];
    }, [mode, wakeMin, bedMin, now, fallAsleep]);

    const duration = mode === 'duration' && bedMin !== null && wakeMin !== null ? sleepDuration(bedMin, wakeMin, { fallAsleep }) : null;
    const chosen = options.find((o) => o.cycles === selected) ?? options[0];
    const chartStart = mode === 'wake' ? chosen?.time : mode === 'bed' ? bedMin : now;
    const bestLabel = (cycles) => (cycles === 5 ? t('Recommended') : cycles === 6 ? t('Best rest') : null);

    return (
        <div className="stack sleep">
            <div className="sleep-sky" aria-hidden="true">
                {Array.from({ length: 22 }, (_, i) => (
                    <i key={i} style={{ left: `${(i * 37 + 11) % 100}%`, top: `${(i * 53 + 7) % 88}%`, animationDelay: `${(i % 7) * 0.45}s` }} />
                ))}
                <span className="sleep-sky__moon" />
            </div>

            <Tabs tabs={MODES.map((x) => ({ ...x, label: t(x.label) }))} value={mode} onChange={setMode} label={t('What do you want to work out?')} />

            <div className="sleep-inputs">
                {(mode === 'wake' || mode === 'duration') && (
                    <div className="field" style={{ order: mode === 'duration' ? 1 : 0 }}>
                        <label className="field__label" htmlFor="sleep-wake">{mode === 'duration' ? t('Woke up at') : t('I want to wake up at')}</label>
                        <input id="sleep-wake" className="input input--time" type="time" value={wake} onChange={(e) => setWake(e.target.value)} />
                    </div>
                )}
                {(mode === 'bed' || mode === 'duration') && (
                    <div className="field">
                        <label className="field__label" htmlFor="sleep-bed">{mode === 'duration' ? t('Went to bed at') : t('I will go to bed at')}</label>
                        <input id="sleep-bed" className="input input--time" type="time" value={bed} onChange={(e) => setBed(e.target.value)} />
                    </div>
                )}
                {mode === 'now' && (
                    <div className="field">
                        <span className="field__label">{t('If you go to bed now')}</span>
                        <span className="sleep-now" data-testid="sleep-now">{formatClock(now, hour12)}</span>
                    </div>
                )}
                <div className="field" style={{ order: 2 }}>
                    <label className="field__label" htmlFor="sleep-fall">{t('Time to fall asleep: {minutes} min', { minutes: fallAsleep })}</label>
                    <input id="sleep-fall" className="range" type="range" min={0} max={60} step={5} value={fallAsleep} onChange={(e) => setFallAsleep(Number(e.target.value))} />
                </div>
            </div>

            <div className="row row--between">
                <span className="field__hint">{t('Most people take 10-20 minutes to fall asleep. Each sleep cycle lasts about 90 minutes.')}</span>
                <div className="seg seg--sm" role="radiogroup" aria-label={t('Clock format')}>
                    <button type="button" role="radio" aria-checked={hour12} onClick={() => setHour12(true)}>{t('12 h')}</button>
                    <button type="button" role="radio" aria-checked={!hour12} onClick={() => setHour12(false)}>{t('24 h')}</button>
                </div>
            </div>

            {mode !== 'duration' && (
                <>
                    {(mode === 'wake' ? wakeMin : mode === 'bed' ? bedMin : now) === null ? (
                        <Notice type="error">{t('Enter a valid time.')}</Notice>
                    ) : (
                        <section aria-live="polite" aria-labelledby="sleep-results-title">
                            <h3 className="sleep-results__title" id="sleep-results-title">
                                {mode === 'wake' ? t('Go to bed at one of these times:') : t('Set your alarm for one of these times:')}
                            </h3>
                            <div className="sleep-cards" key={`${mode}-${wake}-${bed}-${fallAsleep}`}>
                                {options.map((o, i) => (
                                    <TimeCard
                                        key={o.cycles}
                                        option={o}
                                        index={i}
                                        best={bestLabel(o.cycles)}
                                        selected={chosen?.cycles === o.cycles}
                                        onSelect={() => setSelected(o.cycles)}
                                        hour12={hour12}
                                        verb={mode === 'wake' ? t('Bedtime') : t('Wake up')}
                                    />
                                ))}
                            </div>
                            {chosen && <SleepChart start={chartStart} fallAsleep={fallAsleep} cycles={chosen.cycles} hour12={hour12} />}
                        </section>
                    )}
                </>
            )}

            {mode === 'duration' && (
                <>
                    {!duration ? (
                        <Notice type="error">{t('Enter two different times.')}</Notice>
                    ) : (
                        <section className={`sleep-total sleep-total--${duration.rating.level}`} aria-live="polite" key={`${bed}-${wake}-${fallAsleep}`}>
                            <div className="sleep-total__main">
                                <span className="sleep-total__label">{t('You slept about')}</span>
                                <strong className="sleep-total__value" data-testid="sleep-total">{formatSleep(duration.asleep)}</strong>
                                <span className="sleep-total__rating">{duration.rating.label}</span>
                            </div>
                            <div className="sleep-meter" role="img" aria-label={t('{time} of sleep; 7 to 9 hours is recommended', { time: formatSleep(duration.asleep) })}>
                                <span className="sleep-meter__band" />
                                <span className="sleep-meter__fill" style={{ width: `${Math.min(100, (duration.asleep / (12 * 60)) * 100)}%` }} />
                                <span className="sleep-meter__labels"><span>{t('{h} h', { h: 0 })}</span><span>{t('7-9 h')}</span><span>{t('{h} h', { h: 12 })}</span></span>
                            </div>
                            <p className="sleep-total__advice">{duration.rating.advice}</p>
                            <p className="field__hint" style={{ margin: 0 }}>
                                {t('{time} in bed', { time: formatSleep(duration.inBed) })} · {tn('about {count} full sleep cycle', 'about {count} full sleep cycles', duration.cycles)}
                                {duration.intoCycle > 0 && ` + ${t('{m} min', { m: formatNumber(duration.intoCycle) })}`}
                            </p>
                            {duration.cycles > 0 && (
                                <SleepChart start={bedMin} fallAsleep={Math.min(fallAsleep, duration.inBed)} cycles={duration.cycles} extra={duration.intoCycle} hour12={hour12} />
                            )}
                        </section>
                    )}
                </>
            )}
        </div>
    );
}
