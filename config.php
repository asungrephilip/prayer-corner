<?php
/* Prayer Corner - Database configuration */

define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'prayer_corner');
define('DB_USER', 'root');
define('DB_PASS', '');

function db(): PDO {
    static $pdo = null;

    if ($pdo === null) {
        try {
            $pdo = new PDO(
                'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';charset=utf8mb4',
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );

            $pdo->exec('CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
            $pdo->exec('USE `' . DB_NAME . '`');

            $pdo->exec(
                'CREATE TABLE IF NOT EXISTS users (
                    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    full_name VARCHAR(100) NOT NULL,
                    email VARCHAR(190) NOT NULL UNIQUE,
                    username VARCHAR(30) NOT NULL UNIQUE,
                    password_hash VARCHAR(255) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB'
            );

            $pdo->exec(
                'CREATE TABLE IF NOT EXISTS prayer_requests (
                    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    user_id INT UNSIGNED NOT NULL,
                    body TEXT NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    answered_at TIMESTAMP NULL DEFAULT NULL,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                ) ENGINE=InnoDB'
            );

            $pdo->exec(
                'CREATE TABLE IF NOT EXISTS prayer_requests_prayed (
                    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    prayer_request_id INT UNSIGNED NOT NULL,
                    user_id INT UNSIGNED NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    UNIQUE KEY (prayer_request_id, user_id),
                    FOREIGN KEY (prayer_request_id) REFERENCES prayer_requests(id) ON DELETE CASCADE,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                ) ENGINE=InnoDB'
            );

            $pdo->exec(
                'CREATE TABLE IF NOT EXISTS testimonies (
                    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    prayer_request_id INT UNSIGNED NOT NULL,
                    user_id INT UNSIGNED NOT NULL,
                    body TEXT NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    UNIQUE KEY (prayer_request_id, user_id),
                    FOREIGN KEY (prayer_request_id) REFERENCES prayer_requests(id) ON DELETE CASCADE,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                ) ENGINE=InnoDB'
            );

            $pdo->exec(
                'CREATE TABLE IF NOT EXISTS devotionals (
                    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    title VARCHAR(200) NOT NULL,
                    scripture VARCHAR(100) NOT NULL,
                    body TEXT NOT NULL,
                    mins INT UNSIGNED NOT NULL DEFAULT 5,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB'
            );

            $pdo->exec(
                'CREATE TABLE IF NOT EXISTS fellowship_events (
                    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    title VARCHAR(200) NOT NULL,
                    schedule VARCHAR(200) NOT NULL,
                    location VARCHAR(200) NOT NULL,
                    body TEXT NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB'
            );
        } catch (PDOException $e) {
            http_response_code(500);
            error_log('[Prayer Corner] DB error: ' . $e->getMessage());
            die('Database connection failed. Check that WAMP MySQL is running and try again.');
        }
    }

    return $pdo;
}

$pdo = db();

require_once __DIR__ . '/partials/helpers.php';