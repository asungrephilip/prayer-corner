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

$body = trim($_POST['body'] ?? '');

if ($body === '') {
    header('Location: prayer_requests.php?tab=share&error=' . urlencode('Prayer request cannot be empty.'));
    exit;
}

if (mb_strlen($body) > 2000) {
    header('Location: prayer_requests.php?tab=share&error=' . urlencode('Prayer request is too long (max 2000 characters).'));
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO prayer_requests (user_id, body) VALUES (?, ?)');
    $stmt->execute([(int)$_SESSION['user_id'], $body]);
    header('Location: prayer_requests.php?tab=my&created=1');
    exit;
} catch (PDOException $e) {
    error_log('[Prayer Corner] Prayer request error: ' . $e->getMessage());
    header('Location: prayer_requests.php?tab=share&error=' . urlencode('Something went wrong. Please try again.'));
    exit;
}