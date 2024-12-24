<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check admin credentials
    $adminQuery = "SELECT * FROM admin WHERE username = '$username'";
    $adminResult = $conn->query($adminQuery);

    if ($adminResult->num_rows === 1) {
        $admin = $adminResult->fetch_assoc();
        if ($password === $admin['password']) {
            $_SESSION['role'] = 'admin';
            header('Location: admin.php');
            exit();
        } else {
            $error = "Invalid admin credentials!";
        }
    } else {
        // Check for regular user credentials
        $userQuery = "SELECT * FROM users WHERE username = '$username'";
        $userResult = $conn->query($userQuery);

        if ($userResult->num_rows === 1) {
            $user = $userResult->fetch_assoc();
            if ($password === $user['password']) {
                $_SESSION['user_id'] = $user['ID'];
                header('Location: user_home.php');
            } else {
                $error = "Invalid user credentials!";
            }
        } else {
            $error = "User not found!";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <script src="login.js"></script>
    
    
</head>
<body>
<div class="login-container">
    <form action="" method="POST">
        <h2>Login</h2>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <label>Username</label>
        <input type="text" name="username" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit">Login</button>
        <p>Don't have an account? <a href="signup.php">Sign up</a></p>
    </form>
</div>
</body>
</html>
