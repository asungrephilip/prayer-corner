<?php
/* Prayer Corner - Fellowship page (protected) */

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$full_name = htmlspecialchars($_SESSION['full_name'], ENT_QUOTES, 'UTF-8');

require_once __DIR__ . '/partials/verses.php';

$events = [
    [
        'title'   => 'Wednesday Prayer Night',
        'when'    => 'Every Wednesday &middot; 7:00 PM',
        'where'   => 'Community Hall, Room 2',
        'text'    => 'Come together for an evening of worship, intercession, and encouragement.',
    ],
    [
        'title'   => 'Friday Bible Study',
        'when'    => 'Fridays &middot; 6:30 PM',
        'where'   => 'Main Sanctuary',
        'text'    => 'Verse-by-verse study of the Gospel of John. All are welcome, bring a friend.',
    ],
    [
        'title'   => 'Community Outreach',
        'when'    => 'Saturday, October 3 &middot; 9:00 AM',
        'where'   => 'Church Parking Lot',
        'text'    => 'Join us as we serve our neighborhood with meals, fellowship, and prayer.',
    ],
    [
        'title'   => 'Women\'s Breakfast',
        'when'    => 'Second Saturday &middot; 8:30 AM',
        'where'   => 'Fellowship Hall',
        'text'    => 'A morning of good food, testimonies, and encouragement for the women of our community.',
    ],
    [
        'title'   => 'Youth Praise Night',
        'when'    => 'Friday, October 17 &middot; 6:00 PM',
        'where'   => 'Main Sanctuary',
        'text'    => 'Worship, games, and the Word for young people. Bring a friend and a joyful heart.',
    ],
];
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
        <h3><?php echo $e['title']; ?></h3>
        <p style="line-height: 1.6;"><?php echo $e['text']; ?></p>
        <div class="card-meta"><?php echo $e['when']; ?><br><?php echo $e['where']; ?></div>
      </div>
      <?php endforeach; ?>
    </section>
  </main>

  <?php require __DIR__ . '/partials/footer.php'; ?>
</body>
</html>