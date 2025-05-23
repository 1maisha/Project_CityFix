<?php

$conn = new mysqli("localhost", "root", "", "cityfix");

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed"]));
}

$sql = "SELECT complaint_No, user_id, description, location, image_path, status FROM complaints";
$result = $conn->query($sql);
$complaints = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $complaints[] = $row;
    }
}
header('Content-Type: application/json');
echo json_encode($complaints);
$conn->close();
?>
