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

// Insert complaint logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Secure the input to prevent SQL injection
    $complainant_name = mysqli_real_escape_string($con, $_POST['complainant_name']);
    $complaint_type = mysqli_real_escape_string($con, $_POST['complaint_type']);
    $complaint = mysqli_real_escape_string($con, $_POST['complaint']);
    
    // SQL query to insert data
    $sql = "INSERT INTO complaint (complainant_name, complaint_type, complaint) 
            VALUES ('$complainant_name', '$complaint_type', '$complaint')";
    
    // Execute the query
    if ($con->query($sql) === TRUE) {
        echo "<script>alert('Your complaint has been submitted');</script>";
        // Redirect to avoid form resubmission
        header("Refresh:0; url=" . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Failed to submit complaint');</script>";
    }
}

// Close the connection
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints</title>
    <link rel="stylesheet" href="css/stylecomplaints_user.css">
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
            <li class="active"><a href="user_complaints.php">Complaints</a></li>
            <li><a href="user_gallery.php">Gallery</a></li>
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
    <br><br>
    <!-- Main Content -->
    <div class="main-content">
        <!-- Complaint Form Section -->
        <div class="panel">
            <div class="panel-heading" style="text-align:center;">Make Complaint</div>
            <div class="panel-body">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="form-group">
                        <label for="complainant_name">Complainant Name</label>
                        <input type="text" id="complainant_name" name="complainant_name" placeholder="Complainant Name" required>
                    </div>

                    <div class="form-group">
                        <label for="complaint_type">Complaint Type</label>
                        <input type="text" id="complaint_type" name="complaint_type" placeholder="Complaint Type" required>
                    </div>

                    <div class="form-group">
                        <label for="complaint">Please Describe Your Complaints</label>
                        <textarea id="complaint" name="complaint" rows="4" placeholder="Complaint" required></textarea>
                    </div>

                    <div class="btn-container">
                        <input type="submit" class="btn-success" name="submit" value="Submit Complaint">
                        <input type="reset" class="btn-danger" value="Reset">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
