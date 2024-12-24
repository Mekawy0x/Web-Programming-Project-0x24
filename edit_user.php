<?php
session_start();
include 'db.php';

// Ensure only admins can access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Fetch user details for the given ID
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = $conn->prepare("SELECT * FROM users WHERE ID = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found!";
        exit();
    }
}

// Update user details on form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['ID']);
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['Email'];
    $mobile = $_POST['mobile_number'];
    $username = $_POST['username'];
    $password = $_POST['password'];


    $updateQuery = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, Email = ?, mobile_number = ?, username = ?, password = ? WHERE ID = ?");
    $updateQuery->bind_param("ssssssi", $firstName, $lastName, $email, $mobile, $username,  $password, $id);

    if ($updateQuery->execute()) {
        header('Location: admin.php?message=User+updated+successfully');
        exit();
    } else {
        echo "Error updating user: " . $updateQuery->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="styling.css">
</head>
<body>
    <div class="container">
        <h2>Edit User</h2>
        <form method="POST" action="">
            <input type="hidden" name="ID" value="<?= $user['ID'] ?>">
            <label>First Name:</label>
            <input type="text" name="first_name" value="<?= $user['first_name'] ?>" required>
            <label>Last Name:</label>
            <input type="text" name="last_name" value="<?= $user['last_name'] ?>" required>
            <label>Email:</label>
            <input type="email" name="Email" value="<?= $user['Email'] ?>" required>
            <label>Mobile Number:</label>
            <input type="text" name="mobile_number" value="<?= $user['mobile_number'] ?>" required>
            <label>Username:</label>
            <input type="text" name="username" value="<?= $user['username'] ?>" required>
            <label>Password (Leave blank to keep current):</label>
            <input type="password" name="password">
            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
