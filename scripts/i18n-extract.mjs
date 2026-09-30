// Collects every interface string that needs translating and writes
// lang/keys.json (the English source list used by translators and tests).
//
//   node scripts/i18n-extract.mjs
//
// Finds t('...'), tn('one', 'other', n) and tr('...') in resources/js,
// t('...') in Blade views and Locale::t('...') in PHP. Labels that are passed
// to t() through variables are listed in DYNAMIC below.
import fs from 'node:fs';
import path from 'node:path';

const root = path.resolve(import.meta.dirname, '..');

// Strings translated through a variable (t(label), t(opt.label)...).
const DYNAMIC = [
    // Header quick links, footer and tool page badges
    'Merge PDF', 'Split PDF', 'Compress Image', 'QR Code', 'Private', 'Free', 'Fast', 'Runs in your browser', 'No sign up',
    // Home page
    'Private by design', 'Files and text are processed on your own device. Nothing is uploaded, stored or shared.',
    'Works on any device', 'Chrome, Safari, Edge or Firefox on a phone, tablet or computer. No app to install.',
    'Free, with no limits', 'No accounts, no daily caps and no watermarks. Use every tool as often as you like.',
    'Your PDFs, photos and documents never leave your browser', 'No sign up, no email address, no watermarks on your files',
    'Instant results - no waiting in an upload or download queue', 'free tools', 'files uploaded', 'in your browser',
    // About page
    'Privacy first', 'Our tools process your files and text directly in your web browser. PDFs, images and documents never leave your device.',
    'Free forever', 'Every tool is free with no account, no daily limit and no watermark. The site is supported by unobtrusive advertising.',
    'Fast and simple', 'Each tool does one job well, loads quickly and works on phones, tablets and computers.',
    // Info page titles/descriptions (app/Support/SiteData.php)
    'About Us', 'Contact Us', 'Privacy Policy', 'Terms of Use',
    'Learn about {name}, a collection of free, private online tools that run in your browser with no sign up.',
    'Get in touch with the {name} team to report a bug, suggest a new tool or ask a question.',
    'How {name} handles your data, cookies and advertising. Files and text you use in our tools are processed in your browser.',
    'The terms and conditions for using {name} free online tools.',
    // Password options
    'Uppercase (A-Z)', 'Lowercase (a-z)', 'Numbers (0-9)', 'Symbols (!@#$…)', 'Exclude similar (l, 1, O, 0)',
    // QR types
    'URL', 'Text', 'Wi-Fi', 'Email', 'Phone', 'SMS',
    // Split PDF modes
    'Extract pages', 'Split by ranges', 'Split every page',
    // Case names
    'UPPERCASE', 'lowercase', 'Title Case', 'Sentence case',
    // Sleep calculator
    'Wake up at…', 'Go to bed at…', 'Sleep now', 'Hours slept', 'Awake', 'REM', 'Light', 'Deep',
    // Spin the wheel sample entries
    'Pizza', 'Burgers', 'Sushi', 'Tacos', 'Pasta', 'Salad', 'Curry', 'Ramen',
];

// JS string literal: '...' or "..." with escapes (no template literals as keys).
const STR = String.raw`('(?:[^'\\]|\\.)*'|"(?:[^"\\]|\\.)*")`;
const unquote = (s) => {
    const q = s[0];
    return s
        .slice(1, -1)
        .replace(new RegExp(`\\\\${q}`, 'g'), q)
        .replace(/\\n/g, '\n')
        .replace(/\\\\/g, '\\');
};

function walk(dir, exts, out = []) {
    for (const entry of fs.readdirSync(dir, { withFileTypes: true })) {
        const p = path.join(dir, entry.name);
        if (entry.isDirectory()) walk(p, exts, out);
        else if (exts.some((e) => entry.name.endsWith(e)) && !entry.name.endsWith('.test.js')) out.push(p);
    }
    return out;
}

const keys = new Map(); // key -> { plural?: {one} , files: Set }
const add = (key, file, extra = {}) => {
    if (!key) return;
    const item = keys.get(key) ?? { files: new Set() };
    Object.assign(item, extra);
    item.files.add(path.relative(root, file).replace(/\\/g, '/'));
    keys.set(key, item);
};

for (const file of walk(path.join(root, 'resources/js'), ['.js', '.jsx'])) {
    const src = fs.readFileSync(file, 'utf8');
    for (const m of src.matchAll(new RegExp(String.raw`\b(?:t|tr)\(\s*${STR}`, 'g'))) add(unquote(m[1]), file);
    for (const m of src.matchAll(new RegExp(String.raw`\btn\(\s*${STR}\s*,\s*${STR}`, 'g'))) add(unquote(m[2]), file, { plural: { one: unquote(m[1]) } });
}
for (const file of walk(path.join(root, 'resources/views'), ['.blade.php'])) {
    const src = fs.readFileSync(file, 'utf8');
    for (const m of src.matchAll(new RegExp(String.raw`\bt\(\s*${STR}`, 'g'))) add(unquote(m[1]), file);
}
for (const file of walk(path.join(root, 'app'), ['.php'])) {
    const src = fs.readFileSync(file, 'utf8');
    for (const m of src.matchAll(new RegExp(String.raw`Locale::t\(\s*${STR}`, 'g'))) add(unquote(m[1]), file);
}
for (const key of DYNAMIC) add(key, path.join(root, 'scripts/i18n-extract.mjs'));

const list = [...keys.entries()]
    .sort(([a], [b]) => a.localeCompare(b, 'en'))
    .map(([key, v]) => ({ key, ...(v.plural ? { one: v.plural.one } : {}), files: [...v.files].sort() }));

fs.mkdirSync(path.join(root, 'lang'), { recursive: true });
fs.writeFileSync(path.join(root, 'lang/keys.json'), JSON.stringify(list, null, 2) + '\n');
console.log(`${list.length} interface strings (${list.filter((k) => k.one).length} with plural forms) -> lang/keys.json`);
