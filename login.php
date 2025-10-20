<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login — Delish</title>
  <link rel="stylesheet" href="styles.css" />
</head>
<body class="page-body">
  <main class="auth-page">
    <div class="auth-card">
      <h2>Welcome back</h2>
      <form method="POST" action="loginBackend.php">
  <input type="email" name="email" placeholder="Email" required />
  <input type="password" name="password" placeholder="Password" required />
  <div class="auth-actions">
    <a href="signup.php" class="link">Create account</a>
    <button type="submit" class="btn btn-primary">Login</button>
  </div>
</form>

    </div>
  </main>
</body>
</html>
