import { useEffect, useId, useState } from 'react';
import { useLocation, useNavigate } from 'react-router';
import Icon from './Icon.jsx';
import { track } from '../lib/analytics.js';
import { getLocale, t } from '../lib/i18n.js';

async function post(url, body) {
    const res = await fetch(url, {
        method: 'POST',
        headers: { Accept: 'application/json', 'Content-Type': 'application/json' },
        body: JSON.stringify(body),
    });
    return { status: res.status, data: await res.json().catch(() => ({})) };
}

/**
 * Newsletter sign-up: new tool announcements by email (double opt-in).
 * `compact` is the footer version; the default is the home page card.
 */
export default function NewsletterForm({ compact = false }) {
    const id = useId();
    const [email, setEmail] = useState('');
    const [website, setWebsite] = useState(''); // honeypot, hidden from people
    const [state, setState] = useState('idle'); // idle | sending | done | invalid | busy | error

    const submit = async (e) => {
        e.preventDefault();
        if (state === 'sending') return;
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.trim())) {
            setState('invalid');
            return;
        }
        setState('sending');
        try {
            const { status } = await post('/api/newsletter', { email: email.trim(), locale: getLocale(), website });
            if (status === 200) {
                setState('done');
                track('sign_up', { method: 'newsletter' });
            }
            else if (status === 422) setState('invalid');
            else if (status === 429) setState('busy');
            else setState('error');
        } catch {
            setState('error');
        }
    };

    const message = {
        done: t('Almost done! Check your inbox and click the link to confirm your subscription.'),
        invalid: t('Please enter a valid email address.'),
        busy: t('Too many attempts. Please wait a minute and try again.'),
        error: t('Something went wrong. Please try again.'),
    }[state];

    const form =
        state === 'done' ? (
            <p className="m-0 flex items-start gap-2.5 rounded-xl bg-success-soft px-4 py-3 font-semibold text-success" role="status" data-testid="newsletter-done">
                <Icon name="mail" /> <span>{message}</span>
            </p>
        ) : (
            <form className="min-w-0" onSubmit={submit} noValidate>
                <div className={`flex gap-2 ${compact ? 'flex-col min-[420px]:flex-row' : 'flex-col sm:flex-row'}`}>
                    <label className="sr-only" htmlFor={`${id}-email`}>
                        {t('Email address')}
                    </label>
                    <input
                        id={`${id}-email`}
                        className={`input min-w-0 flex-1 ${compact ? '' : 'h-12 rounded-full px-5'}`}
                        type="email"
                        name="email"
                        autoComplete="email"
                        inputMode="email"
                        required
                        maxLength={254}
                        placeholder={t('you@example.com')}
                        value={email}
                        onChange={(e) => {
                            setEmail(e.target.value);
                            if (state === 'invalid') setState('idle');
                        }}
                        aria-invalid={state === 'invalid' || undefined}
                        aria-describedby={message ? `${id}-msg` : undefined}
                    />
                    {/* Bots fill in every field; this one is invisible to people and screen readers. */}
                    <input
                        className="absolute left-[-9999px] size-px opacity-0"
                        type="text"
                        name="website"
                        tabIndex={-1}
                        autoComplete="off"
                        aria-hidden="true"
                        value={website}
                        onChange={(e) => setWebsite(e.target.value)}
                    />
                    <button className={`btn btn--primary shrink-0 ${compact ? '' : 'btn--lg rounded-full'}`} type="submit" disabled={state === 'sending'}>
                        <Icon name="mail" /> {state === 'sending' ? t('Subscribing…') : t('Subscribe')}
                    </button>
                </div>
                {message && (
                    <p id={`${id}-msg`} className="mt-2 mb-0 text-[0.88rem] font-semibold text-danger" role="alert">
                        {message}
                    </p>
                )}
            </form>
        );

    if (compact) {
        return (
            <div className="grid min-w-0 gap-4 md:grid-cols-[1fr_minmax(0,440px)] md:items-center md:gap-8" data-testid="newsletter-footer">
                <div className="flex min-w-0 items-start gap-3.5">
                    <span className="grid size-11 shrink-0 place-items-center rounded-xl bg-[linear-gradient(135deg,#3b82f6,#7c3aed)] text-white [&_svg]:size-5" aria-hidden="true">
                        <Icon name="mail" />
                    </span>
                    <div className="min-w-0">
                        <h2 className="m-0 mb-0.5 text-[1.05rem] font-extrabold">{t('Get new tools by email')}</h2>
                        <p className="m-0 text-muted">{t('One short email when we add a new free tool. No spam.')}</p>
                    </div>
                </div>
                {form}
            </div>
        );
    }

    return (
        <section className="my-14" aria-labelledby="newsletter-heading" data-testid="newsletter">
            <div className="relative overflow-hidden rounded-[28px] bg-[linear-gradient(135deg,#2563eb,#7c3aed)] p-[clamp(1.75rem,5vw,3.5rem)] text-white shadow-[0_30px_60px_-30px_rgb(37_99_235/0.8)]">
                <span className="pointer-events-none absolute -top-16 -right-16 size-56 rounded-full bg-white/10" aria-hidden="true" />
                <span className="pointer-events-none absolute -bottom-20 left-1/3 size-40 rounded-full bg-white/10" aria-hidden="true" />
                <div className="relative grid items-center gap-8 md:grid-cols-[1.1fr_1fr]">
                    <div className="min-w-0">
                        <p className="m-0 mb-3 inline-flex items-center gap-1.5 rounded-full bg-white/15 px-3 py-1 text-[0.8rem] font-bold tracking-wider uppercase">
                            <Icon name="sparkles" /> {t('Newsletter')}
                        </p>
                        <h2 id="newsletter-heading" className="m-0 mb-3 text-[clamp(1.5rem,3vw,2.1rem)] font-extrabold tracking-tight text-white">
                            {t('Be the first to try new tools')}
                        </h2>
                        <p className="m-0 text-[1.02rem] text-white/85">
                            {t('We add new free tools every week. Get one short email when a new one goes live. No spam, unsubscribe in one click.')}
                        </p>
                    </div>
                    <div className="min-w-0 rounded-2xl bg-white p-4 text-ink shadow-lg sm:p-5">{form}</div>
                </div>
            </div>
        </section>
    );
}

/**
 * Banner for the links in newsletter emails: ?newsletter=confirmed|invalid|unsubscribe&token=…
 * Unsubscribing needs a click here (a GET must not unsubscribe; link scanners open links).
 */
export function NewsletterNotice() {
    const location = useLocation();
    const navigate = useNavigate();
    const params = new URLSearchParams(location.search);
    const state = params.get('newsletter');
    const token = params.get('token') || '';
    const [result, setResult] = useState(null); // null | sending | unsubscribed | invalid | error

    useEffect(() => setResult(null), [state]);

    if (!['confirmed', 'invalid', 'unsubscribe'].includes(state)) return null;

    const close = () => {
        params.delete('newsletter');
        params.delete('token');
        const query = params.toString();
        navigate({ pathname: location.pathname, search: query ? `?${query}` : '' }, { replace: true, preventScrollReset: true });
    };

    const unsubscribe = async () => {
        setResult('sending');
        try {
            const { status } = await post('/api/newsletter/unsubscribe', { token });
            setResult(status === 200 ? 'unsubscribed' : status === 404 ? 'invalid' : 'error');
        } catch {
            setResult('error');
        }
    };

    let tone = 'success';
    let text;
    let action = null;
    if (state === 'confirmed') {
        text = t('You are subscribed! We will email you when we add a new tool.');
    } else if (state === 'invalid' || result === 'invalid') {
        tone = 'danger';
        text = t('This link is invalid or has expired.');
    } else if (result === 'unsubscribed') {
        text = t('You have been unsubscribed. You will not get any more emails from us.');
    } else {
        tone = result === 'error' ? 'danger' : 'info';
        text = result === 'error' ? t('Something went wrong. Please try again.') : t('Unsubscribe from new tool emails?');
        action = (
            <button className="btn btn--primary btn--sm" type="button" onClick={unsubscribe} disabled={result === 'sending'}>
                {t('Unsubscribe')}
            </button>
        );
    }

    const tones = {
        success: 'border-success/30 bg-success-soft text-success',
        danger: 'border-danger/30 bg-surface text-danger',
        info: 'border-brand/25 bg-surface text-ink',
    };

    return (
        <div className="shell pt-4">
            <div className={`flex flex-wrap items-center gap-3 rounded-2xl border px-4 py-3 font-semibold ${tones[tone]}`} role="status" data-testid="newsletter-notice">
                <Icon name={tone === 'success' ? 'check' : 'mail'} />
                <span className="min-w-0 flex-1">{text}</span>
                {action}
                <button className="btn btn--ghost btn--sm" type="button" onClick={close} aria-label={t('Close')}>
                    <Icon name="x" />
                </button>
            </div>
        </div>
    );
}
