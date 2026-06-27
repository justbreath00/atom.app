
// Atomic-Bits — Task module behavior
// Search/filter for kanban cards + create-task type selector.
  /* 
(function () {
===== Filters on task.php =====
  const search = document.getElementById('taskSearch');
  const fScope = document.getElementById('taskScope');
  const fPri   = document.getElementById('taskPriority');
  const fDead  = document.getElementById('taskDeadline');

  function applyFilters() {
    const q = (search?.value || '').trim().toLowerCase();
    const scope = fScope?.value || 'all';
    const pri = fPri?.value || 'all';
    const dead = fDead?.value || 'all';
    const now = new Date(); now.setHours(0,0,0,0);

    document.querySelectorAll('.tcard').forEach(card => {
      const title = card.dataset.title?.toLowerCase() || '';
      const cScope = card.dataset.scope;
      const cPri = card.dataset.priority;
      const cDead = card.dataset.deadline; // YYYY-MM-DD
      let show = true;
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

    // Per-column empty state
    document.querySelectorAll('.kanban__column').forEach(col => {
      const list = col.querySelector('.kanban__list');
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

  [search, fScope, fPri, fDead].forEach(el => el && el.addEventListener('input', applyFilters));

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

*/