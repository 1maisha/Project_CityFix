<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'cityfix';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Total complaints
$totalComplaintsQuery = "SELECT COUNT(*) AS total FROM complaints";
$totalResult = $conn->query($totalComplaintsQuery);
$total = $totalResult->fetch_assoc()['total'];

// Resolved complaints
$resolvedComplaintsQuery = "SELECT COUNT(*) AS resolved FROM complaints WHERE status = 'Resolved'";
$resolvedResult = $conn->query($resolvedComplaintsQuery);
$resolved = $resolvedResult->fetch_assoc()['resolved'];

// Active users (is_banned = 0)
$usersQuery = "SELECT COUNT(*) AS users FROM users WHERE is_banned = 0";
$usersResult = $conn->query($usersQuery);
$users = $usersResult->fetch_assoc()['users'];

$conn->close();

echo json_encode([
    'total_complaints' => $total,
    'resolved_complaints' => $resolved,
    'active_users' => $users
]);
?>
