<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../includes/db_config.php';
require_once __DIR__ . '/../models/UserModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'register') {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (registerUser($username, $email, $password)) {
            header("Location: ../views/login.php?success=1");
            exit;
        } else {
            echo "❌ Error: Registration failed.";
        }
    }

    if ($_POST['action'] === 'login') {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $user = loginUser($email, $password);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: ../views/dashboard.php");
            exit;
        } else {
            header("Location: ../views/login.php?error=1");
            exit;
        }
    }
}
?>
