<?php
session_start();
include 'db.php';

// Ensure only admins can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['Email'];
    $mobile = $_POST['mobile_number'];
    $userName = $_POST['username'];
    $password = $_POST['password'];


    // Insert into the users table
    $query = $conn->prepare("INSERT INTO users (first_name, last_name, Email, mobile_number, username, password) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param("ssssss", $firstName, $lastName, $email, $mobile, $userName, $password);

    if ($query->execute()) {
        $_SESSION['message'] = "User added successfully!";
    } else {
        $_SESSION['error'] = "Error adding user: " . $query->error;
    }

    header('Location: admin.php');
    exit();
}
?>
