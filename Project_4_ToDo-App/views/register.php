<?php
session_start();
$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel="stylesheet" href="../public/css/style.css">
  <link rel="stylesheet" href="../public/css/auth.css">
</head>
<body>

<div class="navbar">
  <span><strong>TaskFlow</strong></span>
  <div>
    <a href="../public/index.php">Home</a>
  </div>
</div>


<div class="container">
  <h2>Create Account</h2>

  <?php if ($success): ?>
    <div class="success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <?php if ($error): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form action="../controllers/AuthController.php" method="POST">
    <input type="hidden" name="action" value="register">
    
    <label for="username">Username</label>
    <input type="text" id="username" name="username" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Register</button>
  </form>

  <p>Already have an account? <a href="login.php">Login here</a></p>
  <p>Go back to <a href="../public/index.php">Home</a></p>
</div>

</body>
</html>
