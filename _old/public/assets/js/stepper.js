(() => {
  const form      = document.getElementById('classCreateForm');
  const steps     = [...document.querySelectorAll('[data-step]')];
  const indicators = [...document.querySelectorAll('[data-step-indicator]')];
  let current = 0;

  // ── If server redirected to ?step=done, jump straight to step 3 ──
  if (new URLSearchParams(location.search).get('step') === 'done') {
    goTo(2);
  }

  // ── Radio group selection ─────────────────────────────────────────
  document.querySelectorAll('[data-radio-group]').forEach(group => {
    group.querySelectorAll('.radio-card').forEach(card => {
      card.addEventListener('click', () => {
        group.querySelectorAll('.radio-card').forEach(c => c.classList.remove('is-selected'));
        card.classList.add('is-selected');
        card.querySelector('input[type="radio"]').checked = true;
      });
    });
  });

  // ── Next ──────────────────────────────────────────────────────────
  document.querySelectorAll('[data-next]').forEach(btn => {
    btn.addEventListener('click', () => {
      if (!validateStep(current)) return;
      if (current === 0) populateConfirm();
      goTo(current + 1);
    });
  });

  // ── Prev ──────────────────────────────────────────────────────────
  document.querySelectorAll('[data-prev]').forEach(btn => {
    btn.addEventListener('click', () => goTo(current - 1));
  });

  // ── On submit: copy UI values into hidden fields ──────────────────
  form.addEventListener('submit', () => {
    document.getElementById('hidden_block').value    = document.getElementById('block').value.trim();
    document.getElementById('hidden_year').value     = getRadioValue('_year');
    document.getElementById('hidden_semester').value = getRadioValue('_semester');
  });

  // ── Helpers ───────────────────────────────────────────────────────
  function goTo(index) {
    steps[current].classList.add('is-hidden');
    indicators[current].classList.remove('is-active');
    current = index;
    steps[current].classList.remove('is-hidden');
    indicators[current].classList.add('is-active');
  }

  function validateStep(index) {
    if (index === 0) {
      const block = document.getElementById('block').value.trim();
      if (!block) {
        alert('Please enter a block.');
        return false;
      }
      if (!/^[A-Za-z0-9]+$/.test(block)) {
        alert('Block must be alphanumeric only.');
        return false;
      }
    }
    return true;
  }

  function populateConfirm() {
    document.getElementById('confirm_block').textContent    = document.getElementById('block').value.trim().toUpperCase();
    document.getElementById('confirm_year').textContent     = getRadioValue('_year');
    document.getElementById('confirm_semester').textContent = getRadioValue('_semester');
  }

  function getRadioValue(name) {
    return document.querySelector(`input[name="${name}"]:checked`)?.value ?? '';
  }
})();