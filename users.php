<?php
require '../CityFix/db.php';

$stmt = $pdo->query("SELECT id, name, email, role, created_at FROM manage_users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($users);
?>
