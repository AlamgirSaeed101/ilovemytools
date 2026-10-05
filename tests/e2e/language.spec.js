import { expect, test } from '@playwright/test';

test.describe('Automatic language on first visit', () => {
    test('a German browser opening an English page gets the German page', async ({ browser, baseURL }) => {
        const ctx = await browser.newContext({ locale: 'de-DE', baseURL });
        const page = await ctx.newPage();
        await page.goto('/merge-pdf');
        await expect(page).toHaveURL(/\/de\/merge-pdf$/);
        await expect(page.locator('html')).toHaveAttribute('lang', /^de/);
        await ctx.close();
    });

    test('choosing English in the menu is remembered', async ({ browser, baseURL }) => {
        const ctx = await browser.newContext({ locale: 'de-DE', baseURL });
        const page = await ctx.newPage();
        await page.goto('/');
        await expect(page).toHaveURL(/\/de$/);
        await page.locator('footer a[hreflang="en"]').click();
        await expect(page).toHaveURL(/\/$/);
        await page.goto('/word-counter');
        await expect(page).toHaveURL(/\/word-counter$/); // not redirected again
        await ctx.close();
    });

    test('a Traditional Chinese (zh-TW) browser opening an English page gets the Chinese page', async ({ browser, baseURL }) => {
        const ctx = await browser.newContext({ locale: 'zh-TW', baseURL });
        const page = await ctx.newPage();
        await page.goto('/merge-pdf');
        await expect(page).toHaveURL(/\/zh\/merge-pdf$/);
        await expect(page.locator('html')).toHaveAttribute('lang', /^zh-Hant/);
        await ctx.close();
    });

    test('a Simplified Chinese (zh-CN) browser is never redirected to the Traditional Chinese page', async ({ browser, baseURL }) => {
        const ctx = await browser.newContext({ locale: 'zh-CN', baseURL });
        const page = await ctx.newPage();
        await page.goto('/merge-pdf');
        await expect(page).toHaveURL(/\/merge-pdf$/);
        await ctx.close();
    });

    test('Urdu pages are right-to-left', async ({ page }) => {
        await page.goto('/ur');
        await expect(page.locator('html')).toHaveAttribute('lang', /^ur/);
        await expect(page.locator('html')).toHaveAttribute('dir', 'rtl');
        await page.goto('/ur/merge-pdf');
        await expect(page.locator('html')).toHaveAttribute('dir', 'rtl');
    });

    test('pages opened in a language stay in it, and English browsers are untouched', async ({ browser, baseURL }) => {
        const de = await browser.newContext({ locale: 'de-DE', baseURL });
        const p1 = await de.newPage();
        await p1.goto('/fr/merge-pdf');
        await expect(p1).toHaveURL(/\/fr\/merge-pdf$/);
        await de.close();

        const en = await browser.newContext({ locale: 'en-US', baseURL });
        const p2 = await en.newPage();
        await p2.goto('/merge-pdf');
        await expect(p2).toHaveURL(/\/merge-pdf$/);
        await en.close();
    });
});
