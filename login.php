<?php
session_start();
require '../CityFix/db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo "Please fill in both email and password. <a href='login.html'>Try again</a>.";
        exit();
    }

    try {
        // Check if user is banned
        $banCheck = $pdo->prepare("SELECT * FROM users WHERE email = ? AND is_banned = TRUE");
        $banCheck->execute([$email]);

        if ($banCheck->rowCount() > 0) {
            die("Your account is banned.");
        }

        // Check login credentials
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->execute([$email, $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            echo "Login successful! Welcome, " . htmlspecialchars($user['name']) . ". Redirecting...";
            header("refresh:1; url=submitComplaint.html");
            exit();
        } else {
            echo "Invalid email or password. <a href='login.html'>Try again</a>.";
            exit();
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        exit();
    }
}
?>
