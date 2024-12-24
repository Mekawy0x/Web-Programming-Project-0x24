<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE ID = $user_id";
$result = $conn->query($query);
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Profile</title>
    <link rel="stylesheet" href="user_profile.css">
    <script src="user_profile.js"></script>
</head>
<body>
<div class="profile-container">
    <h2>Your Profile</h2>
    <p><strong>First Name:</strong> <?php echo $user['first_name']; ?></p>
    <p><strong>Last Name:</strong> <?php echo $user['last_name']; ?></p>
    <p><strong>Email:</strong> <?php echo $user['Email']; ?></p>
    <p><strong>Phone:</strong> <?php echo $user['mobile_number']; ?></p>
    <a href="user_home.php" class="back-btn">Back to Dashboard</a>
</div>
</body>
</html>
