// Atomic-Bits — Vanilla JS Kanban drag & drop with batched updates.
// No SortableJS, no jQuery, no dependencies.
(function () {
  const board = document.querySelector('[data-kanban]');
  if (!board) return;

  const lists = board.querySelectorAll('.kanban__list');
  const pendingBar = document.getElementById('pendingBar');
  const pendingCount = document.getElementById('pendingCount');
  const pendingBtn = document.getElementById('pendingBtn');
  const pendingForm = document.getElementById('pendingForm');
  const pendingPayload = document.getElementById('pendingPayload');

  // Snapshot original column for each card so we know what truly changed.
  const original = new Map(); // taskId -> originalStatus
  document.querySelectorAll('.tcard').forEach(card => {
    const list = card.closest('.kanban__list');
    if (list) original.set(card.dataset.id, list.dataset.status);
  });

  const pending = new Map(); // taskId -> newStatus (only when != original)
  let countdownTimer = null;

  function refreshCounts() {
    lists.forEach(list => {
      const col = list.closest('.kanban__column');
      const counter = col?.querySelector('.kanban__count');
      if (counter) {
        const n = list.querySelectorAll('.tcard').length;
        counter.textContent = n;
      }
    });
  }

  function startCountdown(seconds) {
    clearInterval(countdownTimer);
    let remaining = seconds;
    pendingBtn.disabled = true;
    pendingBtn.textContent = 'Preparing… ' + remaining;
    countdownTimer = setInterval(() => {
      remaining--;
      if (remaining > 0) {
        pendingBtn.textContent = 'Preparing… ' + remaining;
      } else {
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
    if (newStatus === orig) {
      pending.delete(id);
    } else {
      pending.set(id, newStatus);
    }
    updatePendingBar();
  }

  // ===== Drag & drop (pointer-based, works on touch + mouse) =====
  let drag = null; // { card, ghost, offsetX, offsetY, sourceList }

  function onPointerDown(e) {
    const card = e.target.closest('.tcard');
    if (!card || !board.contains(card)) return;
    // Don't start drag from interactive controls
    if (e.target.closest('a, button, input, select, textarea')) return;
    if (e.button !== undefined && e.button !== 0) return;

    e.preventDefault();
    const rect = card.getBoundingClientRect();
    const ghost = card.cloneNode(true);
    ghost.classList.add('tcard-ghost');
    Object.assign(ghost.style, {
      position: 'fixed',
      left: rect.left + 'px',
      top: rect.top + 'px',
      width: rect.width + 'px',
      pointerEvents: 'none',
      zIndex: '200',
      transform: 'rotate(1deg)',
      boxShadow: '0 12px 32px rgba(15,23,42,.18)',
    });
    document.body.appendChild(ghost);
    card.classList.add('is-dragging');

    drag = {
      card, ghost,
      offsetX: e.clientX - rect.left,
      offsetY: e.clientY - rect.top,
      sourceList: card.closest('.kanban__list'),
    };
    document.addEventListener('pointermove', onPointerMove);
    document.addEventListener('pointerup', onPointerUp, { once: true });
  }

  function onPointerMove(e) {
    if (!drag) return;
    drag.ghost.style.left = (e.clientX - drag.offsetX) + 'px';
    drag.ghost.style.top  = (e.clientY - drag.offsetY) + 'px';

    // Highlight column under pointer
    let overList = null;
    lists.forEach(list => {
      const r = list.getBoundingClientRect();
      const inside = e.clientX >= r.left && e.clientX <= r.right
                   && e.clientY >= r.top  && e.clientY <= r.bottom;
      list.classList.toggle('is-drop-target', inside);
      if (inside) overList = list;
    });

    // Reorder within column: insert before nearest card
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

  // ===== Submit pending changes =====
  pendingBtn?.addEventListener('click', () => {
    if (pendingBtn.disabled) return;
    const payload = [];
    pending.forEach((status, id) => payload.push({ id, status }));
    if (pendingPayload) pendingPayload.value = JSON.stringify(payload);
    if (pendingForm) {
      pendingForm.submit();
    } else {
      // Fallback toast (no backend yet)
      window.abToast && window.abToast({
        type: 'success',
        title: 'Updates queued',
        message: payload.length + ' task status change(s) ready.',
      });
      // Reset baseline after "save"
      pending.forEach((status, id) => original.set(id, status));
      pending.clear();
      updatePendingBar();
    }
  });

  refreshCounts();
})();
