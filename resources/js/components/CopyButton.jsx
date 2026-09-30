import { useEffect, useRef, useState } from 'react';
import { copyToClipboard } from '../lib/util.js';
import { t } from '../lib/i18n.js';

export default function CopyButton({ text, label, className = 'btn', disabled = false }) {
    const [state, setState] = useState('idle');
    const timer = useRef();

    useEffect(() => () => clearTimeout(timer.current), []);

    async function handleClick() {
        const ok = await copyToClipboard(text ?? '');
        setState(ok ? 'copied' : 'failed');
        clearTimeout(timer.current);
        timer.current = setTimeout(() => setState('idle'), 2000);
    }

    return (
        <button type="button" className={className} onClick={handleClick} disabled={disabled || !text} aria-live="polite">
            {state === 'copied' ? t('Copied!') : state === 'failed' ? t('Press Ctrl+C') : label ?? t('Copy')}
        </button>
    );
}
