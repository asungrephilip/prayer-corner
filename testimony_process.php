<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: prayer_requests.php');
    exit;
}

$request_id = (int)($_POST['prayer_request_id'] ?? 0);
$user_id    = (int)$_SESSION['user_id'];
$body       = trim($_POST['body'] ?? '');

if ($request_id < 1 || $body === '') {
    header('Location: testimony.php?pr=' . $request_id . '&error=' . urlencode('Please share your testimony.'));
    exit;
}

try {
    $stmt = $pdo->prepare('SELECT id FROM prayer_requests WHERE id = ? AND user_id = ?');
    $stmt->execute([$request_id, $user_id]);
    if (!$stmt->fetch()) {
        header('Location: prayer_requests.php');
        exit;
    }

    $stmt = $pdo->prepare('INSERT INTO testimonies (prayer_request_id, user_id, body) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE body = VALUES(body)');
    $stmt->execute([$request_id, $user_id, $body]);

    header('Location: prayer_requests.php?tab=my&testimony=1');
    exit;
} catch (PDOException $e) {
    error_log('[Prayer Corner] Testimony error: ' . $e->getMessage());
    header('Location: testimony.php?pr=' . $request_id . '&error=' . urlencode('Something went wrong. Please try again.'));
    exit;
}