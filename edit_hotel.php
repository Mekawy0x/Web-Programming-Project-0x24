<?php
session_start();
include 'db.php';

// Ensure only admins can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Fetch hotel details for the given ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = $conn->prepare("SELECT * FROM hotels WHERE ID = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 1) {
        $hotel = $result->fetch_assoc();
    } else {
        echo "Hotel not found!";
        exit();
    }
}

// Update hotel details on form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['ID'];
    $name = $_POST['hotel_name'];
    $description = $_POST['description'];
    $image = $_POST['Image'];
    $location = $_POST['location'];
    $rank= $_POST['rank'];
    $priceRoom = intval($_POST['price_room']);
    $features = $_POST['features'];
    $activities = $_POST['activities'];
    $availableRooms = $_POST['availabe_rooms'];

    $updateQuery = $conn->prepare("UPDATE hotels SET hotel_name = ?, description = ?, Image = ?,  location = ?, rank = ?, price_room = ?, features = ?, activities = ?, availabe_rooms = ? WHERE ID = ?");
    $updateQuery->bind_param("ssssiissii", $name, $description, $image, $location, $rank, $priceRoom, $features, $activities, $available_rooms, $id);

    if ($updateQuery->execute()) {
        header('Location: admin.php?message=Hotel+updated+successfully');
        exit();
    } else {
        echo "Error updating hotel: " . $updateQuery->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Hotel</title>
    <link rel="stylesheet" href="styling.css">
</head>
<body>
    <div class="container">
        <h2>Edit Hotel</h2>
        <form method="POST" action="">
            <input type="hidden" name="ID" value="<?= $hotel['ID'] ?>" required>
            <label>Hotel Name:</label>
            <input type="text" name="hotel_name" value="<?= $hotel['hotel_name'] ?>" required>
            <label>Description:</label>
            <input type="text" name="description" value="<?= $hotel['description'] ?>" required>
            <label>Image:</label>
            <input type="text" name="Image" value="<?= $hotel['Image'] ?>" required>
            <label>Location:</label>
            <input type="text" name="location" value="<?= $hotel['location'] ?>" required>
            <label>Rank:</label>
            <input type="text" name="rank" value="<?= $hotel['rank'] ?>" required>
            <label>Price / Room:</label>
            <input type="text" name="price_room" value="<?= $hotel['price_room'] ?>" required>
            <label>Features:</label>
            <input type="text" name="features" value="<?= $hotel['features'] ?>" required>
            <label>Activities:</label>
            <input type="text" name="activities" value="<?= $hotel['activities'] ?>" required>
            <label>Available Rooms:</label>
            <input type="number" name="availabe_rooms" value="<?= $hotel['availabe_rooms'] ?>" required>
            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
