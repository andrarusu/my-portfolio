<?php
require_once __DIR__ . '/../includes/db_config.php';

function getTasksByUser($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
}

function addTask($user_id, $title) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title) VALUES (?, ?)");
    return $stmt->execute([$user_id, $title]);
}

function deleteTask($task_id, $user_id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    return $stmt->execute([$task_id, $user_id]);
}
