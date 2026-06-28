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
  ['key'=>'todo','label'=>'To Do','accent'=>'todo','hex'=>'#A855F7'],
  ['key'=>'ongoing','label'=>'Ongoing','accent'=>'ongoing','hex'=>'#3B82F6'],
  ['key'=>'finished','label'=>'Finished','accent'=>'finished','hex'=>'#22C55E'],
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
    <a href="create-task.php" class="btn btn--primary task-toolbar__create">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
      Add Task
    </a>
  </div>

  <!-- Filter bar: desktop = inline controls, mobile = icon row -->
  <div class="filterbar" role="search">
    <div class="filterbar__search">
      <svg class="filterbar__search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
      <input id="taskSearch" type="search" class="input filterbar__input" placeholder="Search tasks…" />
    </div>
    <div class="filterbar__controls" data-filter-controls>
      <label class="filterbar__field">
        <span class="filterbar__lbl">Scope</span>
        <select id="taskScope" class="select">
          <option value="all">All</option>
          <option value="personal">Personal</option>
          <option value="class">Class</option>
        </select>
      </label>
      <label class="filterbar__field">
        <span class="filterbar__lbl">Priority</span>
        <select id="taskPriority" class="select">
          <option value="all">Any</option>
          <option value="high">High</option>
          <option value="medium">Medium</option>
          <option value="low">Low</option>
        </select>
      </label>
      <label class="filterbar__field">
        <span class="filterbar__lbl">Deadline</span>
        <select id="taskDeadline" class="select">
          <option value="all">Any</option>
          <option value="today">Today</option>
          <option value="week">7 days</option>
          <option value="overdue">Overdue</option>
        </select>
      </label>
      <label class="filterbar__field filterbar__field--toggle">
        <input id="taskArchived" type="checkbox" />
        <span>Archived</span>
      </label>
    </div>

    <!-- Mobile icon row -->
    <div class="filterbar__icons" aria-hidden="false">
      <button type="button" class="ficon" data-filter-toggle="search" aria-label="Search">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
      </button>
      <button type="button" class="ficon" data-filter-toggle="scope" aria-label="Scope">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M6 12h12M10 18h4"/></svg>
      </button>
      <button type="button" class="ficon" data-filter-toggle="priority" aria-label="Priority">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 21V4M4 4l10 3-3 4 3 4-10 3"/></svg>
      </button>
      <button type="button" class="ficon" data-filter-toggle="deadline" aria-label="Deadline">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
      </button>
      <button type="button" class="ficon" data-filter-toggle="archived" aria-label="Archived" aria-pressed="false">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="4" rx="1"/><path d="M5 8v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8"/><path d="M10 12h4"/></svg>
      </button>
    </div>
  </div>

  <!-- Skeleton -->
  <div class="kanban" data-skeleton aria-hidden="true">
    <?php foreach ($columns as $c): ?>
      <div class="kanban__column kanban__column--<?= $c['accent'] ?>">
        <div class="kanban__header">
          <div class="kanban__title"><span class="kanban__dot"></span><?= $c['label'] ?></div>
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
        <section class="kanban__column kanban__column--<?= $c['accent'] ?>" data-col="<?= $c['key'] ?>">
          <div class="kanban__header">
            <div class="kanban__title">
              <span class="kanban__dot"></span>
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
                  <div class="tcard__head-right">
                    <?php if ($t['scope']==='personal'): ?>
                      <span class="badge badge--blue">Personal</span>
                    <?php else: ?>
                      <span class="badge badge--violet">Class</span>
                    <?php endif; ?>
                    <button type="button" class="tcard__menu-btn" data-card-menu aria-label="Card options" aria-haspopup="true">
                      <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><circle cx="5" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="19" cy="12" r="2"/></svg>
                    </button>
                  </div>
                </div>
                <?php if (!empty($t['desc'])): ?>
                  <div class="tcard__desc"><?= htmlspecialchars($t['desc']) ?></div>
                <?php endif; ?>
                <div class="tcard__foot">
                  <div class="tcard__meta">
                    <span title="Deadline">📅 <?= ab_fmt_date($t['deadline']) ?></span>
                    <span class="tcard__priority"><span class="tcard__pri-dot"></span><?= ab_pri_label($t['priority']) ?></span>
                  </div>
                  <a class="tcard__view" href="task-details.php?id=<?= $t['id'] ?>">View →</a>
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

    <!-- Card menu popover (singleton) -->
    <div class="card-menu" id="cardMenu" hidden role="menu">
      <button type="button" class="card-menu__item" data-action="view" role="menuitem">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/></svg>
        View
      </button>
      <button type="button" class="card-menu__item" data-action="edit" role="menuitem">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4Z"/></svg>
        Edit
      </button>
      <button type="button" class="card-menu__item" data-action="archive" role="menuitem">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="4" rx="1"/><path d="M5 8v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8"/><path d="M10 12h4"/></svg>
        Archive
      </button>
      <button type="button" class="card-menu__item card-menu__item--danger" data-action="delete" role="menuitem">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M8 6V4h8v2M6 6l1 14h10l1-14"/></svg>
        Delete
      </button>
    </div>

    <!-- Archive confirm dialog -->
    <div class="ab-dialog" id="archiveDialog" hidden role="dialog" aria-modal="true" aria-labelledby="archiveDialogTitle">
      <div class="ab-dialog__backdrop" data-dialog-close></div>
      <div class="ab-dialog__panel">
        <h3 id="archiveDialogTitle">Archive Task?</h3>
        <p>Do you want to archive this task? You can find it later by enabling the Archived filter.</p>
        <div class="ab-dialog__actions">
          <button type="button" class="btn btn--ghost" data-dialog-close>Cancel</button>
          <button type="button" class="btn btn--primary" id="archiveConfirmBtn">Archive</button>
        </div>
      </div>
    </div>

    <!-- Mobile long-press drop dock -->
    <div class="drop-dock" id="dropDock" hidden aria-hidden="true">
      <div class="drop-dock__hint">Drop on a column</div>
      <div class="drop-dock__targets">
        <button type="button" class="drop-target drop-target--todo" data-drop="todo">
          <span class="drop-target__dot"></span>
          <span class="drop-target__label">Todo</span>
        </button>
        <button type="button" class="drop-target drop-target--ongoing" data-drop="ongoing">
          <span class="drop-target__dot"></span>
          <span class="drop-target__label">Ongoing</span>
        </button>
        <button type="button" class="drop-target drop-target--finished" data-drop="finished">
          <span class="drop-target__dot"></span>
          <span class="drop-target__label">Finished</span>
        </button>
      </div>
    </div>
    <div class="drop-scrim" id="dropScrim" hidden></div>

    <!-- Mobile FAB -->
    <a href="create-task.php" class="fab" id="taskFab" role="button" aria-label="Add Task">
      <span class="fab__icon" aria-hidden="true">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
      </span>
      <span class="fab__label">Add Task</span>
    </a>

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
