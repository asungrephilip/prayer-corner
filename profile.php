<?php
session_start();
require_once 'config.php';

require_once __DIR__ . '/partials/verses.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = (int)$_SESSION['user_id'];

$stmt = $pdo->prepare('SELECT full_name, username, email, created_at FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$stmt = $pdo->prepare('SELECT COUNT(*) AS c FROM prayer_requests WHERE user_id = ?');
$stmt->execute([$user_id]);
$shared_count = (int)$stmt->fetch()['c'];

$stmt = $pdo->prepare('SELECT COUNT(*) AS c FROM prayer_requests WHERE user_id = ? AND answered_at IS NOT NULL');
$stmt->execute([$user_id]);
$answered_count = (int)$stmt->fetch()['c'];

$stmt = $pdo->prepare('SELECT COUNT(*) AS c FROM testimonies WHERE user_id = ?');
$stmt->execute([$user_id]);
$testimony_count = (int)$stmt->fetch()['c'];

$stmt = $pdo->prepare('SELECT COUNT(*) AS c FROM prayer_requests_prayed WHERE user_id = ?');
$stmt->execute([$user_id]);
$prayed_count = (int)$stmt->fetch()['c'];

$active = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Profile - Prayer Corner</title>
  <link rel="stylesheet" href="styles.css?v=2">
</head>
<body>
<?php require __DIR__ . '/partials/nav.php'; ?>
<main class="subpage">
  <div class="subpage-header">
    <div class="subpage-icon">&#128100;</div>
    <h1>My Profile</h1>
  </div>

  <div class="verse-banner">
    <?php $v = get_daily_verse('profile'); ?>&ldquo;<?php echo h($v['text']); ?>&rdquo; &mdash; <?php echo h($v['ref']); ?>
  </div>

  <div class="profile-card">
    <div class="user-avatar"><?php echo strtoupper(substr($user['full_name'], 0, 1)); ?></div>
    <h2><?php echo htmlspecialchars($user['full_name']); ?></h2>
    <p class="welcome-sub">@<?php echo htmlspecialchars($user['username']); ?> &middot; <?php echo htmlspecialchars($user['email']); ?></p>
    <p class="card-meta">Member since <?php echo date('F j, Y', strtotime($user['created_at'])); ?></p>
  </div>

  <section class="profile-stats">
    <div class="feature-card profile-stat">
      <div class="feature-icon">&#128591;</div>
      <h3><?php echo $shared_count; ?></h3>
      <p>Prayer Requests Shared</p>
    </div>
    <div class="feature-card profile-stat">
      <div class="feature-icon">&#10004;</div>
      <h3><?php echo $answered_count; ?></h3>
      <p>Prayers Answered</p>
    </div>
    <div class="feature-card profile-stat">
      <div class="feature-icon">&#10024;</div>
      <h3><?php echo $testimony_count; ?></h3>
      <p>Testimonies Shared</p>
    </div>
    <div class="feature-card profile-stat">
      <div class="feature-icon">&#128521;</div>
      <h3><?php echo $prayed_count; ?></h3>
      <p>Prayers Lifted for Others</p>
    </div>
    <div class="feature-card profile-stat">
      <div class="feature-icon">&#128101;</div>
      <h3>Member</h3>
      <p>Community of Faith</p>
    </div>
  </section>

  <div class="dash-actions">
    <a href="index.php" class="btn btn-secondary">Back to Home</a>
  </div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>