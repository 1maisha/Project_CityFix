<?php
session_start();
require '../CityFix/db.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $adrs = $_POST['address'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm-password'] ?? '';

    if (empty($name) || empty($phone) || empty($adrs) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "Please fill in all fields. <a href='signup.html'>Try again</a>.";
        exit();
    }

    if ($password !== $confirm_password) {
        echo "Passwords do not match. <a href='signup.html'>Try again</a>.";
        exit();
    }

    try {

        // Check if the email is banned
        $banCheckStmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND is_banned = TRUE");
        $banCheckStmt->execute([$email]);
        if ($banCheckStmt->rowCount() > 0) {
            die("This account has been banned and cannot sign up again.");
        }

        $checkStmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $checkStmt->execute([$email]);

        if ($checkStmt->rowCount() > 0) {
            echo "Email already registered. <a href='signup.html'>Try again</a>.";
            exit();
        }

        $stmt = $pdo->prepare("INSERT INTO users (name, phone, address, email, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $phone, $adrs, $email, $password]);

        echo "Signup successful! Redirecting to login...";
        header("refresh:2; url=login.html"); // redirect after 2 seconds
        exit();

    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        exit();
    }
}
?>
