<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome to TaskFlow</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #e0c3fc, #8ec5fc);
      margin: 0;
      padding: 40px 20px;
    }

    .welcome-box {
      max-width: 600px;
      margin: 100px auto;
      background: white;
      padding: 40px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .welcome-box h1 {
      color: #5a2a82;
      margin-bottom: 10px;
    }

    .welcome-box p {
      margin-bottom: 30px;
      color: #555;
    }

    .welcome-box a.button {
      display: inline-block;
      margin: 5px;
      padding: 10px 20px;
      background-color: #5a2a82;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
    }

    .welcome-box a.button:hover {
      background-color: #4a1f6f;
    }
  </style>
</head>
<body>

<div class="navbar">
  <span><strong>TaskFlow</strong></span>
  <div>
    <a href="index.php">Home</a>
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="../views/dashboard.php">My Tasks</a>
      <a href="../controllers/LogoutController.php">Logout</a>
    <?php endif; ?>
  </div>
</div>

<div class="welcome-box">
  <h1>Welcome to <strong>TaskFlow</strong></h1>
  <p>The easiest way to manage your daily tasks.</p>

  <?php if (isset($_SESSION['user_id'])): ?>
    <a href="../views/dashboard.php" class="button">Go to Dashboard</a>
    <a href="../controllers/LogoutController.php" class="button">Logout</a>
  <?php else: ?>
    <a href="../views/login.php" class="button">Login</a>
    <a href="../views/register.php" class="button">Register</a>
  <?php endif; ?>
</div>

</body>
</html>
