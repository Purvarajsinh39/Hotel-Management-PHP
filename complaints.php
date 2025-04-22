<?php
// Database connection
$host = "localhost";  
$user = "root";  
$password = '';  
$db_name = "hotel_management";  
$con = mysqli_connect($host, $user, $password, $db_name);  

// Check connection
if (mysqli_connect_errno()) {  
    die("Failed to connect with MySQL: ". mysqli_connect_error());  
}

// Handle Delete Request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Convert to integer for safety
    
    // Prepare SQL query to delete the complaint
    $stmt = $con->prepare("DELETE FROM complaint WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    
    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('Complaint deleted successfully');</script>";
        // Redirect to avoid form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Failed to delete complaint');</script>";
    }
}

// Fetch complaints from the database
$sql = "SELECT id, complainant_name, complaint_type, complaint FROM complaint";
$result = $con->query($sql);

// Close the connection after fetching
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaints</title>
    <link rel="stylesheet" href="css/stylecomplaints.css">
    <link rel="icon" href="img/mainicon.png" type="image/x-icon">
</head>
<body>
    <div class="sidebar">
        <div class="profile">
            <img src="img/profile-icon.png" alt="Profile Icon">
            <h3>Admin</h3>
            <p>Manager</p>
        </div>
        <ul>
            <li><a href="dashboard.php" style="text-decoration: none; color: #f8f9fa;">Dashboard</a></li>
            <li><a href="reservation.php" style="text-decoration: none; color: #f8f9fa;">Reservation</a></li>
            <li><a href="managerooms.php" style="text-decoration: none; color: #f8f9fa;">Manage Rooms</a></li>
            <li><a href="cust_details.php" style="text-decoration: none; color: #f8f9fa;">Customer Details</a></li>
            <li class="active"><a href="complaints.php" style="text-decoration: none; color: #f8f9fa;">Manage Complaints</a></li>
            <li><a href="review.php" style="text-decoration: none; color: #f8f9fa;">Manage Reviews</a></li>
            <li><a href="about_us.php" style="text-decoration: none; color: #f8f9fa;">About Us</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="user-menu">
                <a href="user_login.php">
                    <img src="img/user-icon.png" alt="User Menu">
                </a>
                <a href="login.php">
                    <img src="img/logout.png" alt="Logout">
                </a>
            </div>
        </div>

        <br><br>
        <!-- Complaint Management Table Section -->
        <div class="panel">
            <div class="panel-heading2">Complaint Management</div>
            <div class="panel-body">
                <!-- Complaints Table -->
                <table>
                    <thead>
                        <tr>
                            <th>Complainant Name</th>
                            <th>Complaint Type</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            // Output data for each row
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['complainant_name']}</td>
                                        <td>{$row['complaint_type']}</td>
                                        <td>{$row['complaint']}</td>
                                        <td>
                                            <a href='complaints.php?delete_id={$row['id']}' class='btn btn-danger'>
                                               Delete
                                            </a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No complaints found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
