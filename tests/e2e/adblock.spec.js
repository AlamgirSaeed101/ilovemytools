import { expect, test } from '@playwright/test';

// Tests run without AdSense; pretend it is configured by patching the page's boot data.
async function withAds(page) {
    await page.route(/^http:\/\/127\.0\.0\.1:\d+\/(\?.*)?$/, async (route) => {
        const res = await route.fetch();
        const body = (await res.text()).replace('"ads":{"client":""', '"ads":{"client":"ca-pub-test"');
        await route.fulfill({ response: res, body });
    });
}

test.describe('Ad blocker notice', () => {
    test('blocks the site until the ad blocker is turned off', async ({ page }) => {
        await withAds(page);
        await page.addInitScript(() => {
            window.__adsBlocked = true; // the AdSense script failed to load
        });
        await page.goto('/');
        const notice = page.getByTestId('adblock-notice');
        await expect(notice).toBeVisible({ timeout: 8000 });
        await expect(notice.getByRole('heading', { name: 'Please turn off your ad blocker' })).toBeVisible();
        await expect(notice.getByRole('button')).toHaveCount(1); // no way to dismiss it
        await page.keyboard.press('Escape');
        await expect(notice).toBeVisible();

        // Still blocked after reloading.
        await notice.getByRole('button', { name: "I've turned it off - reload" }).click();
        await expect(page.getByTestId('adblock-notice')).toBeVisible({ timeout: 8000 });
    });

    test('stays away when nothing is blocked', async ({ page }) => {
        await withAds(page);
        await page.goto('/');
        await page.waitForTimeout(4000);
        await expect(page.getByTestId('adblock-notice')).toHaveCount(0);
    });
});
