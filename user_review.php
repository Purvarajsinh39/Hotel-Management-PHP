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
$con = new mysqli($host, $user, $password, $db_name);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Initialize variables
$name = $username; // Default to the session username
$rating = null;
$review = null;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']); // Get the name from the form
    $rating = (int)$_POST['rating'];
    $review = htmlspecialchars($_POST['review']);

    // Insert review into the database
    $stmt = $con->prepare("INSERT INTO reviews (name, rating, review) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $name, $rating, $review);
    $stmt->execute();
    $stmt->close();

    // Redirect to the same page after form submission
    header("Location: " . $_SERVER['PHP_SELF']); // Redirect to the current page
    exit(); // Make sure to call exit after header redirect
}

// Fetch reviews
$result = $con->query("SELECT * FROM reviews ORDER BY date DESC");
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review</title>
    <link rel="stylesheet" href="css/stylereview_user.css">
    <link rel="icon" href="img/mainicon.png" type="image/x-icon">
</head>
<body style="background-image: url('img/bgbooking.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center; background-color: #f5f6fa;">  
    <!-- Navigation Bar -->
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
            <li  class="active"><a href="user_review.php">Review</a></li>
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


    <!-- Main Content -->
    <div class="main-content">
      
        <!-- Display Reviews -->
        <div class="review-list">
            <h2>Recent Reviews</h2>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="review-item">
                    <p><strong><?php echo htmlspecialchars($row['name']); ?></strong> (<?php echo htmlspecialchars($row['rating']); ?>/5)</p>
                    <div class="star-rating-display">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="star <?php echo ($i <= $row['rating']) ? 'filled' : ''; ?>">★</span>
                        <?php endfor; ?>
                    </div>
                    <p><?php echo htmlspecialchars($row['review']); ?></p>
                    <p><small>Posted on: <?php echo htmlspecialchars($row['date']); ?></small></p>
                </div>
            <?php endwhile; ?>
        </div>
        <!-- Review Form -->
        <div class="review-form">
            <h2>Submit Your Review</h2>
            <form method="post" action="">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name"  required>

                <label for="rating">Rating:</label>
                <div class="star-rating">
                    <input type="radio" id="star5" name="rating" value="5" required>
                    <label for="star5" class="star">★</label>
                    <input type="radio" id="star4" name="rating" value="4" required>
                    <label for="star4" class="star">★</label>
                    <input type="radio" id="star3" name="rating" value="3" required>
                    <label for="star3" class="star">★</label>
                    <input type="radio" id="star2" name="rating" value="2" required>
                    <label for="star2" class="star">★</label>
                    <input type="radio" id="star1" name="rating" value="1" required>
                    <label for="star1" class="star">★</label>
                </div>

                <label for="review">Your Review:</label>
                <textarea id="review" name="review" rows="4" required><?php echo isset($review) ? htmlspecialchars($review) : ''; ?></textarea>

                <button type="submit">Submit Review</button>
            </form>
        </div>
    </div>
</body>
</html>
