// Sends the owner a WhatsApp message after a successful deploy, through the free CallMeBot API.
// Needs the GitHub secrets WHATSAPP_PHONE (international format, e.g. +923001234567) and
// WHATSAPP_APIKEY (from CallMeBot). Does nothing when they are not set.
import { execFileSync } from 'node:child_process';

const phone = process.env.WA_PHONE?.trim();
const apikey = process.env.WA_KEY?.trim();
if (!phone || !apikey) {
    console.log('WhatsApp not configured (WHATSAPP_PHONE / WHATSAPP_APIKEY secrets) - skipped.');
    process.exit(0);
}

// The commits in this deploy, in plain words: "fix(responsive): no sideways..." -> "No sideways...".
const range = process.env.BEFORE && !/^0+$/.test(process.env.BEFORE) ? `${process.env.BEFORE}..HEAD` : '-1';
let subjects = [];
try {
    subjects = execFileSync('git', ['log', '--format=%s', range], { encoding: 'utf8' }).trim().split('\n').filter(Boolean);
} catch {
    subjects = [];
}
const plain = subjects
    .slice(0, 6)
    .map((s) => s.replace(/^[a-z]+(\([^)]*\))?!?:\s*/i, ''))
    .map((s) => `• ${s.charAt(0).toUpperCase()}${s.slice(1)}`);
const more = subjects.length > 6 ? `\n…and ${subjects.length - 6} more` : '';

const text = `✅ ilovemytools.store is updated\n\n${plain.join('\n') || '• Site updated'}${more}\n\nhttps://ilovemytools.store`;
const url = `https://api.callmebot.com/whatsapp.php?phone=${encodeURIComponent(phone)}&text=${encodeURIComponent(text)}&apikey=${encodeURIComponent(apikey)}`;

try {
    const res = await fetch(url);
    console.log(`WhatsApp notification: HTTP ${res.status}`);
} catch (e) {
    console.log(`WhatsApp notification failed: ${e.message}`);
}
