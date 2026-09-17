<?php
/* Prayer Corner - Devotionals page (protected) */

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/partials/verses.php';

$devotionals = db()->query('SELECT * FROM devotionals ORDER BY id')->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Devotionals - Prayer Corner</title>
  <link rel="stylesheet" href="styles.css?v=2">
</head>
<body>
  <?php
  $active = 'devotionals';
  require __DIR__ . '/partials/nav.php';
  ?>

  <main class="subpage">
    <div class="subpage-header">
      <div class="subpage-icon">&#128218;</div>
      <h1>Devotionals</h1>
      <p>Daily scripture and reflection to strengthen your walk with Christ.</p>
    </div>

    <div class="verse-banner">
      <?php $v = get_daily_verse('devotionals'); ?>&ldquo;<?php echo h($v['text']); ?>&rdquo; &mdash; <?php echo h($v['ref']); ?>
    </div>

    <section class="features">
      <?php foreach ($devotionals as $d): ?>
      <div class="feature-card">
        <h3><?php echo htmlspecialchars($d['title']); ?></h3>
        <p style="line-height: 1.6;"><?php echo htmlspecialchars($d['body']); ?></p>
        <div>
          <span class="tag"><?php echo htmlspecialchars($d['scripture']); ?></span>
          <span class="tag"><?php echo (int)$d['mins']; ?> min read</span>
        </div>
      </div>
      <?php endforeach; ?>
    </section>
  </main>

  <?php require __DIR__ . '/partials/footer.php'; ?>
</body>
</html>