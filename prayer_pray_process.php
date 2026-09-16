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

if ($request_id < 1) {
    header('Location: prayer_requests.php');
    exit;
}

try {
    $stmt = $pdo->prepare('SELECT id FROM prayer_requests WHERE id = ?');
    $stmt->execute([$request_id]);
    if (!$stmt->fetch()) {
        header('Location: prayer_requests.php');
        exit;
    }

    $stmt = $pdo->prepare('INSERT IGNORE INTO prayer_requests_prayed (prayer_request_id, user_id) VALUES (?, ?)');
    $stmt->execute([$request_id, $user_id]);

    header('Location: prayer_requests.php');
    exit;
} catch (PDOException $e) {
    error_log('[Prayer Corner] Pray error: ' . $e->getMessage());
    header('Location: prayer_requests.php');
    exit;
}