#!/bin/bash
# Deploy Toolzy on cPanel: app in ~/toolzy, public files in ~/public_html.
set -euo pipefail
# The CI passes the SMTP password on stdin (empty line when there is none).
MAIL_PASSWORD_IN=""
IFS= read -r MAIL_PASSWORD_IN || true
cd ~

echo "== 1. Back up cPanel's placeholder page (first deploy only)"
if [ -f ~/public_html/home.html ] && [ ! -d ~/public_html_original ]; then
    mkdir ~/public_html_original
    mv ~/public_html/home.html ~/public_html/404.shtml ~/public_html/layout-styles.css ~/public_html_original/ 2>/dev/null || true
    echo "moved to ~/public_html_original"
fi

echo "== 2. Unpack the release into ~/toolzy"
mkdir -p ~/toolzy
tar -xzf ~/release.tgz -C ~/toolzy
cd ~/toolzy

echo "== 3. Environment"
if [ ! -f .env ]; then cp ~/env.production .env; echo "created .env from env.production"; else echo "kept existing .env"; fi
chmod 600 .env

# Set KEY=VALUE in .env (replace or append) without sed escaping issues.
set_env() {
    if grep -q "^$1=" .env; then
        K="$1" V="$2" awk 'index($0, ENVIRON["K"] "=") == 1 { print ENVIRON["K"] "=" ENVIRON["V"]; next } { print }' .env > .env.tmp
        cat .env.tmp > .env && rm -f .env.tmp
    else
        printf '%s=%s\n' "$1" "$2" >> .env
    fi
}

echo "== 3b. Newsletter email account"
if [ -n "$MAIL_PASSWORD_IN" ]; then
    set_env MAIL_USERNAME newsletter@ilovemytools.store
    set_env MAIL_PASSWORD "'$MAIL_PASSWORD_IN'"
    set_env MAIL_FROM_ADDRESS newsletter@ilovemytools.store
    set_env MAIL_FROM_NAME '"${APP_NAME}"'
else
    echo "no MAIL_PASSWORD secret - mail settings left as they are"
fi

echo "== 4. PHP packages"
composer install --no-dev --optimize-autoloader --no-interaction --no-progress 2>&1 | tail -4
grep -q '^APP_KEY=base64:' .env || php artisan key:generate --force

mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache
chmod -R u+rwX,go-w storage bootstrap/cache

echo "== 4b. Database (newsletter subscribers)"
# SQLite in ~/toolzy/database; the release never contains it, so it survives deploys.
[ -f database/database.sqlite ] || { touch database/database.sqlite; echo "created database/database.sqlite"; }
chmod 600 database/database.sqlite
# Keep the last 5 copies before migrating.
if [ -s database/database.sqlite ]; then cp database/database.sqlite "database/database.sqlite.bak-$(date +%Y%m%d%H%M%S)"; fi
(ls -1t database/database.sqlite.bak-* 2>/dev/null | tail -n +6 | xargs -r rm -f) || true
php artisan migrate --force

echo "== 4c. Scheduler (cron, installed once)"
CRON_LINE='* * * * * cd ~/toolzy && php artisan schedule:run >> /dev/null 2>&1'
if crontab -l 2>/dev/null | grep -qF 'artisan schedule:run'; then
    echo "cron already installed"
else
    (crontab -l 2>/dev/null; echo "$CRON_LINE") | crontab - && echo "cron installed" || echo "WARNING: could not install cron - add it in cPanel > Cron Jobs: $CRON_LINE"
fi

echo "== 5. Public files -> ~/public_html"
# Keep earlier builds' hashed assets for a week: cached pages may still point at them.
cp -a ~/toolzy/public/. ~/public_html/
find ~/public_html/build/assets -type f -mtime +7 -delete 2>/dev/null || true
cp ~/index.public_html.php ~/public_html/index.php
rm -f ~/public_html/hot

echo "== 6. Caches"
php artisan optimize:clear >/dev/null
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "== 6b. Email delivery check"
# GoDaddy hosting often blocks outgoing SMTP, so try each way to send and keep
# the first that works. Runs again only when the password or this list changes.
MAIL_MARK=storage/app/mail-verified
MAIL_SIG=$(printf 'v2:%s' "$MAIL_PASSWORD_IN" | md5sum | cut -d' ' -f1)
mail_try() { # mailer scheme host port auth(yes/no)
    set_env MAIL_MAILER "$1"; set_env MAIL_SCHEME "$2"; set_env MAIL_HOST "$3"; set_env MAIL_PORT "$4"
    if [ "$5" = yes ]; then set_env MAIL_USERNAME newsletter@ilovemytools.store; set_env MAIL_PASSWORD "'$MAIL_PASSWORD_IN'"
    else set_env MAIL_USERNAME ''; set_env MAIL_PASSWORD ''; fi
    php artisan config:clear >/dev/null
    if out=$(timeout 45 php artisan newsletter:test-mail newsletter@ilovemytools.store 2>&1); then
        echo "OK: $1 $3:$4"; return 0
    fi
    echo "failed: $1 $3:$4 - $(echo "$out" | tr -s ' \n' ' ' | cut -c1-160)"; return 1
}
if [ -n "$MAIL_PASSWORD_IN" ] && [ "$(cat "$MAIL_MARK" 2>/dev/null)" != "$MAIL_SIG" ]; then
    if mail_try smtp smtps smtpout.secureserver.net 465 yes \
        || mail_try smtp smtp smtpout.secureserver.net 587 yes \
        || mail_try sendmail '' '' '' no \
        || mail_try smtp smtp localhost 25 no; then
        echo "$MAIL_SIG" > "$MAIL_MARK"
        echo "test email sent to newsletter@ilovemytools.store"
    else
        set_env MAIL_MAILER log
        echo "WARNING: no way to send email works from this server - mail stays off (MAIL_MAILER=log)"
    fi
    php artisan config:cache
else
    echo "mail already checked - skipped"
fi

echo "== 7. Firewall cache (GoDaddy / Sucuri)"
# Keys live only in the server .env (SUCURI_API_KEY / SUCURI_API_SECRET), never in the repo.
SUCURI_KEY=$(grep -E '^SUCURI_API_KEY=' .env | cut -d= -f2- | tr -d '"\r')
SUCURI_SECRET=$(grep -E '^SUCURI_API_SECRET=' .env | cut -d= -f2- | tr -d '"\r')
if [ -n "$SUCURI_KEY" ] && [ -n "$SUCURI_SECRET" ]; then
    curl -s -m 20 "https://waf.sucuri.net/api?v2" --data "k=$SUCURI_KEY&s=$SUCURI_SECRET&a=clear_cache" \
        | grep -q '"status":1' && echo "firewall cache cleared" || echo "WARNING: firewall cache clear failed"
else
    echo "no SUCURI_API_KEY/SUCURI_API_SECRET in .env - skipped"
fi

rm -f ~/release.tgz ~/env.production ~/index.public_html.php ~/deploy.sh
echo "== done"
