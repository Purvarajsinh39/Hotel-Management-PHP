<?php
// Database connection
$host = "localhost";  
$user = "root";  
$password = '';  
$db_name = "hotel_management";
$conn = mysqli_connect($host, $user, $password, $db_name);  

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete review functionality
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $deleteSql = "DELETE FROM reviews WHERE id = $id";
    $conn->query($deleteSql);
}

// Fetch reviews
$sql = "SELECT * FROM reviews";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reviews</title>
    <link rel="stylesheet" href="css/stylereview.css">
    <link rel="icon" href="img/mainicon.png" type="image/x-icon">
</head>
<body>
    <div class="sidebar">
        <div class="profile">
            <img src="img/profile-icon.png" alt="Profile">
            <h3>Admin</h3>
            <p>Manager</p>
        </div>
        <ul>
            <li><a href="dashboard.php" style="text-decoration: none; color: #f8f9fa;">Dashboard</a></li>
            <li><a href="reservation.php" style="text-decoration: none; color: #f8f9fa;">Reservation</a></li>
            <li><a href="managerooms.php" style=  "text-decoration: none; color: #f8f9fa;">Manage Rooms</a></li>
            <li><a href="cust_details.php" style="text-decoration: none; color: #f8f9fa;">Customer Details</a></li>
            <li><a href="complaints.php" style="text-decoration: none; color: #f8f9fa;">Manage Complaints</a></li>
            <li class="active"><a href="review.php" style="text-decoration: none; color: #f8f9fa;">Manage Reviews</a></li>
            <li><a href="about_us.php" style="text-decoration: none; color: #f8f9fa;">About Us</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="user-menu">
                <a href="user_login.php">
                    <img src="img/user-icon.png" alt="User Menu" title="user">
                </a>
                <a href="login.php">
                    <img src="img/logout.png" alt="User Menu" title="logout">
                </a>
            </div>
        </div>
        <br><br>
        <div class="panel">
            <div class="panel-heading2"><h3>Manage Reviews</h3></div>
            <div class="panel-body"></div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Rating</th>
                    <th>Review</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['rating']); ?></td>
                            <td><?php echo htmlspecialchars($row['review']); ?></td>
                            <td><?php echo htmlspecialchars($row['date']); ?></td>
                            <td>
    <a href="?delete=<?php echo $row['id']; ?>" 
       class="btn btn-danger" 
    >Delete</a>
</td>

                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No reviews found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>