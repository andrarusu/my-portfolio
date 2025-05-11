<?php
$host = 'localhost';
$db   = 'todo_db';
$user = 'myuser';        // utilizator implicit în XAMPP
$pass = '123';            // parola e goală în mod implicit în XAMPP
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
