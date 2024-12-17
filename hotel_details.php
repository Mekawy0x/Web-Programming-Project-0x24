<?php
session_start();
include 'db.php';

$hotel_id = $_GET['id'];
$query = "SELECT * FROM hotels WHERE ID = $hotel_id";
$result = $conn->query($query);
$hotel = $result->fetch_assoc();
$features = explode(",", $hotel['features']);
$activities = explode(",", $hotel['activities']);


if (!isset($_SESSION['user_id'])) {
    $login_message = "Please <a href='login.php'>login</a> to book.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Hotel Details</title>
    <link rel="stylesheet" href="hotel_details.css">
    <script src = "hotel_details.js"></script>
    
</head>
<body>
<div class="hotel-details-container">
    <h1><?php echo $hotel['hotel_name']; ?></h1>
    <img src="assets/images/<?php echo $hotel['image']; ?>" alt="Hotel Image">
     <!-- Right Section -->
     <div class="right-section">
                <p><h3><strong>Description</strong></h3><br><?php echo nl2br($hotel['description']); ?></p>
            </div>
    
    
    <!-- Content Section -->
    <div class="content-container">
    <!-- Left Section -->
    <div class="left-section">
        <h3 class="section-title">Features</h3>
        <ul class="highlights">
            <?php foreach ($features as $feature): ?>
                <li><?php echo htmlspecialchars(trim($feature)); ?></li>
            <?php endforeach; ?>
        </ul>

        <h3>Activities</h3>
        <ul>
            <?php foreach ($activities as $activity): ?>
                <li><?php echo htmlspecialchars(trim($activity)); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>


           
        </div>
        <?php if (isset($_SESSION['user_id'])): ?>
        <a href="hotel_reg.php?hotel_id=<?php echo $hotel['ID']; ?>" class="book-btn">Book Now</a>
    <?php else: ?>
        <p class="login-prompt"><?php echo $login_message; ?></p>
    <?php endif; ?>
    </div>
    
</div>


</body>
</html>
