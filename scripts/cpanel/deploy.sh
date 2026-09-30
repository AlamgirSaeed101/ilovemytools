#!/bin/bash
# Deploy Toolzy on cPanel: app in ~/toolzy, public files in ~/public_html.
set -euo pipefail
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
