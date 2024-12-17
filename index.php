<?php
include 'db.php';

$query = "SELECT * FROM hotels";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

<header class="header">
        <h1>Hotel Booking</h1>
        <nav class="header-nav">
            <a href="login.php" class="header-btn">Login</a>
            <a href="signup.php" class="header-btn">Sign Up</a>
        </nav>
    </header>

    <section class="search-container">
        <form action="search_results.php" method="GET" class="search-form">
            <input type="text" id="hotel-search" name="query" placeholder="Search for hotels..." autocomplete="off">
            <button type="submit" class="search-btn">Search</button>
            <!-- <div id="search-dropdown" class="search-dropdown"></div> -->
        </form>
    </section>
<div class="home-container">
<div style="text-align: center;">
<h1 style="display: inline-block; font-size: 2.5rem; color: #3b5152; padding-bottom: 10px; border-bottom: 3px solid #638889;">
    Welcome to Our Hotel Booking System
</h1>
</div>
    <div class="hotel-list">
        <?php
        if ($result && $result->num_rows > 0):
            while ($hotel = $result->fetch_assoc()): ?>
                <div class="hotel-card">
                    <img src="assets/images/<?php echo $hotel['image']; ?>" alt="Hotel Image">
                    <h3><?php echo $hotel["hotel_name"]; ?></h3>
                    <p><strong>Location:</strong> <?php echo $hotel['location']; ?></p>
                    <p><strong>Rank:</strong> <?php echo $hotel['rank']; ?> stars</p>
                    <p><strong>Price per Room:</strong><?php echo $hotel['price_room']; ?> L.E</p>
                    <a href="hotel_details.php?id=<?php echo $hotel['ID']; ?>" class="details-btn">View Details</a>
                </div>
            <?php endwhile;
        else: ?>
            <p>No hotels found.</p>
        <?php endif; ?>
    </div>
    <div style="text-align: center;">
        <br>
    <a href="login.php" class="login-btn">Login to Book</a>
        </div>
</div>

<footer class="footer">
        <p>&copy; 2024 Web Programming Course. All rights reserved.</p>
    </footer>

</body>
</html>
