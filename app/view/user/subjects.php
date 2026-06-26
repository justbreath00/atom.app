<?php
$pageTitle = 'Subjects';
$activeNav = 'subjects';
include "../app/view/includes/header.php";

// Simulated: get_user_subjects_by_user_id($user_id)
$subjects = [
  ['title'=>'Data Structures & Algorithms','type'=>'Major','adviser'=>'Prof. Maria Santos','schedule'=>'MWF · 9:00 AM','room'=>'Room 301','members'=>34,'code'=>'CS-DSA-301','color'=>1],
  ['title'=>'Database Management Systems','type'=>'Major','adviser'=>'Engr. Carlos Reyes','schedule'=>'TTh · 1:00 PM','room'=>'Room 205','members'=>28,'code'=>'CS-DBMS-220','color'=>2],
  ['title'=>'Software Engineering','type'=>'Major','adviser'=>'Dr. Aileen Cruz','schedule'=>'WF · 3:00 PM','room'=>'Room 410','members'=>30,'code'=>'CS-SE-410','color'=>3],
  ['title'=>'Discrete Mathematics','type'=>'Minor','adviser'=>'Prof. Renato Lim','schedule'=>'MTh · 11:00 AM','room'=>'Room 112','members'=>40,'code'=>'MATH-DM-110','color'=>5],
  ['title'=>'Technical Writing','type'=>'Minor','adviser'=>'Ms. Joanne Tan','schedule'=>'F · 10:00 AM','room'=>'Room 204','members'=>22,'code'=>'ENG-TW-200','color'=>4],
  ['title'=>'Operating Systems','type'=>'Major','adviser'=>'Prof. Daniel Yu','schedule'=>'TTh · 9:00 AM','room'=>'Room 303','members'=>26,'code'=>'CS-OS-330','color'=>2],
];
?>
<div class="page">
  <div class="page__head">
    <div>
      <h2>Your Subjects</h2>
      <p class="page__sub">All subjects you're enrolled in this semester.</p>
    </div>
    <div style="display:flex;gap:8px">
      <a href="#" class="btn btn--secondary">Join Subject</a>
      <a href="create-subject.php" class="btn btn--primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
        Add Subject
      </a>
    </div>
  </div>

  <!-- Skeleton -->
  <div class="grid grid--cards" data-skeleton>
    <?php for ($i=0;$i<6;$i++): ?>
      <div class="card"><span class="skel skel--block" style="height:64px"></span><span class="skel skel--title" style="margin-top:12px"></span><span class="skel skel--line"></span><span class="skel skel--line" style="width:50%"></span></div>
    <?php endfor; ?>
  </div>

  <!-- Content -->
  <div class="is-hidden" data-content>
    <?php if (empty($subjects)): ?>
      <div class="empty">
        <div class="empty__art">📘</div>
        <div class="empty__title">No subjects yet</div>
        <div class="empty__sub">Create your first subject or join an existing one using a class code.</div>
        <div class="empty__actions">
          <a href="create-subject.php" class="btn btn--primary">Create Subject</a>
          <a href="class.php" class="btn btn--secondary">Join Subject</a>
        </div>
      </div>
    <?php else: ?>
      <div class="grid grid--cards">
        <?php foreach ($subjects as $s): ?>
          <a href="class.php" class="card subject-card">
            <div class="subject-card__top color-<?= $s['color'] ?>"><?= $s['title'] ?></div>
            <div class="subject-card__type"><?= $s['type'] ?> subject</div>
            <div class="subject-card__meta">
              <span>👤 <?= $s['adviser'] ?></span>
              <span>🕒 <?= $s['schedule'] ?></span>
              <span>📍 <?= $s['room'] ?></span>
            </div>
            <div class="subject-card__foot">
              <span class="card__meta"><?= $s['members'] ?> members</span>
              <span class="subject-card__code"><?= $s['code'] ?></span>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php include '../app/view/includes/footer.php'; ?>
