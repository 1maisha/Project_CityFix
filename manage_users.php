<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cityfix";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, phone, email, address, is_banned FROM users";
$result = $conn->query($sql);

$users = [];

while ($row = $result->fetch_assoc()) {
  $users[] = $row;
}

echo json_encode($users);
$conn->close();
?>
