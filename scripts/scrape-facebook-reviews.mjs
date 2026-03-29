import { chromium } from 'playwright';

function getArg(flag, fallback = null) {
    const index = process.argv.indexOf(flag);

    if (index === -1 || index === process.argv.length - 1) {
        return fallback;
    }

    return process.argv[index + 1];
}

async function dismissDialog(page) {
    const dialog = page.locator('div[role="dialog"]').first();

    if ((await dialog.count()) === 0 || !(await dialog.isVisible().catch(() => false))) {
        return;
    }

    const dialogBox = await dialog.boundingBox().catch(() => null);

    if (!dialogBox) {
        await page.keyboard.press('Escape').catch(() => {});

        return;
    }

    const buttons = await dialog.locator('[role="button"]').elementHandles();

    for (const button of buttons) {
        const box = await button.boundingBox().catch(() => null);

        if (!box) {
            continue;
        }

        const looksLikeCloseButton =
            box.width <= 80 &&
            box.height <= 80 &&
            box.x >= dialogBox.x + dialogBox.width * 0.65 &&
            box.y <= dialogBox.y + dialogBox.height * 0.25;

        if (!looksLikeCloseButton) {
            continue;
        }

        await button.click({ timeout: 2000 }).catch(() => {});
        await page.waitForTimeout(750);

        if (!(await dialog.isVisible().catch(() => false))) {
            return;
        }
    }

    await page.keyboard.press('Escape').catch(() => {});
    await page.waitForTimeout(500);
}

async function expandArticle(article) {
    const moreButtons = article.getByRole('button', { name: /see more/i });
    const count = await moreButtons.count().catch(() => 0);

    for (let index = 0; index < count; index += 1) {
        await moreButtons.nth(index).click({ timeout: 1500 }).catch(() => {});
        await article.page().waitForTimeout(150);
    }
}

function normalizeText(value) {
    return value.replace(/\s+/g, ' ').trim();
}

async function scrapeArticle(article) {
    await expandArticle(article);

    const data = await article.evaluate((node) => {
        const normalize = (value) => value.replace(/\s+/g, ' ').trim();
        const header = node.querySelector('[data-ad-rendering-role="profile_name"]');
        const headerText = normalize(header?.textContent ?? '');

        if (!headerText.includes('recommends')) {
            return null;
        }

        const headerLinks = Array.from(header?.querySelectorAll('a[href]') ?? []);
        const reviewerName = normalize(headerText.split(' recommends ')[0] ?? '');
        const reviewerLink = headerLinks.find((link) => {
            const text = normalize(link.textContent ?? '');
            return text === reviewerName;
        }) ?? null;
        const pageLink = [...headerLinks].reverse().find((link) => {
            const text = normalize(link.textContent ?? '');
            return text && text !== reviewerName;
        }) ?? null;

        const timeLinks = Array.from(node.querySelectorAll('a[href]'));
        const permalink = timeLinks.find((link) => {
            const href = link.getAttribute('href') ?? '';
            return href.includes('/posts/') || href.includes('permalink.php') || href.includes('story_fbid');
        }) ?? null;

        const messageRoot = node.querySelector('[data-ad-rendering-role="story_message"]');
        const messageText = normalize(messageRoot?.textContent ?? '');

        return {
            reviewer_name: reviewerName,
            reviewer_url: reviewerLink?.href ?? null,
            page_name: normalize(pageLink?.textContent ?? ''),
            page_url: pageLink?.href ?? null,
            recommendation: headerText.includes('recommends'),
            date_text: normalize(permalink?.textContent ?? permalink?.getAttribute('aria-label') ?? ''),
            permalink: permalink?.href ?? null,
            text: messageText || null,
        };
    });

    if (!data || !data.reviewer_name || !data.text) {
        return null;
    }

    return data;
}

async function main() {
    const url = getArg('--url');
    const limit = Math.max(1, Number.parseInt(getArg('--limit', '10'), 10) || 10);

    if (!url) {
        throw new Error('Missing required --url argument.');
    }

    const browser = await chromium.launch({
        headless: true,
    });

    const context = await browser.newContext({
        viewport: { width: 1400, height: 1600 },
        userAgent:
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36',
        locale: 'en-GB',
    });

    const page = await context.newPage();

    try {
        await page.goto(url, {
            waitUntil: 'domcontentloaded',
            timeout: 60000,
        });

        await page.waitForTimeout(2500);
        await dismissDialog(page);
        await dismissDialog(page);
        await page.waitForTimeout(1000);
        await page.locator('div[role="article"]').first().waitFor({ timeout: 15000 }).catch(() => {});

        const reviews = [];
        const seen = new Set();
        let unchangedPasses = 0;

        for (let pass = 0; pass < 20 && reviews.length < limit && unchangedPasses < 4; pass += 1) {
            const articles = page.locator('div[role="article"]');
            const count = await articles.count();
            const previousCount = reviews.length;

            for (let index = 0; index < count && reviews.length < limit; index += 1) {
                const article = articles.nth(index);
                const review = await scrapeArticle(article);

                if (!review) {
                    continue;
                }

                const key = review.permalink ?? `${review.reviewer_name}:${review.date_text}:${review.text}`;

                if (seen.has(key)) {
                    continue;
                }

                seen.add(key);
                reviews.push(review);
            }

            if (reviews.length === previousCount) {
                unchangedPasses += 1;
            } else {
                unchangedPasses = 0;
            }

            await page.evaluate(() => {
                window.scrollBy(0, window.innerHeight * 1.5);
            }).catch(() => {});
            await page.mouse.wheel(0, 2200);
            await page.waitForTimeout(2500);
        }

        process.stdout.write(JSON.stringify({
            source_url: url,
            scraped_at: new Date().toISOString(),
            count: reviews.length,
            reviews,
        }));
    } finally {
        await context.close();
        await browser.close();
    }
}

main().catch((error) => {
    process.stderr.write(`${error.message}\n`);
    process.exit(1);
});
