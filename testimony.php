<?php
session_start();
require_once 'config.php';

require_once __DIR__ . '/partials/verses.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = (int)$_SESSION['user_id'];
$request_id = (int)($_GET['pr'] ?? 0);

$request = null;
$testimony = null;

if ($request_id > 0) {
    $stmt = $pdo->prepare(
        'SELECT pr.*, u.full_name, u.username FROM prayer_requests pr
         JOIN users u ON u.id = pr.user_id
         WHERE pr.id = ? AND pr.answered_at IS NOT NULL'
    );
    $stmt->execute([$request_id]);
    $request = $stmt->fetch();

    if ($request) {
        $stmt = $pdo->prepare(
            'SELECT t.*, u.full_name, u.username FROM testimonies t
             JOIN users u ON u.id = t.user_id
             WHERE t.prayer_request_id = ?'
        );
        $stmt->execute([$request_id]);
        $testimony = $stmt->fetch();

        $stmt = $pdo->prepare('SELECT COUNT(*) AS c FROM prayer_requests_prayed WHERE prayer_request_id = ?');
        $stmt->execute([$request_id]);
        $pray_count = (int)$stmt->fetch()['c'];
    }
}

$is_owner    = $request && (int)$request['user_id'] === $user_id;
$error       = $_GET['error'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Testimony - Prayer Corner</title>
  <link rel="stylesheet" href="styles.css?v=2">
</head>
<body>
  <?php
  $active = 'prayer_requests';
  require __DIR__ . '/partials/nav.php';
  ?>

  <main class="subpage">
    <div class="subpage-header">
      <div class="subpage-icon">&#10024;</div>
      <h1>Testimony</h1>
      <p>Celebrate how God answered this prayer.</p>
    </div>

    <div class="verse-banner">
      <?php $v = get_daily_verse('testimony'); ?>&ldquo;<?php echo h($v['text']); ?>&rdquo; &mdash; <?php echo h($v['ref']); ?>
    </div>

    <?php if ($error): ?>
    <div class="alert-error" style="max-width: 600px; margin: 0 auto 1rem;"><?php echo h($error); ?></div>
    <?php endif; ?>

    <?php if ($request): ?>
    <section class="content-list" style="max-width: 600px; margin: 0 auto;">
      <div class="feature-card">
        <div class="request-head">
          <span class="mini-avatar"><?php echo h(substr($request['full_name'], 0, 1)); ?></span>
          <strong><?php echo h($request['full_name']); ?></strong>
          <span class="request-time">Posted <?php echo time_ago($request['created_at']); ?></span>
        </div>
        <p class="request-body">&quot;<?php echo h($request['body']); ?>&quot;</p>
        <div class="card-meta">
          <?php if (isset($pray_count) && $pray_count): ?>&#128591; <?php echo $pray_count; ?> people prayed &middot;<?php endif; ?>
          Marked answered <?php echo time_ago($request['answered_at']); ?>
        </div>
      </div>

      <?php if ($testimony): ?>
      <div class="feature-card testimony-card">
        <div class="request-head">
          <span class="mini-avatar"><?php echo h(substr($testimony['full_name'], 0, 1)); ?></span>
          <strong><?php echo h($testimony['full_name']); ?></strong>
          <span class="request-time">Shared <?php echo time_ago($testimony['created_at']); ?></span>
        </div>
        <p class="request-body"><?php echo h($testimony['body']); ?></p>
      </div>
      <?php endif; ?>

      <?php if ($is_owner && !$testimony): ?>
      <div class="feature-card">
        <h3>Share your testimony</h3>
        <p style="margin-bottom: 0.75rem;">Your prayer has been answered. Encourage the community by sharing what God has done.</p>
        <form class="auth-form" action="testimony_process.php" method="POST">
          <input type="hidden" name="prayer_request_id" value="<?php echo $request_id; ?>">
          <div class="form-group">
            <label for="body">Your Testimony</label>
            <textarea id="body" name="body" rows="5" placeholder="Share how God answered this prayer..." class="prayer-textarea" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary btn-full">Share Testimony</button>
        </form>
      </div>
      <?php endif; ?>

      <div class="dash-actions">
        <a href="prayer_requests.php" class="btn btn-secondary">Back to Prayer Requests</a>
      </div>
    </section>
    <?php else: ?>
    <div class="alert-error" style="max-width: 600px; margin: 0 auto; text-align: center;">
      Prayer request not found or not yet marked as answered.
    </div>
    <div class="dash-actions">
      <a href="prayer_requests.php" class="btn btn-primary">Back to Prayer Requests</a>
    </div>
    <?php endif; ?>
  </main>

  <?php require __DIR__ . '/partials/footer.php'; ?>
</body>
</html>