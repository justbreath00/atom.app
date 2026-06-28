<?php
$pageTitle = 'Create Class';
$activeNav = 'class';
include "../app/view/includes/header.php";
?>
<div class="page">
  <div class="page__head">
    <div>
      <h2>Create a new class</h2>
      <p class="page__sub">Set up a class block in a few steps.</p>
    </div>
    <a href="class.php" class="btn btn--ghost">Cancel</a>
  </div>

  <div class="card">
    <div class="stepper" aria-label="Progress">
      <div class="step is-active" data-step-indicator="1"><span class="step__num">1</span> Class info</div>
      <span class="step__line"></span>
      <div class="step" data-step-indicator="2"><span class="step__num">2</span> Confirmation</div>
      <span class="step__line"></span>
      <div class="step" data-step-indicator="3"><span class="step__num">3</span> Done</div>
    </div>

    <form id="classCreateForm" action="classcreate_controller.php" method="POST">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '') ?>" />
      <input type="hidden" name="block" id="hidden_block" />
      <input type="hidden" name="year" id="hidden_year" />
      <input type="hidden" name="semester" id="hidden_semester" />

      <!-- Step 1 -->
      <div data-step="1">
        <div class="stack" style="max-width:560px">
          <div class="field">
            <label class="field__label" for="block">Block</label>
            <input class="input" id="block" placeholder="e.g. A" required />
          </div>

          <div class="field">
            <label class="field__label">Year</label>
            <div class="radio-group" data-radio-group style="grid-template-columns:repeat(4,1fr)">
              <?php foreach (['First year','Second year','Third year','Fourth year'] as $i => $y): ?>
                <label class="radio-card <?= $i === 2 ? 'is-selected' : '' ?>">
                  <input type="radio" name="_year" value="<?= $y ?>" <?= $i === 2 ? 'checked' : '' ?> hidden />
                  <span class="radio-card__title"><?= $y ?></span>
                </label>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="field">
            <label class="field__label">Semester</label>
            <div class="radio-group" data-radio-group>
              <label class="radio-card is-selected">
                <input type="radio" name="_semester" value="first semester" checked hidden />
                <span class="radio-card__title">First semester</span>
              </label>
              <label class="radio-card">
                <input type="radio" name="_semester" value="second semester" hidden />
                <span class="radio-card__title">Second semester</span>
              </label>
            </div>
          </div>

          <div class="field">
            <span class="field__label">Default role</span>
            <span class="badge badge--muted" style="width:max-content">Member</span>
            <span class="field__hint">All members joining via class code start as Member. You can promote them later.</span>
          </div>
        </div>
        <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:20px">
          <button type="button" class="btn btn--primary" data-next>Continue</button>
        </div>
      </div>

      <!-- Step 2 -->
      <div data-step="2" class="is-hidden">
        <h3 style="margin-bottom:12px">Confirm details</h3>
        <div class="card card--surface">
          <div class="stack" style="gap:6px">
            <div><strong>Block:</strong> <span id="confirm_block">—</span></div>
            <div><strong>Year:</strong> <span id="confirm_year">—</span></div>
            <div><strong>Semester:</strong> <span id="confirm_semester">—</span></div>
            <div><strong>Owner role:</strong> Admin</div>
            <div><strong>Default member role:</strong> Member</div>
          </div>
        </div>
        <div style="display:flex;justify-content:space-between;gap:8px;margin-top:20px">
          <button type="button" class="btn btn--secondary" data-prev>Back</button>
          <button type="submit" class="btn btn--primary">Create class</button>
        </div>
      </div>

      <!-- Step 3 -->
      <div data-step="3" class="is-hidden">
        <div class="empty" style="background:transparent;border:none;padding:40px 0">
          <div class="empty__art" style="background:#DCFCE7;color:#15803D">✓</div>
          <div class="empty__title">Class created</div>
          <div class="empty__sub">Your class code is <strong><?= htmlspecialchars($_SESSION['last_created_class']['class_code'] ?? '') ?></strong>. Share it with classmates so they can join.</div>
          <div class="empty__actions">
            <a href="create-subject.php" class="btn btn--primary">Add a subject</a>
            <a href="class.php" class="btn btn--secondary">Back to classes</a>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="assets/js/classcreate.js"></script>
<?php include '../app/view/includes/footer.php'; ?>