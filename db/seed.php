<?php
/**
 * seed.php — Run this on a fresh WAMP install to set up the database.
 *
 *   C:\wamp64\bin\php\php8.4.15\php.exe db/seed.php
 *
 * Connects as root@127.0.0.1:3306 with no password.
 * Drops and recreates the prayer_corner database from seed.sql.
 */

define('DB_HOST', '127.0.0.1');
define('DB_PORT', 3306);
define('DB_USER', 'root');
define('DB_PASS', '');

$mysql = sprintf(
    '%s -u%s -h%s -P%s',
    'C:/wamp64/bin/mysql/mysql8.4.7/bin/mysql',
    DB_USER,
    DB_HOST,
    DB_PORT
);

$seedFile = __DIR__ . '/seed.sql';

if (!file_exists($seedFile)) {
    fwrite(STDERR, "ERROR: seed.sql not found at {$seedFile}\n");
    exit(1);
}

echo "Running seed.sql on " . DB_HOST . ":" . DB_PORT . " ...\n";

$cmd = sprintf(
    '%s --password="%s" < "%s" 2>&1',
    $mysql,
    DB_PASS,
    $seedFile
);

$output = [];
$returnCode = 0;
exec($cmd, $output, $returnCode);

if ($returnCode !== 0) {
    fwrite(STDERR, "MySQL exited with code {$returnCode}\n");
    foreach ($output as $line) {
        fwrite(STDERR, $line . "\n");
    }
    exit(1);
}

echo "Database seeded successfully.\n";

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=prayer_corner;charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    foreach (['users', 'prayer_requests', 'prayer_requests_prayed', 'testimonies', 'devotionals', 'fellowship_events'] as $table) {
        $count = $pdo->query("SELECT COUNT(*) FROM `{$table}`")->fetchColumn();
        printf("  %-22s %d rows\n", $table, $count);
    }
    echo "\nSeeded users (except user 1) log in with password: Password123!\n";
} catch (PDOException $e) {
    fwrite(STDERR, "WARNING: tables seeded but couldn't verify counts: " . $e->getMessage() . "\n");
}