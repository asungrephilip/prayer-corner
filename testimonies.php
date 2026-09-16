<?php
session_start();
require_once 'config.php';

require_once __DIR__ . '/partials/verses.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->query(
    'SELECT t.id, t.body AS testimony_body, t.created_at AS testimony_time,
            u.full_name, u.username, pr.body AS request_body
     FROM testimonies t
     JOIN users u ON u.id = t.user_id
     JOIN prayer_requests pr ON pr.id = t.prayer_request_id
     ORDER BY t.created_at DESC'
);
$testimonies = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Testimonies - Prayer Corner</title>
  <link rel="stylesheet" href="styles.css?v=2">
</head>
<body>
  <?php
  $active = 'testimonies';
  require __DIR__ . '/partials/nav.php';
  ?>

  <main class="subpage">
    <div class="subpage-header">
      <div class="subpage-icon">&#10024;</div>
      <h1>Testimonies</h1>
      <p>Stories of answered prayer from the community. Give God the glory for what He has done.</p>
    </div>

    <div class="verse-banner">
      <?php $v = get_daily_verse('testimonies'); ?>&ldquo;<?php echo h($v['text']); ?>&rdquo; &mdash; <?php echo h($v['ref']); ?>
    </div>

    <?php if (empty($testimonies)): ?>
    <div class="feature-card" style="text-align: center;">
      <p>No testimonies yet. Mark a prayer as answered to share the first one.</p>
    </div>
    <?php else: ?>
    <section class="features">
      <?php foreach ($testimonies as $t): ?>
      <div class="feature-card testimony-card">
        <p class="request-body">&quot;<?php echo h($t['testimony_body']); ?>&quot;</p>
        <div class="request-head" style="margin-top: 1rem;">
          <span class="mini-avatar"><?php echo h(substr($t['full_name'], 0, 1)); ?></span>
          <strong><?php echo h($t['full_name']); ?></strong>
        </div>
        <div class="card-meta">Shared <?php echo time_ago($t['testimony_time']); ?></div>
        <div class="tag">&#128591; <?php echo h(mb_substr($t['request_body'], 0, 60)); ?>&#8230;</div>
      </div>
      <?php endforeach; ?>
    </section>
    <?php endif; ?>
  </main>

  <?php require __DIR__ . '/partials/footer.php'; ?>
</body>
</html>