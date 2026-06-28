<?php

// ─────────────────────────────────────────────────────────────
// classcreatecontroller.php
// Handles POST — creates a new block
// ─────────────────────────────────────────────────────────────

declare(strict_types=1);


require_once '../app/model/ClassModel.php';
require_once "../app/utils/session.php";





// ── Method guard ──────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: class-create.php');
    exit;
}

// ── CSRF guard ────────────────────────────────────────────────
if (
    empty($_POST['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])
) {
    $_SESSION['flash_msg'] = [
        'type'    => 'error',
        'message' => 'Invalid request. Please try again.',
    ];
    header('Location: class-create.php');
    exit;
}

// ── Rate limit: 5 blocks per user per hour ────────────────────
$rlKey    = 'block_create_' . $_SESSION['user_id'];
$rlLimit  = 5;
$rlWindow = 3600;

if (!isset($_SESSION[$rlKey])) {
    $_SESSION[$rlKey] = ['count' => 0, 'window_start' => time()];
}

if ((time() - $_SESSION[$rlKey]['window_start']) > $rlWindow) {
    $_SESSION[$rlKey] = ['count' => 0, 'window_start' => time()];
}

if ($_SESSION[$rlKey]['count'] >= $rlLimit) {
    $_SESSION['flash_msg'] = [
        'type'    => 'error',
        'message' => 'Too many blocks created recently. Please wait before trying again.',
    ];
    header('Location: class-create.php');
    exit;
}

// ── User must have a course set ───────────────────────────────
if (empty($_SESSION['course_code'])) {
    $_SESSION['flash_msg'] = [
        'type'    => 'error',
        'message' => 'Your account has no course assigned. Please update your profile first.',
    ];
    header('Location: class-create.php');
    exit;
}

// ── Sanitize & validate ───────────────────────────────────────
$block    = trim($_POST['block']    ?? '');
$year     = trim($_POST['year']     ?? '');
$semester = trim($_POST['semester'] ?? '');

$allowedYears = [
    'first year', 'second year', 'third year', 'fourth year',
];
$allowedSemesters = ['first semester', 'second semester'];

$errors = [];

if ($block === '' || strlen($block) > 10) {
    $errors[] = 'Block is required and must be 10 characters or fewer.';
}

if (!preg_match('/^[A-Za-z0-9]+$/', $block)) {
    $errors[] = 'Block must be alphanumeric only.';
}

if (!in_array(strtolower($year), $allowedYears, true)) {
    $errors[] = 'Invalid year level.';
}

if (!in_array(strtolower($semester), $allowedSemesters, true)) {
    $errors[] = 'Invalid semester.';
}

if ($errors) {
    $_SESSION['flash_msg'] = [
        'type'    => 'error',
        'message' => implode(' ', $errors),
    ];
    header('Location: class-create.php');
    exit;
}

// ── Create block ──────────────────────────────────────────────
try {
    $classModel = new ClassModel($pdo);

    $result = $classModel->createBlock(
        creatorId:  (int) $_SESSION['user_id'],
        courseCode: $_SESSION['course_code'],
        block:      $block,
        year:       strtolower($year),
        semester:   strtolower($semester)
    );

    $_SESSION[$rlKey]['count']++;

    $_SESSION['last_created_class'] = [
        'id'         => $result['id'],
        'class_code' => $result['class_code'],
    ];

    $_SESSION['flash_msg'] = [
        'type'    => 'success',
        'message' => "Block created. Code: {$result['class_code']}",
    ];

    header('Location: class-create.php?step=done');
    exit;

} catch (RuntimeException $e) {
    $_SESSION['flash_msg'] = [
        'type'    => 'error',
        'message' => $e->getMessage(),
    ];
    header('Location: class-create.php');
    exit;

} catch (Throwable $e) {
    error_log('[atomic-bits][classcreate] ' . $e->getMessage());
    $_SESSION['flash_msg'] = [
        'type'    => 'error',
        'message' => 'Something went wrong. Please try again.',
    ];
    header('Location: class-create.php');
    exit;
}