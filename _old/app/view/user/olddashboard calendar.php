
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