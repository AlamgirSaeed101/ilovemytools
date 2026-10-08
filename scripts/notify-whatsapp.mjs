// Tells the owner on their phone after a successful deploy. Uses whichever is configured (GitHub secrets):
//   Twilio:    TWILIO_ACCOUNT_SID, TWILIO_AUTH_TOKEN, TWILIO_FROM (an SMS number like +15551234567, or
//              "whatsapp:+14155238886" for a WhatsApp sender) and NOTIFY_TO (your number, +923001234567)
//   CallMeBot: WHATSAPP_PHONE and WHATSAPP_APIKEY (free WhatsApp API)
// Does nothing when neither is set. Never fails the deploy.
import { execFileSync } from 'node:child_process';

const env = (k) => process.env[k]?.trim() || '';

// The commits in this deploy, in plain words: "fix(responsive): no sideways..." -> "No sideways...".
const before = env('BEFORE');
const range = before && !/^0+$/.test(before) ? `${before}..HEAD` : '-1';
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

async function twilio() {
    const sid = env('TWILIO_ACCOUNT_SID');
    const token = env('TWILIO_AUTH_TOKEN');
    const from = env('TWILIO_FROM');
    let to = env('NOTIFY_TO');
    if (!sid || !token || !from || !to) return false;
    if (from.startsWith('whatsapp:') && !to.startsWith('whatsapp:')) to = `whatsapp:${to}`;
    const res = await fetch(`https://api.twilio.com/2010-04-01/Accounts/${sid}/Messages.json`, {
        method: 'POST',
        headers: { Authorization: `Basic ${Buffer.from(`${sid}:${token}`).toString('base64')}`, 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ From: from, To: to, Body: text.slice(0, 1500) }),
    });
    const body = await res.json().catch(() => ({}));
    console.log(`Twilio: HTTP ${res.status}${body.message ? ` - ${body.message}` : ''}`);
    return true;
}

async function callMeBot() {
    const phone = env('WA_PHONE');
    const apikey = env('WA_KEY');
    if (!phone || !apikey) return false;
    const res = await fetch(`https://api.callmebot.com/whatsapp.php?phone=${encodeURIComponent(phone)}&text=${encodeURIComponent(text)}&apikey=${encodeURIComponent(apikey)}`);
    console.log(`CallMeBot: HTTP ${res.status}`);
    return true;
}

try {
    const sent = [await twilio(), await callMeBot()].some(Boolean);
    if (!sent) console.log('No phone notification configured (Twilio or CallMeBot secrets) - skipped.');
} catch (e) {
    console.log(`Phone notification failed: ${e.message}`);
}
