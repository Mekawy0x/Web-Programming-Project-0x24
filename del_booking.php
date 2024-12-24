<?php

session_start();

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve the ID from the request
    $id = intval($_POST['ID']);

    $query = $conn->prepare("SELECT hotel_id, num_rooms FROM registrations WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $query->bind_result($hotel_id, $rooms_booked);

    if ($query->fetch()) {
        $query->close();

        // Update the available rooms for the hotel
        $updateQuery = $conn->prepare("UPDATE hotels SET availabe_rooms = availabe_rooms + ? WHERE id = ?");
        $updateQuery->bind_param("ii", $rooms_booked, $hotel_id);

        if ($updateQuery->execute()) {
            $updateQuery->close();}}

    // Prepare the DELETE query
    $query = $conn->prepare("DELETE FROM registrations WHERE ID = ?");
    $query->bind_param("i", $id);

    // Execute the query and check the result
    if ($query->execute()) {
        header('Location: view_book.php');
        exit();
    } else {
        echo "Error deleting record: " . $query->error;
    }

    $query->close();
}
?>
