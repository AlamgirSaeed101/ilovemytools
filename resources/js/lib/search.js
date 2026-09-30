// Tool search used by the home page filter and the Ctrl+K command palette.
// Every word typed must match somewhere; better matches rank higher.

function normalize(text) {
    return String(text || '')
        .toLocaleLowerCase()
        .normalize('NFD')
        .replace(/[̀-ͯ]/g, '');
}

export function searchTools(tools, query, categories = []) {
    const terms = normalize(query).split(/\s+/).filter(Boolean);
    if (terms.length === 0) return tools;

    const categoryNames = Object.fromEntries(categories.map((c) => [c.slug, normalize(c.name)]));

    return tools
        .map((tool, index) => {
            const name = normalize(tool.name);
            const keywords = normalize((tool.keywords || []).join(' '));
            const rest = `${normalize(tool.tagline)} ${categoryNames[tool.category] || ''} ${tool.slug}`;
            let score = 0;
            for (const term of terms) {
                if (name.startsWith(term)) score += 12;
                else if (new RegExp(`\\b${term.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')}`).test(name)) score += 8;
                else if (name.includes(term)) score += 6;
                else if (keywords.includes(term)) score += 4;
                else if (rest.includes(term)) score += 2;
                else return null;
            }
            return { tool, score, index };
        })
        .filter(Boolean)
        .sort((a, b) => b.score - a.score || a.index - b.index)
        .map((r) => r.tool);
}
