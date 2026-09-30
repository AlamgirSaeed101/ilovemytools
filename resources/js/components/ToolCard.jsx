import { Link } from 'react-router';
import Icon from './Icon.jsx';
import { getSite } from '../lib/api.js';

export function accentFor(categorySlug) {
    return getSite().categories.find((c) => c.slug === categorySlug)?.accent;
}

/** Coloured icon square (uses the category accent). Sizes: sm, md, lg. */
export function IconTile({ icon, accent, size = 'md' }) {
    return (
        <span className={`icon-tile icon-tile--${size}`} style={accent ? { '--accent': accent } : undefined}>
            <Icon name={icon} />
        </span>
    );
}

export default function ToolCard({ tool }) {
    return (
        <Link
            className="tool-card group relative flex items-start gap-3.5 rounded-card border border-line bg-surface p-[1.1rem] text-ink no-underline shadow-hair transition duration-200 ease-snap hover:-translate-y-0.5 hover:border-accent/45 hover:text-ink hover:shadow-card hover:ring-4 hover:ring-accent/10"
            to={`/${tool.slug}`}
            style={{ '--accent': accentFor(tool.category) }}
        >
            <IconTile icon={tool.icon} />
            <span className="min-w-0 flex-1">
                <span className="mb-0.5 block font-bold">{tool.name}</span>
                <span className="line-clamp-2 block text-[0.88rem] leading-normal text-muted">{tool.tagline}</span>
            </span>
            <Icon name="arrow" className="icon self-center text-muted opacity-0 transition duration-200 group-hover:text-accent-ink group-hover:opacity-100 ltr:-translate-x-1.5 rtl:translate-x-1.5 rtl:-scale-x-100 group-hover:translate-x-0" />
        </Link>
    );
}

export function ToolGrid({ tools }) {
    return (
        <div className="tool-grid grid grid-cols-[repeat(auto-fill,minmax(260px,1fr))] gap-4">
            {tools.map((tool) => (
                <ToolCard key={tool.slug} tool={tool} />
            ))}
        </div>
    );
}
