<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "db.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die(json_encode(["success" => false, "message" => "User is not logged in. Please log in to continue."]));
}

$user_id = $_SESSION['user_id'];
$hotel_id = isset($_GET['hotel_id']) ? intval($_GET['hotel_id']) : 0;

// Validate the hotel ID
if ($hotel_id <= 0) {
    die(json_encode(["success" => false, "message" => "Invalid hotel ID provided."]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    var_dump($data);
    $check_in_date = $data['check_in_date'] ?? null;
    $check_out_date = $data['check_out_date'] ?? null;
    $num_rooms = isset($data['num_rooms']) ? intval($data['num_rooms']) : 0;
    $num_guests = isset($data['num_guests']) ? intval($data['num_guests']) : 0;

    // Validate input
    if (!$check_in_date || !$check_out_date || $num_rooms <= 0 || $num_guests <= 0) {
        die(json_encode(["success" => false, "message" => "Please fill out all fields correctly."]));
    }

    try {
        // Begin a transaction
        $conn->begin_transaction();

        // Fetch hotel data
        $stmt = $conn->prepare("SELECT available_rooms, price_room FROM hotels WHERE id = ?");
        $stmt->bind_param("i", $hotel_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $hotel = $result->fetch_assoc();

        if (!$hotel) {
            throw new Exception("Hotel not found.");
        }

        $available_rooms = $hotel['available_rooms'];
        $price_room = $hotel['price_room'];

        // Check room availability
        if ($available_rooms < $num_rooms) {
            throw new Exception("Not enough rooms available.");
        }

        // Calculate total price
        $check_in = new DateTime($check_in_date);
        $check_out = new DateTime($check_out_date);
        $interval = $check_in->diff($check_out);
        $number_of_nights = $interval->days;

        if ($number_of_nights <= 0) {
            throw new Exception("Check-out date must be after the check-in date.");
        }

        $total_price = $number_of_nights * $num_rooms * $price_room;

        // Insert booking details
        $stmt = $conn->prepare("
            INSERT INTO registrations (user_id, hotel_id, check_in_date, check_out_date, num_rooms, num_guests, total_price)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("iissiid", $user_id, $hotel_id, $check_in_date, $check_out_date, $num_rooms, $num_guests, $total_price);

        if (!$stmt->execute()) {
            throw new Exception("Failed to insert registration.");
        }

        // Update available rooms in the hotels table
        $stmt = $conn->prepare("UPDATE hotels SET available_rooms = available_rooms - ? WHERE id = ?");
        $stmt->bind_param("ii", $num_rooms, $hotel_id);

        if (!$stmt->execute()) {
            throw new Exception("Failed to update hotel availability.");
        }

        // Commit transaction
        $conn->commit();

        echo json_encode([
            "success" => true,
            "message" => "Booking registered successfully!",
            "total_price" => $total_price,
        ]);
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }
    exit;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Registration</title>
    <link rel="stylesheet" href="hotel_reg.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> <!-- For calendars -->
</head>
<body>
    <div class="container">
        <h1 class="page-title">Room Registration</h1>
        <form id="registration-form">
            <label for="check_in_date">Check-In Date:</label>
            <input type="date" id="check_in_date" name="check_in_date" class="form-input" required>
            
            <label for="check_out_date">Check-Out Date:</label>
            <input type="date" id="check_out_date" name="check_out_date" class="form-input" required>
            
            <label for="num_rooms">Number of Rooms:</label>
            <input type="number" id="num_rooms" name="num_rooms" class="form-input" min="1" required>
        
            <label for="num_guests">Number of Guests:</label>
            <input type="number" id="num_guests" name="num_guests" min="1" class="form-input" required>

            <div id="price-container" class="hidden">
                <p id="total-price-text"></p>
                <button type="button" id="approve-button" class="button">Approve and Register</button>
            </div>

            <a href = "user_home.php"><button type="submit" class="button">Book Now</button></a>
            
        </form>
    </div>

    <script src = "hotel_reg.js"></script>
</body>
</html>
