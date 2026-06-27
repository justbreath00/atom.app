<?php
$pageTitle = 'Dashboard';
$activeNav = 'dashboard';
include "../app/view/includes/header.php";
    
$subjects = [
  ['title'=>'Data Structures & Algorithms','adviser'=>'Prof. Maria Santos','schedule'=>'Mon · Wed · Fri  ·  9:00 AM','room'=>'Room 301','color'=>1,'announce'=>['Lab 4 deadline moved to Friday','Submit pseudocode for binary trees before class.']],
  ['title'=>'Database Management Systems','adviser'=>'Engr. Carlos Reyes','schedule'=>'Tue · Thu  ·  1:00 PM','room'=>'Room 205','color'=>2,'announce'=>['Quiz on Normalization','Cover 1NF through 3NF. Bring a pen, no calculator needed.']],
  ['title'=>'Software Engineering','adviser'=>'Dr. Aileen Cruz','schedule'=>'Wed · Fri  ·  3:00 PM','room'=>'Room 410','color'=>3,'announce'=>['Sprint 2 demo next week','Each team prepares a 10-minute walkthrough of the MVP.']],
  ['title'=>'Discrete Mathematics','adviser'=>'Prof. Renato Lim','schedule'=>'Mon · Thu  ·  11:00 AM','room'=>'Room 112','color'=>5,'announce'=>['Problem set #3 posted','Due Sunday 11:59 PM via the portal.']],
];
?>
<div class="page">
  <div class="dashboard">
    <!-- LEFT: Subject feed -->
    <section>
      <div class="page__head" style="margin-bottom:8px">
        <div>
          <h2>Greetings, <?php echo $_SESSION['username']; ?></h2>
          <p class="page__sub">You have 3 classes today and 2 tasks due this week.</p>
            <span><?php if(!empty($_SESSION['success'])){ echo $_SESSION['success'] ?? '';} ?></span>
            <span><?php if(!empty($_SESSION['success_login'])){ echo $_SESSION['success_login'] ?? '';} ?></span>
        </div>
        <a href="create-subject.php" class="btn btn--primary">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
          New Subject
        </a>
      </div>

      <!-- Skeleton -->
      <div class="subject-feed" data-skeleton>
        <?php for ($i = 0; $i < 3; $i++): ?>
          <div class="card"><span class="skel skel--title"></span><span class="skel skel--line"></span><span class="skel skel--line" style="width:40%"></span><span class="skel skel--block" style="margin-top:10px"></span></div>
        <?php endfor; ?>
      </div>

      <!-- Content -->
      <div class="subject-feed is-hidden" data-content>
        <?php if (empty($subjects)): ?>
          <div class="empty">
            <div class="empty__art">📚</div>
            <div class="empty__title">No subjects available</div>
            <div class="empty__sub">Create your first subject to start tracking your schedule, announcements, and tasks.</div>
            <div class="empty__actions">
              <a href="create-subject.php" class="btn btn--primary">Create Subject</a>
            </div>
          </div>
        <?php else: foreach ($subjects as $s): ?>
          <article class="card feed-card">
            <span class="feed-card__stripe color-<?= $s['color'] ?>"></span>
            <div class="feed-card__head">
              <div>
                <div class="feed-card__title"><?= $s['title'] ?></div>
                <div class="feed-card__meta">
                  <span>👤 <?= $s['adviser'] ?></span>
                  <span>🕒 <?= $s['schedule'] ?></span>
                  <span>📍 <?= $s['room'] ?></span>
                </div>
              </div>
              <span class="badge badge--primary">Active</span>
            </div>
            <div class="feed-card__announce">
              <strong><?= $s['announce'][0] ?></strong>
              <?= $s['announce'][1] ?>
            </div>
            <div class="feed-card__actions">
              <a class="btn btn--secondary btn--sm" href="class.php">Open class</a>
              <a class="btn btn--ghost btn--sm" href="#">View tasks</a>
            </div>
          </article>
        <?php endforeach; endif; ?>
      </div>
    </section>

    <!-- RIGHT sidebar -->
    <aside class="dashboard__right">
      <!-- Calendar widget skeleton -->
      <div class="card" data-skeleton>
        <span class="skel skel--title"></span>
        <span class="skel skel--block" style="margin-top:10px"></span>
      </div>
      <div class="card is-hidden" data-content>
        <div class="cal">
          <div class="cal__head">
            <strong>June 2026</strong>
            <span class="card__meta">Today · 25</span>
          </div>
          <div class="cal__grid">
            <?php foreach (['S','M','T','W','T','F','S'] as $d): ?>
              <div class="cal__dow"><?= $d ?></div>
            <?php endforeach; ?>
            <?php
              $first = 0; // Sunday offset
              $days = 30;
              for ($i=0;$i<$first;$i++) echo '<div class="cal__day is-muted"></div>';
              for ($d=1;$d<=$days;$d++) {
                $cls = 'cal__day';
                if ($d === 25) $cls .= ' is-today';
                if (in_array($d, [26,28,30])) $cls .= ' has-event';
                echo "<div class=\"$cls\">$d</div>";
              }
            ?>
          </div>
          <div class="cal__upcoming">
            <div class="cal__upcoming-item"><span class="cal__upcoming-dot" style="background:#4F46E5"></span> Fri · DSA Lab 4 due</div>
            <div class="cal__upcoming-item"><span class="cal__upcoming-dot" style="background:#7C3AED"></span> Sun · DB problem set</div>
            <div class="cal__upcoming-item"><span class="cal__upcoming-dot" style="background:#3B82F6"></span> Tue · SE sprint demo</div>
          </div>
        </div>
      </div>

      <!-- Tasks widget skeleton -->
      <div class="card" data-skeleton>
        <span class="skel skel--title"></span>
        <span class="skel skel--line"></span><span class="skel skel--line"></span><span class="skel skel--line" style="width:60%"></span>
      </div>
      <div class="card is-hidden" data-content>
        <div class="card__head"><div class="card__title">Today's tasks</div><span class="card__meta">3 of 5</span></div>
        <div class="progress"><div class="progress__bar" style="width:60%"></div></div>
        <div class="task-list">
          <div class="task-item is-done"><span class="task-item__check"></span><span class="task-item__title">Read Ch. 7 — Hash Tables</span><span class="task-item__due">9:00</span></div>
          <div class="task-item is-done"><span class="task-item__check"></span><span class="task-item__title">Submit DB ERD draft</span><span class="task-item__due">1:00</span></div>
          <div class="task-item"><span class="task-item__check"></span><span class="task-item__title">Outline SE sprint demo</span><span class="task-item__due">5:00</span></div>
          <div class="task-item"><span class="task-item__check"></span><span class="task-item__title">Discrete math PS #3 · Q1–Q4</span><span class="task-item__due">Tonight</span></div>
        </div>
      </div>
    </aside>
  </div>
</div>
<?php include '../app/view/includes/footer.php'; ?>
