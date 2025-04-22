<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details</title>
    <link rel="stylesheet" href="css/stylecust_details.css">
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
            <li class="active"><a href="cust_details.php" style="text-decoration: none; color: #f8f9fa;">Customer Details</a></li>
            <li><a href="complaints.php" style="text-decoration: none; color: #f8f9fa;">Manage Complaints</a></li>
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
        <!-- Customer Details Table Section -->
        <div class="panel">
            <h1>Customer Details</h1>
            <?php
            // Database connection details
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "hotel_management"; // Replace with your database name

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch customer data
            $sql = "SELECT * FROM customer";
            $result = $conn->query($sql);

            if ($result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Customer ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>ID Card Type</th>
                            <th>ID Card Number</th>
                            <th>Residential Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['customer_id']); ?></td>
                                <td><?= htmlspecialchars($row['first_name']); ?></td>
                                <td><?= htmlspecialchars($row['last_name']); ?></td>
                                <td><?= htmlspecialchars($row['email']); ?></td>
                                <td><?= htmlspecialchars($row['contact']); ?></td>
                                <td><?= htmlspecialchars($row['id_card_type']); ?></td>
                                <td><?= htmlspecialchars($row['id_card_number']); ?></td>
                                <td><?= htmlspecialchars($row['residential_address']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No customer records found.</p>
            <?php endif;

            // Close connection
            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
