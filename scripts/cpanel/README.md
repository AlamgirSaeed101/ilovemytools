# Deploying to cPanel (ilovemytools.store)

Layout on the server:

- `~/toolzy` - the Laravel app (outside the web root; holds `.env`, `vendor`, `storage`)
- `~/public_html` - public files only, copied from `~/toolzy/public`, plus `index.php`
  from `index.public_html.php`, which loads the app from `../toolzy`
- `~/public_html_original` - cPanel's original placeholder page (backup)

## Update the live site

1. On your computer: `npm run build` (and delete `public/hot` if it exists).
2. Pack the project without `node_modules`, `vendor`, `.env`, logs and caches:

   ```bash
   tar -czf release.tgz --exclude=./node_modules --exclude=./vendor --exclude=./.env \
     --exclude=./test-results --exclude=./playwright-report --exclude=./public/hot \
     --exclude='./storage/logs/*.log' --exclude='./storage/framework/views/*.php' \
     --exclude='./bootstrap/cache/*.php' .
   ```

3. Upload `release.tgz`, `scripts/cpanel/deploy.sh` and `scripts/cpanel/index.public_html.php`
   to your home folder (cPanel File Manager, SFTP or `scp`), then over SSH run `bash ~/deploy.sh`.

The script keeps the server's `.env` (it only creates one on the first deploy, from
`~/env.production` - see `env.production.example`), installs PHP packages without dev tools,
generates the app key once, copies the public files and rebuilds Laravel's caches.

## Change a setting on the live site

Edit `~/toolzy/.env` (for example `CONTACT_EMAIL`, `ADSENSE_SLOT_*`), then run:

```bash
cd ~/toolzy && php artisan config:cache
```
