<?php
// Enable error reporting to catch any issues
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session to manage state
session_start();

// Database connection
$host = "localhost";  
$user = "root";  
$password = '';  
$db_name = "hotel_management";  
$connection = mysqli_connect($host, $user, $password, $db_name);  

if (mysqli_connect_errno()) {  
    die("Failed to connect with MySQL: " . mysqli_connect_error());  
}

// Check for check-in or check-out requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['check_in'])) {
        $room_id = intval($_POST['room_id']);
        
        // Use prepared statements to prevent SQL injection
        $check_in_query = "UPDATE room SET check_in_status = 1, status = 1 WHERE room_id = ?";
        $stmt = $connection->prepare($check_in_query);
        $stmt->bind_param("i", $room_id);

        if ($stmt->execute()) {
            // Set a session variable for success message
            $_SESSION['message'] = 'Check-in Successful';
            // Redirect to prevent resubmission
            header("Location: managerooms.php");
            exit();
        } else {
            echo "<script>alert('Error during check-in: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    }

    if (isset($_POST['check_out'])) {
        $room_id = intval($_POST['room_id']);

        // Fetch booking details securely
        $booking_query = "SELECT total_price, remaining_price FROM booking WHERE room_id = ? AND payment_status = 0";
        $stmt = $connection->prepare($booking_query);
        $stmt->bind_param("i", $room_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $booking = $result->fetch_assoc();

        // Check if there is remaining payment
        if ($booking && $booking['remaining_price'] > 0) {
            // Show payment prompt
            echo "<script>
                var remainingPrice = " . htmlspecialchars($booking['remaining_price']) . ";
                var paymentAmount = prompt('Outstanding payment: $' + remainingPrice + '. Please enter the payment amount:');
                if (paymentAmount != null && paymentAmount != '') {
                    paymentAmount = parseFloat(paymentAmount);
                    if (paymentAmount >= remainingPrice) {
                        window.location.href='process_payment.php?room_id=" . $room_id . "&payment_amount=' + paymentAmount;
                    } else {
                        alert('Insufficient payment amount. Please try again.');
                    }
                }
            </script>";
        } else {
            // Complete checkout if no remaining payment
            $check_out_query = "UPDATE room SET status = NULL, check_in_status = 0 WHERE room_id = ?"; // Set status to 0 for available
            $stmt = $connection->prepare($check_out_query);
            $stmt->bind_param("i", $room_id);

            if ($stmt->execute()) {
                $_SESSION['message'] = 'Check-out Successful';
                header("Location: managerooms.php");
                exit();
            } else {
                echo "<script>alert('Error during check-out: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        }
    }
}

// Display success messages from session and clear it
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']); // Clear the message after displaying it
}

// Fetch all rooms to display
$room_query = "SELECT * FROM room NATURAL JOIN room_type WHERE deleteStatus = 0";
$rooms_result = mysqli_query($connection, $room_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rooms</title>
    <link rel="stylesheet" href="css/stylemanagerooms.css">
    <link rel="icon" href="img/mainicon.png" type="image/x-icon">
</head>
<body>
    <div class="sidebar">
        <div class="profile">
            <img src="img/profile-icon.png" alt="Profile">
            <h3>Admin</h3>
            <p>Manager</p>
        </div>
        <ul style="text-decoration: none; color: #f8f9 fa;">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="reservation.php">Reservation</a></li>
            <li class="active"><a href="managerooms.php">Manage Rooms</a></li>
            <li><a href="cust_details.php" style="text-decoration: none; color: #f8f9fa;">Customer Details</a></li>
            <li><a href="complaints.php">Manage Complaints</a></li>
            <li><a href="review.php" style="text-decoration: none; color: #f8f9fa;">Manage Reviews</a></li>
            <li><a href="about_us.php">About Us</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="user-menu">
                <a href="user_login.php"><img src="img/user-icon.png" alt="User Menu" title="user"></a>
                <a href="login.php"><img src="img/logout.png" alt="User Menu" title="logout"></a>
            </div>
        </div>

        <div class="container">
            <div class="header">
                <h1>Manage Rooms</h1>
            </div><br>

            <div class="room-details">
                <div class="table-header">
                    <h3>Manage Rooms</h3>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Room No</th>
                            <th>Room Type</th>
                            <th>Booking Status</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($rooms_result) > 0) {
                            while ($rooms = mysqli_fetch_assoc($rooms_result)) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($rooms['room_no']); ?></td>
                                    <td><?php echo htmlspecialchars($rooms['room_type']); ?></td>
                                    <td>
                                        <?php
                                        if ($rooms['status'] == 0) {
                                            echo '<a href="reservation.php?room_id=' . $rooms['room_id'] . '&room_type_id=' . $rooms['room_type_id'] . '" class="btn">Book Room</a>';
                                        } else {
                                            echo '<span class="text-danger">Booked</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($rooms['check_in_status'] == 0 && $rooms['status'] == 1) {
                                            echo '<form method="POST" action="managerooms.php" style="display:inline;">
                                                <input type="hidden" name="room_id" value="' . $rooms['room_id'] . '">
                                                <button type="submit" name="check_in" class="btn">Check In</button>
                                                </form>';
                                        } elseif ($rooms['status'] == 0) {
                                            echo '-';
                                        } else {
                                            echo '<span class="text-danger">Checked In</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($rooms['check_in_status'] == 1 && $rooms['status'] == 1) {
                                            echo '<form method="POST" action="managerooms.php" style="display:inline;">
                                                <input type="hidden" name="room_id" value="' . $rooms['room_id'] . '">
                                                <button type="submit" name="check_out" class="btn">Check Out</button>
                                                </form>';
                                        } elseif ($rooms['status'] == 0) {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php }
                        } else {
                            echo "<tr><td colspan='5'>No Rooms Available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
    // Close database connection
    mysqli_close($connection);
    ?>
</body>
</html>
