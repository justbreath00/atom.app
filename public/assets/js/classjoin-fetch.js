(function () {
  var form     = document.getElementById('joinForm');
  var input    = document.getElementById('joinCode');
  var errEl    = document.getElementById('joinError');
  var stepP    = document.getElementById('joinStepPaste');
  var stepW    = document.getElementById('joinStepProcess');
  var stepD    = document.getElementById('joinStepPending');
  var btnAgain = document.getElementById('joinAnother');

  // ── Grab CSRF from meta tag ───────────────────────────────
  // Add <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>"> in your header.php
  var csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

  function show(el) { el.classList.remove('is-hidden'); }
  function hide(el) { el.classList.add('is-hidden'); }

  function isValidCode(v) {
    return /^[A-Z0-9\-]{5,32}$/i.test(v.trim());
  }

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    var code = input.value.trim().toUpperCase();

    if (!isValidCode(code)) {
      errEl.hidden = false;
      input.focus();
      return;
    }

    errEl.hidden = true;
    hide(stepP);
    show(stepW);

    fetch('../server/controllers/joinclasscontroller.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-Token': csrfToken,
      },
      body: JSON.stringify({ code: code }),
    })
      .then(function (res) { return res.json(); })
      .then(function (data) {
        hide(stepW);

        if (!data.success) {
          show(stepP);
          errEl.textContent = data.message;
          errEl.hidden = false;
          input.focus();
          return;
        }

        // Populate pending step
        var friendly = data.block
          ? data.year + ' — Block ' + data.block
          : data.class_code;

        document.getElementById('joinClassName').textContent = friendly;
        document.getElementById('joinMetaCode').textContent  = data.class_code;
        document.getElementById('joinMetaTime').textContent  = new Date(data.requested_at)
          .toLocaleString(undefined, { dateStyle: 'medium', timeStyle: 'short' });

        show(stepD);
      })
      .catch(function () {
        hide(stepW);
        show(stepP);
        errEl.textContent = 'Network error. Please check your connection and try again.';
        errEl.hidden = false;
      });
  });

  btnAgain.addEventListener('click', function () {
    input.value   = '';
    errEl.hidden  = true;
    errEl.textContent = 'Please enter a valid class code.';
    hide(stepD);
    show(stepP);
    input.focus();
  });
})();