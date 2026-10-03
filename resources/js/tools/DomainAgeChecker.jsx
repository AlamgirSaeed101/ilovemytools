import { useMemo, useState } from 'react';
import { Notice } from '../components/ui.jsx';
import { domainAge } from '../lib/domainAge.js';
import { formatDate, t } from '../lib/i18n.js';
import { toCsv } from '../lib/links.js';
import { downloadText } from '../lib/util.js';

const MAX = 20;

function ageText(age) {
    if (!age) return '–';
    return t('{years}y {months}m {days}d', { years: age.years, months: age.months, days: age.days });
}

function rowErrorText(error) {
    switch (error) {
        case 'not-found':
            return t('No RDAP record was found (it may be unregistered or very new).');
        case 'tld-not-supported':
            return t('This domain’s extension does not have an RDAP service yet.');
        default:
            return t('Could not be checked right now. Please try again.');
    }
}

function requestErrorText(status, error) {
    switch (error) {
        case 'too-many':
            return t('Please enter at most {max} domains at a time.', { max: MAX });
        default:
            return status === 429
                ? t('Too many checks in a short time. Please wait a minute and try again.')
                : t('The domain age service is not available right now. Please try again later.');
    }
}

export default function DomainAgeChecker() {
    const [text, setText] = useState('');
    const [data, setData] = useState(null);
    const [busy, setBusy] = useState(false);
    const [error, setError] = useState('');

    const lines = useMemo(() => text.split(/[\n,;\s]+/).map((s) => s.trim()).filter(Boolean), [text]);

    const check = async () => {
        if (busy || lines.length === 0) return;
        if (lines.length > MAX) {
            setError(t('Please enter at most {max} domains at a time.', { max: MAX }));
            return;
        }
        setBusy(true);
        setError('');
        try {
            const res = await fetch('/api/domain-age', {
                method: 'POST',
                headers: { Accept: 'application/json', 'Content-Type': 'application/json' },
                body: JSON.stringify({ domains: lines }),
            });
            const json = await res.json().catch(() => ({}));
            if (!res.ok || json.error) setError(requestErrorText(res.status, json.error));
            else setData(json);
        } catch {
            setError(t('The domain age service is not available right now. Please try again later.'));
        } finally {
            setBusy(false);
        }
    };

    const results = data?.results ?? [];
    const ok = results.filter((r) => !r.error);
    const failed = results.filter((r) => r.error);

    const exportCsv = () =>
        downloadText(
            toCsv([
                ['Domain', 'Created', 'Age', 'Expires', 'Last updated', 'Registrar', 'Status', 'Nameservers'],
                ...ok.map((r) => {
                    const age = domainAge(r.created);
                    return [
                        r.domain,
                        r.created ? formatDate(r.created.slice(0, 10)) : '',
                        age ? `${age.years}y ${age.months}m ${age.days}d` : '',
                        r.expires ? formatDate(r.expires.slice(0, 10)) : '',
                        r.updated ? formatDate(r.updated.slice(0, 10)) : '',
                        r.registrar || '',
                        (r.status || []).join('; '),
                        (r.nameservers || []).join('; '),
                    ];
                }),
            ]),
            'domain-age.csv',
            'text/csv',
        );

    return (
        <div className="stack">
            <div className="field">
                <label className="field__label" htmlFor="age-domains">{t('Domains (one per line, up to {max})', { max: MAX })}</label>
                <textarea
                    id="age-domains"
                    className="textarea textarea--code"
                    rows={8}
                    spellCheck={false}
                    placeholder={'example.com\nwikipedia.org\nhttps://www.yoursite.co.uk/page'}
                    value={text}
                    onChange={(e) => setText(e.target.value)}
                />
                <p className="field__hint">{t('{count} of {max} domains · full URLs are fine, they are reduced to the domain.', { count: lines.length, max: MAX })}</p>
            </div>

            <div className="row">
                <button type="button" className="btn btn--primary" onClick={check} disabled={busy || lines.length === 0}>
                    {busy ? t('Checking…') : t('Check domain age')}
                </button>
                <button type="button" className="btn btn--danger" onClick={() => { setText(''); setData(null); setError(''); }} disabled={!text && !data}>
                    {t('Clear')}
                </button>
            </div>

            <Notice type="error">{error}</Notice>

            {data && (
                <>
                    {data.invalid?.length > 0 && <Notice type="warn">{t('Skipped (not a domain): {list}', { list: data.invalid.join(', ') })}</Notice>}

                    {ok.length > 0 && (
                        <>
                            <div className="row row--between">
                                <p className="field__hint m-0" aria-live="polite">{t('{count} of {total} domains checked', { count: ok.length, total: results.length })}</p>
                                <button type="button" className="btn btn--sm" onClick={exportCsv}>
                                    {t('Download CSV')}
                                </button>
                            </div>

                            <div className="table-wrap">
                                <table className="compare-table" data-testid="age-table">
                                    <caption className="sr-only">{t('Domain age results')}</caption>
                                    <thead>
                                        <tr>
                                            <th scope="col">{t('Domain')}</th>
                                            <th scope="col">{t('Created')}</th>
                                            <th scope="col">{t('Age')}</th>
                                            <th scope="col">{t('Expires')}</th>
                                            <th scope="col">{t('Last updated')}</th>
                                            <th scope="col">{t('Registrar')}</th>
                                            <th scope="col">{t('Status')}</th>
                                            <th scope="col">{t('Nameservers')}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {ok.map((r) => (
                                            <tr key={r.domain}>
                                                <th scope="row" className="[overflow-wrap:anywhere]">{r.domain}</th>
                                                <td>{r.created ? formatDate(r.created.slice(0, 10)) : '–'}</td>
                                                <td className="tabular-nums">{ageText(domainAge(r.created))}</td>
                                                <td>{r.expires ? formatDate(r.expires.slice(0, 10)) : '–'}</td>
                                                <td>{r.updated ? formatDate(r.updated.slice(0, 10)) : '–'}</td>
                                                <td>{r.registrar || '–'}</td>
                                                <td>{r.status?.length ? r.status.join(', ') : '–'}</td>
                                                <td>{r.nameservers?.length ? r.nameservers.join(', ') : '–'}</td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </>
                    )}

                    {failed.length > 0 && (
                        <div className="stack" data-testid="age-errors">
                            {failed.map((r) => (
                                <Notice type="warn" key={r.domain}>{`${r.domain}: ${rowErrorText(r.error)}`}</Notice>
                            ))}
                        </div>
                    )}
                </>
            )}
        </div>
    );
}
