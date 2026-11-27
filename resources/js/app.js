import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    // Mobile navbar toggle
    const mobileBtn = document.querySelector('[data-mobile-menu-toggle]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');
    if (mobileBtn && mobileMenu) {
        mobileBtn.addEventListener('click', () => {
            const expanded = mobileBtn.getAttribute('aria-expanded') === 'true';
            mobileBtn.setAttribute('aria-expanded', String(!expanded));
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Accessible dropdown toggles
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
});
