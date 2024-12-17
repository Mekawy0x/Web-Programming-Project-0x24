<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$query = "SELECT * FROM hotels";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Home</title>
    <link rel="stylesheet" href="user_home.css">

</head>
<body>
    <header class="header">
        <h1>Hotel Booking</h1>
        <nav class="header-nav">
            <a href="user_profile.php" class="header-btn">View Profile</a>
            <a href="view_book.php" class="header-btn">View Your Booking</a>
            <a href="logout.php" class="header-btn">Logout</a>
        </nav>
    </header>

    <section class="search-container">
        <form action="search_results.php" method="GET" class="search-form">
            <input type="text" id="hotel-search" name="query" placeholder="Search for hotels..." autocomplete="off">
            <button type="submit" class="search-btn">Search</button>
            <!-- <div id="search-dropdown" class="search-dropdown"></div> -->
        </form>
    </section>


<div class="user-home-container">
<div style="text-align: center;">
    <h1 style="display: inline-block; font-size: 2.5rem; color: #3b5152; padding-bottom: 10px; border-bottom: 3px solid #638889;">
        Welcome to Your Dashboard
    </h1>
    <!-- <div style="text-align: center; margin-top: 20px;">
    <h1 style="
        display: inline-block;
        font-size: 2.8rem;
        color: #3b5152;
        padding: 10px 20px;
        background: linear-gradient(90deg, #4e54c8, #8f94fb);
        color: white;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        font-family: 'Arial', sans-serif;
        text-transform: capitalize;
    ">
        Welcome to Your Dashboard
    </h1>
</div> -->
</div>
    <div class="hotel-list">
        <?php while ($hotel = $result->fetch_assoc()): ?>
            <div class="hotel-card">
                <img src="assets/images/<?php echo $hotel['image']; ?>" alt="Hotel Image">
                <h3><?php echo $hotel['hotel_name']; ?></h3>
                <p><strong>Location:</strong> <?php echo $hotel['location']; ?></p>
                <p><strong>Rank:</strong> <?php echo $hotel['rank']; ?> stars</p>
                <p><strong>Price per Room:</strong> <?php echo $hotel['price_room']; ?> L.E</p>
                <a href="hotel_details.php?id=<?php echo $hotel['ID']; ?>" class="details-btn">Book Now</a>
            </div>
        <?php endwhile; ?>
    </div>
</div>

    <footer class="footer">
        <p>&copy; 2024 Web Programming Course. All rights reserved.</p>
    </footer>


</body>
</html>
