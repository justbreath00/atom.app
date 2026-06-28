<?php
require_once __DIR__ . '/../../app/utils/session.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'errors' => ['Method not allowed.']]);
    exit;
}

// ── Rate limit ────────────────────────────────────────────────────
$rl_key    = 'rl_calendar';
$rl_limit  = 30;
$rl_window = 60;
$now       = time();
$rl        = $_SESSION[$rl_key] ?? ['count' => 0, 'window_start' => $now];

if ($now - $rl['window_start'] > $rl_window) {
    $rl = ['count' => 0, 'window_start' => $now];
}
$rl['count']++;
$_SESSION[$rl_key] = $rl;

if ($rl['count'] > $rl_limit) {
    http_response_code(429);
    header('Retry-After: ' . $rl_window);
    echo json_encode(['success' => false, 'errors' => ['Too many requests.']]);
    exit;
}

// ── Input ─────────────────────────────────────────────────────────
$year  = filter_var($_GET['year']  ?? date('Y'), FILTER_VALIDATE_INT, ['options' => ['min_range' => 2000, 'max_range' => 2100]]);
$month = filter_var($_GET['month'] ?? date('n'), FILTER_VALIDATE_INT, ['options' => ['min_range' => 1,    'max_range' => 12]]);

if ($year  === false) $year  = (int) date('Y');
if ($month === false) $month = (int) date('n');

// ── Idempotency cache ─────────────────────────────────────────────
$cache_key = "cal_{$year}_{$month}";
$cache_ttl = 60;
$cached    = $_SESSION['cache'][$cache_key] ?? null;

if ($cached && ($now - $cached['ts']) < $cache_ttl) {
    header('Content-Type: application/json');
    header('X-Cache: HIT');
    echo json_encode(['success' => true, 'data' => $cached['data']]);
    exit;
}

// ── Build payload (pure date math, no DB) ─────────────────────────
$payload = [
    'year'          => $year,
    'month'         => $month,
    'month_name'    => date('F', mktime(0, 0, 0, $month, 1, $year)),
    'days_in_month' => cal_days_in_month(CAL_GREGORIAN, $month, $year),
    'first_dow'     => (int) date('w', mktime(0, 0, 0, $month, 1, $year)),
    'today'         => (int) date('j'),
    'today_month'   => (int) date('n'),
    'today_year'    => (int) date('Y'),
];

// ── Cache + respond ───────────────────────────────────────────────
$_SESSION['cache'][$cache_key] = ['data' => $payload, 'ts' => $now];

header('Content-Type: application/json');
header('X-Cache: MISS');
echo json_encode(['success' => true, 'data' => $payload]);
exit;