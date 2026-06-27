<?php
$pageTitle = 'Tasks';
$activeNav = 'tasks';
include "../app/view/includes/header.php";

// Realistic student data — both personal and class tasks across statuses.
$tasks = [
  ['id'=>'t1','title'=>'Read Ch. 7 — Hash Tables','desc'=>'Cover open addressing and chaining. Take notes for tomorrow’s recitation.','scope'=>'personal','priority'=>'medium','deadline'=>'2026-06-28','status'=>'todo'],
  ['id'=>'t2','title'=>'DSA Lab 4 — Binary Trees','desc'=>'Submit pseudocode and complexity analysis on the portal.','scope'=>'class','subject'=>'Data Structures','priority'=>'high','deadline'=>'2026-06-26','status'=>'todo'],
  ['id'=>'t3','title'=>'Buy index cards for Discrete Math','desc'=>'Need 200 cards for proof drills this weekend.','scope'=>'personal','priority'=>'low','deadline'=>'2026-06-27','status'=>'todo'],
  ['id'=>'t4','title'=>'DB Quiz on Normalization','desc'=>'1NF through 3NF, with sample decompositions.','scope'=>'class','subject'=>'Database Management','priority'=>'high','deadline'=>'2026-06-27','status'=>'ongoing'],
  ['id'=>'t5','title'=>'SE Sprint 2 — MVP walkthrough','desc'=>'Draft the 10-minute demo script and rehearse with the team.','scope'=>'class','subject'=>'Software Engineering','priority'=>'medium','deadline'=>'2026-07-02','status'=>'ongoing'],
  ['id'=>'t6','title'=>'Update GitHub portfolio README','desc'=>'Add the new internship project and pin the top 3 repos.','scope'=>'personal','priority'=>'low','deadline'=>'2026-07-05','status'=>'ongoing'],
  ['id'=>'t7','title'=>'Submit DB ERD draft','desc'=>'Posted in the class group. Confirm submission email.','scope'=>'class','subject'=>'Database Management','priority'=>'medium','deadline'=>'2026-06-24','status'=>'finished'],
  ['id'=>'t8','title'=>'Discrete Math PS #2 Q1–Q4','desc'=>'Proofs by induction. Re-check Q3 simplification.','scope'=>'class','subject'=>'Discrete Mathematics','priority'=>'medium','deadline'=>'2026-06-23','status'=>'finished'],
  ['id'=>'t9','title'=>'Refill student ID load','desc'=>'For library printing and cafeteria.','scope'=>'personal','priority'=>'low','deadline'=>'2026-06-22','status'=>'finished'],
];

$columns = [
  ['key'=>'todo','label'=>'To Do','dot'=>'todo'],
  ['key'=>'ongoing','label'=>'Ongoing','dot'=>'ongoing'],
  ['key'=>'finished','label'=>'Finished','dot'=>'finished'],
];

function ab_pri_class($p){return ['low'=>'pri-low','medium'=>'pri-med','high'=>'pri-high'][$p]??'pri-med';}
function ab_pri_label($p){return ['low'=>'Low','medium'=>'Medium','high'=>'High'][$p]??'Medium';}
function ab_fmt_date($d){return date('M j', strtotime($d));}
?>
<link rel="stylesheet" href="task.css" />

<div class="task-page">
  <!-- Toolbar -->
  <div class="task-toolbar">
    <div class="task-toolbar__title">
      <h2>Tasks</h2>
      <p>Manage your personal and class activities.</p>
    </div>
    <div class="task-toolbar__actions">
      <a href="create-task.php" class="btn btn--primary">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
        Create Task
      </a>
    </div>
  </div>

  <!-- Filters   -->
  <div class="task-filters" role="search">
    <input id="taskSearch" type="search" class="input" placeholder="Search tasks by title…" />
    <select id="taskScope" class="select" aria-label="Scope">
      <option value="all">All</option>
      <option value="personal">Personal</option>
      <option value="class">Class</option>
    </select>
    <select id="taskPriority" class="select" aria-label="Priority">
      <option value="all">Any priority</option>
      <option value="high">High</option>
      <option value="medium">Medium</option>
      <option value="low">Low</option>
    </select>
    <select id="taskDeadline" class="select" aria-label="Deadline">
      <option value="all">Any deadline</option>
      <option value="today">Due today</option>
      <option value="week">Within 7 days</option>
      <option value="overdue">Overdue</option>
    </select>
  </div>


  <!-- Skeleton -->
  <div class="kanban" data-skeleton aria-hidden="true">
    <?php foreach ($columns as $c): ?>
      <div class="kanban__column">
        <div class="kanban__header">
          <div class="kanban__title"><span class="kanban__dot kanban__dot--<?= $c['dot'] ?>"></span><?= $c['label'] ?></div>
          <span class="kanban__count">–</span>
        </div>
        <div class="kanban__list">
          <?php for ($i=0;$i<3;$i++): ?>
            <div class="tcard tcard-skel">
              <span class="skel skel--line"></span>
              <span class="skel skel--line" style="width:90%"></span>
              <span class="skel skel--line" style="width:50%"></span>
            </div>
          <?php endfor; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Content -->
  <?php if (empty($tasks)): ?>
    <div class="is-hidden" data-content>
      <div class="empty task-empty">
        <div>
          <div class="empty__art">🗂️</div>
          <div class="empty__title">No Tasks Yet</div>
          <div class="empty__sub">Start by adding your first task. Personal tasks are private; class tasks are shared with your classmates.</div>
          <div class="empty__actions">
            <a href="create-task.php?type=personal" class="btn btn--secondary">Create Personal Task</a>
            <a href="create-task.php?type=class" class="btn btn--primary">Create Class Task</a>
          </div>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div class="kanban is-hidden" data-content data-kanban>
      <?php foreach ($columns as $c):
        $colTasks = array_values(array_filter($tasks, fn($t)=>$t['status']===$c['key'])); ?>
        <section class="kanban__column">
          <div class="kanban__header">
            <div class="kanban__title">
              <span class="kanban__dot kanban__dot--<?= $c['dot'] ?>"></span>
              <?= $c['label'] ?>
            </div>
            <span class="kanban__count"><?= count($colTasks) ?></span>
          </div>
          <div class="kanban__list" data-status="<?= $c['key'] ?>">
            <?php foreach ($colTasks as $t): $pri = ab_pri_class($t['priority']); ?>
              <article class="tcard <?= $pri ?>"
                       data-id="<?= $t['id'] ?>"
                       data-title="<?= htmlspecialchars($t['title']) ?>"
                       data-scope="<?= $t['scope'] ?>"
                       data-priority="<?= $t['priority'] ?>"
                       data-deadline="<?= $t['deadline'] ?>">
                <div class="tcard__head">
                  <div class="tcard__title"><?= htmlspecialchars($t['title']) ?></div>
                  <?php if ($t['scope']==='personal'): ?>
                    <span class="badge badge--blue">Personal</span>
                  <?php else: ?>
                    <span class="badge badge--violet">Class</span>
                  <?php endif; ?>
                </div>
                <?php if (!empty($t['desc'])): ?>
                  <div class="tcard__desc"><?= htmlspecialchars($t['desc']) ?></div>
                <?php endif; ?>
                <div class="tcard__foot">
                  <div class="tcard__meta">
                    <span title="Deadline">📅 <?= ab_fmt_date($t['deadline']) ?></span>
                    <span class="tcard__priority"><span class="tcard__pri-dot"></span><?= ab_pri_label($t['priority']) ?></span>
                  </div>
                  <a class="tcard__view" href="task-details.php?id=<?= $t['id'] ?>">View Task →</a>
                </div>
              </article>
            <?php endforeach; ?>
            <?php if (empty($colTasks)): ?>
              <div class="kanban__empty">Drop tasks here.</div>
            <?php endif; ?>
          </div>
        </section>
      <?php endforeach; ?>
    </div>

    <!-- Floating pending update bar -->
    <aside class="pending-bar" id="pendingBar" hidden aria-live="polite">
      <div class="pending-bar__icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-3-6.7"/><path d="M21 4v5h-5"/></svg>
      </div>
      <div class="pending-bar__meta">
        <span class="pending-bar__title">Pending Changes</span>
        <span class="pending-bar__sub"><span class="pending-bar__count" id="pendingCount">0 Tasks Modified</span></span>
      </div>
      <div class="pending-bar__actions">
        <form id="pendingForm" action="update-task-status.php" method="post" style="margin:0">
          <input type="hidden" name="changes" id="pendingPayload" />
          <button type="button" id="pendingBtn" class="btn btn--primary btn--sm" disabled>Preparing…</button>
        </form>
      </div>
    </aside>
  <?php endif; ?>
</div>

 <script src="assets/js/task.js"></script>
<script src="assets/js/kanban.js"></script>
<?php include '../app/view/includes/footer.php'; ?>
