import { useEffect, useState } from 'react';
import { domainAge } from '../lib/domainAge.js';
import { formatDate, formatNumber, t } from '../lib/i18n.js';
import { Notice } from './ui.jsx';

/** One labelled value; renders nothing for empty values so each section only shows what is known. */
function Item({ label, children }) {
    if (children === null || children === undefined || children === '' || (Array.isArray(children) && children.length === 0)) return null;
    return (
        <div className="min-w-0">
            <dt className="text-[0.8rem] text-muted">{label}</dt>
            <dd className="m-0 [overflow-wrap:anywhere]">{children}</dd>
        </div>
    );
}

function Section({ title, children }) {
    return (
        <section className="min-w-0">
            <h3 className="m-0 mb-2 text-base">{title}</h3>
            <dl className="m-0 grid gap-2">{children}</dl>
        </section>
    );
}

const list = (values) => (values?.length ? values.join(', ') : null);
const date = (iso) => (iso ? formatDate(iso) : null);

function registrationError(error) {
    switch (error) {
        case 'not-found':
            return t('No RDAP record was found (it may be unregistered or very new).');
        case 'tld-not-supported':
            return t('This domain’s extension does not have an RDAP service yet.');
        default:
            return t('Could not be checked right now. Please try again.');
    }
}

/** Registration, hosting, DNS, HTTPS and authority for one domain, from /api/domain-details. */
export default function DomainDetails({ domain }) {
    const [state, setState] = useState({ loading: true, data: null, error: false });

    useEffect(() => {
        let alive = true;
        setState({ loading: true, data: null, error: false });
        fetch('/api/domain-details', {
            method: 'POST',
            headers: { Accept: 'application/json', 'Content-Type': 'application/json' },
            body: JSON.stringify({ domain }),
        })
            .then((res) => (res.ok ? res.json() : Promise.reject(res)))
            .then((data) => alive && setState({ loading: false, data, error: false }))
            .catch(() => alive && setState({ loading: false, data: null, error: true }));
        return () => {
            alive = false;
        };
    }, [domain]);

    if (state.loading) return <p className="m-0 text-muted" aria-live="polite">{t('Loading details…')}</p>;
    if (state.error) return <Notice type="error">{t('Could not be checked right now. Please try again.')}</Notice>;

    const { registration: reg, dns, hosting, https, score } = state.data;
    const age = reg && !reg.error && reg.created ? domainAge(reg.created) : null;

    return (
        <div className="grid gap-5 sm:grid-cols-2" data-testid="domain-details">
            <Section title={t('Registration')}>
                {reg?.error ? (
                    <p className="m-0 text-muted">{registrationError(reg.error)}</p>
                ) : (
                    <>
                        <Item label={t('Registrar')}>{reg?.registrar}</Item>
                        <Item label={t('Created')}>{date(reg?.created)}</Item>
                        <Item label={t('Age')}>{age && t('{years}y {months}m {days}d', { years: age.years, months: age.months, days: age.days })}</Item>
                        <Item label={t('Expires')}>{date(reg?.expires)}</Item>
                        <Item label={t('Last updated')}>{date(reg?.updated)}</Item>
                        <Item label={t('Status')}>{list(reg?.status)}</Item>
                    </>
                )}
            </Section>

            <Section title={t('Hosting')}>
                {!state.data.resolves && <p className="m-0 text-muted">{t('This domain does not point to a server.')}</p>}
                <Item label={t('Hosting network')}>{hosting?.network}</Item>
                <Item label={t('IP address')}>{list([...(dns?.ipv4 ?? []), ...(dns?.ipv6 ?? [])])}</Item>
                <Item label={t('ASN')}>{hosting?.asn ? `AS${hosting.asn}` : null}</Item>
                <Item label={t('Server country')}>{hosting?.country}</Item>
            </Section>

            <Section title={t('DNS and email')}>
                <Item label={t('DNS provider')}>{dns?.dns_provider}</Item>
                <Item label={t('Nameservers')}>{list(dns?.nameservers)}</Item>
                <Item label={t('Email provider')}>{dns?.mail_provider ?? (dns?.mx?.length ? null : t('No mail servers'))}</Item>
                <Item label={t('Mail servers')}>{list(dns?.mx)}</Item>
            </Section>

            <Section title={t('Security and authority')}>
                <Item label={t('HTTPS')}>
                    {https === null || https === undefined ? t('No HTTPS') : https.valid ? t('Valid certificate') : t('Certificate problem')}
                </Item>
                <Item label={t('Certificate issuer')}>{https?.issuer}</Item>
                <Item label={t('Certificate expires')}>{date(https?.expires)}</Item>
                <Item label={t('Score (0-10)')}>{score?.score ?? null}</Item>
                <Item label={t('Global rank')}>{score?.rank ? `#${formatNumber(score.rank)}` : null}</Item>
                <Item label={t('Referring domains')}>{score?.referring_domains ? formatNumber(score.referring_domains) : null}</Item>
            </Section>
        </div>
    );
}
