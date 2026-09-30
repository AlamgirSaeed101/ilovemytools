import { Link } from 'react-router';
import Icon from './Icon.jsx';
import { getSite } from '../lib/api.js';
import { t } from '../lib/i18n.js';

export function categoryOf(categorySlug) {
    return getSite().categories.find((c) => c.slug === categorySlug);
}

export function accentFor(categorySlug) {
    return categoryOf(categorySlug)?.accent;
}

/** CSS variables for a category's gradient (used by icon tiles and category cards). */
export function accentStyle(categorySlug) {
    const c = categoryOf(categorySlug);
    return c ? { '--accent': c.accent, '--accent2': c.accent2 || c.accent } : undefined;
}

/** Gradient icon square with a white icon (uses the category colours). Sizes: sm, md, lg. */
export function IconTile({ icon, accent, accent2, size = 'md' }) {
    const style = accent ? { '--accent': accent, '--accent2': accent2 || accent } : undefined;
    return (
        <span className={`icon-tile icon-tile--${size}`} style={style}>
            <Icon name={icon} />
        </span>
    );
}

/** White tool card: icon, name, three-line description and the category label. */
export default function ToolCard({ tool }) {
    const category = categoryOf(tool.category);
    return (
        <Link
            className="tool-card group flex h-full min-w-0 flex-col rounded-2xl border border-line bg-surface p-4 text-ink no-underline shadow-hair transition duration-200 ease-snap hover:-translate-y-1 hover:border-accent/40 hover:text-ink hover:shadow-card sm:p-5"
            to={`/${tool.slug}`}
            style={accentStyle(tool.category)}
        >
            <span className="mb-3">
                <IconTile icon={tool.icon} size="sm" />
            </span>
            <span className="mb-1 block text-[0.95rem] leading-snug font-extrabold tracking-tight [overflow-wrap:anywhere] hyphens-auto">{tool.name}</span>
            <span className="line-clamp-3 text-[0.8rem] leading-relaxed text-muted">{tool.description || tool.tagline}</span>
            {category && (
                <span className="mt-auto block pt-3 text-center text-[0.68rem] font-extrabold tracking-[0.12em] text-muted/80 uppercase">
                    {t('{category} tool', { category: category.short || category.name })}
                </span>
            )}
        </Link>
    );
}

export function ToolGrid({ tools }) {
    return (
        <div className="tool-grid grid grid-cols-2 gap-3 sm:grid-cols-[repeat(auto-fill,minmax(210px,1fr))] sm:gap-4">
            {tools.map((tool) => (
                <ToolCard key={tool.slug} tool={tool} />
            ))}
        </div>
    );
}
