const fs = require('fs');
const edit = (f, a, b) => { let s = fs.readFileSync(f, 'utf8'); if (!s.includes(a)) throw new Error(f + ': ' + a); fs.writeFileSync(f, s.replace(a, b)); };

// ssh-run: optional secret on stdin (never on the command line); stdin is always closed.
edit('scripts/cpanel/ssh-run.cjs', "// Usage: node ssh-run.cjs \"<command>\"   (credentials from env: SSH_HOST, SSH_PORT, SSH_USER, SSH_PASS)",
  "// Usage: node ssh-run.cjs \"<command>\"   (credentials from env: SSH_HOST, SSH_PORT, SSH_USER, SSH_PASS)\n// SSH_STDIN (optional) is written to the command's stdin, so secrets never appear in `ps` or logs.");
edit('scripts/cpanel/ssh-run.cjs', "      .stderr.on('data', (d) => process.stderr.write(d));",
  "      .stderr.on('data', (d) => process.stderr.write(d));\n    stream.end(process.env.SSH_STDIN ? process.env.SSH_STDIN + '\n' : '');");

edit('.github/workflows/deploy.yml', "          SSH_PASS: ${{ secrets.SSH_PASS }}\n        run: |\n          node scripts/cpanel/ssh-put.cjs",
  "          SSH_PASS: ${{ secrets.SSH_PASS }}\n          # Newsletter SMTP password: sent to deploy.sh on stdin, written only to the server .env.\n          SSH_STDIN: ${{ secrets.MAIL_PASSWORD }}\n        run: |\n          node scripts/cpanel/ssh-put.cjs");

edit('scripts/cpanel/deploy.sh', 'set -euo pipefail\ncd ~\n', `set -euo pipefail
# The CI passes the SMTP password on stdin (empty line when there is none).
MAIL_PASSWORD_IN=""
IFS= read -r MAIL_PASSWORD_IN || true
cd ~
`);
edit('scripts/cpanel/deploy.sh', 'chmod 600 .env\n', `chmod 600 .env

# Set KEY=VALUE in .env (replace or append) without sed escaping issues.
set_env() {
    if grep -q "^$1=" .env; then
        K="$1" V="$2" awk 'index($0, ENVIRON["K"] "=") == 1 { print ENVIRON["K"] "=" ENVIRON["V"]; next } { print }' .env > .env.tmp
        cat .env.tmp > .env && rm -f .env.tmp
    else
        printf '%s=%s\n' "$1" "$2" >> .env
    fi
}

echo "== 3b. Newsletter email (GoDaddy SMTP)"
MAIL_CHANGED=0
if [ -n "$MAIL_PASSWORD_IN" ]; then
    OLD_MAIL=$(grep -E '^MAIL_(MAILER|HOST|PASSWORD)=' .env | md5sum || true)
    set_env MAIL_MAILER smtp
    set_env MAIL_SCHEME smtps
    set_env MAIL_HOST smtpout.secureserver.net
    set_env MAIL_PORT 465
    set_env MAIL_USERNAME newsletter@ilovemytools.store
    set_env MAIL_PASSWORD "'$MAIL_PASSWORD_IN'"
    set_env MAIL_FROM_ADDRESS newsletter@ilovemytools.store
    set_env MAIL_FROM_NAME '"\${APP_NAME}"'
    [ "$OLD_MAIL" = "$(grep -E '^MAIL_(MAILER|HOST|PASSWORD)=' .env | md5sum)" ] || MAIL_CHANGED=1
    echo "mail settings applied (changed: $MAIL_CHANGED)"
else
    echo "no MAIL_PASSWORD secret - mail settings left as they are"
fi
`);
edit('scripts/cpanel/deploy.sh', 'echo "== 7. Firewall cache', `if [ "$MAIL_CHANGED" = 1 ]; then
    echo "== 6b. Test email (mail settings changed)"
    php artisan newsletter:test-mail newsletter@ilovemytools.store || echo "WARNING: test email failed - check the SMTP settings"
fi

echo "== 7. Firewall cache`);

edit('routes/console.php', "use Illuminate\Support\Facades\Schedule;", "use Illuminate\Support\Facades\Artisan;\nuse Illuminate\Support\Facades\Mail;\nuse Illuminate\Support\Facades\Schedule;");
fs.appendFileSync('routes/console.php', `
// Check the SMTP settings: php artisan newsletter:test-mail you@example.com
Artisan::command('newsletter:test-mail {to}', function (string $to) {
    Mail::raw('This is a test email from '.config('app.name').'. The newsletter email settings work.', function ($message) use ($to) {
        $message->to($to)->subject(config('app.name').' newsletter: test email');
    });
    $this->info('Test email sent to '.$to.' via '.config('mail.default').'.');
})->purpose('Send a test email to check the mail settings');
`);
