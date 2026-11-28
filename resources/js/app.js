document.addEventListener('DOMContentLoaded', () => {
    // Theme synchronization and toggle without page reload
    const root = document.documentElement;
    const themeToggles = Array.from(document.querySelectorAll('[data-theme-toggle]'));

    const syncThemeUI = (theme) => {
        const isDark = theme === 'dark';
        const nextLabel = isDark ? 'Mode terang' : 'Mode gelap';
        const nextAriaLabel = isDark ? 'Aktifkan mode terang' : 'Aktifkan mode gelap';

        themeToggles.forEach((btn) => {
            btn.setAttribute('aria-pressed', String(isDark));
            btn.setAttribute('aria-label', nextAriaLabel);

            const label = btn.querySelector('[data-theme-label]');
            if (label) {
                label.textContent = nextLabel;
            }

            const sunIcon = btn.querySelector('[data-theme-icon="sun"]');
            const moonIcon = btn.querySelector('[data-theme-icon="moon"]');
            if (sunIcon) sunIcon.classList.toggle('hidden', !isDark);
            if (moonIcon) moonIcon.classList.toggle('hidden', isDark);
        });
    };

    syncThemeUI(root.getAttribute('data-theme') || 'light');

    themeToggles.forEach((btn) => {
        btn.addEventListener('click', () => {
            const current = root.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
            const next = current === 'dark' ? 'light' : 'dark';
            root.setAttribute('data-theme', next);
            try {
                window.localStorage.setItem('theme', next);
            } catch {
                // Storage might be disabled in restricted browsing modes.
            }
            syncThemeUI(next);
        });
    });

    // Mobile full-panel navigation with focus trap and Escape dismissal
    const mobileBtn = document.querySelector('[data-mobile-menu-toggle]');
    const mobilePanel = document.querySelector('[data-mobile-menu]');
    const mobileClose = document.querySelector('[data-mobile-menu-close]');

    if (mobileBtn && mobilePanel) {
        const focusableSelector =
            'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';

        const isPanelOpen = () => !mobilePanel.classList.contains('hidden');

        const openPanel = () => {
            mobilePanel.classList.remove('hidden');
            mobilePanel.setAttribute('aria-hidden', 'false');
            mobileBtn.setAttribute('aria-expanded', 'true');
            const firstTarget = mobileClose || mobilePanel.querySelector(focusableSelector);
            if (firstTarget instanceof HTMLElement) {
                firstTarget.focus();
            }
        };

        const closePanel = (restoreFocus = true) => {
            if (!isPanelOpen()) return;
            mobilePanel.classList.add('hidden');
            mobilePanel.setAttribute('aria-hidden', 'true');
            mobileBtn.setAttribute('aria-expanded', 'false');
            if (restoreFocus && mobileBtn instanceof HTMLElement) {
                mobileBtn.focus();
            }
        };

        mobileBtn.addEventListener('click', () => {
            if (isPanelOpen()) {
                closePanel(true);
            } else {
                openPanel();
            }
        });

        if (mobileClose) {
            mobileClose.addEventListener('click', () => closePanel(true));
        }

        mobilePanel.querySelectorAll('a[href]').forEach((link) => {
            link.addEventListener('click', () => closePanel(false));
        });

        mobilePanel.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                event.preventDefault();
                closePanel(true);
                return;
            }

            if (event.key !== 'Tab') return;

            const focusables = Array.from(mobilePanel.querySelectorAll(focusableSelector)).filter(
                (el) => el instanceof HTMLElement && el.offsetParent !== null,
            );
            if (focusables.length === 0) return;

            const first = focusables[0];
            const last = focusables[focusables.length - 1];

            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        });
    }

    // Ticker pause / resume button (WCAG 2.2.2)
    document.querySelectorAll('[data-ticker]').forEach((ticker) => {
        const toggle = ticker.querySelector('[data-ticker-toggle]');
        if (!toggle) return;

        const syncTickerUI = (paused) => {
            ticker.setAttribute('data-paused', paused ? 'true' : 'false');
            toggle.setAttribute('aria-pressed', paused ? 'true' : 'false');
            toggle.setAttribute('aria-label', paused ? 'Putar ticker pengumuman' : 'Jeda ticker pengumuman');

            const label = toggle.querySelector('[data-ticker-toggle-label]');
            if (label) {
                label.textContent = paused ? 'Putar' : 'Jeda';
            }

            const playIcon = toggle.querySelector('[data-ticker-icon="play"]');
            const pauseIcon = toggle.querySelector('[data-ticker-icon="pause"]');
            if (playIcon) playIcon.classList.toggle('hidden', !paused);
            if (pauseIcon) pauseIcon.classList.toggle('hidden', paused);
        };

        syncTickerUI(ticker.getAttribute('data-paused') === 'true');

        toggle.addEventListener('click', () => {
            const isPaused = ticker.getAttribute('data-paused') === 'true';
            syncTickerUI(!isPaused);
        });
    });

    // Move focus to the first invalid form field after validation redirect
    const firstInvalidField = document.querySelector('[data-focus-first-error] [aria-invalid="true"]');
    if (firstInvalidField instanceof HTMLElement) {
        firstInvalidField.focus();
    }

    // Accessible dropdown toggles (used by legacy/admin screens if present)
    document.querySelectorAll('[data-dropdown-toggle]').forEach((trigger) => {
        const targetId = trigger.getAttribute('data-dropdown-toggle');
        const panel = targetId ? document.getElementById(targetId) : null;
        if (!panel) return;

        trigger.addEventListener('click', (event) => {
            event.stopPropagation();
            const isHidden = panel.classList.contains('hidden');
            document.querySelectorAll('[data-dropdown-panel]').forEach((other) => {
                other.classList.add('hidden');
            });
            panel.classList.toggle('hidden', !isHidden);
            trigger.setAttribute('aria-expanded', String(isHidden));
        });
    });

    document.addEventListener('click', () => {
        document.querySelectorAll('[data-dropdown-panel]').forEach((panel) => {
            panel.classList.add('hidden');
        });
        document.querySelectorAll('[data-dropdown-toggle]').forEach((btn) => {
            btn.setAttribute('aria-expanded', 'false');
        });
    });

    // Modal triggers (e.g., logout confirmation)
    document.querySelectorAll('[data-modal-open]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const modal = document.getElementById(btn.getAttribute('data-modal-open'));
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                const firstFocus = modal.querySelector('button, [href], input');
                if (firstFocus instanceof HTMLElement) {
                    firstFocus.focus();
                }
            }
        });
    });

    document.querySelectorAll('[data-modal-close]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const modal = btn.closest('[data-modal]');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });
    });

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') return;
        document.querySelectorAll('[data-modal]').forEach((modal) => {
            if (!modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });
    });
});
