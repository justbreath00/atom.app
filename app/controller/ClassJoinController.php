<?php

// ─────────────────────────────────────────────────────────────
// joinclasscontroller.php
// Handles POST (JSON) — submits a class join request
// ─────────────────────────────────────────────────────────────

declare(strict_types=1);


require_once '../app/model/ClassModel.php';
require_once '../app/utils/session.php';

header('Content-Type: application/json');

// ── Auth guard ────────────────────────────────────────────────
if (empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthenticated.']);
    exit;
}

// ── Method guard ──────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

// ── CSRF guard ────────────────────────────────────────────────
$headers = getallheaders();
$token   = $headers['X-CSRF-Token'] ?? '';

if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}

// ── Rate limit: 10 join requests per user per hour ────────────
$rlKey    = 'join_request_' . $_SESSION['user_id'];
$rlLimit  = 10;
$rlWindow = 3600;

if (!isset($_SESSION[$rlKey])) {
    $_SESSION[$rlKey] = ['count' => 0, 'window_start' => time()];
}

if ((time() - $_SESSION[$rlKey]['window_start']) > $rlWindow) {
    $_SESSION[$rlKey] = ['count' => 0, 'window_start' => time()];
}

if ($_SESSION[$rlKey]['count'] >= $rlLimit) {
    http_response_code(429);
    echo json_encode(['success' => false, 'message' => 'Too many requests. Please wait before trying again.']);
    exit;
}

// ── Parse body ────────────────────────────────────────────────
$body = json_decode(file_get_contents('php://input'), true);
$code = trim($body['code'] ?? '');

if ($code === '' || !preg_match('/^[A-Z0-9\-]{5,32}$/i', $code)) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Invalid class code format.']);
    exit;
}

// ── Process ───────────────────────────────────────────────────
try {
    $model  = new JoinClassModel($pdo);
    $userId = (int) $_SESSION['user_id'];

    $class = $model->getClassByCode($code);

    if (!$class) {
        echo json_encode(['success' => false, 'message' => 'Class code not found. Please check and try again.']);
        exit;
    }

    $classId = (int) $class['id'];

    // Already a member
    if ($model->isMember($classId, $userId)) {
        echo json_encode(['success' => false, 'message' => 'You are already a member of this class.']);
        exit;
    }

    // Check existing request
    $existing = $model->getRequestStatus($classId, $userId);

    if ($existing === 'pending') {
        echo json_encode(['success' => false, 'message' => 'You already have a pending request for this class.']);
        exit;
    }

    if ($existing === 'rejected') {
        echo json_encode(['success' => false, 'message' => 'Your previous request was rejected. Contact the class admin.']);
        exit;
    }

    $model->submitRequest($classId, $userId);
    $_SESSION[$rlKey]['count']++;

    echo json_encode([
        'success'    => true,
        'class_code' => $class['class_code'],
        'block'      => $class['block'],
        'year'       => $class['year'],
        'semester'   => $class['semester'],
        'requested_at' => date('Y-m-d H:i:s'),
    ]);

} catch (Throwable $e) {
    error_log('[atomic-bits][joinclass] ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Something went wrong. Please try again.']);
}