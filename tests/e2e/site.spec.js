import { expect, test } from '@playwright/test';
import { openTool, trackErrors } from './helpers.js';

test.describe('App shell', () => {
    test('home page renders every tool, with no errors', async ({ page }) => {
        const t = trackErrors(page);
        await page.goto('/');
        await expect(page.getByRole('heading', { level: 1 })).toContainText('Free Online Tools for PDF, Image & Text');
        // The server-rendered copy is replaced by the React app.
        await expect(page.locator('#app > .ssr')).toHaveCount(0);

        const site = await page.evaluate(() => JSON.parse(document.getElementById('boot-data').textContent).site);
        // The grid shows the first 15; "View all" reveals the rest.
        await page.getByRole('button', { name: `View all ${site.tools.length} tools` }).click();
        for (const tool of site.tools) {
            await expect(page.locator(`main a.tool-card[href="/${tool.slug}"]`).first()).toBeVisible();
        }
        t.assertNone();
    });

    test('home filter pills show one category at a time', async ({ page }) => {
        // Count from the site data, so adding tools never breaks this test.
        const site = await (await page.request.get('/api/site')).json();
        const total = site.tools.length;
        const inCategory = (slug) => site.categories.find((c) => c.slug === slug).tools.length;
        await page.goto('/');
        const pills = page.getByRole('group', { name: 'Filter by category' });
        const tiles = page.locator('main .tile-grid a.tool-card');
        await expect(tiles).toHaveCount(Math.min(total, 15));

        await pills.getByRole('button', { name: 'PDF Tools' }).click();
        await expect(pills.getByRole('button', { name: 'PDF Tools' })).toHaveAttribute('aria-pressed', 'true');
        await expect(tiles).toHaveCount(inCategory('pdf-tools'));

        await pills.getByRole('button', { name: 'Developer Tools' }).click();
        await expect(tiles).toHaveCount(inCategory('developer-tools'));

        await pills.getByRole('button', { name: 'All tools' }).click();
        await expect(tiles).toHaveCount(Math.min(total, 15));
        await page.getByRole('button', { name: `View all ${total} tools` }).click();
        await expect(tiles).toHaveCount(total);
    });

    test('home category cards link to categories and scroll', async ({ page }) => {
        const site = await (await page.request.get('/api/site')).json();
        await page.goto('/');
        const browse = page.locator('section[aria-labelledby="browse-heading"]');
        await expect(browse.locator('.browse-card')).toHaveCount(site.categories.length);
        await browse.getByRole('button', { name: 'Next' }).click();
        await browse.locator('.browse-card').first().getByRole('link').first().click();
        await expect(page).toHaveURL(/\/category\/pdf-tools$/);
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
        // Type only once the search box has focus (on slow CI machines it can lag the dialog).
        await expect(dialog.locator('input')).toBeFocused();
        await page.keyboard.type('split');
        await expect(dialog.getByRole('option').first()).toContainText('Split PDF');
        await page.keyboard.press('Enter');
        await expect(page).toHaveURL(/\/split-pdf$/);
        await expect(dialog).toBeHidden();

        await page.locator('body').click({ position: { x: 5, y: 300 } });
        await page.keyboard.press('/');
        await expect(dialog).toBeVisible();
        await expect(dialog.locator('input')).toBeFocused();
        await page.keyboard.type('json');
        // Wait for the results to update before using the keyboard (slower CI machines).
        await expect(dialog.getByRole('option').first()).toContainText('JSON Formatter');
        await page.keyboard.press('ArrowDown');
        await page.keyboard.press('ArrowUp');
        await page.keyboard.press('Enter');
        await expect(page).toHaveURL(/\/json-formatter$/);

        await page.keyboard.press('Control+k');
        await page.keyboard.press('Escape');
        await expect(dialog).toBeHidden();
    });

    test('header category menus', async ({ page }) => {
        // Counts come from the site data, so adding a tool never breaks this test.
        const site = await (await page.request.get('/api/site')).json();
        await page.goto('/');
        const nav = page.getByRole('navigation', { name: 'Main' });
        // Each menu lists at most 5 tools (popular first), then "View all N tools".
        const pdfTools = site.categories.find((c) => c.slug === 'pdf-tools').tools.length;
        await nav.getByRole('button', { name: 'PDF' }).click();
        await expect(nav.locator('ul a')).toHaveCount(Math.min(5, pdfTools));
        await expect(nav.getByRole('link', { name: `View all ${pdfTools} tools` })).toBeVisible();
        await nav.getByRole('link', { name: 'Merge PDF' }).click();
        await expect(page).toHaveURL(/\/merge-pdf$/);

        await nav.getByRole('button', { name: 'Calculators' }).click();
        await nav.getByRole('link', { name: /View all/ }).click();
        await expect(page).toHaveURL(/\/category\/calculators$/);
        await expect(page.locator('main .tool-grid .tool-card')).toHaveCount(site.categories.find((c) => c.slug === 'calculators').tools.length);

        // Categories that don't fit sit under "More".
        await nav.getByRole('button', { name: 'More' }).click();
        await nav.getByRole('link', { name: /Time Tools/ }).click();
        await expect(page).toHaveURL(/\/category\/time-tools$/);
    });

    test('light mode is the default and a dark choice is remembered', async ({ page }) => {
        // Even when the device prefers dark, the site starts light.
        await page.emulateMedia({ colorScheme: 'dark' });
        await page.goto('/');
        await expect(page.locator('html')).toHaveAttribute('data-theme', 'light');
        expect(await page.evaluate(() => getComputedStyle(document.body).backgroundColor)).toBe('rgb(255, 255, 255)');

        await page.getByRole('button', { name: 'Switch to dark mode' }).click();
        await expect(page.locator('html')).toHaveAttribute('data-theme', 'dark');
        await page.reload();
        await expect(page.locator('html')).toHaveAttribute('data-theme', 'dark');
        expect(await page.evaluate(() => getComputedStyle(document.body).backgroundColor)).toBe('rgb(11, 16, 32)');

        await page.getByRole('button', { name: 'Switch to light mode' }).click();
        await page.reload();
        await expect(page.locator('html')).toHaveAttribute('data-theme', 'light');
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
