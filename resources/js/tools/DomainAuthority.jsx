import { Fragment, useMemo, useState } from 'react';
import DomainDetails from '../components/DomainDetails.jsx';
import { Notice, Stat } from '../components/ui.jsx';
import { formatDate, formatNumber, t } from '../lib/i18n.js';
import { toCsv } from '../lib/links.js';
import { downloadText } from '../lib/util.js';

const MAX = 100;

/** Colour for a 0-10 authority score. */
const tone = (s) => (s >= 7 ? 'var(--success)' : s >= 4 ? '#2563eb' : s >= 2 ? '#d97706' : 'var(--danger)');

function errorText(status, error) {
    switch (error) {
        case 'not-configured':
            return t('The Domain Authority Checker is being set up. Please check back soon.');
        case 'daily-limit':
            return t('Today’s free lookups have been used up. Please try again tomorrow.');
        case 'too-many':
            return t('Please enter at most {max} domains at a time.', { max: MAX });
        case 'busy':
            return t('Too many checks in a short time. Please wait a minute and try again.');
        default:
            return status === 429 ? t('Too many checks in a short time. Please wait a minute and try again.') : t('The score service is not available right now. Please try again later.');
    }
}

export default function DomainAuthority() {
    const [text, setText] = useState('');
    const [data, setData] = useState(null);
    const [busy, setBusy] = useState(false);
    const [error, setError] = useState('');
    const [sort, setSort] = useState('score');
    // Domain whose details panel is open (one at a time; opened automatically for a single domain).
    const [open, setOpen] = useState(null);

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
            const res = await fetch('/api/domain-authority', {
                method: 'POST',
                headers: { Accept: 'application/json', 'Content-Type': 'application/json' },
                body: JSON.stringify({ domains: lines }),
            });
            const json = await res.json().catch(() => ({}));
            if (!res.ok || json.error) setError(errorText(res.status, json.error));
            else {
                setData(json);
                setOpen(json.results?.length === 1 ? json.results[0].domain : null);
            }
        } catch {
            setError(t('The score service is not available right now. Please try again later.'));
        } finally {
            setBusy(false);
        }
    };

    const rows = useMemo(() => {
        if (!data) return [];
        const list = [...data.results];
        if (sort === 'score') list.sort((a, b) => (b.score ?? -1) - (a.score ?? -1));
        if (sort === 'domain') list.sort((a, b) => a.domain.localeCompare(b.domain));
        return list;
    }, [data, sort]);

    const found = rows.filter((r) => r.found && r.score !== null);
    const average = found.length ? found.reduce((a, r) => a + r.score, 0) / found.length : null;

    const exportCsv = () =>
        downloadText(
            toCsv([['Domain', 'OpenPageRank (0-10)', 'Global rank', 'Referring domains'], ...rows.map((r) => [r.domain, r.score ?? 'not found', r.rank ?? '', r.referring_domains ?? ''])]),
            'domain-authority.csv',
            'text/csv',
        );

    return (
        <div className="stack">
            <div className="field">
                <label className="field__label" htmlFor="da-domains">{t('Domains (one per line, up to {max})', { max: MAX })}</label>
                <textarea
                    id="da-domains"
                    className="textarea textarea--code"
                    rows={8}
                    spellCheck={false}
                    placeholder={'example.com\nwikipedia.org\nhttps://www.yoursite.com/page'}
                    value={text}
                    onChange={(e) => setText(e.target.value)}
                />
                <p className="field__hint">{t('{count} of {max} domains · full URLs are fine, they are reduced to the domain.', { count: lines.length, max: MAX })}</p>
            </div>

            <div className="row">
                <button type="button" className="btn btn--primary" onClick={check} disabled={busy || lines.length === 0}>
                    {busy ? t('Checking…') : t('Check authority')}
                </button>
                <button type="button" className="btn btn--danger" onClick={() => { setText(''); setData(null); setError(''); setOpen(null); }} disabled={!text && !data}>
                    {t('Clear')}
                </button>
            </div>

            <Notice type="error">{error}</Notice>

            {data && (
                <>
                    {data.invalid?.length > 0 && <Notice type="warn">{t('Skipped (not a domain): {list}', { list: data.invalid.join(', ') })}</Notice>}

                    <div className="stats" aria-live="polite">
                        <Stat value={formatNumber(rows.length)} label={t('Domains checked')} />
                        <Stat value={formatNumber(found.length)} label={t('With a score')} />
                        <Stat value={average === null ? '–' : formatNumber(Math.round(average * 100) / 100)} label={t('Average score')} />
                    </div>

                    <div className="row row--between">
                        <label className="row">
                            <span className="field__label m-0">{t('Sort by')}</span>
                            <select className="select" value={sort} onChange={(e) => setSort(e.target.value)}>
                                <option value="score">{t('Highest score')}</option>
                                <option value="domain">{t('Domain A-Z')}</option>
                                <option value="input">{t('Your order')}</option>
                            </select>
                        </label>
                        <button type="button" className="btn btn--sm" onClick={exportCsv} disabled={rows.length === 0}>
                            {t('Download CSV')}
                        </button>
                    </div>

                    <div className="table-wrap">
                        <table className="compare-table" data-testid="da-table">
                            <caption className="sr-only">{t('Domain authority results')}</caption>
                            <thead>
                                <tr>
                                    <th scope="col">{t('Domain')}</th>
                                    <th scope="col">{t('Score (0-10)')}</th>
                                    <th scope="col">{t('Global rank')}</th>
                                    <th scope="col">{t('Referring domains')}</th>
                                    <th scope="col"><span className="sr-only">{t('Details')}</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                {rows.map((r) => (
                                    <Fragment key={r.domain}>
                                        <tr>
                                            <th scope="row" className="[overflow-wrap:anywhere]">{r.domain}</th>
                                            <td className="min-w-[150px]">
                                                {r.score === null ? (
                                                    <span className="text-muted">{t('Not found')}</span>
                                                ) : (
                                                    <span className="flex items-center gap-2">
                                                        <strong className="w-10 tabular-nums">{formatNumber(r.score)}</strong>
                                                        <span className="h-2 flex-1 overflow-hidden rounded-full bg-surface-2" aria-hidden="true">
                                                            <span className="block h-full rounded-full" style={{ width: `${r.score * 10}%`, background: tone(r.score) }} />
                                                        </span>
                                                    </span>
                                                )}
                                            </td>
                                            <td className="tabular-nums">{r.rank ? `#${formatNumber(r.rank)}` : '–'}</td>
                                            <td className="tabular-nums">{r.referring_domains ? formatNumber(r.referring_domains) : '–'}</td>
                                            <td>
                                                <button
                                                    type="button"
                                                    className="btn btn--sm"
                                                    aria-expanded={open === r.domain}
                                                    onClick={() => setOpen(open === r.domain ? null : r.domain)}
                                                >
                                                    {open === r.domain ? t('Hide details') : t('Details')}
                                                </button>
                                            </td>
                                        </tr>
                                        {open === r.domain && (
                                            <tr>
                                                <td colSpan={5}>
                                                    <DomainDetails domain={r.domain} />
                                                </td>
                                            </tr>
                                        )}
                                    </Fragment>
                                ))}
                            </tbody>
                        </table>
                    </div>

                    <p className="field__hint">
                        {t('Scores: OpenPageRank (0-10), based on the Common Crawl link graph.')} {t('Details: registry RDAP records, public DNS and the site’s HTTPS certificate.')}
                        {data.as_of ? ` ${t('Data from {date}.', { date: formatDate(data.as_of) })}` : ''}
                    </p>
                </>
            )}
        </div>
    );
}
