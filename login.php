<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Prayer Corner</title>
  <link rel="stylesheet" href="styles.css?v=2">
</head>
<body>
<?php
$active = 'login';
require __DIR__ . '/partials/nav.php';
?>
<main class="auth-page">
  <div class="auth-container">
    <div class="auth-header">
      <h1>Welcome Back</h1>
      <p>Login to continue your fellowship.</p>
    </div>
    <div id="errorBox" class="alert alert-error" style="display: none;"></div>
    <form class="auth-form" id="loginForm" action="login_process.php" method="POST">
      <div class="form-group">
        <label for="identifier">Email or Username</label>
        <input type="text" id="identifier" name="identifier" placeholder="Enter your email or username" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
      </div>
      <div class="form-group checkbox-group">
        <input type="checkbox" id="rememberMe">
        <label for="rememberMe">Remember me</label>
      </div>
      <button type="submit" class="btn btn-primary btn-full">Login</button>
    </form>
    <div class="auth-footer">
      <p><a href="#" class="forgot-link">Forgot your password?</a></p>
      <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
    </div>
  </div>
</main>

<?php require __DIR__ . '/partials/footer.php'; ?>
<script>
  const errorBox = document.getElementById('errorBox');
  const params = new URLSearchParams(window.location.search);
  const error = params.get('error');
  if (error) {
    errorBox.textContent = error;
    errorBox.style.display = 'block';
  }
</script>
</body>
</html>