<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cityfix";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $conn->real_escape_string($_POST['name']);
  $email = $conn->real_escape_string($_POST['email']);
  $description = $conn->real_escape_string($_POST['description']);
  $location = $conn->real_escape_string($_POST['location']);

  // Check if user exists in users table
  $user_query = "SELECT id FROM users WHERE name = '$name' AND email = '$email' LIMIT 1";
  $user_result = $conn->query($user_query);

  if ($user_result && $user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();
    $user_id = $user['id'];
  } else {
    // Insert user if not exists
    $insert_user = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
    if ($conn->query($insert_user)) {
      $user_id = $conn->insert_id;
    } else {
      die("Error inserting user: " . $conn->error);
    }
  }

  // Handle image upload
  $image_path = "";
  if (!empty($_FILES["image"]["name"])) {
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
      mkdir($target_dir, 0777, true);
    }
    $image_path = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $image_path);
  }

  // Insert complaint into complaints table
  $insert_complaint = "INSERT INTO complaints (user_id, description, location, image_path)
                       VALUES ('$user_id', '$description', '$location', '$image_path')";

  if ($conn->query($insert_complaint) === TRUE) {
    echo "<!DOCTYPE html>
    <html>
    <head>
      <title>Complaint Submitted</title>
      <style>
        body {
          font-family: Arial, sans-serif;
          background: #e0ffe0;
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
        }
        .message-box {
          background: #ffffff;
          padding: 30px 40px;
          border-radius: 10px;
          box-shadow: 0 4px 8px rgba(0,0,0,0.2);
          text-align: center;
        }
        .message-box h2 {
          color: #2e7d32;
        }
        .message-box p {
          margin-top: 10px;
          color: #444;
        }
        .message-box a {
          margin-top: 20px;
          display: inline-block;
          text-decoration: none;
          background-color: #2e7d32;
          color: white;
          padding: 10px 20px;
          border-radius: 5px;
        }
      </style>
    </head>
    <body>
      <div class='message-box'>
        <h2>Complaint Submitted Successfully!</h2>
        <p>Your complaint has been sent to the authority.</p>
        <p>Please be patient and cooperate with the officials during the resolution process.</p>
        <a href='submitComplaint.html'>Submit Another Complaint</a>
        <a href='Home.html'>Home</a>
      </div>
    </body>
    </html>";
  } else {
    echo "Error inserting complaint: " . $conn->error;
  }

  $conn->close();
}
?>
