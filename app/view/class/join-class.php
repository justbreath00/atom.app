<?php
$pageTitle = 'Join Class';
$activeNav = 'class';
include "../app/view/includes/header.php";
?>


<div class="page">
  <div class="page__head">
    <div>
      <h2>Join class</h2>
      <p class="page__sub">Join Block and wait for class admin response.</p>
    </div>
    <a href="class.php" class="btn btn--ghost">Cancel</a>
  </div>

  <!-- Skeleton -->
  <div data-skeleton>
    <div class="card" style="max-width:560px;margin:24px auto">
      <span class="skel skel--title"></span>
      <span class="skel skel--line"></span>
      <span class="skel skel--line" style="width:70%"></span>
      <span class="skel skel--block" style="margin-top:12px;height:80px"></span>
    </div>
  </div>

  <!-- Content -->
  <div class="is-hidden" data-content>
    <div class="join-wrap">

      <!-- STEP 1: Paste code -->
      <section class="join-card" id="joinStepPaste" data-step="paste">
        <div class="join-card__head">
          <div class="join-card__icon" aria-hidden="true">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="8" y="3" width="8" height="4" rx="1"/><path d="M16 5h2a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h2"/></svg>
          </div>
          <div>
            <h2 class="join-card__title">Join a Class</h2>
            <p class="join-card__sub">Paste the class code your admin shared with you.</p>
          </div>
        </div>

        <form id="joinForm" class="join-form" novalidate>
          <label class="field">
            <span class="field__label">Class code</span>
            <input
              type="text"
              id="joinCode"
              class="input join-input"
              placeholder="BSIT-2.1A-2026"
              autocomplete="off"
              spellcheck="false"
              maxlength="32"
              required
            />
            <span class="field__hint">Codes are case-insensitive. Looks like <code>XXXX-XXXXX</code>.</span>
            <span class="field__error" id="joinError" hidden style="display: none">Please enter a valid class code.</span>
          </label>

          <div class="join-actions">
            <a href="class.php" class="btn btn--ghost">Cancel</a>
            <button type="submit" class="btn btn--primary" id="joinSubmit">
              <span class="btn__label">Join Class</span>
            </button>
          </div>
        </form>
      </section>

      <!-- STEP 2: Processing -->
      <section class="join-card join-card--center is-hidden" id="joinStepProcess" data-step="process" aria-live="polite">
        <div class="join-spinner" aria-hidden="true"></div>
        <h2 class="join-card__title">Checking your code…</h2>
        <p class="join-card__sub">Verifying the class and sending your request to the admin.</p>
      </section>

      <!-- STEP 3: Pending -->
      <section class="join-card join-card--center is-hidden" id="joinStepPending" data-step="pending">
        <div class="join-badge join-badge--pending" aria-hidden="true">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
        </div>
        <h2 class="join-card__title">Request sent</h2>
        <p class="join-card__sub">
          Your request to join <strong id="joinClassName">this class</strong> is now
          <span class="badge badge--warning">Pending</span>.
          The admin will review and approve it soon.
        </p>

        <div class="join-meta">
          <div class="join-meta__row">
            <span class="join-meta__k">Class code</span>
            <span class="join-meta__v" id="joinMetaCode">—</span>
          </div>
          <div class="join-meta__row">
            <span class="join-meta__k">Requested at</span>
            <span class="join-meta__v" id="joinMetaTime">—</span>
          </div>
          <div class="join-meta__row">
            <span class="join-meta__k">Status</span>
            <span class="join-meta__v"><span class="dot dot--warning"></span> Waiting for admin approval</span>
          </div>
        </div>

        <div class="join-actions join-actions--center">
          <a href="class.php" class="btn btn--secondary">Back to Classes</a>
          <button type="button" class="btn btn--ghost" id="joinAnother">Join another class</button>
        </div>
      </section>

    </div>
  </div>
</div>


<script src="assets/js/classjoin-fetch.js"></script>
<?php include '../app/view/includes/footer.php'; ?>
