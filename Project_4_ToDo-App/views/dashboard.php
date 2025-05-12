<?php
session_start();
require_once __DIR__ . '/../includes/db_config.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$userId = $_SESSION['user_id'];
$editId = $_GET['edit'] ?? null;

// Taskuri active
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ? AND status != 'completed' ORDER BY id DESC");
$stmt->execute([$userId]);
$tasks = $stmt->fetchAll();

// Taskuri completate
$done = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ? AND status = 'completed' ORDER BY id DESC");
$done->execute([$userId]);
$completedTasks = $done->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link rel="stylesheet" href="../public/css/style.css">
  <style>
    .task-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .task-title {
      flex-grow: 1;
    }

    .task-actions form {
      display: inline-block;
      margin-left: 10px;
    }

    .task-actions button {
      padding: 5px 10px;
      font-size: 0.85rem;
      background-color: #5a2a82;
      border: none;
      color: white;
      border-radius: 4px;
      cursor: pointer;
    }

    .task-actions button:hover {
      background-color: #4a1f6f;
    }

    .edit-form {
      display: flex;
      gap: 10px;
      margin-top: 10px;
    }

    .edit-form input[type="text"] {
      flex-grow: 1;
      padding: 6px;
    }

    .completed {
      text-decoration: line-through;
      color: #888;
    }

    .completed-section {
      margin-top: 40px;
    }

    .completed-section h3 {
      color: #5a2a82;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

<div class="navbar">
  <span><strong>TaskFlow</strong></span>
  <div>
    <a href="../public/index.php">Home</a>
    <a href="../controllers/LogoutController.php">Logout</a>
  </div>
</div>

<div class="container">
  <h2>My Tasks</h2>

  <!-- Form adăugare taskuri -->
  <form action="../controllers/TaskController.php" method="POST">
    <input type="hidden" name="action" value="add_task">
    <input type="text" name="title" placeholder="Enter a new task" required>
    <button type="submit">Add Task</button>
  </form>

  <!-- Lista taskuri active -->
  <div class="task-list">
    <?php foreach ($tasks as $task): ?>
      <div class="task-item">
        <div class="task-title">
          <?php if ($editId == $task['id']): ?>
            <form class="edit-form" action="../controllers/TaskController.php" method="POST">
              <input type="hidden" name="action" value="update_task">
              <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
              <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required>
              <button type="submit">Save</button>
              <a href="dashboard.php" style="color:#5a2a82;">Cancel</a>
            </form>
          <?php else: ?>
            <?= htmlspecialchars($task['title']) ?>
          <?php endif; ?>
        </div>

        <?php if ($editId != $task['id']): ?>
        <div class="task-actions">
          <form action="../controllers/TaskController.php" method="POST">
            <input type="hidden" name="action" value="complete_task">
            <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
            <button type="submit">Complete</button>
          </form>

          <form action="../controllers/TaskController.php" method="POST">
            <input type="hidden" name="action" value="delete_task">
            <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
            <button type="submit">Delete</button>
          </form>

          <form action="dashboard.php" method="GET">
            <input type="hidden" name="edit" value="<?= $task['id'] ?>">
            <button type="submit">Modify</button>
          </form>
        </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Secțiune cu taskuri completate -->
  <?php if (count($completedTasks) > 0): ?>
    <div class="completed-section">
      <div style="display: flex; justify-content: space-between; align-items: center;">
  <h3>Completed Tasks</h3>
  <form action="../controllers/TaskController.php" method="POST">
    <input type="hidden" name="action" value="reset_completed">
    <button type="submit" style="background-color: crimson; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer;">Reset</button>
  </form>
</div>

      <div class="task-list">
        <?php foreach ($completedTasks as $task): ?>
          <div class="task-item completed">
            <?= htmlspecialchars($task['title']) ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>

</div>

</body>
</html>
