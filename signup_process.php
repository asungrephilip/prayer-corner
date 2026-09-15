<?php
/* Prayer Corner - Signup handler */

session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: signup.html');
    exit;
}

$full_name     = trim($_POST['full_name'] ?? '');
$email         = strtolower(trim($_POST['email'] ?? ''));
$username      = trim($_POST['username'] ?? '');
$password      = $_POST['password'] ?? '';
$conf_password = $_POST['confirm_password'] ?? '';

$error = null;

if ($full_name === '' || !preg_match('/^[\p{L} .\'-]{2,100}$/u', $full_name)) {
    $error = 'Please enter a valid full name (letters and spaces only).';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = 'Please enter a valid email address.';
} elseif (!preg_match('/^[a-zA-Z0-9._]{3,30}$/', $username)) {
    $error = 'Username must be 3-30 characters using letters, numbers, dots or underscores.';
} elseif (strlen($password) < 8) {
    $error = 'Password must be at least 8 characters long.';
} elseif ($password !== $conf_password) {
    $error = 'Passwords do not match.';
}

if ($error !== null) {
    header('Location: signup.html?error=' . urlencode($error));
    exit;
}

try {
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? OR username = ?');
    $stmt->execute([$email, $username]);
    if ($stmt->fetch()) {
        header('Location: signup.html?error=' . urlencode('An account with that email or username already exists.'));
        exit;
    }

    $stmt = $pdo->prepare('INSERT INTO users (full_name, email, username, password_hash) VALUES (?, ?, ?, ?)');
    $stmt->execute([$full_name, $email, $username, password_hash($password, PASSWORD_DEFAULT)]);

    session_regenerate_id(true);
    $_SESSION['user_id']   = (int)$pdo->lastInsertId();
    $_SESSION['full_name'] = $full_name;
    $_SESSION['username']  = $username;
    $_SESSION['email']     = $email;

    header('Location: login.html');
    exit;
} catch (PDOException $e) {
    error_log('[Prayer Corner] Signup error: ' . $e->getMessage());
    header('Location: signup.html?error=' . urlencode('Something went wrong on our end. Please try again.'));
    exit;
}