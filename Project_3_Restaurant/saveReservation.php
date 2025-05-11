<?php
$host = "localhost";
$user = "myuser";
$pass = "123";
$db = "restaurantdb";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event = $_POST['eventType'];
    $name = $_POST['reservationName'];
    $phone = $_POST['phoneNumber'];
    $guests = $_POST['guests'];

    $stmt = $conn->prepare("INSERT INTO reservations (eventType, reservationName, phoneNumber, guests) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $event, $name, $phone, $guests);

    if ($stmt->execute()) {
        echo "<script>window.location.href = 'restaurant.html?status=success';</script>";
    } else {
        echo "<script>window.location.href = 'restaurant.html?status=error';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
