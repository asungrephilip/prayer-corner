<?php
/* Prayer Corner - Logged-in landing page (protected) */

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

$full_name = htmlspecialchars($_SESSION['full_name'], ENT_QUOTES, 'UTF-8');
$email     = htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8');
$username  = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
$avatar    = strtoupper(substr($_SESSION['full_name'], 0, 1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - Prayer Corner</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <nav class="navbar">
    <div class="nav-brand">Prayer Corner</div>
    <div class="nav-links">
      <a href="index.html">Home</a>
      <a href="dashboard.php" class="active">Dashboard</a>
      <a href="logout.php">Logout</a>
    </div>
  </nav>

  <main class="dash-main">
    <div class="welcome-card">
      <div class="user-avatar"><?php echo $avatar; ?></div>
      <h1>Welcome back, <?php echo $full_name; ?>!</h1>
      <p class="welcome-sub">You are signed in as <strong>@<?php echo $username; ?></strong> (<?php echo $email; ?>).</p>
      <p class="verse">"The Lord is my strength and my shield; my heart trusts in him, and he helps me." &mdash; Psalm 28:7</p>
    </div>

    <section class="features">
      <a href="#" class="feature-card dash-card">
        <div class="feature-icon">&#128591;</div>
        <h3>Prayer Requests</h3>
        <p>Share your prayer requests and uplift one another in prayer.</p>
      </a>
      <a href="#" class="feature-card dash-card">
        <div class="feature-icon">&#128218;</div>
        <h3>Devotionals</h3>
        <p>Read daily devotionals and scripture to strengthen your walk.</p>
      </a>
      <a href="#" class="feature-card dash-card">
        <div class="feature-icon">&#128101;</div>
        <h3>Fellowship</h3>
        <p>Connect with believers and build lasting relationships.</p>
      </a>
    </section>

    <div class="dash-actions">
      <a href="logout.php" class="btn btn-secondary">Logout</a>
    </div>
  </main>

  <footer class="footer">
    <p>&copy; 2026 Prayer Corner. Built with love and faith.</p>
  </footer>
</body>
</html>