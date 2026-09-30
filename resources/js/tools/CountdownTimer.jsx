import { useCallback, useEffect, useMemo, useRef, useState } from 'react';
import { Notice } from '../components/ui.jsx';
import { beep, unlockAudio, useShortcuts } from '../lib/motion.js';
import { formatCountdown, fromMs, MAX_TIMER_MS, toMs } from '../lib/time.js';
import { t } from '../lib/i18n.js';

const RING = 2 * Math.PI * 108;
const PRESETS = [
    [() => t('{s} sec', { s: 30 }), 30000],
    [() => t('{m} min', { m: 1 }), 60000],
    [() => t('{m} min', { m: 3 }), 180000],
    [() => t('{m} min', { m: 5 }), 300000],
    [() => t('{m} min', { m: 10 }), 600000],
    [() => t('{m} min', { m: 15 }), 900000],
    [() => t('{m} min', { m: 25 }), 1500000],
    [() => t('1 hour'), 3600000],
];
const ALARM_SECONDS = 30;
const pad2 = (v) => String(Math.floor(Number(v)) || 0).padStart(2, '0');

function alarmBurst() {
    // "beep-beep-beep" pattern, repeated every second while the alarm rings.
    [0, 0.22, 0.44].forEach((delay) => beep({ frequency: 988, delay, duration: 0.16 }));
}

/**
 * States: idle (editing) -> running (endAt) <-> paused (remaining) -> done (alarm).
 * The deadline is a timestamp, so the timer stays exact in background tabs.
 */
export default function CountdownTimer() {
    const [fields, setFields] = useState({ h: '00', m: '05', s: '00' });
    const [state, setState] = useState('idle');
    const [duration, setDuration] = useState(300000); // length of the current countdown
    const [endAt, setEndAt] = useState(0);
    const [remaining, setRemaining] = useState(300000);
    const [sound, setSound] = useState(true);
    const [ringing, setRinging] = useState(false);
    const originalTitle = useRef('');

    const inputMs = toMs(fields);

    // Tick while running. 100 ms keeps the ring smooth; the maths uses the deadline.
    useEffect(() => {
        if (state !== 'running') return undefined;
        const update = () => {
            const left = endAt - performance.now();
            if (left <= 0) {
                setRemaining(0);
                setState('done');
                setRinging(true);
            } else {
                setRemaining(left);
            }
        };
        update();
        const id = setInterval(update, 100);
        return () => clearInterval(id);
    }, [state, endAt]);

    // Alarm: beeps for up to 30 s or until stopped.
    useEffect(() => {
        if (!ringing) return undefined;
        if (sound) alarmBurst();
        let n = 1;
        const id = setInterval(() => {
            if (n++ >= ALARM_SECONDS) {
                setRinging(false);
                return;
            }
            if (sound) alarmBurst();
        }, 1000);
        return () => clearInterval(id);
    }, [ringing, sound]);

    // Show the time left in the browser tab, and restore the page title afterwards.
    // The page's own title is saved the first time we replace it, and put back on reset / leaving.
    useEffect(() => {
        if (state === 'idle') {
            if (originalTitle.current) document.title = originalTitle.current;
            originalTitle.current = '';
            return;
        }
        if (!originalTitle.current) originalTitle.current = document.title;
        document.title = state === 'done' ? `⏰ ${t("Time's up!")}` : `${state === 'paused' ? '⏸ ' : ''}${formatCountdown(remaining)} · ${t('Timer')}`;
    }, [state, remaining]);
    useEffect(() => () => {
        if (originalTitle.current) document.title = originalTitle.current;
    }, []);

    const start = useCallback(
        (ms = inputMs) => {
            if (ms <= 0) return;
            unlockAudio(); // allowed now because this runs from a click or key press
            setDuration(ms);
            setRemaining(ms);
            setEndAt(performance.now() + ms);
            setRinging(false);
            setState('running');
        },
        [inputMs],
    );

    const pause = useCallback(() => {
        setRemaining(Math.max(0, endAt - performance.now()));
        setState('paused');
    }, [endAt]);

    const resume = useCallback(() => {
        unlockAudio();
        setEndAt(performance.now() + remaining);
        setState('running');
    }, [remaining]);

    const reset = useCallback(() => {
        setRinging(false);
        setState('idle');
        setRemaining(inputMs);
    }, [inputMs]);

    const addMinute = () => {
        if (state === 'running') {
            setEndAt((e) => Math.min(e + 60000, performance.now() + MAX_TIMER_MS));
            setDuration((d) => d + 60000);
        } else if (state === 'paused') {
            setRemaining((r) => r + 60000);
            setDuration((d) => d + 60000);
        }
    };

    const primary = useCallback(() => {
        if (state === 'running') pause();
        else if (state === 'paused') resume();
        else if (state === 'done') reset();
        else start();
    }, [state, pause, resume, reset, start]);

    const shortcuts = useMemo(() => ({ ' ': primary, r: reset }), [primary, reset]);
    useShortcuts(shortcuts);

    const set = (key) => (e) => {
        const value = e.target.value.replace(/[^\d]/g, '').slice(0, 2);
        setFields((f) => ({ ...f, [key]: value }));
    };

    function preset(ms) {
        const parts = fromMs(ms);
        setFields({ h: pad2(parts.h), m: pad2(parts.m), s: pad2(parts.s) });
        start(ms);
    }

    const active = state !== 'idle';
    const shownMs = active ? remaining : inputMs;
    const fraction = active && duration > 0 ? remaining / duration : 1;
    const urgent = state === 'running' && remaining <= 10000;

    return (
        <div className="stack">
            <div className="chips chips--left" role="group" aria-label={t('Quick presets')}>
                {PRESETS.map(([label, ms]) => (
                    <button key={ms} type="button" className="chip" onClick={() => preset(ms)}>
                        {label()}
                    </button>
                ))}
            </div>

            <div className={`clock clock--timer${state === 'running' ? ' is-running' : ''}${urgent ? ' is-urgent' : ''}${state === 'done' ? ' is-done' : ''}${state === 'paused' ? ' is-paused' : ''}`}>
                <svg className="clock__ring" viewBox="0 0 240 240" aria-hidden="true">
                    <circle className="clock__track" cx="120" cy="120" r="108" />
                    <circle
                        className="clock__progress"
                        cx="120"
                        cy="120"
                        r="108"
                        strokeDasharray={RING}
                        strokeDashoffset={RING * (1 - fraction)}
                        transform="rotate(-90 120 120)"
                    />
                </svg>
                <div className="clock__center">
                    {state === 'idle' ? (
                        <div className="time-inputs" role="group" aria-label={t('Timer length')}>
                            {[['h', t('Hours')], ['m', t('Minutes')], ['s', t('Seconds')]].map(([key, label], i) => (
                                <span key={key} className="time-inputs__part">
                                    {i > 0 && <span className="time-inputs__sep">:</span>}
                                    <input
                                        className="time-inputs__input"
                                        inputMode="numeric"
                                        aria-label={label}
                                        value={fields[key]}
                                        onChange={set(key)}
                                        onFocus={(e) => e.target.select()}
                                        onBlur={() => setFields((f) => ({ ...f, [key]: pad2(f[key]) }))}
                                        onKeyDown={(e) => {
                                            if (e.key === 'Enter') start();
                                        }}
                                        placeholder="00"
                                    />
                                    <small>{key}</small>
                                </span>
                            ))}
                        </div>
                    ) : (
                        <span className="clock__time" data-testid="timer-time">
                            {state === 'done' ? '00:00' : formatCountdown(shownMs)}
                        </span>
                    )}
                    <span className="clock__sub" aria-live="polite" data-testid="timer-status">
                        {state === 'idle' && (inputMs > 0 ? t('{time} timer', { time: formatCountdown(inputMs) }) : t('Set a time'))}
                        {state === 'running' && t('Counting down')}
                        {state === 'paused' && t('Paused')}
                        {state === 'done' && t("Time's up!")}
                    </span>
                </div>
            </div>

            {state === 'done' && ringing && (
                <div className="alarm-banner pop-in" role="alert">
                    <span className="alarm-banner__bell" aria-hidden="true">⏰</span> {t("Time's up!")}
                    <button type="button" className="btn btn--sm" onClick={() => setRinging(false)}>{t('Stop alarm')}</button>
                </div>
            )}

            <div className="clock-buttons">
                <button type="button" className="btn btn--lg" onClick={reset} disabled={state === 'idle'}>{t('Reset')}</button>
                <button
                    type="button"
                    className={`btn btn--lg ${state === 'running' ? 'btn--stop' : 'btn--go'}`}
                    onClick={primary}
                    disabled={state === 'idle' && inputMs <= 0}
                >
                    {state === 'running' ? t('Pause') : state === 'paused' ? t('Resume') : state === 'done' ? t('New timer') : t('Start')}
                </button>
                <button type="button" className="btn btn--lg" onClick={addMinute} disabled={state !== 'running' && state !== 'paused'}>+{t('{m} min', { m: 1 })}</button>
            </div>

            <div className="row row--between">
                <label className="check">
                    <input type="checkbox" checked={sound} onChange={(e) => setSound(e.target.checked)} /> {t('Play an alarm sound')}
                </label>
                <span className="field__hint">
                    <kbd className="kbd">Space</kbd> {t('start / pause')} · <kbd className="kbd">R</kbd> {t('reset')}
                </span>
            </div>
            {state === 'idle' && inputMs >= MAX_TIMER_MS && <Notice type="info">{t('The longest timer is 99 hours, 59 minutes and 59 seconds.')}</Notice>}
        </div>
    );
}
