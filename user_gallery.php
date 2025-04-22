<?php
session_start(); // Start session to access the stored username

if (!isset($_SESSION['username'])) {
    header("Location: user_login.php"); // Redirect to login if not authenticated
    exit();
}

$username = $_SESSION['username']; // Get the username from the session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link rel="stylesheet" href="css/stylegallery.css">
    <link rel="icon" href="img/mainicon.png" type="image/x-icon">
</head>
<body style="background-image: url('img/bgbooking.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center; background-color: #f5f6fa;">
    <div class="navbar">
        <div class="profile">
            <img src="img/profile-icon.png" alt="Profile Icon">
            <h3><?php echo htmlspecialchars($username); ?></h3>
        </div>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="user_booking.php">Booking</a></li>
            <li><a href="user_complaints.php">Complaints</a></li>
            <li class="active"><a href="user_gallery.php">Gallery</a></li>
            <li><a href="user_review.php">Review</a></li>
            <li><a href="user_about_us.php">About Us</a></li>
            
        </ul>
        <div class="user-menu">
            <a href="user_login.php" title="Logout">
                <img src="img/logout.png" alt="Logout Icon">
            </a>
            <a href="login.php" title="Admin">
                <img src="img/user-icon.png" alt="Admin Icon">
            </a>
        </div>
    </div>

    <div class="gallery">
            <h1>Photo Gallery</h1>
            <div class="gallery-grid">
                <div class="gallery-item">
                <a href="user_booking.php">
                    <img src="img/gallery1.jpg" alt="Gallery Image 1">
                    </a>
                </div>
                <div class="gallery-item">
                <a href="user_booking.php">
                    <img src="img/gallery2.jpg" alt="Gallery Image 2">
                    </a>
                </div>
                <div class="gallery-item">
                <a href="user_booking.php">
                    <img src="img/gallery3.jpg" alt="Gallery Image 3">
                    </a>
                </div>
                <div class="gallery-item">
                <a href="user_booking.php">
                    <img src="img/gallery4.jpg" alt="Gallery Image 4">
                    </a>
                </div>
                <div class="gallery-item">
                <a href="user_booking.php">
                    <img src="img/gallery5.jpg" alt="Gallery Image 5">
                    </a>
                </div>
                <div class="gallery-item">
                <a href="user_booking.php">
                    <img src="img/gallery6.jpg" alt="Gallery Image 6">
                    </a>
                </div>
            </div>
        </div>
</body>
</html>
