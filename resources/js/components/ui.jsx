import { useRef } from 'react';

export function Notice({ type = 'info', children }) {
    if (!children) return null;
    return (
        <p className={`notice notice--${type}`} role={type === 'error' ? 'alert' : 'status'}>
            {children}
        </p>
    );
}

export function Stat({ value, label }) {
    return (
        <div className="stat">
            <span className="stat__value">{value}</span>
            <span className="stat__label">{label}</span>
        </div>
    );
}

/** Segmented tabs. Arrow keys, Home and End move between tabs (WAI-ARIA tabs pattern). */
export function Tabs({ tabs, value, onChange, label }) {
    const ref = useRef(null);

    function onKeyDown(e) {
        const index = tabs.findIndex((t) => t.id === value);
        let next = null;
        if (e.key === 'ArrowRight') next = (index + 1) % tabs.length;
        else if (e.key === 'ArrowLeft') next = (index - 1 + tabs.length) % tabs.length;
        else if (e.key === 'Home') next = 0;
        else if (e.key === 'End') next = tabs.length - 1;
        if (next === null) return;
        e.preventDefault();
        onChange(tabs[next].id);
        ref.current?.querySelectorAll('[role="tab"]')[next]?.focus();
    }

    return (
        <div className="tabs" role="tablist" aria-label={label} ref={ref} onKeyDown={onKeyDown}>
            {tabs.map((tab) => (
                <button
                    key={tab.id}
                    type="button"
                    role="tab"
                    aria-selected={value === tab.id}
                    tabIndex={value === tab.id ? 0 : -1}
                    onClick={() => onChange(tab.id)}
                >
                    {tab.label}
                </button>
            ))}
        </div>
    );
}
