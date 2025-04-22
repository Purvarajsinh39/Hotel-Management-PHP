<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/styledashboard.css">
    <link rel="icon" href ="img/mainicon.png"type ="image/x-icon">
</head>
<body>
    <div class="sidebar">
        <div class="profile">
            <img src="img/profile-icon.png" alt="Profile">
            <h3>Admin</h3>
            <p>Manager</p>
        </div>
        <ul>
            <li class="active"> <a href="dashboard.php" style="text-decoration: none; color: #f8f9fa;">Dashboard</a></li>
            <li><a href="reservation.php" style="text-decoration: none; color: #f8f9fa;">Reservation</a></li>
            <li><a href="managerooms.php" style="text-decoration: none; color: #f8f9fa;">Manage Rooms</a></li>
            <li><a href="cust_details.php" style="text-decoration: none; color: #f8f9fa;">Customer Details</a></li>
            <li><a href="complaints.php" style="text-decoration: none; color: #f8f9fa;">Manage Complaints</a></li>
            <li><a href="review.php" style="text-decoration: none; color: #f8f9fa;">Manage Reviews</a></li>
            <li><a href="about_us.php" style="text-decoration: none; color: #f8f9fa;">About Us</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>HOTEL MANAGEMENT SYSTEM</h1>
            <div class="user-menu">
                <!-- <img src="img/user-icon.png" alt="User Menu"> -->
                <a href="user_login.php">
                <img src="img/user-icon.png" alt="User Menu" title="user">
            <a href="login.php">
                <img src="img/logout.png" alt="User Menu" title="logout">
            </a>
            </div>
        </div>

        <div class="dashboard">
            <div class="dashboard-cards">
                <div class="card">
                    <img src="img/total-rooms-icon.png" alt="Total Rooms">
                    <h3><?php include 'counters/room-count.php'?></h3>
                    <p>Total Rooms</p>
                </div>
                <!-- <div class="card">
                    <img src="img/reservations-icon.png" alt="Reservations">
                    <h3><?php include 'counters/reserve-count.php'?></h3>
                    <p>Reservations</p>
                </div> -->
                <div class="card">
                    <img src="img/complaints-icon.png" alt="Complaints">
                    <h3><?php include 'counters/complaints-count.php'?></h3>
                    <p>Complaints</p>
                </div>
                <div class="card">
                    <img src="img/booked-rooms-icon.png" alt="Booked Rooms">
                    <h3><?php include 'counters/bookedroom-count.php'?></h3>
                    <p>Booked Rooms</p>
                </div>
                <div class="card">
                    <img src="img/available-rooms-icon.png" alt="Available Rooms">
                    <h3><?php include 'counters/avrooms-count.php'?></h3>	
                    <p>Available Rooms</p>
                </div>
                <div class="card">
                    <img src="img/checked-in-icon.png" alt="Checked In">
                    <h3><?php include 'counters/checkedin-count.php'?></h3>
                    <p>Checked In</p>
                </div>
                <!-- <div class="card">
                    <img src="img/pending-payments-icon.png" alt="Pending Payments">
                    <h3><?php include 'counters/pendingpay-count.php'?></h3>
                    <p>Total Pending Payments</p>
                </div> -->
                <div class="card">
    <img src="img/total-earnings-icon.png" alt="Total Earnings">
    <h3>
        Rs.
        <?php 
            // Database connection and query for total earnings
            $host = "localhost";  
            $user = "root";  
            $password = '';  
            $db_name = "hotel_management";  

            // Create connection
            $con = mysqli_connect($host, $user, $password, $db_name);  
            
            // Check connection
            if(mysqli_connect_errno()) {  
                die("Failed to connect with MySQL: ". mysqli_connect_error());  
            }  

            // SQL query to sum total_price where payment_status is '1'
            $sql = "SELECT SUM(total_price) AS total_sum FROM booking WHERE payment_status = '1'";
            
            // Execute the query
            $result = mysqli_query($con, $sql) or die(mysqli_error($con));

            // Fetch the result
            $row = mysqli_fetch_assoc($result);
            $totalSum = $row['total_sum'];

            // Display the total sum
            echo $totalSum !== null ? $totalSum : 0;

            // Close the connection
            mysqli_close($con);
        ?>
    </h3>
    <p>Total Earnings</p>
</div>

                <!-- <div class="card">
                    <img src="img/total-earnings-icon.png" alt="Total Earnings">
                    <h3>Rs.<?php include 'counters/income-count.php'?></h3>
                    <p>Total Earnings</p>
                </div> -->
                <!-- <div class="card">
                    <img src="img/pending-payment-icon.png" alt="Pending Payment">
                    <h3>Rs.<?php include 'counters/pendingpayment.php'?></h3>
                    <p>Pending Payment</p>
                </div> -->
            </div>
        </div>
    </div>
</body>
</html>
