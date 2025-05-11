<?php
$host = "localhost";
$user = "myuser";
$pass = "123";
$db   = "restaurantdb";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
