<?php
$pageTitle = 'Classes';
$activeNav = 'class';
include "../app/view/includes/header.php";

// Simulated: get_classes_by_user_id($user_id)
$classes = [
  ['name'=>'BSCS 3-A','block'=>'A','year'=>'3rd Year','semester'=>'1st Semester','members'=>38,'role'=>'admin'],
  ['name'=>'BSCS 3-B Elective','block'=>'B','year'=>'3rd Year','semester'=>'1st Semester','members'=>26,'role'=>'editor'],
  ['name'=>'CS Research Group','block'=>'R','year'=>'3rd Year','semester'=>'1st Semester','members'=>12,'role'=>'member'],
];
$roleBadge = ['admin'=>'badge--primary','editor'=>'badge--violet','member'=>'badge--muted'];
?>
<div class="page">
  <div class="page__head">
    <div>
      <h2>Your Classes</h2>
      <p class="page__sub">Class blocks group your subjects, members, and schedules.</p>
    </div>
    <div style="display:flex;gap:8px">
      <a href="#" class="btn btn--secondary">Join Class</a>
      <a href="create-class.php" class="btn btn--primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
        Create Class
      </a>
    </div>
  </div>

  <div class="grid grid--cards" data-skeleton>
    <?php for ($i=0;$i<3;$i++): ?>
      <div class="card"><span class="skel skel--title"></span><span class="skel skel--line"></span><span class="skel skel--line" style="width:60%"></span><span class="skel skel--block" style="margin-top:10px"></span></div>
    <?php endfor; ?>
  </div>

  <div class="is-hidden" data-content>
    <?php if (empty($classes)): ?>
      <div class="empty">
        <div class="empty__art">👥</div>
        <div class="empty__title">No Classes Yet</div>
        <div class="empty__sub">Create a class block for your batch or join an existing one with a class code.</div>
        <div class="empty__actions">
          <a href="create-class.php" class="btn btn--primary">Create Class</a>
          <a href="#" class="btn btn--secondary">Join Class</a>
        </div>
      </div>
    <?php else: ?>
      <div class="grid grid--cards">
        <?php foreach ($classes as $c): ?>
          <article class="card">
            <div class="card__head">
              <div>
                <div class="card__title" style="font-size:16px"><?= $c['name'] ?></div>
                <div class="card__meta">Block <?= $c['block'] ?> · <?= $c['year'] ?> · <?= $c['semester'] ?></div>
              </div>
              <span class="badge <?= $roleBadge[$c['role']] ?>"><?= ucfirst($c['role']) ?></span>
            </div>
            <div class="card__meta" style="margin:6px 0 14px">👥 <?= $c['members'] ?> members</div>
            <div style="display:flex;gap:8px">
              <a href="#" class="btn btn--primary btn--sm">Open Class</a>
              <?php if ($c['role'] !== 'member'): ?>
                <a href="#" class="btn btn--secondary btn--sm">Manage</a>
              <?php endif; ?>
              <a href="#" class="btn btn--ghost btn--sm">Join</a>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php include '../app/view/includes/footer.php'; ?>
