import { expect, test } from '@playwright/test';
import { trackErrors } from './helpers.js';

// Every tool in every language must open and render without errors before a deploy.
// The list comes from the site itself, so new tools and new languages are covered automatically.
// (Each tool's behaviour is tested in tools.spec.js / games.spec.js; this checks that none is broken anywhere.)

const site = await (async () => {
    const base = `http://127.0.0.1:${process.env.PORT || 8765}`;
    try {
        return await (await fetch(`${base}/api/site`)).json();
    } catch {
        return null; // the web server is started by Playwright; tests below fail loudly if it isn't up
    }
})();

const locales = site?.locales ?? [{ code: 'en' }];
const tools = site?.tools ?? [];

test.describe('Every tool opens in every language', () => {
    test('the site list was loaded', () => {
        expect(tools.length, 'could not read /api/site').toBeGreaterThan(0);
    });

    for (const { code } of locales) {
        test(`all tools in "${code}"`, async ({ page }) => {
            test.setTimeout(30_000 + tools.length * 8_000);
            const prefix = code === site?.defaultLocale || code === 'en' ? '' : `/${code}`;
            for (const tool of tools) {
                const errors = trackErrors(page);
                await page.goto(`${prefix}/${tool.slug}`);
                await expect(page.locator('h1'), `${code}/${tool.slug}: heading`).toBeVisible();
                await expect(page.locator('.tool-panel .tool-loading'), `${code}/${tool.slug}: still loading`).toHaveCount(0, { timeout: 15_000 });
                const panel = page.locator('.tool-panel');
                await expect(panel, `${code}/${tool.slug}: tool panel`).toBeVisible();
                await expect(panel.locator('.notice--error'), `${code}/${tool.slug}: tool shows an error`).toHaveCount(0);
                await expect(page.locator('html'), `${code}/${tool.slug}: page language`).toHaveAttribute('lang', new RegExp(`^${code}`, 'i'));
                errors.assertNone();
                page.removeAllListeners('console');
                page.removeAllListeners('pageerror');
            }
        });
    }
});
