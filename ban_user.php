<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cityfix";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$user_id = $_POST['user_id'];

$sql = "UPDATE users SET is_banned = TRUE WHERE id = $user_id";

if ($conn->query($sql) === TRUE) {
  echo "User banned successfully.";
} else {
  echo "Error banning user: " . $conn->error;
}

$conn->close();
?>
