<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "cityfix");

    if ($conn->connect_error) {
        http_response_code(500);
        echo "Database connection failed";
        exit;
    }

    $id = intval($_POST['id']);
    $status = $conn->real_escape_string($_POST['status']);

    $sql = "UPDATE complaints SET status='$status' WHERE complaint_No=$id";

    if ($conn->query($sql)) {
        echo "Status updated.";
    } else {
        http_response_code(500);
        echo "Error updating status.";
    }

    $conn->close();
} else {
    http_response_code(400);
    echo "Invalid request method.";
}
?>
ye