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
    set_env MAIL_FROM_NAME '"${APP_NAME}"'
    [ "$OLD_MAIL" = "$(grep -E '^MAIL_(MAILER|HOST|PASSWORD)=' .env | md5sum)" ] || MAIL_CHANGED=1
    echo "mail settings applied (changed: $MAIL_CHANGED)"
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
rm -rf ~/public_html/build
cp -a ~/toolzy/public/. ~/public_html/
cp ~/index.public_html.php ~/public_html/index.php
rm -f ~/public_html/hot

echo "== 6. Caches"
php artisan optimize:clear >/dev/null
php artisan config:cache
php artisan route:cache
php artisan view:cache

if [ "$MAIL_CHANGED" = 1 ]; then
    echo "== 6b. Test email (mail settings changed)"
    php artisan newsletter:test-mail newsletter@ilovemytools.store || echo "WARNING: test email failed - check the SMTP settings"
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
