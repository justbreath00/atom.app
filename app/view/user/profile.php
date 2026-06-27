<?php
$pageTitle = 'Profile';
$activeNav = 'profile';
include "../app/view/includes/header.php";

$stats = [
  ['Classes joined','3'],
  ['Subjects','6'],
  ['Completed tasks','142'],
  ['Current streak','12 days'],
  ['Most active day','Wednesday'],
];

// Build a fake 53-week heatmap (371 cells)
$cells = [];
for ($i=0;$i<371;$i++) {
  $r = (int)(sin($i * 0.31) * 2 + 2 + ($i % 7 === 6 ? -1 : 0));
  if ($r < 0) $r = 0; if ($r > 4) $r = 4;
  $cells[] = $r;
}
?>
<div class="page">
  <!-- Hero skeleton -->
  <div class="card" data-skeleton>
    <div style="display:flex;gap:16px;align-items:center">
      <span class="skel" style="width:80px;height:80px;border-radius:20px"></span>
      <div style="flex:1"><span class="skel skel--title"></span><span class="skel skel--line" style="width:30%"></span></div>
    </div>
  </div>
  

  <div class="card is-hidden" data-content>
    <div class="profile-hero">
      <div class="profile-hero__avatar"><?php echo $_SESSION['profile']; ?></div>
      <div style="flex:1;min-width:200px">
        <div class="profile-hero__name"><?php echo $_SESSION['username']; ?></div>
        <div class="profile-hero__meta"><?php echo $_SESSION['course_name']; ?> · 3rd Year · 1st Semester</div>
        <div style="display:flex;gap:6px;margin-top:8px;flex-wrap:wrap">
          <span class="badge badge--primary">Founder</span>
          <span class="badge badge--violet">Top 5%</span>
          <span class="badge badge--success">12-day streak</span>
        </div>
      </div>
      <a href="#" class="btn btn--secondary">Edit profile</a>
    </div>
  </div>

  <!-- Stats -->
  <div class="grid grid--stats" data-skeleton>
    <?php for ($i=0;$i<5;$i++): ?>
      <div class="card"><span class="skel skel--line" style="width:50%"></span><span class="skel skel--title"></span></div>
    <?php endfor; ?>
  </div>

  <div class="grid grid--stats is-hidden" data-content>
    <?php foreach ($stats as $s): ?>
      <div class="card stat-card">
        <div class="stat-card__label"><?= $s[0] ?></div>
        <div class="stat-card__value"><?= $s[1] ?></div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Heatmap -->
  <div class="card" data-skeleton>
    <span class="skel skel--title"></span>
    <span class="skel" style="height:120px;display:block;margin-top:12px"></span>
  </div>

  <div class="card is-hidden" data-content>
    <div class="card__head">
      <div>
        <div class="card__title" style="font-size:16px">Activity</div>
        <div class="card__meta">Daily productivity, attendance, task completion, and study streak.</div>
      </div>
      <span class="badge badge--muted">Last 12 months</span>
    </div>
    <div class="heatmap" aria-label="Activity heatmap">
      <?php foreach ($cells as $r): ?>
        <div class="heatmap__cell heat-<?= $r ?>"></div>
      <?php endforeach; ?>
    </div>
    <div class="heatmap-legend">
      Less
      <span class="heatmap-legend__sq" style="background:#F1F5F9"></span>
      <span class="heatmap-legend__sq heat-1"></span>
      <span class="heatmap-legend__sq heat-2"></span>
      <span class="heatmap-legend__sq heat-3"></span>
      <span class="heatmap-legend__sq heat-4"></span>
      More
    </div>
  </div>

  <!-- Lower grid: recent + scores -->
  <div class="grid" style="grid-template-columns:1.4fr 1fr">
    <div class="card is-hidden" data-content>
      <div class="card__head"><div class="card__title">Recent activity</div><a href="#" class="card__meta">View all</a></div>
      <div class="stack" style="gap:10px">
        <div class="task-item"><span class="task-item__check" style="background:#22C55E;border-color:#22C55E"></span><span class="task-item__title">Completed Lab 3 — Linked Lists</span><span class="task-item__due">Today, 10:42</span></div>
        <div class="task-item"><span class="task-item__check" style="background:#3B82F6;border-color:#3B82F6"></span><span class="task-item__title">Attended Database lecture</span><span class="task-item__due">Yesterday</span></div>
        <div class="task-item"><span class="task-item__check" style="background:#7C3AED;border-color:#7C3AED"></span><span class="task-item__title">Joined CS Research Group</span><span class="task-item__due">2 days ago</span></div>
        <div class="task-item"><span class="task-item__check" style="background:#F59E0B;border-color:#F59E0B"></span><span class="task-item__title">Submitted Discrete Math PS #2</span><span class="task-item__due">4 days ago</span></div>
      </div>
    </div>

    <div class="card is-hidden" data-content>
      <div class="card__head"><div class="card__title">This week</div><span class="badge badge--success">+8%</span></div>
      <div class="stack">
        <div>
          <div style="display:flex;justify-content:space-between"><span class="card__meta">Productivity</span><strong>82%</strong></div>
          <div class="progress"><div class="progress__bar" style="width:82%"></div></div>
        </div>
        <div>
          <div style="display:flex;justify-content:space-between"><span class="card__meta">Consistency</span><strong>74%</strong></div>
          <div class="progress"><div class="progress__bar" style="width:74%;background:#7C3AED"></div></div>
        </div>
        <div>
          <div style="display:flex;justify-content:space-between"><span class="card__meta">Attendance</span><strong>96%</strong></div>
          <div class="progress"><div class="progress__bar" style="width:96%;background:#22C55E"></div></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include '../app/view/includes/footer.php'; ?>
