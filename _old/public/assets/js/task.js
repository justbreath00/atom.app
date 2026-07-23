// Atomic-Bits — Task module behavior
// Filters (desktop + mobile icon row), card three-dot menu,
// archive dialog, FAB expand, and create-task type selector.
(function () {
  // ===== Filters =====
  const search    = document.getElementById('taskSearch');
  const fScope    = document.getElementById('taskScope');
  const fPri      = document.getElementById('taskPriority');
  const fDead     = document.getElementById('taskDeadline');
  const fArchived = document.getElementById('taskArchived');

  function applyFilters() {
    const q       = (search?.value || '').trim().toLowerCase();
    const scope   = fScope?.value || 'all';
    const pri     = fPri?.value || 'all';
    const dead    = fDead?.value || 'all';
    const showArc = !!fArchived?.checked;
    const now = new Date(); now.setHours(0,0,0,0);

    document.querySelectorAll('.tcard').forEach(card => {
      if (card.classList.contains('tcard-skel')) return;
      const title = card.dataset.title?.toLowerCase() || '';
      const cScope = card.dataset.scope;
      const cPri = card.dataset.priority;
      const cDead = card.dataset.deadline;
      const archived = card.dataset.archived === '1';
      let show = true;
      if (archived && !showArc) show = false;
      if (!archived && showArc) show = false;
      if (q && !title.includes(q)) show = false;
      if (scope !== 'all' && cScope !== scope) show = false;
      if (pri !== 'all' && cPri !== pri) show = false;
      if (dead !== 'all' && cDead) {
        const d = new Date(cDead); d.setHours(0,0,0,0);
        const diff = Math.round((d - now) / 86400000);
        if (dead === 'today' && diff !== 0) show = false;
        if (dead === 'week' && (diff < 0 || diff > 7)) show = false;
        if (dead === 'overdue' && diff >= 0) show = false;
      }
      card.style.display = show ? '' : 'none';
    });

    document.querySelectorAll('.kanban__column').forEach(col => {
      const list = col.querySelector('.kanban__list');
      if (!list) return;
      const visible = [...list.querySelectorAll('.tcard')].some(c => c.style.display !== 'none');
      let empty = list.querySelector('.kanban__empty');
      if (!visible) {
        if (!empty) {
          empty = document.createElement('div');
          empty.className = 'kanban__empty';
          empty.textContent = 'No tasks match your filters.';
          list.appendChild(empty);
        }
      } else if (empty) empty.remove();
    });
  }
  [search, fScope, fPri, fDead, fArchived].forEach(el => el && el.addEventListener('input', applyFilters));

  // ===== Mobile filter icon row =====
  const filterbar = document.querySelector('.filterbar');
  document.querySelectorAll('[data-filter-toggle]').forEach(btn => {
    btn.addEventListener('click', () => {
      const kind = btn.dataset.filterToggle;
      if (kind === 'archived') {
        if (!fArchived) return;
        fArchived.checked = !fArchived.checked;
        btn.classList.toggle('is-active', fArchived.checked);
        btn.setAttribute('aria-pressed', String(fArchived.checked));
        applyFilters();
        return;
      }
      if (kind === 'search') {
        filterbar?.classList.toggle('is-search-open');
        if (filterbar?.classList.contains('is-search-open')) {
          setTimeout(() => search?.focus(), 50);
        }
        return;
      }
      // scope / priority / deadline → show controls row, focus the target select
      filterbar?.classList.add('is-controls-open');
      const target = { scope: fScope, priority: fPri, deadline: fDead }[kind];
      if (target) setTimeout(() => target.focus(), 50);
    });
  });

  // ===== Card three-dot menu =====
  const menu = document.getElementById('cardMenu');
  let menuCard = null;

  function openMenu(card, anchor) {
    if (!menu) return;
    menuCard = card;
    menu.hidden = false;
    const r = anchor.getBoundingClientRect();
    // Position below the trigger, clamped to viewport
    let left = r.right - 160;
    let top  = r.bottom + 6;
    if (left < 8) left = 8;
    if (left + 180 > window.innerWidth) left = window.innerWidth - 188;
    if (top + 200 > window.innerHeight) top = r.top - 200;
    menu.style.left = left + 'px';
    menu.style.top  = top + 'px';
  }
  function closeMenu() { if (menu) { menu.hidden = true; menuCard = null; } }

  document.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-card-menu]');
    if (btn) {
      e.stopPropagation();
      const card = btn.closest('.tcard');
      if (menuCard === card && menu && !menu.hidden) { closeMenu(); return; }
      openMenu(card, btn);
      return;
    }
    if (menu && !menu.hidden && !e.target.closest('#cardMenu')) closeMenu();
  });
  window.addEventListener('scroll', closeMenu, true);
  window.addEventListener('resize', closeMenu);

  // ===== Archive dialog =====
  const dlg = document.getElementById('archiveDialog');
  const dlgConfirm = document.getElementById('archiveConfirmBtn');
  let archiveTarget = null;

  function openDialog() { if (dlg) dlg.hidden = false; }
  function closeDialog() { if (dlg) { dlg.hidden = true; archiveTarget = null; } }
  dlg?.querySelectorAll('[data-dialog-close]').forEach(el => el.addEventListener('click', closeDialog));

  menu?.addEventListener('click', (e) => {
    const item = e.target.closest('.card-menu__item');
    if (!item || !menuCard) return;
    const action = item.dataset.action;
    const card = menuCard;
    closeMenu();
    if (action === 'view') {
      window.location.href = 'task-details.php?id=' + encodeURIComponent(card.dataset.id);
    } else if (action === 'edit') {
      window.location.href = 'create-task.php?id=' + encodeURIComponent(card.dataset.id);
    } else if (action === 'archive') {
      archiveTarget = card;
      openDialog();
    } else if (action === 'delete') {
      card.remove();
      window.abToast && window.abToast({ type:'success', title:'Deleted', message:'Task removed from view.' });
    }
  });

  dlgConfirm?.addEventListener('click', () => {
    if (archiveTarget) {
      archiveTarget.dataset.archived = '1';
      applyFilters();
      window.abToast && window.abToast({ type:'success', title:'Archived', message:'Task moved to archive.' });
    }
    closeDialog();
  });

  // ===== FAB expand on tap =====
  const fab = document.getElementById('taskFab');
  if (fab) {
    fab.addEventListener('click', (e) => {
      if (!fab.classList.contains('is-expanded')) {
        e.preventDefault();
        fab.classList.add('is-expanded');
      }
      // if expanded, allow the anchor to navigate
    });
    document.addEventListener('click', (e) => {
      if (!fab.contains(e.target)) fab.classList.remove('is-expanded');
    });
  }

  // ===== Create-task type selector =====
  document.querySelectorAll('[data-type-grid]').forEach(grid => {
    const cards = grid.querySelectorAll('.type-card');
    const forms = document.querySelectorAll('[data-type-form]');
    cards.forEach(c => c.addEventListener('click', () => {
      cards.forEach(x => x.classList.remove('is-selected'));
      c.classList.add('is-selected');
      const t = c.dataset.type;
      forms.forEach(f => f.classList.toggle('is-hidden', f.dataset.typeForm !== t));
    }));
  });
})();
