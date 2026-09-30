import { expect, test } from '@playwright/test';
import { openTool, trackErrors } from './helpers.js';

test('mobile menu, search button and a tool work on a phone', async ({ page }) => {
    const t = trackErrors(page);
    await page.goto('/');

    await page.getByRole('button', { name: 'Open menu' }).click();
    const nav = page.getByRole('navigation', { name: 'Mobile' });
    await expect(nav).toBeVisible();
    await nav.getByRole('link', { name: 'PDF Tools' }).click();
    await expect(page).toHaveURL(/\/category\/pdf-tools$/);
    await expect(nav).toBeHidden();

    await page.getByRole('button', { name: 'Search tools' }).click();
    await page.keyboard.type('counter');
    await page.keyboard.press('Enter');
    await expect(page).toHaveURL(/\/word-counter$/);

    await openTool(page, 'word-counter');
    await page.getByLabel('Your text').fill('One two three.');
    await expect(page.locator('.stat').first()).toContainText('3');

    // No horizontal scrolling on a phone.
    const overflow = await page.evaluate(() => document.documentElement.scrollWidth - window.innerWidth);
    expect(overflow).toBeLessThanOrEqual(0);
    t.assertNone();
});
