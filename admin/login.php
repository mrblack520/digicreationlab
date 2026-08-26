<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/helpers.php';

adminSessionStart();

if (adminIsLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (adminLogin($username, $password)) {
        header('Location: index.php');
        exit;
    }
    $error = 'Invalid username or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | Master Control</title>
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <link rel="stylesheet" href="../assets/css/admin.css?v=<?php echo @filemtime(__DIR__ . '/../assets/css/admin.css') ?: time(); ?>">
</head>
<body class="admin-login-page">
  <div class="login-card">
    <h1>Master Control</h1>
    <p class="login-sub">Sign in to manage Digi Creation content & leads</p>
    <?php if ($error): ?><div class="alert alert-error"><?php echo e($error); ?></div><?php endif; ?>
    <form method="post" class="admin-form">
      <label>Username<input type="text" name="username" required autofocus></label>
      <label>Password<input type="password" name="password" required></label>
      <button type="submit" class="btn-save">Sign in</button>
    </form>
    <p class="login-hint">Default: <code>admin</code> / <code>admin123</code></p>
    <a href="../index.php" class="back-link">← Back to site</a>
  </div>
</body>
</html>
