import { defineConfig, devices } from '@playwright/test';

// End-to-end tests for every page and tool, in a real browser.
// Uses the Chrome installed on this machine (no browser download needed).
// Run: npm run build && npm run test:e2e
const PORT = 8123;

export default defineConfig({
    testDir: 'tests/e2e',
    timeout: 60_000,
    expect: { timeout: 10_000 },
    fullyParallel: false,
    workers: 1, // php artisan serve handles one request at a time
    reporter: [['list']],
    use: {
        baseURL: `http://127.0.0.1:${PORT}`,
        channel: 'chrome',
        acceptDownloads: true,
        trace: 'retain-on-failure',
    },
    projects: [
        { name: 'desktop', use: { ...devices['Desktop Chrome'], channel: 'chrome' }, testIgnore: /mobile.spec.js/ },
        { name: 'mobile', use: { ...devices['Pixel 7'], channel: 'chrome' }, testMatch: /mobile\.spec\.js/ },
    ],
    webServer: {
        command: `php artisan serve --host=127.0.0.1 --port=${PORT}`,
        url: `http://127.0.0.1:${PORT}/up`,
        reuseExistingServer: false,
        // Never load real Google ads in tests (no fake impressions on your AdSense account).
        env: { ADSENSE_CLIENT: '' },
        timeout: 60_000,
    },
});
