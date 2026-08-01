/**
 * ghost.js — Ghost eye tracking + password peek animation
 * Works on both login.php and register.php
 * No external dependencies.
 *
 * Rewritten for plain <img>-based markup (not SVG).
 */

(function () {
    'use strict';

    /* ── Element references ─────────────────────────────────── */
    const ghost       = document.getElementById('ghosty-base');
    const eyeLeft     = document.getElementById('eye-left');
    const eyeRight    = document.getElementById('eye-right');
    const eyeLeftClosed  = document.getElementById('eye-left-closed');
    const eyeRightClosed = document.getElementById('eye-right-closed');

    // Grab ALL password-type inputs on the page
    const passwordInputs = Array.from(
        document.querySelectorAll('input[type="password"]')
    );

    if (!ghost || !eyeLeft || !eyeRight) return; // safety guard

    const MAX_OFFSET = 6; // px the pupils are allowed to shift

    /**
     * Work out how far to nudge the pupils, based on pointer
     * position relative to the ghost's on-screen center.
     */
    function getOffset(clientX, clientY) {
        const rect = ghost.getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;

        const dx = clientX - centerX;
        const dy = clientY - centerY;
        const len = Math.hypot(dx, dy) || 1;

        const dist = Math.min(len, MAX_OFFSET);
        return {
            x: (dx / len) * dist,
            y: (dy / len) * dist,
        };
    }

    /* ── State ───────────────────────────────────────────────── */
    let eyesClosed   = false;
    let rafId        = null;
    let latestClient = null; // most recent pointer position

    /* ── Eye tracking loop ──────────────────────────────────── */
    function updateEyes() {
        rafId = null;
        if (eyesClosed || !latestClient) return;

        const offset = getOffset(latestClient.x, latestClient.y);
        const transform = `translate(${offset.x}px, ${offset.y}px)`;
        eyeLeft.style.transform  = transform;
        eyeRight.style.transform = transform;
    }

    function scheduleUpdate() {
        if (!rafId) rafId = requestAnimationFrame(updateEyes);
    }

    /* ── Pointer events ─────────────────────────────────────── */
    // Mouse
    document.addEventListener('mousemove', (e) => {
        latestClient = { x: e.clientX, y: e.clientY };
        if (!eyesClosed) scheduleUpdate();
    });

    // Touch — use first touch point
    document.addEventListener('touchmove', (e) => {
        const t = e.touches[0];
        latestClient = { x: t.clientX, y: t.clientY };
        if (!eyesClosed) scheduleUpdate();
    }, { passive: true });

    /* ── Open / close helpers ────────────────────────────────── */
    function closeEyes() {
        if (eyesClosed) return;
        eyesClosed = true;

        eyeLeft.style.display  = 'none';
        eyeRight.style.display = 'none';
        if (eyeLeftClosed)  eyeLeftClosed.style.display  = 'block';
        if (eyeRightClosed) eyeRightClosed.style.display = 'block';

        // Reset pupils to centre for next time they open
        eyeLeft.style.transform  = '';
        eyeRight.style.transform = '';
    }

    function openEyes() {
        if (!eyesClosed) return;
        eyesClosed = false;

        eyeLeft.style.display  = 'block';
        eyeRight.style.display = 'block';
        if (eyeLeftClosed)  eyeLeftClosed.style.display  = 'none';
        if (eyeRightClosed) eyeRightClosed.style.display = 'none';

        // Immediately aim at last known pointer
        if (latestClient) scheduleUpdate();
    }

    /* ── Password field focus events ────────────────────────── */
    // Keep track of how many password fields are currently focused
    // (register has two, login has one)
    let focusCount = 0;

    passwordInputs.forEach((input) => {
        input.addEventListener('focus', () => {
            focusCount++;
            closeEyes();
        });

        input.addEventListener('blur', () => {
            focusCount = Math.max(0, focusCount - 1);
            if (focusCount === 0) openEyes();
        });
    });

    /* ── Initial idle position (look slightly down-centre) ─── */
    latestClient = {
        x: window.innerWidth  / 2,
        y: window.innerHeight / 2,
    };
    scheduleUpdate();

})();