<?php
session_start();
include 'db.php';

// Ensure only admins can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['hotel_name'];
    $description = $_POST['description'];
    $image = $_POST['Image'];
    $location = $_POST['location'];
    $rank = $_POST['rank'];
    $priceRoom = $_POST['price_room'];
    $features = $_POST['features'];
    $activities = $_POST['activities'];
    $available_rooms = $_POST['availabe_rooms'];

    // Insert into the hotels table
    $query = $conn->prepare("INSERT INTO hotels (hotel_name, description, Image, location, rank, price_room, features, activities, availabe_rooms) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $query->bind_param("ssssiissi", $name, $description, $image, $location, $rank, $priceRoom, $features, $activities, $available_rooms);

    if ($query->execute()) {
        $_SESSION['message'] = "Hotel added successfully!";
    } else {
        $_SESSION['error'] = "Error adding hotel: " . $query->error;
    }

    header('Location: admin.php');
    exit();
}
?>
