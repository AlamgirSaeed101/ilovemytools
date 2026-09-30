import { expect, test } from '@playwright/test';
import { openTool, trackErrors } from './helpers.js';

let errors;
test.beforeEach(({ page }) => {
    errors = trackErrors(page);
});
test.afterEach(() => errors.assertNone());

/** Same maths as segmentAt() in resources/js/lib/random.js, to check what the pointer really shows. */
function sliceUnderPointer(rotation, count) {
    const seg = 360 / count;
    const angle = (((360 - (rotation % 360)) % 360) + 360) % 360;
    return Math.min(count - 1, Math.floor(angle / seg));
}

test.describe('Random & Games', () => {
    test('dice roller animates, then shows values and the correct total', async ({ page }) => {
        await openTool(page, 'dice-roller');
        const result = page.getByTestId('dice-result');
        await page.getByRole('button', { name: 'Roll 2 dice' }).click();
        await expect(result).toContainText('Rolling…');
        await expect(page.locator('.cube-wrap.is-rolling')).toHaveCount(2);

        await expect(result).toContainText('=', { timeout: 5000 });
        const text = await result.innerText();
        const [, sum, total] = /([\d +]+)=\s*(\d+)/.exec(text);
        const values = sum.split('+').map((v) => Number(v.trim()));
        expect(values).toHaveLength(2);
        values.forEach((v) => expect(v >= 1 && v <= 6).toBe(true));
        expect(values.reduce((a, b) => a + b)).toBe(Number(total));
        await expect(page.locator('.history__item')).toHaveCount(1);
    });

    test('dice roller: any die type, 1-10 dice, keyboard shortcut', async ({ page }) => {
        await page.emulateMedia({ reducedMotion: 'reduce' });
        await openTool(page, 'dice-roller');
        await page.getByRole('radio', { name: 'd20' }).click();
        await page.getByRole('button', { name: 'More dice' }).click();
        await expect(page.getByTestId('dice-count')).toHaveText('3');
        await expect(page.locator('.poly-die--d20')).toHaveCount(3);

        for (let i = 0; i < 5; i++) {
            await page.getByRole('button', { name: 'Roll 3 dice' }).click();
            await expect(page.getByTestId('dice-result')).toContainText('=');
            const values = await page.locator('.poly-die__value').allInnerTexts();
            values.forEach((v) => expect(Number(v) >= 1 && Number(v) <= 20).toBe(true));
        }
        await expect(page.locator('.history__item')).toHaveCount(5);

        for (let i = 0; i < 9; i++) await page.getByRole('button', { name: 'More dice' }).click({ force: true });
        await expect(page.getByTestId('dice-count')).toHaveText('10');
        await expect(page.getByRole('button', { name: 'More dice' })).toBeDisabled();

        await page.locator('body').click({ position: { x: 5, y: 400 } });
        await page.keyboard.press('r');
        await expect(page.locator('.history__item')).toHaveCount(6);
        await expect(page.locator('.history__item').first()).toContainText('10d20');
    });

    test('coin flip: 3D toss, running stats and many coins', async ({ page }) => {
        await openTool(page, 'coin-flip');
        await page.getByRole('button', { name: 'Flip the coin' }).click();
        await expect(page.getByTestId('coin-result')).toContainText('Flipping…');
        await expect(page.locator('.coin-toss.is-tossing')).toHaveCount(1);
        expect(await page.locator('.coin').evaluate((el) => el.getAnimations().length)).toBe(1); // end-over-end tumble running
        await expect(page.getByTestId('coin-result')).toHaveText(/^(Heads|Tails)!$/, { timeout: 5000 });

        // The coin lands showing the announced side: tails = an odd number of half turns end over end.
        const side = (await page.getByTestId('coin-result').innerText()).replace('!', '');
        const rotation = Number(await page.locator('.coin').getAttribute('data-rotation'));
        expect(rotation).toBeGreaterThanOrEqual(7 * 360); // it really tumbled
        await expect(page.locator('.coin')).toHaveCSS('transform', rotation % 360 === 0 ? 'matrix(1, 0, 0, 1, 0, 0)' : /matrix3d\(1, 0, 0, 0, 0, -1/);
        expect(Math.round(rotation / 180) % 2 === 1 ? 'Tails' : 'Heads').toBe(side);

        await page.emulateMedia({ reducedMotion: 'reduce' });
        await page.getByRole('radio', { name: '100' }).click();
        await page.getByRole('button', { name: 'Flip 100 coins' }).click();
        await expect(page.locator('.mini-coin--heads, .mini-coin--tails')).toHaveCount(100);
        const heads = Number(await page.getByTestId('heads-total').innerText());
        const tails = Number(await page.getByTestId('tails-total').innerText());
        expect(heads + tails).toBe(101);
        await expect(page.locator('.split-bar')).toHaveAttribute('aria-label', /% heads/);

        await page.getByRole('button', { name: 'Reset stats' }).click();
        await expect(page.getByTestId('heads-total')).toHaveCount(0);
    });

    test('spin the wheel lands on the slice it announces', async ({ page }) => {
        await openTool(page, 'spin-the-wheel');
        const entries = (await page.getByLabel('Entries (one per line)').inputValue()).split('\n');
        await page.getByRole('button', { name: 'Spin the wheel', exact: true }).click();
        await expect(page.getByTestId('wheel-result')).toContainText('Spinning…');
        await expect(page.locator('.wheel.is-spinning')).toHaveCount(1);
        await expect(page.locator('.winner__name')).toBeVisible({ timeout: 10_000 });

        const winner = await page.locator('.winner__name').innerText();
        const rotation = await page.locator('.wheel__svg').evaluate((el) => Number(/rotate\(([\d.]+)deg\)/.exec(el.style.transform)[1]));
        expect(entries[sliceUnderPointer(rotation, entries.length)]).toBe(winner);
        expect(rotation).toBeGreaterThan(6 * 360);
    });

    test('spin the wheel: remove winners, shuffle and validation', async ({ page }) => {
        await page.emulateMedia({ reducedMotion: 'reduce' });
        await openTool(page, 'spin-the-wheel');
        const box = page.getByLabel('Entries (one per line)');
        await box.fill('Ann\nBen\nCat');
        await page.getByLabel('Remove the winner after each spin').check();

        const picked = [];
        for (let i = 0; i < 2; i++) {
            await page.getByRole('button', { name: 'Spin the wheel', exact: true }).click();
            const name = await page.locator('.winner__name').innerText();
            picked.push(name);
            await expect(box).not.toHaveValue(new RegExp(`(^|\\n)${name}($|\\n)`));
        }
        expect(new Set(picked).size).toBe(2); // never the same person twice
        await expect(page.getByText('Add at least 2 entries to spin.')).toBeVisible();
        await expect(page.getByRole('button', { name: 'Spin the wheel', exact: true })).toBeDisabled();

        await box.fill(Array.from({ length: 12 }, (_, i) => `Person ${i + 1}`).join('\n'));
        await page.getByRole('button', { name: 'Shuffle' }).click();
        const shuffled = (await box.inputValue()).split('\n');
        expect([...shuffled].sort()).toEqual(Array.from({ length: 12 }, (_, i) => `Person ${i + 1}`).sort());
        await expect(page.locator('.wheel__slice')).toHaveCount(12);
    });

    test('random number generator: reveal, ranges, no duplicates and errors', async ({ page }) => {
        await openTool(page, 'random-number-generator');
        await page.getByLabel('Minimum').fill('500');
        await page.getByLabel('Maximum').fill('505');
        await page.getByRole('button', { name: 'Generate' }).click();
        await expect(page.locator('.rng-big.is-revealing')).toHaveCount(1);
        await expect(page.locator('.rng-big.is-final')).toHaveCount(1, { timeout: 5000 });
        const value = Number(await page.getByTestId('rng-value').innerText());
        expect(value >= 500 && value <= 505).toBe(true);

        await page.emulateMedia({ reducedMotion: 'reduce' });
        await page.getByRole('button', { name: 'Lottery 6 of 49' }).click();
        const lottery = (await page.getByTestId('rng-list').locator('li').allInnerTexts()).map(Number);
        expect(lottery).toHaveLength(6);
        expect(new Set(lottery).size).toBe(6);
        expect([...lottery].sort((a, b) => a - b)).toEqual(lottery);
        lottery.forEach((n) => expect(n >= 1 && n <= 49).toBe(true));

        await page.getByLabel('Minimum').fill('-10');
        await page.getByLabel('Maximum').fill('10');
        await page.getByLabel('How many').fill('21');
        await page.getByLabel('No duplicates').check();
        await page.getByLabel('Sort low to high').check();
        await page.getByRole('button', { name: 'Generate' }).click();
        const all = (await page.getByTestId('rng-list').locator('li').allInnerTexts()).map(Number);
        expect(all).toEqual(Array.from({ length: 21 }, (_, i) => i - 10));

        await page.getByLabel('How many').fill('22');
        await page.getByRole('button', { name: 'Generate' }).click();
        await expect(page.getByRole('alert')).toContainText('only 21 different numbers');

        await page.getByLabel('Minimum').fill('9');
        await page.getByLabel('Maximum').fill('1');
        await page.getByRole('button', { name: 'Generate' }).click();
        await expect(page.getByRole('alert')).toContainText('less than or equal');
    });
});

/**
 * Fake clock, paused once the page has loaded: time only moves when the test calls
 * runFor(), so results are exact however slow the machine is.
 */
async function openClockTool(page, slug) {
    await page.clock.install({ time: new Date('2026-01-01T10:00:00') });
    await openTool(page, slug);
    await page.clock.pauseAt(new Date('2026-01-01T10:05:00'));
}

test.describe('Time tools', () => {
    test('stopwatch times to the hundredth, with laps, stop, resume and reset', async ({ page }) => {
        await openClockTool(page, 'stopwatch');
        const time = page.getByTestId('stopwatch-time');
        await expect(time).toHaveText('00:00.00');

        await page.getByRole('button', { name: 'Start' }).click();
        await page.clock.runFor(1234);
        await expect(time).toHaveText('00:01.23');
        await page.getByRole('button', { name: 'Lap', exact: true }).click();
        await page.clock.runFor(3000);
        await page.getByRole('button', { name: 'Lap', exact: true }).click();
        await page.clock.runFor(500);
        await page.getByRole('button', { name: 'Lap', exact: true }).click();

        const rows = page.locator('.laps tbody tr');
        await expect(rows).toHaveCount(3);
        await expect(rows.nth(0)).toContainText('00:00.50'); // newest first
        await expect(rows.nth(0)).toContainText('Fastest');
        await expect(rows.nth(1)).toContainText('00:03.00');
        await expect(rows.nth(1)).toContainText('Slowest');
        await expect(rows.nth(2)).toContainText('00:01.23');

        await page.getByRole('button', { name: 'Stop' }).click();
        const stopped = await time.innerText();
        await page.clock.runFor(5000);
        await expect(time).toHaveText(stopped);

        await page.getByRole('button', { name: 'Resume' }).click();
        await page.clock.runFor(2000);
        // 4.734 s before stopping + 2 s after resuming; the display may trail by one animation frame.
        await expect(time).toHaveText(/^00:06\.7[23]$/);

        // Keyboard: Space stops, R resets.
        await page.locator('body').click({ position: { x: 5, y: 400 } });
        await page.keyboard.press('Space');
        await expect(page.getByRole('button', { name: 'Resume' })).toBeVisible();
        await page.keyboard.press('r');
        await expect(time).toHaveText('00:00.00');
        await expect(rows).toHaveCount(0);
    });

    test('countdown timer counts down, pauses, updates the tab title and rings', async ({ page }) => {
        await openClockTool(page, 'countdown-timer');
        const pageTitle = await page.title();

        await page.getByLabel('Hours').fill('0');
        await page.getByLabel('Minutes').fill('0');
        await page.getByLabel('Seconds').fill('5');
        await page.getByRole('button', { name: 'Start' }).click();
        const time = page.getByTestId('timer-time');
        await expect(time).toHaveText('00:05');

        await page.clock.runFor(2000);
        await expect(time).toHaveText('00:03');
        await expect(page).toHaveTitle('00:03 · Timer');
        await expect(page.locator('.clock.is-urgent')).toHaveCount(1); // last 10 seconds

        await page.getByRole('button', { name: 'Pause' }).click();
        await page.clock.runFor(4000);
        await expect(time).toHaveText('00:03');
        await expect(page).toHaveTitle('⏸ 00:03 · Timer');

        await page.getByRole('button', { name: 'Resume' }).click();
        await page.clock.runFor(3100);
        await expect(page.getByTestId('timer-status')).toHaveText("Time's up!");
        await expect(page.getByRole('alert')).toContainText("Time's up!");
        await expect(page).toHaveTitle("⏰ Time's up!");

        await page.getByRole('button', { name: 'Stop alarm' }).click();
        await expect(page.getByRole('alert')).toHaveCount(0);
        await page.getByRole('button', { name: 'New timer' }).click();
        await expect(page).toHaveTitle(pageTitle);
        await expect(page.getByLabel('Seconds')).toHaveValue('05');
    });

    test('timer presets and +1 minute', async ({ page }) => {
        await openClockTool(page, 'countdown-timer');
        await page.getByRole('button', { name: '1 min', exact: true }).click();
        const time = page.getByTestId('timer-time');
        await expect(time).toHaveText('01:00');
        await page.clock.runFor(1000);
        await expect(time).toHaveText('00:59');
        await page.getByRole('button', { name: '+1 min' }).click();
        await expect(time).toHaveText('01:59');
        await page.getByRole('button', { name: 'Reset' }).click();
        await expect(page.getByLabel('Minutes')).toHaveValue('01');
    });
});

test.describe('Sleep calculator', () => {
    const cardTimes = (page) => page.getByTestId('sleep-option').locator('.sleep-card__time').allInnerTexts();

    test('suggests bedtimes for a wake-up time, with settings and a sleep chart', async ({ page }) => {
        await openTool(page, 'sleep-calculator');
        await expect(page.getByLabel('I want to wake up at')).toHaveValue('07:00');
        await expect.poll(() => cardTimes(page)).toEqual(['9:45 PM', '11:15 PM', '12:45 AM', '2:15 AM']);
        await expect(page.getByTestId('sleep-option').nth(1)).toHaveAttribute('aria-pressed', 'true'); // 5 cycles recommended
        await expect(page.getByTestId('sleep-option').nth(1)).toContainText('Recommended');

        // Falling asleep instantly moves every bedtime 15 minutes later.
        await page.getByLabel(/Time to fall asleep/).focus();
        await page.keyboard.press('Home');
        await expect(page.getByLabel(/Time to fall asleep/)).toHaveValue('0');
        await expect.poll(() => cardTimes(page)).toEqual(['10:00 PM', '11:30 PM', '1:00 AM', '2:30 AM']);

        await page.getByTestId('sleep-option').nth(2).click();
        await expect(page.getByTestId('sleep-option').nth(2)).toHaveAttribute('aria-pressed', 'true');
        await expect(page.locator('.sleep-chart figcaption')).toContainText('about 4 cycles');
        await expect(page.locator('.sleep-chart__band')).toHaveCount(4);

        await page.getByRole('radio', { name: '24 h' }).click();
        await expect.poll(() => cardTimes(page)).toEqual(['22:00', '23:30', '01:00', '02:30']);

        await page.getByLabel('I want to wake up at').fill('06:30');
        await expect.poll(() => cardTimes(page)).toEqual(['21:30', '23:00', '00:30', '02:00']);
    });

    test('suggests wake-up times for a bedtime', async ({ page }) => {
        await openTool(page, 'sleep-calculator');
        await page.getByRole('tab', { name: 'Go to bed at…' }).click();
        await page.getByLabel('I will go to bed at').fill('22:30');
        await expect.poll(() => cardTimes(page)).toEqual(['3:15 AM', '4:45 AM', '6:15 AM', '7:45 AM']);
        await expect(page.getByText('Set your alarm for one of these times:')).toBeVisible();
    });

    test('"Sleep now" starts from the current time', async ({ page }) => {
        await page.clock.install({ time: new Date('2026-01-01T23:00:00') });
        await openTool(page, 'sleep-calculator');
        await page.getByRole('tab', { name: 'Sleep now' }).click();
        await expect(page.getByTestId('sleep-now')).toHaveText('11:00 PM');
        await expect.poll(() => cardTimes(page)).toEqual(['3:45 AM', '5:15 AM', '6:45 AM', '8:15 AM']);
    });

    test('counts hours slept across midnight and rates them', async ({ page }) => {
        await openTool(page, 'sleep-calculator');
        await page.getByRole('tab', { name: 'Hours slept' }).click();
        await page.getByLabel('Went to bed at').fill('23:00');
        await page.getByLabel('Woke up at').fill('07:00');
        await expect(page.getByTestId('sleep-total')).toHaveText('7 h 45 min'); // 8 h in bed - 15 min to fall asleep
        await expect(page.locator('.sleep-total')).toContainText('Healthy amount');
        await expect(page.locator('.sleep-total')).toContainText('8 h in bed · about 5 full sleep cycles + 15 min');

        await page.getByLabel('Went to bed at').fill('01:00');
        await page.getByLabel('Woke up at').fill('06:00');
        await expect(page.getByTestId('sleep-total')).toHaveText('4 h 45 min');
        await expect(page.locator('.sleep-total')).toContainText('Too little sleep');

        await page.getByLabel('Woke up at').fill('01:00');
        await expect(page.getByText('Enter two different times.')).toBeVisible();
    });
});
