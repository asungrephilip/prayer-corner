<?php
/* Prayer Corner - Fellowship page (protected) */

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$full_name = htmlspecialchars($_SESSION['full_name'], ENT_QUOTES, 'UTF-8');

require_once __DIR__ . '/partials/verses.php';
require_once __DIR__ . '/config.php';

$events = db()->query('SELECT * FROM fellowship_events ORDER BY id')->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fellowship - Prayer Corner</title>
  <link rel="stylesheet" href="styles.css?v=2">
</head>
<body>
  <?php
  $active = 'fellowship';
  require __DIR__ . '/partials/nav.php';
  ?>

  <main class="subpage">
    <div class="subpage-header">
      <div class="subpage-icon">&#128101;</div>
      <h1>Fellowship</h1>
      <p>Connect with believers, <?php echo $full_name; ?>, and build lasting relationships in community.</p>
    </div>

    <div class="verse-banner">
      <?php $v = get_daily_verse('fellowship'); ?>&ldquo;<?php echo h($v['text']); ?>&rdquo; &mdash; <?php echo h($v['ref']); ?>
    </div>

    <section class="features">
      <?php foreach ($events as $e): ?>
      <div class="feature-card">
        <h3><?php echo htmlspecialchars($e['title']); ?></h3>
        <p style="line-height: 1.6;"><?php echo htmlspecialchars($e['body']); ?></p>
        <div class="card-meta"><?php echo htmlspecialchars($e['schedule']); ?><br><?php echo htmlspecialchars($e['location']); ?></div>
      </div>
      <?php endforeach; ?>
    </section>
  </main>

  <?php require __DIR__ . '/partials/footer.php'; ?>
</body>
</html>