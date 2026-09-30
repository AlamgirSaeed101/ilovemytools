// Animation helpers shared by the game and time tools.
import { useEffect, useState } from 'react';

const QUERY = '(prefers-reduced-motion: reduce)';

export function prefersReducedMotion() {
    return typeof window !== 'undefined' && Boolean(window.matchMedia?.(QUERY).matches);
}

/** True when the visitor asked their OS for less motion: tools then show results instantly. */
export function useReducedMotion() {
    const [reduced, setReduced] = useState(prefersReducedMotion);
    useEffect(() => {
        const mq = window.matchMedia?.(QUERY);
        if (!mq) return undefined;
        const onChange = () => setReduced(mq.matches);
        mq.addEventListener('change', onChange);
        return () => mq.removeEventListener('change', onChange);
    }, []);
    return reduced;
}

/** Keyboard shortcuts for a tool, ignored while the visitor is typing in a field or a dialog is open. */
export function useShortcuts(map, enabled = true) {
    useEffect(() => {
        if (!enabled) return undefined;
        const onKey = (e) => {
            if (e.ctrlKey || e.metaKey || e.altKey) return;
            const el = e.target;
            if (el instanceof HTMLElement) {
                if (el.isContentEditable || /^(INPUT|TEXTAREA|SELECT)$/.test(el.tagName) || el.closest('dialog')) return;
                // A focused button already reacts to Space/Enter itself.
                if (el.tagName === 'BUTTON' && (e.key === ' ' || e.key === 'Enter')) return;
            }
            const action = map[e.key.toLowerCase()] ?? map[e.code];
            if (action) {
                e.preventDefault();
                action();
            }
        };
        document.addEventListener('keydown', onKey);
        return () => document.removeEventListener('keydown', onKey);
    }, [map, enabled]);
}

let audioCtx = null;

/** Create/resume the audio context. Call from a click so browsers allow sound later. */
export function unlockAudio() {
    try {
        const Ctx = window.AudioContext || window.webkitAudioContext;
        if (!Ctx) return null;
        audioCtx = audioCtx || new Ctx();
        if (audioCtx.state === 'suspended') audioCtx.resume();
        return audioCtx;
    } catch {
        return null;
    }
}

/** A short beep (no audio files needed). */
export function beep({ frequency = 880, duration = 0.18, volume = 0.25, delay = 0 } = {}) {
    const ctx = unlockAudio();
    if (!ctx) return;
    const start = ctx.currentTime + delay;
    const osc = ctx.createOscillator();
    const gain = ctx.createGain();
    osc.type = 'sine';
    osc.frequency.value = frequency;
    gain.gain.setValueAtTime(0.0001, start);
    gain.gain.exponentialRampToValueAtTime(volume, start + 0.02);
    gain.gain.exponentialRampToValueAtTime(0.0001, start + duration);
    osc.connect(gain).connect(ctx.destination);
    osc.start(start);
    osc.stop(start + duration + 0.02);
}
