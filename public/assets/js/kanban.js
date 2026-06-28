// Atomic-Bits — Kanban interactions
// Desktop: classic pointer drag-and-drop between columns.
// Mobile: long-press to lift card → bottom Drop Zone Dock with 3 targets.
// In both, moves are tracked locally and submitted via the pending bar.
(function () {
  const board = document.querySelector('[data-kanban]');
  if (!board) return;

  const lists = board.querySelectorAll('.kanban__list');
  const pendingBar = document.getElementById('pendingBar');
  const pendingCount = document.getElementById('pendingCount');
  const pendingBtn = document.getElementById('pendingBtn');
  const pendingForm = document.getElementById('pendingForm');
  const pendingPayload = document.getElementById('pendingPayload');

  const dock   = document.getElementById('dropDock');
  const scrim  = document.getElementById('dropScrim');
  const dropTargets = dock ? dock.querySelectorAll('.drop-target') : [];

  const isMobile = () => window.matchMedia('(max-width: 900px)').matches;

  // Snapshot original column for each card so we know what truly changed.
  const original = new Map();
  document.querySelectorAll('.tcard').forEach(card => {
    const list = card.closest('.kanban__list');
    if (list) original.set(card.dataset.id, list.dataset.status);
  });

  const pending = new Map();
  let countdownTimer = null;

  function refreshCounts() {
    lists.forEach(list => {
      const col = list.closest('.kanban__column');
      const counter = col?.querySelector('.kanban__count');
      if (counter) counter.textContent = list.querySelectorAll('.tcard').length;
    });
  }

  function startCountdown(seconds) {
    clearInterval(countdownTimer);
    let remaining = seconds;
    pendingBtn.disabled = true;
    pendingBtn.textContent = 'Preparing… ' + remaining;
    countdownTimer = setInterval(() => {
      remaining--;
      if (remaining > 0) pendingBtn.textContent = 'Preparing… ' + remaining;
      else {
        clearInterval(countdownTimer);
        pendingBtn.disabled = false;
        pendingBtn.textContent = 'Update';
      }
    }, 1000);
  }

  function updatePendingBar() {
    const n = pending.size;
    if (n === 0) {
      pendingBar.hidden = true;
      clearInterval(countdownTimer);
      return;
    }
    pendingBar.hidden = false;
    pendingCount.textContent = n + ' Task' + (n === 1 ? '' : 's') + ' Modified';
    startCountdown(10);
  }

  function recordMove(card, newStatus) {
    const id = card.dataset.id;
    const orig = original.get(id);
    if (newStatus === orig) pending.delete(id);
    else pending.set(id, newStatus);
    updatePendingBar();
  }

  function moveCardToStatus(card, status) {
    const targetList = document.querySelector('.kanban__list[data-status="' + status + '"]');
    if (!targetList || card.closest('.kanban__list') === targetList) {
      recordMove(card, status);
      refreshCounts();
      return;
    }
    const empty = targetList.querySelector('.kanban__empty');
    if (empty) empty.remove();
    targetList.appendChild(card);
    recordMove(card, status);
    refreshCounts();
  }

  // ============================================================
  // DESKTOP: pointer drag-and-drop between columns
  // ============================================================
  let drag = null;

  function onPointerDown(e) {
    if (isMobile()) return; // mobile uses long-press flow
    const card = e.target.closest('.tcard');
    if (!card || !board.contains(card)) return;
    if (e.target.closest('a, button, input, select, textarea, [data-card-menu]')) return;
    if (e.button !== undefined && e.button !== 0) return;

    e.preventDefault();
    const rect = card.getBoundingClientRect();
    const ghost = card.cloneNode(true);
    ghost.classList.add('tcard-ghost');
    Object.assign(ghost.style, {
      position:'fixed', left:rect.left+'px', top:rect.top+'px',
      width:rect.width+'px', pointerEvents:'none', zIndex:'200',
      transform:'rotate(1deg)', boxShadow:'0 12px 32px rgba(15,23,42,.18)',
    });
    document.body.appendChild(ghost);
    card.classList.add('is-dragging');

    drag = { card, ghost,
      offsetX:e.clientX-rect.left, offsetY:e.clientY-rect.top,
      sourceList:card.closest('.kanban__list'),
    };
    document.addEventListener('pointermove', onPointerMove);
    document.addEventListener('pointerup', onPointerUp, { once:true });
  }

  function onPointerMove(e) {
    if (!drag) return;
    drag.ghost.style.left = (e.clientX - drag.offsetX) + 'px';
    drag.ghost.style.top  = (e.clientY - drag.offsetY) + 'px';

    let overList = null;
    lists.forEach(list => {
      const r = list.getBoundingClientRect();
      const inside = e.clientX >= r.left && e.clientX <= r.right
                   && e.clientY >= r.top  && e.clientY <= r.bottom;
      list.classList.toggle('is-drop-target', inside);
      if (inside) overList = list;
    });

    if (overList) {
      const after = getCardAfter(overList, e.clientY);
      if (after == null) overList.appendChild(drag.card);
      else overList.insertBefore(drag.card, after);
    }
  }

  function getCardAfter(list, y) {
    const cards = [...list.querySelectorAll('.tcard:not(.is-dragging)')];
    return cards.find(c => {
      const r = c.getBoundingClientRect();
      return y < r.top + r.height / 2;
    }) || null;
  }

  function onPointerUp() {
    if (!drag) return;
    document.removeEventListener('pointermove', onPointerMove);
    drag.ghost.remove();
    drag.card.classList.remove('is-dragging');
    lists.forEach(l => l.classList.remove('is-drop-target'));

    const newList = drag.card.closest('.kanban__list');
    const newStatus = newList?.dataset.status;
    if (newStatus) recordMove(drag.card, newStatus);
    refreshCounts();
    drag = null;
  }

  board.addEventListener('pointerdown', onPointerDown);

  // ============================================================
  // MOBILE: long-press → drop dock
  // ============================================================
  const LONG_PRESS_MS = 380;
  let pressTimer = null;
  let pressed = null;     // the card being long-pressed
  let liftedCard = null;  // the card currently selected for dock drop
  let pressStart = null;

  function clearPress() {
    if (pressTimer) { clearTimeout(pressTimer); pressTimer = null; }
    pressed = null;
    pressStart = null;
  }

  function openDock(card) {
    liftedCard = card;
    card.classList.add('is-lifted');
    if (dock) { dock.hidden = false; requestAnimationFrame(() => dock.classList.add('is-open')); }
    if (scrim) { scrim.hidden = false; requestAnimationFrame(() => scrim.classList.add('is-open')); }
  }

  function closeDock(animate = true) {
    if (liftedCard) liftedCard.classList.remove('is-lifted');
    liftedCard = null;
    dock?.classList.remove('is-open');
    scrim?.classList.remove('is-open');
    dropTargets.forEach(t => t.classList.remove('is-over'));
    if (animate) {
      setTimeout(() => { if (dock) dock.hidden = true; if (scrim) scrim.hidden = true; }, 250);
    } else {
      if (dock) dock.hidden = true;
      if (scrim) scrim.hidden = true;
    }
  }

  board.addEventListener('pointerdown', (e) => {
    if (!isMobile()) return;
    const card = e.target.closest('.tcard');
    if (!card) return;
    if (e.target.closest('a, button, input, select, textarea, [data-card-menu]')) return;
    pressed = card;
    pressStart = { x: e.clientX, y: e.clientY };
    pressTimer = setTimeout(() => {
      if (pressed) {
        if (navigator.vibrate) navigator.vibrate(15);
        openDock(pressed);
      }
      pressTimer = null;
    }, LONG_PRESS_MS);
  });

  board.addEventListener('pointermove', (e) => {
    if (!pressStart || !pressed) return;
    const dx = e.clientX - pressStart.x;
    const dy = e.clientY - pressStart.y;
    if (Math.hypot(dx, dy) > 10) clearPress(); // scroll started — cancel
  });
  board.addEventListener('pointerup', clearPress);
  board.addEventListener('pointercancel', clearPress);

  // Drop dock target taps
  dropTargets.forEach(t => {
    t.addEventListener('pointerenter', () => t.classList.add('is-over'));
    t.addEventListener('pointerleave', () => t.classList.remove('is-over'));
    t.addEventListener('click', () => {
      if (!liftedCard) return;
      const status = t.dataset.drop;
      flyAndMove(liftedCard, t, status);
    });
  });

  scrim?.addEventListener('click', () => closeDock());

  // Card flies toward the chosen target, then is re-parented.
  function flyAndMove(card, target, status) {
    const cardRect = card.getBoundingClientRect();
    const tRect = target.getBoundingClientRect();
    const dx = (tRect.left + tRect.width/2) - (cardRect.left + cardRect.width/2);
    const dy = (tRect.top  + tRect.height/2) - (cardRect.top  + cardRect.height/2);

    card.classList.remove('is-lifted');
    card.classList.add('is-flying');
    card.style.transform = `translate(${dx}px, ${dy}px) scale(.3)`;
    card.style.opacity = '0';

    setTimeout(() => {
      card.style.transform = '';
      card.style.opacity = '';
      card.classList.remove('is-flying');
      moveCardToStatus(card, status);
      closeDock();
    }, 360);
  }

  // ============================================================
  // Submit pending changes
  // ============================================================
  pendingBtn?.addEventListener('click', () => {
    if (pendingBtn.disabled) return;
    const payload = [];
    pending.forEach((status, id) => payload.push({ id, status }));
    if (pendingPayload) pendingPayload.value = JSON.stringify(payload);
    if (pendingForm) pendingForm.submit();
    else {
      window.abToast && window.abToast({
        type:'success', title:'Updates queued',
        message: payload.length + ' task status change(s) ready.',
      });
      pending.forEach((status, id) => original.set(id, status));
      pending.clear();
      updatePendingBar();
    }
  });

  refreshCounts();
})();
