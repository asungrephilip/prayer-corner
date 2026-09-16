<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up - Prayer Corner</title>
  <link rel="stylesheet" href="styles.css?v=2">
</head>
<body>
<?php
$active = 'signup';
require __DIR__ . '/partials/nav.php';
?>
<main class="auth-page">
  <div class="auth-container">
    <div class="auth-header">
      <h1>Create Your Account</h1>
      <p>Join our community of faith and fellowship.</p>
    </div>
    <div id="errorBox" class="alert alert-error" style="display: none;"></div>
    <form class="auth-form" id="signupForm" action="signup_process.php" method="POST">
      <div class="form-group">
        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" required>
      </div>
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
      </div>
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Choose a username" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Create a password" required>
      </div>
      <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
      </div>
      <div class="form-group checkbox-group">
        <input type="checkbox" id="agreeTerms" required>
        <label for="agreeTerms">I agree to the Terms of Service and Community Guidelines</label>
      </div>
      <button type="submit" class="btn btn-primary btn-full">Sign Up</button>
    </form>
    <div class="auth-footer">
      <p>Already have an account? <a href="login.php">Login here</a></p>
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