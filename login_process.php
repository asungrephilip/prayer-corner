<?php
/* Prayer Corner - Login handler */

session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$identifier = trim($_POST['identifier'] ?? '');
$password   = $_POST['password'] ?? '';

if ($identifier === '' || $password === '') {
    header('Location: login.php?error=' . urlencode('Please fill in all fields.'));
    exit;
}

try {
    $stmt = $pdo->prepare('SELECT id, full_name, username, email, password_hash FROM users WHERE email = ? OR username = ? LIMIT 1');
    $stmt->execute([$identifier, $identifier]);
    $user = $stmt->fetch();
} catch (PDOException $e) {
    error_log('[Prayer Corner] Login error: ' . $e->getMessage());
    header('Location: login.php?error=' . urlencode('Something went wrong on our end. Please try again.'));
    exit;
}

if ($user !== false && password_verify($password, $user['password_hash'])) {
    session_regenerate_id(true);
    $_SESSION['user_id']   = (int)$user['id'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['username']  = $user['username'];
    $_SESSION['email']     = $user['email'];

    header('Location: index.php');
    exit;
}

header('Location: login.php?error=' . urlencode('Invalid email/username or password.'));
exit;