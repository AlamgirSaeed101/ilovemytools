import { expect, test } from '@playwright/test';

// Tests run without AdSense; pretend it is configured by patching the page's boot data.
async function withAds(page) {
    await page.route(/^http:\/\/127\.0\.0\.1:\d+\/(\?.*)?$/, async (route) => {
        const res = await route.fetch();
        const body = (await res.text()).replace('"ads":{"client":""', '"ads":{"client":"ca-pub-test"').replace('"adblockNotice":false', '"adblockNotice":true');
        await route.fulfill({ response: res, body });
    });
}

test.describe('Ad blocker notice', () => {
    test('stays off until AdSense has approved the site (adblock_notice switch)', async ({ page }) => {
        await page.route(/^http:\/\/127\.0\.0\.1:\d+\/(\?.*)?$/, async (route) => {
            const res = await route.fetch();
            await route.fulfill({ response: res, body: (await res.text()).replace('"ads":{"client":""', '"ads":{"client":"ca-pub-test"') });
        });
        await page.addInitScript(() => {
            window.__adsBlocked = true;
        });
        await page.route(/googlesyndication.com/, (route) => route.abort());
        await page.goto('/');
        await page.waitForTimeout(4500);
        await expect(page.getByTestId('adblock-notice')).toHaveCount(0);
    });

    test('asks to turn off the ad blocker and can be closed for a week', async ({ page }) => {
        await withAds(page);
        // Like an ad blocker: the ad script fails to load and can't be fetched again.
        await page.addInitScript(() => {
            window.__adsBlocked = true;
        });
        await page.route(/googlesyndication.com/, (route) => route.abort());
        await page.goto('/');
        const notice = page.getByTestId('adblock-notice');
        await expect(notice).toBeVisible({ timeout: 8000 });
        await expect(notice.getByRole('heading', { name: 'Please turn off your ad blocker' })).toBeVisible();
        await expect(notice.getByTestId('adblock-reason')).toHaveText('(ad script blocked)');

        // Still asked after reloading with the blocker on.
        await notice.getByRole('button', { name: "I've turned it off - reload" }).click();
        await expect(page.getByTestId('adblock-notice')).toBeVisible({ timeout: 8000 });

        // Closing it lets the visitor use the site, and it stays away on the next page load.
        await page.getByTestId('adblock-notice').getByRole('button', { name: 'Continue without allowing ads' }).click();
        await expect(page.getByTestId('adblock-notice')).toHaveCount(0);
        await page.reload();
        await page.waitForTimeout(4500);
        await expect(page.getByTestId('adblock-notice')).toHaveCount(0);
    });

    test('the close button and Escape also dismiss it', async ({ page }) => {
        await withAds(page);
        await page.addInitScript(() => {
            window.__adsBlocked = true;
        });
        await page.route(/googlesyndication.com/, (route) => route.abort());
        await page.goto('/');
        const notice = page.getByTestId('adblock-notice');
        await expect(notice).toBeVisible({ timeout: 8000 });
        await page.keyboard.press('Escape');
        await expect(notice).toHaveCount(0);
        await page.evaluate(() => localStorage.clear());
        await page.reload();
        await expect(page.getByTestId('adblock-notice')).toBeVisible({ timeout: 8000 });
        await page.getByTestId('adblock-notice').getByRole('button', { name: 'Close' }).click();
        await expect(page.getByTestId('adblock-notice')).toHaveCount(0);
    });

    test('stays away when nothing is blocked, even after a one-off script failure', async ({ page }) => {
        await withAds(page);
        await page.addInitScript(() => {
            window.__adsBlocked = true; // failed once, but the re-check can reach it
        });
        await page.route(/googlesyndication.com/, (route) => route.fulfill({ status: 200, body: '' }));
        await page.goto('/');
        await page.waitForTimeout(4000);
        await expect(page.getByTestId('adblock-notice')).toHaveCount(0);
    });
});
