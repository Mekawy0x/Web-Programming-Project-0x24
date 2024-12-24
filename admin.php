<?php
session_start();
include 'db.php';

// Ensure only admins can access the page
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Fetch users and hotels
$userQuery = "SELECT * FROM users";
$userResult = $conn->query($userQuery);

$hotelQuery = "SELECT * FROM hotels";
$hotelResult = $conn->query($hotelQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F9EFDB;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #EBD9B4;
            color: #638889;
            padding: 15px;
            text-align: center;
        }
        .container {
            padding: 20px;
        }
        .section {
            margin-bottom: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #9DBC98;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #638889;
            color: white;
        }
        .form-container {
            background-color: #FFFFFF;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container h3 {
            color: #638889;
        }
        .button {
            background-color: #9DBC98;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #638889;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
    </div>
    <div class="container">
        <!-- Users Section -->
        <div class="section">
            <h2>Manage Users</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Fisrt Name</th>
                    <th>Last Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>
                <?php while ($user = $userResult->fetch_assoc()): ?>
                <tr>
                    <td><?= $user['ID'] ?></td>
                    <td><?= $user['first_name'] ?></td>
                    <td><?= $user['last_name'] ?></td>
                    <td><?= $user['mobile_number'] ?></td>
                    <td><?= $user['Email'] ?></td>
                    <td><?= $user['username'] ?></td>
                    <td>
                        <button class="button" onclick="location.href='edit_user.php?id=<?= $user['ID'] ?>'">Edit</button>
                        <button class="button" onclick="location.href='delete_user.php?id=<?= $user['ID'] ?>'">Delete</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
            <div class="form-container">
                <h3>Add User</h3>
                <form action="add_user.php" method="POST">
                    <label>Fisrt Name:</label>
                    <input type="text" name="first_name" required><br>
                    <label>Last Name:</label>
                    <input type="text" name="last_name" required><br>
                    <label>Mobile Number:</label>
                    <input type="text" name="mobile_number" required><br>
                    <label>Email:</label>
                    <input type="email" name="Email" required><br>
                    <label>Username:</label>
                    <input type="text" name="username" required><br> 
                    <label>Password:</label>
                    <input type="password" name="password" required><br>
                    <button type="submit" class="button">Add User</button>
                </form>
            </div>
        </div>
        <!-- Hotels Section -->
        <div class="section">
            <h2>Manage Hotels</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Hotel Name</th>
                    <th>Describtion</th>
                    <th>Image</th>
                    <th>Location</th>
                    <th>Rank</th>
                    <th>Price/Room</th>
                    <th>Features</th>
                    <th>Activities</th>
                    <th>Available Rooms</th>
                    <th>Actions</th>
                </tr>
                <?php while ($hotel = $hotelResult->fetch_assoc()): ?>
                <tr>
                    <td><?= $hotel['ID'] ?></td>
                    <td><?= $hotel['hotel_name'] ?></td>
                    <td><?= $hotel['description'] ?></td>
                    <td><?= $hotel['Image'] ?></td>
                    <td><?= $hotel['location'] ?></td>
                    <td><?= $hotel['rank'] ?></td>
                    <td><?= $hotel['price_room'] ?></td>
                    <td><?= $hotel['features'] ?></td>
                    <td><?= $hotel['activities'] ?></td>
                    <td><?= $hotel['availabe_rooms'] ?></td>
                    <td>
                        <button class="button" onclick="location.href='edit_hotel.php?id=<?= $hotel['ID'] ?>'">Edit</button>
                        <button class="button">Delete</button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
            <div class="form-container">
                <h3>Add Hotel</h3>
                <form action="add_hotel.php" method="POST">
                    <label>Hotel Name:</label>
                    <input type="text" name="hotel_name" required><br>
                    <label>Description:</label>
                    <input type="text" name="description" required><br>
                    <label>Image:</label>
                    <input type="text" name="Image" required><br>
                    <label>Location:</label>
                    <input type="text" name="location" required><br>
                    <label>Rank:</label>
                    <input type="number" name="rank" required><br>
                    <label>Price / Room:</label>
                    <input type="number" name="price_room" required><br>
                    <label>Features:</label>
                    <input type="text" name="features" required><br>
                    <label>Activities:</label>
                    <input type="text" name="activities" required><br>
                    <label>Available Rooms:</label>
                    <input type="text" name="availabe_rooms" required><br>
                    <button type="submit" class="button">Add Hotel</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
