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
    <title>About Us</title>
    <link rel="stylesheet" href="css/styleaboutus_user.css">
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
            <li><a href="user_gallery.php">Gallery</a></li>
            <li><a href="user_review.php">Review</a></li>
            <li class="active"><a href="user_about_us.php">About Us</a></li>
            
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
    <div class="about-section">
    <h1>About Us</h1>
    <p>Welcome to the <strong>Hotel Management System</strong>, an innovative solution developed by a team of three passionate developers aimed at optimizing the day-to-day operations of hotels. Our system simplifies the process for both guests and hotel administrators, offering efficient tools for booking, room management, and more.</p>
    
    
    <h2>System Overview:</h2>
    <p>Our Hotel Management System is designed with two primary user types in mind: <strong>guests</strong> and <strong>administrators</strong>.</p>
    
    <h3>User Side Modules:</h3>
    <ul>
        <li><strong>Home Module:</strong>  Allows users to view an overview of the hotel and explore four types of rooms, each with images, brief descriptions, and pricing information. This helps guests get an idea of available accommodations and choose the one that best suits their needs.</li>
        <li><strong>Booking Module:</strong> Guests can book rooms, and manage their reservations online.</li>
        <li><strong>Complaints Module:</strong> Guests can submit and track complaints to ensure any issues they encounter are resolved efficiently.</li>
        <li><strong>Gallery Module:</strong> The gallery showcases the hotel’s rooms, amenities, and services, offering a visual experience for potential guests.</li>
        <li><strong>Review Module:</strong> Guests can share their experiences by submitting reviews and ratings for the services and accommodations they received. This module allows potential guests to read feedback from previous visitors, helping them make informed decisions while enhancing overall guest satisfaction through transparency and community engagement.</li>

    </ul>
    
    <h3>Admin Side Modules:</h3>
    <ul>
        <li><strong>Dashboard:</strong> The admin dashboard provides an overview of bookings, complaints, and room statuses, giving administrators full control over the system.</li>
        <li><strong>Booking Management:</strong> Administrators can view, update, and manage all bookings made by guests.</li>
        <li><strong>Room Management:</strong> This module allows hotel staff to add, modify, or remove rooms, manage availability, set pricing, and configure room features.</li>
        <li><strong>Customer Details:</strong> This module allows hotel staff to view and manage customer information, including personal details, contact info, and booking history.</li>
        <li><strong>Complaint Management:</strong> Hotel administrators can view, track, and resolve guest complaints, ensuring timely responses and maintaining service quality.</li>
        <li><strong>Manage Reviews:</strong> Administrators can view, moderate, and respond to guest reviews, ensuring that feedback is addressed and appropriate. This module helps maintain a positive online presence and enhances guest satisfaction by allowing hotel staff to acknowledge compliments and resolve any issues raised by guests.</li>

    </ul>
    
    <h2>Meet the Developers:</h2>
    <ul class="developer-list">
        <li>
            <strong>Vaghela Purvarajsinh</strong><br>
            <strong>Division:</strong> D <strong>Semester:</strong> 3rd <strong>Roll No:</strong> 54<br>
            <strong>Enrollment Number:</strong> 23018501210273<br>
        </li>
    </ul>

    <p>With these modules in place, our system aims to improve efficiency, transparency, and guest satisfaction, while giving administrators all the tools they need to effectively manage their hotel operations.</p>
</div>
</body>
</html>
