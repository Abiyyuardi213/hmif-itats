/**
 * Usage (from repository root hmif-itats, with Playwright cached offline in npm npx cache and local PHP server running):
 *   $env:VERIFY_BASE_URL="http://127.0.0.1:8099"; $env:VERIFY_EMAIL="verify@hmif-itats.local"; $env:VERIFY_PASS="VerifyPassword123!"; node docs/redesign/evidence/tools/verify-r1.mjs
 * Requires ad-hoc Playwright package (never add Playwright to package.json).
 */
import { createRequire } from 'node:module';
import fs from 'node:fs';
import path from 'node:path';

const require = createRequire(import.meta.url);
const { chromium } = require('D:\\Pacoel_SystemVault\\DevCaches\\npm-cache\\_npx\\e41f203b7505f1fb\\node_modules\\playwright');

const BASE_URL = process.env.VERIFY_BASE_URL || 'http://127.0.0.1:8099';
const EVIDENCE_DIR = path.resolve('d:/MY CODE/website-hmif-itats/hmif-itats/docs/redesign/evidence/R1');
const ADMIN_EMAIL = process.env.VERIFY_EMAIL || 'verify@hmif-itats.local';
const ADMIN_PASS = process.env.VERIFY_PASS || 'VerifyPassword123!';

fs.mkdirSync(EVIDENCE_DIR, { recursive: true });

async function launchBrowser() {
    try {
        return await chromium.launch({ headless: true });
    } catch {
        return await chromium.launch({
            headless: true,
            executablePath: 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe',
        });
    }
}

async function prepareImagesAndScrollTop(page) {
    await page.evaluate(async () => {
        const imgs = Array.from(document.querySelectorAll('img'));
        for (const img of imgs) {
            img.loading = 'eager';
            img.scrollIntoView({ behavior: 'instant', block: 'center' });
        }
        window.scrollTo({ top: 0, left: 0, behavior: 'instant' });
        await Promise.all(
            imgs.map(async (img) => {
                if (!(img.complete && img.naturalWidth > 0)) {
                    await new Promise((resolve) => {
                        img.addEventListener('load', resolve, { once: true });
                        img.addEventListener('error', resolve, { once: true });
                        setTimeout(resolve, 4000);
                    });
                }
                if (typeof img.decode === 'function') {
                    await img.decode().catch(() => {});
                }
            }),
        );
    });
    await page.waitForTimeout(350);
    await page.evaluate(() => window.scrollTo({ top: 0, left: 0, behavior: 'instant' }));
}

const browser = await launchBrowser();
const consoleErrors = [];
const failedAssets = [];

function attachListeners(page) {
    page.on('console', (msg) => {
        if (msg.type() === 'error') {
            consoleErrors.push(msg.text());
        }
    });
    page.on('requestfailed', (req) => {
        consoleErrors.push(`REQ FAILED: ${req.url()} -> ${req.failure()?.errorText || 'unknown'}`);
    });
    page.on('response', (res) => {
        if (res.status() >= 400 && !res.url().includes('/favicon.ico')) {
            failedAssets.push(`${res.status()} ${res.url()}`);
        }
    });
}

async function measureFcpBg(page) {
    return page.evaluate(() => {
        const fcpEntries = performance.getEntriesByType('paint').filter((e) => e.name === 'first-contentful-paint');
        return {
            dataTheme: document.documentElement.getAttribute('data-theme'),
            fcpTimeMs: fcpEntries.length ? Math.round(fcpEntries[0].startTime * 100) / 100 : null,
            earlyPaintRecord: window.__paintBgCheck || null,
            bodyBg: getComputedStyle(document.body).backgroundColor,
        };
    });
}

try {
    // 1. Desktop 1280x800 light & dark + toggle + persistence + FCP no-flash check + keyboard ticker check
    const desktopCtx = await browser.newContext({ viewport: { width: 1280, height: 800 }, colorScheme: 'light' });
    await desktopCtx.addInitScript(() => {
        window.__paintBgCheck = [];
        try {
            const po = new PerformanceObserver((list) => {
                for (const entry of list.getEntries()) {
                    if (entry.name === 'first-contentful-paint') {
                        window.__paintBgCheck.push({
                            name: entry.name,
                            startTime: Math.round(entry.startTime * 100) / 100,
                            dataTheme: document.documentElement.getAttribute('data-theme'),
                            docBg: getComputedStyle(document.documentElement).backgroundColor,
                            bodyBg: document.body ? getComputedStyle(document.body).backgroundColor : null,
                        });
                    }
                }
            });
            po.observe({ type: 'paint', buffered: true });
        } catch {
            // Paint observer fallback
        }
    });

    const page = await desktopCtx.newPage();
    attachListeners(page);

    await page.goto(`${BASE_URL}/_styleguide`, { waitUntil: 'networkidle' });
    await prepareImagesAndScrollTop(page);
    await page.screenshot({ path: path.join(EVIDENCE_DIR, 'styleguide-1280-light.png'), fullPage: true });

    await page.click('[data-theme-toggle]');
    await page.waitForTimeout(350);
    await page.evaluate(() => window.scrollTo({ top: 0, left: 0, behavior: 'instant' }));
    await page.screenshot({ path: path.join(EVIDENCE_DIR, 'styleguide-1280-dark.png'), fullPage: true });

    // Reload with localStorage theme='dark' -> measure FCP bg
    await page.reload({ waitUntil: 'networkidle' });
    await page.waitForTimeout(200);
    console.log('FCP DARK VIA LOCALSTORAGE RELOAD:', JSON.stringify(await measureFcpBg(page)));

    // F3.2: Ticker keyboard Enter (pause) + Space (resume)
    await page.focus('[data-ticker-toggle]');
    await page.keyboard.press('Enter');
    const afterEnter = await page.evaluate(() => ({
        pausedAttr: document.querySelector('[data-ticker]')?.getAttribute('data-paused'),
        pressed: document.querySelector('[data-ticker-toggle]')?.getAttribute('aria-pressed'),
        label: document.querySelector('[data-ticker-toggle-label]')?.textContent?.trim(),
    }));
    await page.keyboard.press('Space');
    const afterSpace = await page.evaluate(() => ({
        pausedAttr: document.querySelector('[data-ticker]')?.getAttribute('data-paused'),
        pressed: document.querySelector('[data-ticker-toggle]')?.getAttribute('aria-pressed'),
        label: document.querySelector('[data-ticker-toggle-label]')?.textContent?.trim(),
    }));
    console.log('TICKER KEYBOARD CHECK:', JSON.stringify({ afterEnter, afterSpace }));

    // /login + /admin 1280 light & dark
    await page.evaluate(() => window.localStorage.setItem('theme', 'light'));
    await page.goto(`${BASE_URL}/login`, { waitUntil: 'networkidle' });
    await prepareImagesAndScrollTop(page);
    await page.screenshot({ path: path.join(EVIDENCE_DIR, 'login-1280-light.png'), fullPage: true });

    await page.click('[data-theme-toggle]');
    await page.waitForTimeout(350);
    await page.screenshot({ path: path.join(EVIDENCE_DIR, 'login-1280-dark.png'), fullPage: true });

    await page.fill('input[name="email"]', ADMIN_EMAIL);
    await page.fill('input[name="password"]', ADMIN_PASS);
    await Promise.all([
        page.waitForURL(`${BASE_URL}/admin`),
        page.click('button[type="submit"]'),
    ]);
    await page.waitForLoadState('networkidle');
    await prepareImagesAndScrollTop(page);
    await page.screenshot({ path: path.join(EVIDENCE_DIR, 'admin-1280.png'), fullPage: true });
    await desktopCtx.close();

    // 2. Fresh dark OS preference with no localStorage -> FCP bg check
    const osDarkCtx = await browser.newContext({ viewport: { width: 1280, height: 800 }, colorScheme: 'dark' });
    await osDarkCtx.addInitScript(() => {
        window.__paintBgCheck = [];
        const po = new PerformanceObserver((list) => {
            for (const entry of list.getEntries()) {
                if (entry.name === 'first-contentful-paint') {
                    window.__paintBgCheck.push({
                        name: entry.name,
                        startTime: Math.round(entry.startTime * 100) / 100,
                        dataTheme: document.documentElement.getAttribute('data-theme'),
                        bodyBg: document.body ? getComputedStyle(document.body).backgroundColor : null,
                    });
                }
            }
        });
        po.observe({ type: 'paint', buffered: true });
    });
    const osDarkPage = await osDarkCtx.newPage();
    attachListeners(osDarkPage);
    await osDarkPage.goto(`${BASE_URL}/_styleguide`, { waitUntil: 'networkidle' });
    await osDarkPage.waitForTimeout(200);
    console.log('FCP DARK VIA OS PREFERS-COLOR-SCHEME (NO STORAGE):', JSON.stringify(await measureFcpBg(osDarkPage)));
    await osDarkCtx.close();

    // 3. Tablet 768x1024 light & dark screenshots (/styleguide, /login, /admin)
    const tabletCtx = await browser.newContext({ viewport: { width: 768, height: 1024 }, colorScheme: 'light' });
    const tPage = await tabletCtx.newPage();
    attachListeners(tPage);
    await tPage.goto(`${BASE_URL}/_styleguide`, { waitUntil: 'networkidle' });
    await prepareImagesAndScrollTop(tPage);
    console.log('TABLET 768 LIGHT OVERFLOW:', JSON.stringify(await tPage.evaluate(() => ({ scrollWidth: document.documentElement.scrollWidth, innerWidth: window.innerWidth }))));
    await tPage.screenshot({ path: path.join(EVIDENCE_DIR, 'styleguide-768-light.png'), fullPage: true });

    await tPage.click('[data-theme-toggle]');
    await tPage.waitForTimeout(350);
    await tPage.evaluate(() => window.scrollTo({ top: 0, left: 0, behavior: 'instant' }));
    console.log('TABLET 768 DARK OVERFLOW:', JSON.stringify(await tPage.evaluate(() => ({ scrollWidth: document.documentElement.scrollWidth, innerWidth: window.innerWidth }))));
    await tPage.screenshot({ path: path.join(EVIDENCE_DIR, 'styleguide-768-dark.png'), fullPage: true });

    await tPage.evaluate(() => window.localStorage.setItem('theme', 'light'));
    await tPage.goto(`${BASE_URL}/login`, { waitUntil: 'networkidle' });
    await tPage.screenshot({ path: path.join(EVIDENCE_DIR, 'login-768-light.png'), fullPage: true });
    await tPage.click('[data-theme-toggle]');
    await tPage.waitForTimeout(350);
    await tPage.screenshot({ path: path.join(EVIDENCE_DIR, 'login-768-dark.png'), fullPage: true });

    await tPage.fill('input[name="email"]', ADMIN_EMAIL);
    await tPage.fill('input[name="password"]', ADMIN_PASS);
    await Promise.all([tPage.waitForURL(`${BASE_URL}/admin`), tPage.click('button[type="submit"]')]);
    await tPage.waitForLoadState('networkidle');
    await tPage.screenshot({ path: path.join(EVIDENCE_DIR, 'admin-768.png'), fullPage: true });
    await tabletCtx.close();

    // 4. Mobile 360x800 light & dark + touch gaps >= 8px + Focus Trap Tab/Shift-Tab + scrollY=0 verification
    const mobileCtx = await browser.newContext({ viewport: { width: 360, height: 800 }, colorScheme: 'light' });
    const mPage = await mobileCtx.newPage();
    attachListeners(mPage);
    await mPage.goto(`${BASE_URL}/_styleguide`, { waitUntil: 'networkidle' });
    await prepareImagesAndScrollTop(mPage);

    const mobileMetrics = await mPage.evaluate(() => {
        const header = document.querySelector('header');
        const controls = Array.from(header.querySelectorAll('a, button')).filter((el) => {
            const r = el.getBoundingClientRect();
            return r.width > 0 && r.height > 0;
        });
        const rects = controls.map((el) => {
            const r = el.getBoundingClientRect();
            return {
                label: el.textContent.trim() || el.getAttribute('aria-label') || el.tagName,
                width: Math.round(r.width * 10) / 10,
                height: Math.round(r.height * 10) / 10,
                left: Math.round(r.left * 10) / 10,
                right: Math.round(r.right * 10) / 10,
            };
        });
        const gaps = [];
        for (let i = 0; i < rects.length - 1; i++) {
            gaps.push({
                between: `${rects[i].label} -> ${rects[i + 1].label}`,
                gapPx: Math.round((rects[i + 1].left - rects[i].right) * 10) / 10,
            });
        }
        return {
            scrollY: window.scrollY,
            scrollWidth: document.documentElement.scrollWidth,
            innerWidth: window.innerWidth,
            controls: rects,
            gaps,
        };
    });
    console.log('MOBILE 360 TOUCH TARGETS & GAPS:', JSON.stringify(mobileMetrics));
    await mPage.screenshot({ path: path.join(EVIDENCE_DIR, 'styleguide-360-light.png'), fullPage: true });

    // Focus trap test: Tab past N items and Shift+Tab backward
    await mPage.click('[data-mobile-menu-toggle]');
    const focusableCount = await mPage.evaluate(() => {
        const panel = document.querySelector('[data-mobile-menu]');
        return Array.from(panel.querySelectorAll('a[href], button:not([disabled])')).filter((el) => el.offsetParent !== null).length;
    });
    const tabSequence = [];
    const describeActive = () => mPage.evaluate(() => {
        const el = document.activeElement;
        const panel = document.querySelector('[data-mobile-menu]');
        return {
            tag: el?.tagName,
            label: el?.textContent?.trim() || el?.getAttribute('aria-label') || '',
            insidePanel: Boolean(panel && panel.contains(el)),
        };
    });
    tabSequence.push({ step: 'open', ...(await describeActive()) });
    for (let i = 1; i <= focusableCount + 3; i++) {
        await mPage.keyboard.press('Tab');
        tabSequence.push({ step: `Tab#${i}`, ...(await describeActive()) });
    }
    for (let i = 1; i <= 2; i++) {
        await mPage.keyboard.press('Shift+Tab');
        tabSequence.push({ step: `Shift+Tab#${i}`, ...(await describeActive()) });
    }
    await mPage.keyboard.press('Escape');
    tabSequence.push({ step: 'Escape', ...(await describeActive()), panelHidden: await mPage.evaluate(() => document.querySelector('[data-mobile-menu]')?.classList.contains('hidden')) });
    console.log('MOBILE DRAWER FOCUS TRAP TRACE:', JSON.stringify({ focusableCount, tabSequence }));

    await mPage.click('[data-theme-toggle]');
    await mPage.waitForTimeout(350);
    await mPage.evaluate(() => window.scrollTo({ top: 0, left: 0, behavior: 'instant' }));
    await mPage.screenshot({ path: path.join(EVIDENCE_DIR, 'styleguide-360-dark.png'), fullPage: true });

    // /login & /admin on 360px
    await mPage.evaluate(() => window.localStorage.setItem('theme', 'light'));
    await mPage.goto(`${BASE_URL}/login`, { waitUntil: 'networkidle' });
    await mPage.evaluate(() => window.scrollTo({ top: 0, left: 0, behavior: 'instant' }));
    await mPage.screenshot({ path: path.join(EVIDENCE_DIR, 'login-360-light.png'), fullPage: true });
    await mPage.click('[data-theme-toggle]');
    await mPage.waitForTimeout(350);
    await mPage.screenshot({ path: path.join(EVIDENCE_DIR, 'login-360-dark.png'), fullPage: true });

    await mPage.fill('input[name="email"]', ADMIN_EMAIL);
    await mPage.fill('input[name="password"]', ADMIN_PASS);
    await Promise.all([mPage.waitForURL(`${BASE_URL}/admin`), mPage.click('button[type="submit"]')]);
    await mPage.waitForLoadState('networkidle');
    await mPage.screenshot({ path: path.join(EVIDENCE_DIR, 'admin-360.png'), fullPage: true });
    await mobileCtx.close();

    console.log('CONSOLE ERRORS:', JSON.stringify(consoleErrors));
    console.log('FAILED ASSETS (>=400):', JSON.stringify(failedAssets));
} finally {
    await browser.close();
}
