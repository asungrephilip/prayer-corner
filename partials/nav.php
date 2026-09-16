<?php
/* Shared navbar partial.
   Include with:  $active = 'prayer_requests'; require __DIR__ . '/nav.php';
   $active values: home | prayer_requests | devotionals | fellowship | testimonies */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$active      = $active ?? '';
$logged_in   = isset($_SESSION['user_id']);
$user_initial = $logged_in ? strtoupper(substr($_SESSION['full_name'], 0, 1)) : '';
$user_name   = $logged_in ? htmlspecialchars($_SESSION['full_name'], ENT_QUOTES, 'UTF-8') : '';

function nav_link(string $href, string $label, string $key, string $active): string {
    $cls = ($active === $key) ? ' class="active"' : '';
    return '<a href="' . $href . '"' . $cls . '>' . $label . '</a>';
}
?>
<nav class="navbar">
  <a href="index.php" class="nav-brand"><span class="nav-logo">&#128591;</span> Prayer Corner</a>
  <button type="button" class="nav-toggle" id="navToggle" aria-label="Toggle navigation">&#9776;</button>
  <div class="nav-links" id="navLinks">
    <?php echo nav_link('index.php', 'Home', 'home', $active); ?>
    <?php echo nav_link('prayer_requests.php', 'Prayer Requests', 'prayer_requests', $active); ?>
    <?php echo nav_link('devotionals.php', 'Devotionals', 'devotionals', $active); ?>
    <?php echo nav_link('fellowship.php', 'Fellowship', 'fellowship', $active); ?>
    <?php echo nav_link('testimonies.php', 'Testimonies', 'testimonies', $active); ?>

    <?php if ($logged_in): ?>
    <div class="nav-profile">
      <button type="button" class="profile-btn" id="profileBtn" aria-label="Account menu">
        <span class="profile-avatar"><?php echo $user_initial; ?></span>
        <span class="profile-arrow">&#9662;</span>
      </button>
      <div class="profile-menu" id="profileMenu">
        <div class="profile-menu-header"><?php echo $user_name; ?></div>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
      </div>
    </div>
    <?php else: ?>
    <?php echo nav_link('login.php', 'Login', 'login', $active); ?>
    <?php echo nav_link('signup.php', 'Sign Up', 'signup', $active); ?>
    <?php endif; ?>
  </div>
</nav>