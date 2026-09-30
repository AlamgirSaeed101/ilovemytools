import { useEffect, useId, useMemo, useRef, useState } from 'react';
import { useNavigate } from 'react-router';
import Icon from './Icon.jsx';
import { accentFor, IconTile } from './ToolCard.jsx';
import { getSite } from '../lib/api.js';
import { getRecent } from '../lib/recent.js';
import { searchTools } from '../lib/search.js';
import { t } from '../lib/i18n.js';

/** Quick tool search (Ctrl/Cmd + K or "/"). Built on <dialog> for focus trapping and Esc. */
export default function CommandPalette({ open, onClose }) {
    const site = getSite();
    const navigate = useNavigate();
    const dialogRef = useRef(null);
    const listRef = useRef(null);
    const id = useId();
    const [query, setQuery] = useState('');
    const [active, setActive] = useState(0);

    useEffect(() => {
        const dialog = dialogRef.current;
        if (!dialog) return;
        if (open && !dialog.open) {
            setQuery('');
            setActive(0);
            dialog.showModal();
        } else if (!open && dialog.open) {
            dialog.close();
        }
    }, [open]);

    const results = useMemo(() => {
        if (query.trim()) return searchTools(site.tools, query, site.categories);
        const recent = getRecent()
            .map((slug) => site.tools.find((x) => x.slug === slug))
            .filter(Boolean);
        const rest = site.tools.filter((x) => !recent.includes(x));
        return [...recent, ...rest];
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [query, open, site]);

    useEffect(() => {
        listRef.current?.querySelector(`[data-index="${active}"]`)?.scrollIntoView({ block: 'nearest' });
    }, [active]);

    function go(tool) {
        if (!tool) return;
        onClose();
        navigate(`/${tool.slug}`);
    }

    function onKeyDown(e) {
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            setActive((i) => Math.min(results.length - 1, i + 1));
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            setActive((i) => Math.max(0, i - 1));
        } else if (e.key === 'Enter') {
            e.preventDefault();
            go(results[active]);
        }
    }

    const categoryName = (slug) => site.categories.find((c) => c.slug === slug)?.name ?? '';

    return (
        <dialog
            ref={dialogRef}
            className="palette"
            aria-label={t('Search tools')}
            onClose={onClose}
            onClick={(e) => {
                if (e.target === e.currentTarget) onClose();
            }}
        >
            <div className="palette__box">
                <div className="palette__search">
                    <Icon name="search" />
                    <input
                        className="palette__input"
                        type="text"
                        role="combobox"
                        aria-expanded="true"
                        aria-controls={`${id}-list`}
                        aria-activedescendant={results[active] ? `${id}-${results[active].slug}` : undefined}
                        aria-label={t('Search tools')}
                        placeholder={t('Search tools…')}
                        autoComplete="off"
                        spellCheck={false}
                        autoFocus
                        value={query}
                        onChange={(e) => {
                            setQuery(e.target.value);
                            setActive(0);
                        }}
                        onKeyDown={onKeyDown}
                    />
                    <kbd className="kbd">Esc</kbd>
                </div>
                <ul className="palette__list" id={`${id}-list`} role="listbox" ref={listRef} aria-label={t('Tools')}>
                    {results.map((tool, i) => (
                        <li
                            key={tool.slug}
                            id={`${id}-${tool.slug}`}
                            role="option"
                            aria-selected={i === active}
                            data-index={i}
                            className="palette__item"
                            onMouseMove={() => active !== i && setActive(i)}
                            onClick={() => go(tool)}
                        >
                            <IconTile icon={tool.icon} accent={accentFor(tool.category)} size="sm" />
                            <span className="palette__text">
                                <span className="palette__name">{tool.name}</span>
                                <span className="palette__desc">{tool.tagline}</span>
                            </span>
                            <span className="palette__cat">{categoryName(tool.category)}</span>
                        </li>
                    ))}
                    {results.length === 0 && (
                        <li className="palette__empty" role="presentation">
                            {t('No tools match “{query}”. Try another word.', { query })}
                        </li>
                    )}
                </ul>
                <div className="palette__foot" aria-hidden="true">
                    <span><kbd className="kbd">↑</kbd><kbd className="kbd">↓</kbd> {t('to navigate')}</span>
                    <span><kbd className="kbd">Enter</kbd> {t('to open')}</span>
                </div>
            </div>
        </dialog>
    );
}
