import { expect, test } from '@playwright/test';
import { openTool, trackErrors } from './helpers.js';

test.describe('App shell', () => {
    test('home page renders every tool, with no errors', async ({ page }) => {
        const t = trackErrors(page);
        await page.goto('/');
        await expect(page.getByRole('heading', { level: 1 })).toContainText('free online tools you need');
        // The server-rendered copy is replaced by the React app.
        await expect(page.locator('#app > .ssr')).toHaveCount(0);

        const site = await page.evaluate(() => JSON.parse(document.getElementById('boot-data').textContent).site);
        for (const tool of site.tools) {
            await expect(page.locator(`main a.tool-card[href="/${tool.slug}"]`).first()).toBeVisible();
        }
        t.assertNone();
    });

    test('home filter pills show one category at a time', async ({ page }) => {
        await page.goto('/');
        const pills = page.getByRole('group', { name: 'Filter by category' });
        const tiles = page.locator('main .tile-grid a.tool-card');
        await expect(tiles).toHaveCount(20);

        await pills.getByRole('button', { name: 'PDF Tools' }).click();
        await expect(pills.getByRole('button', { name: 'PDF Tools' })).toHaveAttribute('aria-pressed', 'true');
        await expect(tiles).toHaveCount(2);
        await expect(tiles.first()).toContainText('Merge PDF');

        await pills.getByRole('button', { name: 'Developer Tools' }).click();
        await expect(tiles).toHaveCount(3);

        await pills.getByRole('button', { name: 'All' }).click();
        await expect(tiles).toHaveCount(20);
        // The "Suggest a tool" card is always last.
        await expect(page.locator('main .tile-grid > a').last()).toHaveAttribute('href', '/contact');
    });

    test('links navigate inside the app without a full reload and update the head', async ({ page }) => {
        const t = trackErrors(page);
        await page.goto('/');
        await page.evaluate(() => (window.__spaMarker = 'still-here'));

        await page.locator('main a.tool-card[href="/merge-pdf"]').first().click();
        await expect(page).toHaveURL(/\/merge-pdf$/);
        await expect(page.getByRole('heading', { level: 1 })).toHaveText('Merge PDF Files');
        expect(await page.evaluate(() => window.__spaMarker)).toBe('still-here');
        await expect(page).toHaveTitle(/Merge PDF/);
        await expect(page.locator('link[rel="canonical"]')).toHaveAttribute('href', /\/merge-pdf$/);

        // Breadcrumb to the category, then back.
        await page.getByRole('navigation', { name: 'Breadcrumb' }).getByRole('link', { name: 'PDF Tools' }).click();
        await expect(page).toHaveURL(/\/category\/pdf-tools$/);
        await expect(page.getByRole('heading', { level: 1 })).toHaveText('PDF Tools');
        await page.goBack();
        await expect(page).toHaveURL(/\/merge-pdf$/);
        expect(await page.evaluate(() => window.__spaMarker)).toBe('still-here');
        t.assertNone();
    });

    test('command palette opens with Ctrl+K and "/" and navigates', async ({ page }) => {
        await page.goto('/about');
        await page.keyboard.press('Control+k');
        const dialog = page.getByRole('dialog', { name: 'Search tools' });
        await expect(dialog).toBeVisible();
        await page.keyboard.type('split');
        await expect(dialog.getByRole('option').first()).toContainText('Split PDF');
        await page.keyboard.press('Enter');
        await expect(page).toHaveURL(/\/split-pdf$/);
        await expect(dialog).toBeHidden();

        await page.locator('body').click({ position: { x: 5, y: 300 } });
        await page.keyboard.press('/');
        await expect(dialog).toBeVisible();
        await page.keyboard.type('json');
        await page.keyboard.press('ArrowDown');
        await page.keyboard.press('ArrowUp');
        await page.keyboard.press('Enter');
        await expect(page).toHaveURL(/\/json-formatter$/);

        await page.keyboard.press('Control+k');
        await page.keyboard.press('Escape');
        await expect(dialog).toBeHidden();
    });

    test('header quick links and the All tools menu', async ({ page }) => {
        await page.goto('/');
        const nav = page.getByRole('navigation', { name: 'Main' });
        await nav.getByRole('link', { name: 'Split PDF' }).click();
        await expect(page).toHaveURL(/\/split-pdf$/);

        await nav.getByRole('button', { name: 'All tools' }).click();
        await nav.getByRole('link', { name: 'Percentage Calculator' }).click();
        await expect(page).toHaveURL(/\/percentage-calculator$/);

        await nav.getByRole('button', { name: 'All tools' }).click();
        await nav.getByRole('link', { name: 'Calculators' }).click();
        await expect(page).toHaveURL(/\/category\/calculators$/);
        await expect(page.locator('main .tool-grid .tool-card')).toHaveCount(2);
    });

    test('dark mode is the default and a light choice is remembered', async ({ page }) => {
        // Even when the device prefers light, the site starts dark.
        await page.emulateMedia({ colorScheme: 'light' });
        await page.goto('/');
        await expect(page.locator('html')).toHaveAttribute('data-theme', 'dark');
        expect(await page.evaluate(() => getComputedStyle(document.body).backgroundColor)).toBe('rgb(11, 16, 32)');

        await page.getByRole('button', { name: 'Switch to light mode' }).click();
        await expect(page.locator('html')).toHaveAttribute('data-theme', 'light');
        await page.reload();
        await expect(page.locator('html')).toHaveAttribute('data-theme', 'light');
        expect(await page.evaluate(() => getComputedStyle(document.body).backgroundColor)).toBe('rgb(246, 247, 251)');

        await page.getByRole('button', { name: 'Switch to dark mode' }).click();
        await page.reload();
        await expect(page.locator('html')).toHaveAttribute('data-theme', 'dark');
    });

    test('recently used tools are listed first in the search palette', async ({ page }) => {
        await openTool(page, 'split-pdf');
        await page.goto('/');
        await page.locator('main .tile-grid').waitFor();
        await page.keyboard.press('Control+k');
        await expect(page.getByRole('dialog', { name: 'Search tools' }).getByRole('option').first()).toContainText('Split PDF');
    });

    test('unknown pages show a 404 (server status and in-app)', async ({ page }) => {
        const response = await page.goto('/this-does-not-exist');
        expect(response.status()).toBe(404);
        await expect(page.getByRole('heading', { level: 1 })).toHaveText('Page not found');
        await expect(page.locator('meta[name="robots"]')).toHaveAttribute('content', /noindex/);

        const nested = await page.goto('/category/nope');
        expect(nested.status()).toBe(404);
        await expect(page.getByRole('heading', { level: 1 })).toHaveText('Page not found');

        await page.goto('/');
        await page.evaluate(() => {
            window.history.pushState({}, '', '/also-missing');
            window.dispatchEvent(new PopStateEvent('popstate'));
        });
        await expect(page.getByRole('heading', { level: 1 })).toHaveText('Page not found');
    });

    test('info pages render', async ({ page }) => {
        const t = trackErrors(page);
        for (const [path, h1] of [['/about', /About/], ['/contact', 'Contact Us'], ['/privacy-policy', 'Privacy Policy'], ['/terms', 'Terms of Use']]) {
            await page.goto(path);
            await expect(page.getByRole('heading', { level: 1 })).toHaveText(h1);
        }
        await expect(page.getByRole('link', { name: 'Google Ads Settings' })).toHaveCount(0);
        await page.goto('/privacy-policy');
        await expect(page.getByRole('link', { name: 'Google Ads Settings' })).toHaveAttribute('href', 'https://adssettings.google.com');
        t.assertNone();
    });

    test('ad placeholders reserve space locally', async ({ page }) => {
        await page.goto('/word-counter');
        await expect(page.locator('.ad--below_tool .ad__placeholder')).toBeVisible();
    });

    test('pages work without JavaScript (crawler view)', async ({ browser }) => {
        const context = await browser.newContext({ javaScriptEnabled: false });
        const page = await context.newPage();
        await page.goto('/merge-pdf');
        await expect(page.getByRole('heading', { level: 1 })).toHaveText('Merge PDF Files');
        await expect(page.getByText('This tool needs JavaScript')).toBeVisible();
        await expect(page.getByRole('heading', { name: 'Frequently asked questions' })).toBeVisible();
        await context.close();
    });
});
