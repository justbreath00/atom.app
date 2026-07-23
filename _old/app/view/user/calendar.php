<?php
$pageTitle = 'Calendar';
$activeNav = 'calendar';
include "../app/view/includes/header.php";

$days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
$todayIdx = 3; // Thursday — Jun 25, 2026
$times = ['08:00','09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00'];

// events[day_index][start_time] = ['title','room','color',(span hours)]
$events = [
  0 => ['08:00'=>['Programming','Room 301',1,2],'13:00'=>['Discrete Math','Room 112',5,1]],
  1 => ['09:00'=>['Operating Systems','Room 303',2,1],'13:00'=>['Database','Room 205',2,2]],
  2 => ['09:00'=>['Programming','Room 301',1,1],'15:00'=>['Software Eng.','Room 410',3,2]],
  3 => ['09:00'=>['Operating Systems','Room 303',2,1],'11:00'=>['Discrete Math','Room 112',5,1],'13:00'=>['Database','Room 205',2,2]],
  4 => ['09:00'=>['Programming','Room 301',1,1],'10:00'=>['Technical Writing','Room 204',4,1],'15:00'=>['Software Eng.','Room 410',3,2]],
  5 => [],
];
$nowDay = 3; $nowTime = '13:00';

// Build a skip-map for cells covered by a multi-hour event
$skip = [];
foreach ($events as $dIdx => $list) {
  foreach ($list as $t => $ev) {
    for ($i=1; $i<$ev[3]; $i++) {
      $hour = (int)substr($t,0,2) + $i;
      $skip["$dIdx-".sprintf('%02d:00',$hour)] = true;
    }
  }
}
?>
<div class="page">
  <div class="page__head">
    <div>
      <h2>Weekly Schedule</h2>
      <p class="page__sub">June 22 – 27, 2026 · 1st Semester</p>
    </div>
    <div style="display:flex;gap:8px">
      <button class="btn btn--secondary btn--sm">‹ Prev</button>
      <button class="btn btn--secondary btn--sm">This week</button>
      <button class="btn btn--secondary btn--sm">Next ›</button>
    </div>
  </div>

  <div data-skeleton>
    <div class="card"><span class="skel skel--title"></span>
      <?php for ($i=0;$i<6;$i++) echo '<span class="skel skel--block" style="margin-top:10px"></span>'; ?>
    </div>
  </div>

  <div class="is-hidden" data-content>
    <?php
      $hasEvents = false;
      foreach ($events as $e) if (!empty($e)) { $hasEvents = true; break; }
    ?>
    <?php if (!$hasEvents): ?>
      <div class="empty">
        <div class="empty__art">🗓️</div>
        <div class="empty__title">No schedule yet</div>
        <div class="empty__sub">Add subjects with a schedule to see them on your weekly timetable.</div>
        <div class="empty__actions">
          <a href="create-subject.php" class="btn btn--primary">Add Subject</a>
        </div>
      </div>
    <?php else: ?>
      <div class="timetable-wrap">
        <div class="timetable">
          <div class="tt__corner"></div>
          <?php foreach ($days as $idx => $d): ?>
            <div class="tt__dow <?= $idx === $todayIdx ? 'is-today' : '' ?>"><?= $d ?></div>
          <?php endforeach; ?>

          <?php foreach ($times as $t): ?>
            <div class="tt__time"><?= $t ?></div>
            <?php foreach ($days as $idx => $d):
              $key = "$idx-$t";
              if (isset($skip[$key])) continue;
              $isToday = $idx === $todayIdx;
              echo '<div class="tt__cell ' . ($isToday ? 'is-today' : '') . '"';
              $ev = $events[$idx][$t] ?? null;
              if ($ev && $ev[3] > 1) echo ' style="grid-row:span ' . $ev[3] . '"';
              echo '>';
              if ($ev) {
                $nowCls = ($idx === $nowDay && $t === $nowTime) ? ' is-now' : '';
                echo '<div class="tt__event color-' . $ev[2] . $nowCls . '">';
                echo '<span class="tt__event-title">' . htmlspecialchars($ev[0]) . '</span>';
                echo '<span class="tt__event-room">' . htmlspecialchars($ev[1]) . '</span>';
                echo '</div>';
              }
              echo '</div>';
            endforeach; ?>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php include '../app/view/includes/footer.php'; ?>
