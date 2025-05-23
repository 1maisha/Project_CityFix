<?php
$host = 'localhost';
$db = 'cityfix';
$user = 'root'; // change if different
$pass = '';     // change if you have a password

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT description, location, image_path, status FROM complaints ORDER BY complaint_No DESC LIMIT 3";
$result = $conn->query($sql);

$complaints = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $complaints[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($complaints);
?>
