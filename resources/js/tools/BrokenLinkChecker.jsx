import { useMemo, useRef, useState } from 'react';
import { Notice, Stat, Tabs } from '../components/ui.jsx';
import { formatNumber, t } from '../lib/i18n.js';
import { chunk, classifyLink, toCsv } from '../lib/links.js';
import { downloadText } from '../lib/util.js';

const BATCH = 10;

const LABELS = {
    ok: 'OK',
    redirect: 'Redirect',
    broken: 'Broken',
    blocked: 'Blocked',
    error: 'No answer',
};

const TONES = {
    ok: 'bg-success-soft text-success',
    redirect: 'bg-[#fef3c7] text-[#92400e]',
    broken: 'bg-danger-soft text-danger',
    blocked: 'bg-surface-2 text-ink-2',
    error: 'bg-surface-2 text-ink-2',
};

async function postJson(url, body) {
    const res = await fetch(url, {
        method: 'POST',
        headers: { Accept: 'application/json', 'Content-Type': 'application/json' },
        body: JSON.stringify(body),
    });
    return { status: res.status, data: await res.json().catch(() => ({})) };
}

function extractError(status, data) {
    if (status === 429) return t('Too many checks in a short time. Please wait a minute and try again.');
    switch (data.error) {
        case 'invalid-url':
            return t('Please enter a valid web address, for example example.com/page.');
        case 'not-allowed':
            return t('This address can’t be checked. Only public websites on normal web ports are supported.');
        case 'dns':
            return t('That website could not be found. Check the address for typos.');
        case 'unreachable':
            return t('The website did not respond. It may be down or blocking automated checks.');
        case 'status':
            return t('The page answered with error {status}, so its links could not be read.', { status: data.status });
        case 'not-html':
            return t('That address is not a web page (HTML), so there are no links to check.');
        case 'too-many-redirects':
            return t('The page redirects too many times.');
        default:
            return t('Something went wrong. Please try again.');
    }
}

function statusText(r) {
    if (r.error === 'dns') return t('Domain not found');
    if (r.error === 'unreachable') return t('No response');
    if (r.error === 'not-allowed') return t('Not checked');
    if (r.error === 'too-many-redirects') return t('Too many redirects');
    return String(r.status);
}

export default function BrokenLinkChecker() {
    const [input, setInput] = useState('');
    const [page, setPage] = useState(null); // { url, links, truncated }
    const [results, setResults] = useState({}); // url -> result
    const [running, setRunning] = useState(false);
    const [error, setError] = useState('');
    const [filter, setFilter] = useState('problems');
    const stop = useRef(false);

    const rows = useMemo(
        () => (page ? page.links.map((l) => ({ ...l, result: results[l.url], kind: results[l.url] ? classifyLink(results[l.url]) : null })) : []),
        [page, results],
    );
    const counts = useMemo(() => {
        const c = { ok: 0, redirect: 0, broken: 0, blocked: 0, error: 0, done: 0 };
        for (const r of rows) if (r.kind) {
            c[r.kind]++;
            c.done++;
        }
        return c;
    }, [rows]);
    const visible = rows.filter((r) => {
        if (!r.kind) return filter === 'all';
        if (filter === 'problems') return r.kind === 'broken' || r.kind === 'error' || r.kind === 'blocked';
        if (filter === 'all') return true;
        return r.kind === filter;
    });

    const start = async (e) => {
        e.preventDefault();
        if (running || !input.trim()) return;
        setError('');
        setPage(null);
        setResults({});
        setFilter('problems');
        stop.current = false;
        setRunning(true);
        try {
            const { status, data } = await postJson('/api/links/extract', { url: input.trim() });
            if (status !== 200 || data.error) {
                setError(extractError(status, data));
                return;
            }
            setPage(data);
            for (const batch of chunk(data.links.map((l) => l.url), BATCH)) {
                if (stop.current) break;
                const res = await postJson('/api/links/check', { urls: batch });
                if (res.status === 429) {
                    setError(t('Too many checks in a short time. Please wait a minute and try again.'));
                    break;
                }
                if (res.status !== 200) {
                    setError(t('Something went wrong. Please try again.'));
                    break;
                }
                setResults((prev) => {
                    const next = { ...prev };
                    for (const r of res.data.results) next[r.url] = r;
                    return next;
                });
            }
        } catch {
            setError(t('Something went wrong. Please try again.'));
        } finally {
            setRunning(false);
        }
    };

    const exportCsv = () => {
        const host = page ? new URL(page.url).hostname : 'links';
        downloadText(
            toCsv([
                ['URL', 'Status', 'Result', 'Final URL', 'Link text', 'Type', 'Internal'],
                ...rows.filter((r) => r.result).map((r) => [r.url, statusText(r.result), LABELS[r.kind], r.result.final, r.text, r.type, r.internal ? 'yes' : 'no']),
            ]),
            `${host}-links.csv`,
            'text/csv',
        );
    };

    const total = page?.links.length ?? 0;
    const progress = total ? Math.round((counts.done / total) * 100) : 0;

    return (
        <div className="stack">
            <form className="field" onSubmit={start}>
                <label className="field__label" htmlFor="blc-url">{t('Page address (URL)')}</label>
                <div className="flex flex-col gap-2 sm:flex-row">
                    <input
                        id="blc-url"
                        className="input min-w-0 flex-1"
                        type="text"
                        inputMode="url"
                        autoComplete="url"
                        spellCheck={false}
                        placeholder="https://example.com/page"
                        value={input}
                        onChange={(e) => setInput(e.target.value)}
                    />
                    {running ? (
                        <button type="button" className="btn btn--danger" onClick={() => (stop.current = true)}>
                            {t('Stop')}
                        </button>
                    ) : (
                        <button type="submit" className="btn btn--primary" disabled={!input.trim()}>
                            {t('Check links')}
                        </button>
                    )}
                </div>
                <p className="field__hint">{t('Checks every link and image on one page (up to 300).')}</p>
            </form>

            <Notice type="error">{error}</Notice>

            {page && (
                <>
                    <div className="result" aria-live="polite" data-testid="blc-summary">
                        <p className="m-0 mb-2 font-bold">
                            {running
                                ? t('Checking {done} of {total} links…', { done: formatNumber(counts.done), total: formatNumber(total) })
                                : t('Checked {done} of {total} links on {url}', { done: formatNumber(counts.done), total: formatNumber(total), url: page.url })}
                        </p>
                        <div className="h-2 overflow-hidden rounded-full bg-surface-2" aria-hidden="true">
                            <div className="h-full rounded-full bg-brand transition-[width]" style={{ width: `${progress}%` }} />
                        </div>
                        {page.truncated && <p className="mt-2 mb-0 text-[0.85rem] text-muted">{t('This page has more than 300 links; the first 300 were checked.')}</p>}
                    </div>

                    <div className="stats">
                        <Stat value={formatNumber(counts.broken)} label={t('Broken')} />
                        <Stat value={formatNumber(counts.redirect)} label={t('Redirects')} />
                        <Stat value={formatNumber(counts.ok)} label={t('OK')} />
                        <Stat value={formatNumber(counts.blocked + counts.error)} label={t('Blocked or no answer')} />
                    </div>

                    <div className="row row--between">
                        <Tabs
                            label={t('Show')}
                            value={filter}
                            onChange={setFilter}
                            tabs={[
                                { id: 'problems', label: t('Problems') },
                                { id: 'redirect', label: t('Redirects') },
                                { id: 'ok', label: t('OK') },
                                { id: 'all', label: t('All') },
                            ]}
                        />
                        <button type="button" className="btn btn--sm" onClick={exportCsv} disabled={counts.done === 0}>
                            {t('Download CSV')}
                        </button>
                    </div>

                    {visible.length === 0 ? (
                        <p className="field__hint" data-testid="blc-empty">
                            {running ? t('No problems found so far…') : filter === 'problems' ? t('No broken links found on this page.') : t('Nothing to show.')}
                        </p>
                    ) : (
                        <div className="table-wrap">
                            <table className="compare-table" data-testid="blc-table">
                                <caption className="sr-only">{t('Link check results')}</caption>
                                <thead>
                                    <tr>
                                        <th scope="col">{t('Status')}</th>
                                        <th scope="col">{t('Link')}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {visible.slice(0, 300).map((r) => (
                                        <tr key={r.url}>
                                            <td className="whitespace-nowrap align-top">
                                                {r.result ? (
                                                    <span className={`inline-block rounded-full px-2.5 py-0.5 text-[0.8rem] font-bold ${TONES[r.kind]}`}>
                                                        {statusText(r.result)} · {t(LABELS[r.kind])}
                                                    </span>
                                                ) : (
                                                    <span className="text-muted">…</span>
                                                )}
                                            </td>
                                            <td className="min-w-0 align-top">
                                                <a href={r.url} target="_blank" rel="nofollow noopener noreferrer" className="[overflow-wrap:anywhere]">
                                                    {r.url}
                                                </a>
                                                <div className="text-[0.82rem] text-muted">
                                                    {r.type === 'image' ? t('Image') : t('Link')}
                                                    {r.text ? ` · “${r.text}”` : ''} · {r.internal ? t('Internal') : t('External')}
                                                    {r.result?.redirects > 0 && ` · ${t('redirects to {url}', { url: r.result.final })}`}
                                                </div>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    )}
                </>
            )}
        </div>
    );
}
