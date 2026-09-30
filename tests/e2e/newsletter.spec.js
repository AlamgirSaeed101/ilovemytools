import { expect, test } from '@playwright/test';
import { trackErrors } from './helpers.js';

test.describe('Newsletter', () => {
    test('sign up from the home page card', async ({ page }) => {
        const t = trackErrors(page);
        await page.goto('/');
        const card = page.getByTestId('newsletter');
        await expect(card.getByRole('heading', { name: 'Be the first to try new tools' })).toBeVisible();

        const email = card.getByLabel('Email address');
        await email.fill('not-an-email');
        await card.getByRole('button', { name: 'Subscribe' }).click();
        await expect(card.getByRole('alert')).toHaveText('Please enter a valid email address.');
        await expect(email).toHaveAttribute('aria-invalid', 'true');

        await email.fill(`e2e-${Date.now()}@example.com`);
        await card.getByRole('button', { name: 'Subscribe' }).click();
        await expect(card.getByTestId('newsletter-done')).toContainText('Check your inbox');
        t.assertNone();
    });

    test('footer form is on every page and translated', async ({ page }) => {
        await page.goto('/es/word-counter');
        const footer = page.getByTestId('newsletter-footer');
        await expect(footer.getByRole('heading', { name: 'Recibe las nuevas herramientas por correo' })).toBeVisible();
        await expect(footer.getByRole('button', { name: 'Suscribirme' })).toBeVisible();
    });

    test('links from emails show a notice, and unsubscribing needs a click', async ({ page }) => {
        await page.goto('/?newsletter=confirmed');
        await expect(page.getByTestId('newsletter-notice')).toContainText('You are subscribed!');
        await page.getByTestId('newsletter-notice').getByRole('button', { name: 'Close' }).click();
        await expect(page.getByTestId('newsletter-notice')).toHaveCount(0);
        await expect(page).toHaveURL(/\/$/);

        await page.goto('/?newsletter=unsubscribe&token=' + 'x'.repeat(48));
        const notice = page.getByTestId('newsletter-notice');
        await expect(notice).toContainText('Unsubscribe from new tool emails?');
        await notice.getByRole('button', { name: 'Unsubscribe', exact: true }).click();
        // Unknown token: the server answers 404.
        await expect(notice).toContainText('This link is invalid or has expired.');
    });
});
