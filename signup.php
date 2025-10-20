<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sign Up — Delish</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="styles.css" />
</head>
<body class="bg-gray-50">
  <main class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow">
      <h2 class="text-2xl font-extrabold mb-4">Create account</h2>
     <form method="POST" action="signupBackend.php">
     <input type="text" name="name" placeholder="Full name" required />
    <input type="email" name="email" placeholder="Email" required />
    <input type="password" name="password" placeholder="Password" required />
  <div class="auth-actions">
    <a href="login.php" class="link">Already have an account?</a>
    <button type="submit" class="btn btn-primary">Sign up</button>
  </div>
</form>

    </div>
  </main>
  <script>
    document.getElementById('signupForm').addEventListener('submit', function(e){ e.preventDefault(); alert('Static signup — no backend.'); });
  </script>
</body>
</html>
