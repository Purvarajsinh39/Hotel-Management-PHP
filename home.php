<?php
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: user_login.php"); // Redirect to login if not authenticated
    exit();
}

$username = $_SESSION['username']; // Get the username from the session

// Database connection
$host = "localhost";  
$user = "root";  
$password = '';  
$db_name = "hotel_management";  
$con = mysqli_connect($host, $user, $password, $db_name);  

if (mysqli_connect_errno()) {  
    die("Failed to connect with MySQL: " . mysqli_connect_error());  
}  

// Close the connection
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/stylehome_user.css">
    <link rel="icon" href="img/mainicon.png" type="image/x-icon">
</head>
<body style="background-image: url('img/bgbooking.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center; background-color: #f5f6fa;">
    <div class="navbar">
        <div class="profile">
            <img src="img/profile-icon.png" alt="Profile Icon">
            <h3><?php echo htmlspecialchars($username); ?></h3>
        </div>
        <ul>
            <li class="active"><a href="home.php" title="Home">Home</a></li>
            <li><a href="user_booking.php" title="Booking">Booking</a></li>
            <li><a href="user_complaints.php" title="Complaints">Complaints</a></li>
            <li><a href="user_gallery.php" title="Gallery">Gallery</a></li>
            <li><a href="user_review.php" title="Review">Review</a></li>
            <li><a href="user_about_us.php" title="About Us">About Us</a></li>
        </ul>
        <div class="user-menu">
            <a href="user_login.php" title="Logout">
                <img src="img/logout.png" alt="Logout Button">
            </a>
            <a href="login.php" title="Admin Login">
                <img src="img/user-icon.png" alt="Admin Button">
            </a>
        </div>
    </div>
    <!-- Main Content -->
    <div class="main-content">
        <div class="gallery">
            <h1>Our Rooms</h1>
            <div class="gallery-grid">
                <div class="gallery-item">
                <!-- <a href="user_booking.php"> -->
                    <img src="img/Single.png" alt="Single Room">
                    <h4>Single Room</h4>
                    <p>Cozy space perfect for solo travelers, equipped with essential amenities.</p>
                </div>
                <div class="gallery-item">
                <!-- <a href="user_booking.php"> -->
                    <img src="img/Double.png" alt="Double Room">
                    <h4>Double Room</h4>
                    <p>Spacious room ideal for two, offering comfort and modern facilities.</p>
                </div>
                <div class="gallery-item">
                <!-- <a href="user_booking.php"> -->
                    <img src="img/Suite.png" alt="Suite Room">
                    <h4>Suite Room</h4>
                    <p>Luxurious suite with separate living area and premium amenities.</p>
                </div>
                <div class="gallery-item">
                <!-- <a href="user_booking.php"> -->
                    <img src="img/Deluxe.png" alt="Deluxe Room" >
                    <h4>Deluxe Room</h4>
                    <p>Elegant room with upscale decor and enhanced comfort features.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
