// Atomic-Bits — UI behavior (minimal, no animation-heavy effects)
(function () {
  // Mobile sidebar
  const sidebar = document.getElementById('abSidebar');
  const overlay = document.getElementById('abSidebarOverlay');
  const openBtn = document.getElementById('abMenuOpen');
  function openSidebar() {
    sidebar.classList.add('is-open');
    overlay.hidden = false;
    openBtn && openBtn.setAttribute('aria-expanded', 'true');
  }
  function closeSidebar() {
    sidebar.classList.remove('is-open');
    overlay.hidden = true;
    openBtn && openBtn.setAttribute('aria-expanded', 'false');
  }
  openBtn && openBtn.addEventListener('click', openSidebar);
  overlay && overlay.addEventListener('click', closeSidebar);
  window.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeSidebar(); });

  // Toasts
  const region = document.getElementById('abToasts');
  window.abToast = function (opts) {
    if (!region) return;
    const t = document.createElement('div');
    t.className = 'toast toast--' + (opts.type || 'info');
    t.innerHTML = '<span class="toast__dot"></span><div><div class="toast__title">' +
      (opts.title || '') + '</div><div class="toast__msg">' + (opts.message || '') + '</div></div>';
    region.appendChild(t);
    setTimeout(() => t.remove(), 4000);
  };

  // Simulate data load: hide skeletons, reveal content after ~700ms
  setTimeout(function () {
    document.querySelectorAll('[data-skeleton]').forEach(el => el.classList.add('is-hidden'));
    document.querySelectorAll('[data-content]').forEach(el => el.classList.remove('is-hidden'));
  }, 700);

  // Radio cards
  document.querySelectorAll('[data-radio-group]').forEach(group => {
    group.querySelectorAll('.radio-card').forEach(card => {
      card.addEventListener('click', () => {
        group.querySelectorAll('.radio-card').forEach(c => c.classList.remove('is-selected'));
        card.classList.add('is-selected');
        const input = card.querySelector('input[type=radio]');
        if (input) input.checked = true;
      });
    });
  });

  // Multi-step form
  document.querySelectorAll('[data-stepper]').forEach(form => {
    const steps = form.querySelectorAll('[data-step]');
    const indicators = form.querySelectorAll('.step');
    let current = 0;
    function render() {
      steps.forEach((s, i) => s.classList.toggle('is-hidden', i !== current));
      indicators.forEach((el, i) => {
        el.classList.toggle('is-active', i === current);
        el.classList.toggle('is-done', i < current);
      });
    }
    form.querySelectorAll('[data-next]').forEach(b => b.addEventListener('click', () => {
      if (current < steps.length - 1) { current++; render(); }
    }));
    form.querySelectorAll('[data-prev]').forEach(b => b.addEventListener('click', () => {
      if (current > 0) { current--; render(); }
    }));
    render();
  });

  // Demo submit handlers
  document.querySelectorAll('[data-demo-submit]').forEach(form => {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      window.abToast({ type: 'success', title: 'Saved', message: 'Your changes were applied.' });
    });
  });
})();

