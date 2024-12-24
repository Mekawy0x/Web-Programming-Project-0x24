<?php
session_start();
include 'db.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);

    // Fetch the user
    $userQuery = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($userQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "User not found.";
        exit;
    }

    $user = $result->fetch_assoc();
    $user_id = $user['ID'];

    // Fetch registrations for the user
    $query = "SELECT * FROM registrations WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $filename = "registrations_user_$userId.csv";
        $output = fopen('php://output', 'w');
        
        // Clear buffer and set headers
        ob_clean();
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        // Add CSV headers
        $headers = array("Registration ID", "User ID", "Hotel ID", "Check_In_Date", "Check_Out_Date", "Num_Rooms", "Num_Guests", "Total_Price");
        fputcsv($output, $headers);

        // Add rows
        while ($row = $result->fetch_assoc()) {
            fputcsv($output, $row);
        }

        fclose($output);
    }

    // Delete user and their registrations
    $deleteRegistrations = "DELETE FROM registrations WHERE user_id = ?";
    $stmt = $conn->prepare($deleteRegistrations);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $deleteUser = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($deleteUser);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

} else {
    echo "No user ID provided.";
}

$conn->close();
?>
