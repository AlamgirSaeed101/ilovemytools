import { useCallback, useEffect, useMemo, useRef, useState } from 'react';
import CopyButton from '../components/CopyButton.jsx';
import { formatStopwatch, lapExtremes } from '../lib/time.js';
import { useShortcuts } from '../lib/motion.js';
import { t } from '../lib/i18n.js';

const RING = 2 * Math.PI * 108; // circumference of the progress ring (r = 108)

/**
 * Time is measured from timestamps (performance.now), not by counting ticks,
 * so it stays exact even when the tab is in the background and frames stop.
 */
export default function Stopwatch() {
    const [running, setRunning] = useState(false);
    const [startedAt, setStartedAt] = useState(0); // performance.now() when last started
    const [banked, setBanked] = useState(0); // ms from earlier start/stop sessions
    const [now, setNow] = useState(0);
    const [laps, setLaps] = useState([]); // total elapsed at each lap press
    const frame = useRef();

    useEffect(() => {
        if (!running) return undefined;
        const tick = () => {
            setNow(performance.now());
            frame.current = requestAnimationFrame(tick);
        };
        frame.current = requestAnimationFrame(tick);
        return () => cancelAnimationFrame(frame.current);
    }, [running]);

    const elapsed = running ? banked + Math.max(0, now - startedAt) : banked;

    const toggle = useCallback(() => {
        const nowMs = performance.now();
        if (running) {
            setBanked((b) => b + (nowMs - startedAt));
            setRunning(false);
        } else {
            setStartedAt(nowMs);
            setNow(nowMs);
            setRunning(true);
        }
    }, [running, startedAt]);

    const lap = useCallback(() => {
        if (!running) return;
        setLaps((l) => [...l, banked + (performance.now() - startedAt)]);
    }, [running, banked, startedAt]);

    const reset = useCallback(() => {
        if (running) return;
        setBanked(0);
        setLaps([]);
        setNow(0);
    }, [running]);

    const shortcuts = useMemo(() => ({ ' ': toggle, l: lap, r: reset }), [toggle, lap, reset]);
    useShortcuts(shortcuts);

    // Lap durations (each lap minus the previous one), newest shown first.
    const lapTimes = laps.map((total, i) => total - (i ? laps[i - 1] : 0));
    const { fastest, slowest } = lapExtremes(lapTimes);
    const currentLap = elapsed - (laps.length ? laps[laps.length - 1] : 0);
    const secondsFraction = (elapsed % 60000) / 60000;
    const exportText = lapTimes.map((lapMs, i) => `${t('Lap {n}', { n: i + 1 })}\t${formatStopwatch(lapMs)}\t${formatStopwatch(laps[i])}`).join('\n');

    return (
        <div className="stack">
            <div className={`clock${running ? ' is-running' : ''}`}>
                <svg className="clock__ring" viewBox="0 0 240 240" aria-hidden="true">
                    <circle className="clock__track" cx="120" cy="120" r="108" />
                    {Array.from({ length: 60 }, (_, i) => (
                        <line key={i} className={i % 5 ? 'clock__tick' : 'clock__tick clock__tick--major'} x1="120" y1="6" x2="120" y2={i % 5 ? 11 : 15} transform={`rotate(${i * 6} 120 120)`} />
                    ))}
                    <circle
                        className="clock__progress"
                        cx="120"
                        cy="120"
                        r="108"
                        strokeDasharray={RING}
                        strokeDashoffset={RING * (1 - secondsFraction)}
                        transform="rotate(-90 120 120)"
                    />
                    <g transform={`rotate(${secondsFraction * 360} 120 120)`}>
                        <circle className="clock__dot" cx="120" cy="12" r="6" />
                    </g>
                </svg>
                <div className="clock__center">
                    <span className="clock__time" data-testid="stopwatch-time" aria-live={running ? 'off' : 'polite'}>
                        {formatStopwatch(elapsed)}
                    </span>
                    {laps.length > 0 && <span className="clock__sub">{t('Lap {n}', { n: laps.length + 1 })} · {formatStopwatch(currentLap)}</span>}
                </div>
            </div>

            <div className="clock-buttons">
                <button type="button" className="btn btn--lg" onClick={running ? lap : reset} disabled={!running && elapsed === 0}>
                    {running ? t('Lap') : t('Reset')}
                </button>
                <button type="button" className={`btn btn--lg ${running ? 'btn--stop' : 'btn--go'}`} onClick={toggle}>
                    {running ? t('Stop') : elapsed > 0 ? t('Resume') : t('Start')}
                </button>
            </div>
            <p className="field__hint shortcut-hint">
                {t('Keyboard:')} <kbd className="kbd">Space</kbd> {t('start / stop')} · <kbd className="kbd">L</kbd> {t('lap')} · <kbd className="kbd">R</kbd> {t('reset')}
            </p>

            {laps.length > 0 && (
                <div className="field">
                    <div className="row row--between">
                        <span className="field__label">{t('Laps')}</span>
                        <CopyButton text={exportText} className="btn btn--sm" label={t('Copy laps')} />
                    </div>
                    <table className="laps">
                        <thead>
                            <tr><th scope="col">{t('Lap')}</th><th scope="col">{t('Lap time')}</th><th scope="col">{t('Total')}</th></tr>
                        </thead>
                        <tbody>
                            {lapTimes.map((lapMs, i) => ({ lapMs, i })).reverse().map(({ lapMs, i }) => (
                                <tr key={i} className={`${i === laps.length - 1 ? 'is-new ' : ''}${i === fastest ? 'is-fastest' : i === slowest ? 'is-slowest' : ''}`}>
                                    <td>
                                        {i + 1}
                                        {i === fastest && <span className="lap-tag lap-tag--fast">{t('Fastest')}</span>}
                                        {i === slowest && <span className="lap-tag lap-tag--slow">{t('Slowest')}</span>}
                                    </td>
                                    <td>{formatStopwatch(lapMs)}</td>
                                    <td>{formatStopwatch(laps[i])}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            )}
        </div>
    );
}
