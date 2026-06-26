<?php
require_once '../app/utils/session.php';
    if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
        header('Location: login.php');
        exit;
    }

// _header.php — shared layout shell for Atomic-Bits
// Usage: include __DIR__ . '/_header.php'; before page content, then close </main></div> at end.
if (!isset($pageTitle)) $pageTitle = 'Atomic-Bits';
if (!isset($activeNav)) $activeNav = '';
$navItems = [
  ['key' => 'dashboard', 'label' => 'Dashboard', 'href' => 'dashboard.php', 'icon' => 'home'],
  ['key' => 'subjects',  'label' => 'Subjects',  'href' => 'subjects.php',  'icon' => 'book'],
  ['key' => 'class',     'label' => 'Classes',   'href' => 'class.php',     'icon' => 'users'],
  ['key' => 'calendar',  'label' => 'Calendar',  'href' => 'calendar.php',  'icon' => 'calendar'],
  ['key' => 'tasks',     'label' => 'Tasks',     'href' => '#',             'icon' => 'check', 'soon' => true],
  ['key' => 'daily',     'label' => 'Daily Spread', 'href' => '#',          'icon' => 'layers', 'soon' => true],
  ['key' => 'profile',   'label' => 'Profile',   'href' => 'profile.php',   'icon' => 'user'],
  ['key' => 'logout',    'label' => 'logout',    'href' => 'logout.php',    'icon' => 'logout'],

];

function ab_icon($name) {
  $icons = [
    'home'     => '<path d="M3 12 12 4l9 8"/><path d="M5 10v10h14V10"/>',
    'book'     => '<path d="M4 4h12a4 4 0 0 1 4 4v12H8a4 4 0 0 1-4-4z"/><path d="M4 4v12a4 4 0 0 0 4 4"/>',
    'users'    => '<circle cx="9" cy="8" r="3"/><circle cx="17" cy="10" r="2.5"/><path d="M3 20c0-3 3-5 6-5s6 2 6 5"/><path d="M15 20c0-2 2-4 4-4s4 2 4 4"/>',
    'calendar' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 9h18M8 3v4M16 3v4"/>',
    'check'    => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="m8 12 3 3 5-6"/>',
    'layers'   => '<path d="M12 3 2 8l10 5 10-5z"/><path d="m2 13 10 5 10-5"/>',
    'user'     => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-7 8-7s8 3 8 7"/>',
    'menu'     => '<path d="M4 6h16M4 12h16M4 18h16"/>',
    'close'    => '<path d="M6 6l12 12M18 6 6 18"/>',
    'plus'     => '<path d="M12 5v14M5 12h14"/>',
    'logout' => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/>',

  ];
  return '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ($icons[$name] ?? '') . '</svg>';
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($pageTitle) ?> · Atomic-Bits</title>
  <meta name="description" content="Atomic-Bits — a student productivity platform inspired by Atomic Habits. Manage classes, subjects, schedules, and tasks." />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" />
  <link rel="stylesheet" href="assets/css/general.css" />
</head>
<body>
  <a class="sr-skip" href="#main">Skip to content</a>

  <!-- Mobile top bar -->
  <header class="mobile-bar" role="banner">
    <button class="icon-btn" id="abMenuOpen" aria-label="Open navigation" aria-controls="abSidebar" aria-expanded="false">
      <?= ab_icon('menu') ?>
    </button>
    <a href="dashboard.php" class="brand brand--sm" aria-label="Atomic-Bits home">
    
      <span class="brand__name">Atomic-Bits</span>
    </a>
    <div class="avatar avatar--sm" aria-hidden="true"><?php echo $_SESSION['profile'];  ?></div>
  </header>

  <div class="app-shell">
    <!-- Sidebar -->
    <aside class="sidebar" id="abSidebar" aria-label="Primary navigation">
      <div class="sidebar__inner">
        <a href="dashboard.php" class="brand">
        
          <span class="brand__name">Atomic-Bits</span>
        </a>

        <nav class="nav" aria-label="Main">
          <?php foreach ($navItems as $item): ?>
            <a href="<?= $item['href'] ?>"
               class="nav__item<?= $activeNav === $item['key'] ? ' is-active' : '' ?>"
               <?= !empty($item['soon']) ? 'aria-disabled="true"' : '' ?>>
              <span class="nav__icon"><?= ab_icon($item['icon']) ?></span>
              <span class="nav__label"><?= $item['label'] ?></span>
              <?php if (!empty($item['soon'])): ?>
                <span class="badge badge--muted">Soon</span>
              <?php endif; ?>
            </a>
          <?php endforeach; ?>
        </nav>

        <div class="sidebar__footer">
          <div class="profile-card">
            <div class="avatar"><?php echo $_SESSION['profile'];  ?></div>
            <div class="profile-card__meta">
              <div class="profile-card__name"><?php echo $_SESSION['username']; ?></div>
              <div class="profile-card__sub">BSCS · 3rd Year</div>
            </div>
          </div>
        </div>
      </div>
    </aside>

    <div class="sidebar__overlay" id="abSidebarOverlay" hidden></div>

    <!-- Page content wrapper -->
    <main class="main" id="main" role="main">
      <!-- Sticky top header for desktop -->
      <div class="topbar">
        <div class="topbar__title">
          <h1><?= htmlspecialchars($pageTitle) ?></h1>
        </div>
        <div class="topbar__actions">
          <button class="btn btn--ghost" type="button" aria-label="Notifications">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 1 1 12 0c0 7 3 7 3 9H3c0-2 3-2 3-9Z"/><path d="M10 21a2 2 0 0 0 4 0"/></svg>
          </button>
        </div>
      </div>
      <!-- Toast region -->
      <div class="toast-region" id="abToasts" role="status" aria-live="polite"></div>