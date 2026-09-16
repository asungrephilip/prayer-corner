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
    $stmt = $pdo->prepare('UPDATE prayer_requests SET answered_at = NOW() WHERE id = ? AND user_id = ? AND answered_at IS NULL');
    $stmt->execute([$request_id, $user_id]);

    header('Location: testimony.php?pr=' . $request_id);
    exit;
} catch (PDOException $e) {
    error_log('[Prayer Corner] Answer error: ' . $e->getMessage());
    header('Location: prayer_requests.php');
    exit;
}