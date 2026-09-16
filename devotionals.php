<?php
/* Prayer Corner - Devotionals page (protected) */

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/partials/verses.php';

$devotionals = [
    [
        'title'   => 'Strength in Silence',
        'scripture' => 'Psalm 46:10',
        'text'    => 'In a world that never stops talking, this devotional invites you to find peace in stillness and to listen for the still, small voice of God.',
        'mins'    => 5,
    ],
    [
        'title'   => 'The Courage to Ask',
        'scripture' => 'Matthew 7:7',
        'text'    => 'We often carry burdens alone when God invites us simply to ask. Learn how humble, persistent prayer changes the posture of the heart.',
        'mins'    => 7,
    ],
    [
        'title'   => 'Walking in Forgiveness',
        'scripture' => 'Colossians 3:13',
        'text'    => 'Forgiveness frees the forgiver as much as the forgiven. Reflect on releasing old hurts and extending the grace you have received.',
        'mins'    => 6,
    ],
    [
        'title'   => 'Gratitude That Transforms',
        'scripture' => '1 Thessalonians 5:18',
        'text'    => 'Giving thanks in every circumstance reshapes how we see our day. Discover the practice of counting blessings as a path to joy.',
        'mins'    => 4,
    ],
    [
        'title'   => 'Trusting God\'s Timing',
        'scripture' => 'Ecclesiastes 3:1',
        'text'    => 'Waiting on the Lord can feel endless. This devotional explores how seasons of waiting shape faith and mature our trust in His perfect timing.',
        'mins'    => 6,
    ],
];
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
        <p style="line-height: 1.6;"><?php echo htmlspecialchars($d['text']); ?></p>
        <div>
          <span class="tag"><?php echo htmlspecialchars($d['scripture']); ?></span>
          <span class="tag"><?php echo $d['mins']; ?> min read</span>
        </div>
      </div>
      <?php endforeach; ?>
    </section>
  </main>

  <?php require __DIR__ . '/partials/footer.php'; ?>
</body>
</html>