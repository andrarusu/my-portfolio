<?php
session_start();
require_once __DIR__ . '/../includes/db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.php");
    exit;
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add_task') {
        $title = trim($_POST['title']);

        if (!empty($title)) {
            $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title) VALUES (?, ?)");
            if ($stmt->execute([$userId, $title])) {
                header("Location: ../views/dashboard.php?status=added");
            } else {
                header("Location: ../views/dashboard.php?status=error");
            }
        } else {
            header("Location: ../views/dashboard.php?status=error");
        }
        exit;

    } elseif ($action === 'complete_task') {
        $taskId = (int) $_POST['task_id'];

        $check = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
        $check->execute([$taskId, $userId]);

        if ($check->rowCount() > 0) {
            $update = $pdo->prepare("UPDATE tasks SET status = 'completed' WHERE id = ?");
            $update->execute([$taskId]);
            header("Location: ../views/dashboard.php?status=completed");
        } else {
            header("Location: ../views/dashboard.php?status=error");
        }
        exit;

    } elseif ($action === 'delete_task') {
        $taskId = (int) $_POST['task_id'];

        $check = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
        $check->execute([$taskId, $userId]);

        if ($check->rowCount() > 0) {
            $delete = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
            $delete->execute([$taskId]);
            header("Location: ../views/dashboard.php?status=deleted");
        } else {
            header("Location: ../views/dashboard.php?status=error");
        }
        exit;

    } elseif ($action === 'update_task') {
        $taskId = (int) $_POST['task_id'];
        $newTitle = trim($_POST['title']);

        $check = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
        $check->execute([$taskId, $userId]);

        if ($check->rowCount() > 0 && !empty($newTitle)) {
            $update = $pdo->prepare("UPDATE tasks SET title = ? WHERE id = ?");
            $update->execute([$newTitle, $taskId]);
            header("Location: ../views/dashboard.php?status=updated");
        } else {
            header("Location: ../views/dashboard.php?status=error");
        }
        exit;
    } elseif ($action === 'reset_completed') {
        $delete = $pdo->prepare("DELETE FROM tasks WHERE user_id = ? AND status = 'completed'");
        $delete->execute([$userId]);
        header("Location: ../views/dashboard.php?status=reset");
        exit;
    }
}
