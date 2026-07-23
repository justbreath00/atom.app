/**
 * auth.js — Shared UI behaviours for login.php and register.php
 * - Password show/hide toggle (preserves original togglePassword() intent)
 * - Error message display helper
 * No external dependencies.
 */

(function () {
    'use strict';

    /* ── Password visibility toggles ────────────────────────── */
    // Handles both login's single toggle (#toggle-pw) and
    // register's multiple toggles ([data-target] buttons).

    document.querySelectorAll('.toggle-pw').forEach((btn) => {
        btn.addEventListener('click', () => {
            // Resolve which input this button controls
            const targetId = btn.dataset.target || 'password';
            const input    = document.getElementById(targetId)
                          || btn.closest('.input-wrap')?.querySelector('input');

            if (!input) return;

            const isPassword = input.type === 'password';
            input.type       = isPassword ? 'text' : 'password';

            // Swap eye icons
            const iconOpen   = btn.querySelector('.icon-eye-open');
            const iconClosed = btn.querySelector('.icon-eye-closed');
            if (iconOpen && iconClosed) {
                iconOpen.style.display   = isPassword ? 'none'  : '';
                iconClosed.style.display = isPassword ? ''      : 'none';
            }

            btn.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
        });
    });

    /* ── Error message utility ───────────────────────────────── */
    // PHP flash messages often set #error-message content server-side;
    // this ensures visibility if content is injected after load.
    const errorEl = document.getElementById('error-message');
    if (errorEl && errorEl.textContent.trim()) {
        errorEl.style.display = '';
    }

})();