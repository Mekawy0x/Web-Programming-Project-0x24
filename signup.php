<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['Email'];
    $phone = $_POST['mobile_number'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "INSERT INTO users (first_name, last_name, Email, mobile_number, username, password) 
              VALUES ('$first_name', '$last_name', '$email', '$phone', '$username', '$password')";

    if ($conn->query($query) === 1) {
        header('Location: login.php');
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    <div class="form-container">
        <h1>User Registration</h1>
        <form action="signup.php" method="POST" id="registrationForm">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="Email">Email</label>
                <input type="email" id="Email" name="Email" required>
            </div>
            <div class="form-group">
                <label for="mobile_number">Mobile Number</label>
                <input type="tel" id="mobile_number" name="mobile_number" pattern="[0-9]{10}" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Register</button>
        </form>
    </div>
    <script src="scripts.js"></script>
</body>
</html>
