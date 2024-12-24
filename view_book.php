<?php
session_start();

include 'db.php';

// Check user login session
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle booking deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_booking'])) {
    $booking_id = intval($_POST['ID']);
    $delete_sql = "DELETE FROM registrations WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $stmt->close();
    header("Location: view_booking.php");
    exit();
}

// Fetch user bookings
$sql = "SELECT * FROM registrations WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Your Bookings</title>
    <link rel="stylesheet" href="view_book.css">
    <script>
        function confirmCancel(bookingId) {
            if (confirm("Are you sure you want to cancel this booking?")) {
                document.getElementById("deleteForm" + bookingId).submit();
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Your Bookings</h1>

        <?php if ($result->num_rows > 0): ?>
            <div class="booking-list">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="booking-card">
                        <!-- <h2><?php echo "Booking ID: " . $row['ID']; ?></h2> -->
                        <p><strong>Check-in Date:</strong> <?php echo $row['check_in_date']; ?></p>
                        <p><strong>Check-out Date:</strong> <?php echo $row['check_out_date']; ?></p>
                        <p><strong>Number of Rooms:</strong> <?php echo $row['num_rooms']; ?></p>
                        <p><strong>Number of Guests:</strong> <?php echo $row['num_guests']; ?></p>
                        <p><strong>Total Price:</strong> <?php echo $row['total_price']; ?> L.E</p>
                        
                        <form id="deleteForm<?php echo $row['ID']; ?>" action ="del_booking.php" method="POST" style="display: inline;">
                            <input type="hidden" name="ID" value="<?php echo $row['ID']; ?>">
                            <button type="submit" class="cancel-btn">Cancel</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No bookings found.</p>
        <?php endif; ?>

        <?php $stmt->close(); $conn->close(); ?>
    </div>
</body>
</html>
