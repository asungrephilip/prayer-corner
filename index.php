<?php
/* Prayer Corner - Homepage
   Shows the dashboard view when logged in, or the public homepage otherwise. */

session_start();

require_once __DIR__ . '/partials/helpers.php';
require_once __DIR__ . '/partials/verses.php';

$logged_in = isset($_SESSION['user_id']);

if ($logged_in) {
    $full_name = htmlspecialchars($_SESSION['full_name'], ENT_QUOTES, 'UTF-8');
    $email     = htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8');
    $username  = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
    $avatar    = strtoupper(substr($_SESSION['full_name'], 0, 1));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prayer Corner</title>
  <link rel="stylesheet" href="styles.css?v=2">
</head>
<body>
  <?php
  $active = 'home';
  require __DIR__ . '/partials/nav.php';
  ?>

  <?php if ($logged_in): ?>
  <main class="dash-main">
    <div class="welcome-card">
      <div class="user-avatar"><?php echo $avatar; ?></div>
      <h1>Welcome back, <?php echo $full_name; ?>!</h1>
      <p class="welcome-sub">You are signed in as <strong>@<?php echo $username; ?></strong> (<?php echo $email; ?>).</p>
      <p class="verse"><?php $v = get_daily_verse('home_member'); ?>&ldquo;<?php echo h($v['text']); ?>&rdquo; &mdash; <?php echo h($v['ref']); ?></p>
    </div>

    <section class="features">
      <a href="prayer_requests.php" class="feature-card dash-card">
        <div class="feature-icon">&#128591;</div>
        <h3>Prayer Requests</h3>
        <p>Share your prayer requests and uplift one another in prayer.</p>
      </a>
      <a href="devotionals.php" class="feature-card dash-card">
        <div class="feature-icon">&#128218;</div>
        <h3>Devotionals</h3>
        <p>Read daily devotionals and scripture to strengthen your walk.</p>
      </a>
      <a href="fellowship.php" class="feature-card dash-card">
        <div class="feature-icon">&#128101;</div>
        <h3>Fellowship</h3>
        <p>Connect with believers and build lasting relationships.</p>
      </a>
      <a href="testimonies.php" class="feature-card dash-card">
        <div class="feature-icon">&#10024;</div>
        <h3>Testimonies</h3>
        <p>Read how God has answered the prayers of the community.</p>
      </a>
      <a href="fellowship.php" class="feature-card dash-card">
        <div class="feature-icon">&#128197;</div>
        <h3>Events</h3>
        <p>Join prayer nights, Bible studies, and fellowship gatherings.</p>
      </a>
    </section>

    <div class="dash-actions">
      <a href="logout.php" class="btn btn-secondary">Logout</a>
    </div>
  </main>
  <?php else: ?>
  <main class="hero">
    <div class="hero-content">
      <h1>Welcome to Prayer Corner</h1>
      <p>A place to fellowship, pray, and grow together in faith.</p>
      <p class="verse"><?php $v = get_daily_verse('home_guest'); ?>&ldquo;<?php echo h($v['text']); ?>&rdquo; &mdash; <?php echo h($v['ref']); ?></p>
      <div class="hero-buttons">
        <a href="signup.php" class="btn btn-primary">Join Our Community</a>
        <a href="login.php" class="btn btn-secondary">Login</a>
      </div>
    </div>

    <section class="features">
      <div class="feature-card">
        <div class="feature-icon">&#128591;</div>
        <h3>Prayer Requests</h3>
        <p>Share your prayer requests and uplift one another in prayer.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">&#128218;</div>
        <h3>Devotionals</h3>
        <p>Read daily devotionals and scripture to strengthen your walk.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">&#128101;</div>
        <h3>Fellowship</h3>
        <p>Connect with believers and build lasting relationships.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">&#10024;</div>
        <h3>Testimonies</h3>
        <p>Read how God has answered the prayers of the community.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon">&#128197;</div>
        <h3>Events</h3>
        <p>Join prayer nights, Bible studies, and fellowship gatherings.</p>
      </div>
    </section>
  </main>
  <?php endif; ?>

  <?php require __DIR__ . '/partials/footer.php'; ?>
</body>
</html>