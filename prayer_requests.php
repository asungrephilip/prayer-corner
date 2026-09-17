<?php
session_start();
require_once 'config.php';

require_once __DIR__ . '/partials/verses.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = (int)$_SESSION['user_id'];
$tab     = ($_GET['tab'] ?? 'all') === 'my' ? 'my' : 'all';

$requests = [];

if ($tab === 'all') {
    $stmt = $pdo->query(
        "SELECT pr.*, u.full_name, u.username,
                (SELECT COUNT(*) FROM prayer_requests_prayed p WHERE p.prayer_request_id = pr.id) AS pray_count,
                (SELECT COUNT(*) FROM prayer_requests_prayed p WHERE p.prayer_request_id = pr.id AND p.user_id = $user_id) AS i_prayed
         FROM prayer_requests pr
         JOIN users u ON u.id = pr.user_id
         WHERE pr.answered_at IS NULL OR pr.answered_at > DATE_SUB(NOW(), INTERVAL 1 DAY)
         ORDER BY pr.created_at ASC"
    );
    $requests = $stmt->fetchAll();
} else {
    $stmt = $pdo->prepare(
        "SELECT pr.*, u.full_name, u.username,
                (SELECT COUNT(*) FROM prayer_requests_prayed p WHERE p.prayer_request_id = pr.id) AS pray_count
         FROM prayer_requests pr
         JOIN users u ON u.id = pr.user_id
         WHERE pr.user_id = ?
         ORDER BY pr.created_at ASC"
    );
    $stmt->execute([$user_id]);
    $requests = $stmt->fetchAll();
}

$answered_ids = [];
foreach ($requests as $r) {
    if ($r['answered_at'] !== null) {
        $answered_ids[] = (int)$r['id'];
    }
}

$testimonies = [];
if ($answered_ids) {
    $in = implode(',', array_fill(0, count($answered_ids), '?'));
    $stmt = $pdo->prepare("SELECT prayer_request_id, body, user_id FROM testimonies WHERE prayer_request_id IN ($in)");
    $stmt->execute($answered_ids);
    foreach ($stmt->fetchAll() as $t) {
        $testimonies[(int)$t['prayer_request_id']] = $t;
    }
}

$error      = $_GET['error'] ?? null;
$created    = isset($_GET['created']);
$shared     = isset($_GET['testimony']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prayer Requests - Prayer Corner</title>
  <link rel="stylesheet" href="styles.css?v=2">
</head>
<body>
  <?php
  $active = 'prayer_requests';
  require __DIR__ . '/partials/nav.php';
  ?>

  <main class="subpage pr-page">
    <div class="subpage-header">
      <div class="subpage-icon">&#128591;</div>
      <h1>Prayer Requests</h1>
      <p>Share your needs and uplift one another through the power of prayer.</p>
    </div>

    <div class="verse-banner">
      <?php $v = get_daily_verse('prayer_requests'); ?>&ldquo;<?php echo h($v['text']); ?>&rdquo; &mdash; <?php echo h($v['ref']); ?>
    </div>

    <?php if ($created): ?>
    <div class="notify notify-success">Your prayer request has been shared with the community.</div>
    <?php elseif ($shared): ?>
    <div class="notify notify-success">Thank you for sharing your testimony!</div>
    <?php elseif ($error): ?>
    <div class="notify notify-error"><?php echo h($error); ?></div>
    <?php endif; ?>

    <section class="share-card" id="shareCard">
      <h3>Share a Prayer Request</h3>
      <form class="auth-form" action="prayer_request_process.php" method="POST">
        <div class="form-group">
          <textarea id="body" name="body" rows="4" placeholder="What would you like the community to pray about?" class="prayer-textarea" maxlength="2000" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-full">Share Request</button>
      </form>
    </section>
    
    <button onclick="toggleShareCard()" type="button" class="btn-primary share-btn" id="shareBtn">&#10010;</button>

    <script>
      const shareCard = document.getElementById('shareCard');
      const shareBtn  = document.getElementById('shareBtn');

      function toggleShareCard() {
        const open = shareCard.style.display === 'block';
        shareCard.style.display = open ? 'none' : 'block';
        shareBtn.textContent = open ? '\u271A' : '\u2715';
      }

      document.addEventListener('click', function(e) {
        if (!shareCard.contains(e.target) && e.target !== shareBtn) {
          shareCard.style.display = 'none';
          shareBtn.textContent = '\u271A';
        }
      });
    </script>
  

    <div class="tabs">
      <a href="prayer_requests.php?tab=all" class="tab-link <?php echo $tab === 'all' ? 'active' : ''; ?>">All Requests</a>
      <a href="prayer_requests.php?tab=my" class="tab-link <?php echo $tab === 'my' ? 'active' : ''; ?>">My Requests</a>
    </div>

    <?php if (empty($requests)): ?>
    <div class="feature-card" style="text-align: center;">
      <p>No prayer requests here yet.</p>
    </div>
    <?php else: ?>
    <section class="features">
      <?php foreach ($requests as $r): ?>
      <?php $is_own = (int)$r['user_id'] === $user_id; ?>
      <div class="feature-card request-card <?php echo $r['answered_at'] !== null ? 'request-answered' : ''; ?>">
        <div class="request-head">
          <span class="mini-avatar"><?php echo h(substr($r['full_name'], 0, 1)); ?></span>
          <strong><?php echo h($r['full_name']); ?></strong>
          <span class="request-time"><?php echo time_ago($r['created_at']); ?></span>
        </div>

        <p class="request-body">&quot;<?php echo h($r['body']); ?>&quot;</p>

        <div class="request-foot">
          <span class="pray-count">
            &#128591; <?php echo (int)$r['pray_count']; ?> <?php echo (int)$r['pray_count'] === 1 ? 'person' : 'people'; ?> prayed
          </span>

          <?php if ($r['answered_at'] !== null): ?>
          <a href="testimony.php?pr=<?php echo (int)$r['id']; ?>" class="btn btn-small btn-answered">
            &#10004; Answered<?php echo isset($testimonies[(int)$r['id']]) ? ' - Read Testimony' : ''; ?>
          </a>
          <?php elseif ($is_own): ?>
          <span class="own-tag">Your request</span>
          <form action="prayer_answer_process.php" method="POST" style="display: inline-block;">
            <input type="hidden" name="prayer_request_id" value="<?php echo (int)$r['id']; ?>">
            <button type="submit" class="btn btn-small btn-answer">Prayer Answered</button>
          </form>
          <?php else: ?>
          <form action="prayer_pray_process.php" method="POST" style="display: inline-block;">
            <input type="hidden" name="prayer_request_id" value="<?php echo (int)$r['id']; ?>">
            <button type="submit" class="btn btn-small <?php echo (int)$r['i_prayed'] ? 'btn-prayed' : 'btn-pray'; ?>">
              <?php echo (int)$r['i_prayed'] ? '&#10004; I Prayed' : 'I Prayed'; ?>
            </button>
          </form>
          <?php endif; ?>
        </div>

        <?php if ($r['answered_at'] !== null): ?>
        <div class="answered-note">
          Marked as answered <?php echo time_ago($r['answered_at']); ?>.
        </div>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </section>
    <?php endif; ?>
  </main>

  <?php require __DIR__ . '/partials/footer.php'; ?>
</body>
</html>