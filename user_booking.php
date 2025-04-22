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
    <title>Booking</title>
    <link rel="stylesheet" href="css/stylereservation_user.css">
    <link rel="icon" href="img/mainicon.png" type="image/x-icon">
    <script>
        function fetchRoomNumbers() {
            var roomTypeId = document.getElementById('room-type').value;

            // Create a new XMLHttpRequest
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "fetch_rooms.php?room_type_id=" + roomTypeId, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var roomNoDropdown = document.getElementById('room-no');
                    roomNoDropdown.innerHTML = ""; // Clear previous options

                    // Parse the JSON response
                    var rooms = JSON.parse(xhr.responseText);
                    rooms.forEach(function(room) {
                        var option = document.createElement("option");
                        option.value = room.room_no;
                        option.textContent = room.room_no;
                        roomNoDropdown.appendChild(option);
                    });
                }
            };
            xhr.send();
        }
    </script>
</head>

<body style="background-image: url('img/bgbooking.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center; background-color: #f5f6fa;">

    <!-- Updated Navbar -->
    <div class="navbar">
        <div class="profile">
            <img src="img/profile-icon.png" alt="Profile Icon">
            <h3><?php echo htmlspecialchars($username); ?></h3>
        </div>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li class="active"><a href="user_booking.php">Booking</a></li>
            <li><a href="user_complaints.php">Complaints</a></li>
            <li><a href="user_gallery.php">Gallery</a></li>
            <li><a href="user_review.php">Review</a></li>
            <li><a href="user_about_us.php">About Us</a></li>
        </ul>
        <div class="user-menu">
            <a href="user_login.php">
                <img src="img/logout.png" alt="Logout Icon" title="Logout">
            </a>
            <a href="login.php">
                <img src="img/user-icon.png" alt="Admin Icon" title="Admin">
            </a>
        </div>
    </div>

    <div class="main-content">
        <!-- Rest of the content -->
        <div class="reservation-section">
            <h2>Room Information :</h2>
            <form action="user_submit_reservation.php" method="POST">
                <div class="room-info">
                    <div class="form-group">
                        <label for="room-type">Room Type</label>
                        <select id="room-type" name="room_type_id" required onchange="fetchRoomNumbers()">
                            <option selected disabled>Select Room Type</option>
                            <?php
                            // Database connection
                            $host = "localhost";  
                            $user = "root";  
                            $password = '';  
                            $db_name = "hotel_management";  
                            $con = mysqli_connect($host, $user, $password, $db_name);  
                            
                            if (mysqli_connect_errno()) {  
                                die("Failed to connect with MySQL: " . mysqli_connect_error());  
                            }  

                            // Fetch room types
                            $query  = "SELECT * FROM room_type";
                            $result = mysqli_query($con, $query);
                            if (mysqli_num_rows($result) > 0) {
                                while ($room_type = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $room_type['room_type_id'] . '">' . $room_type['room_type'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="room-no">Room No</label>
                        <select id="room-no" name="room_no" required>
                            <option selected disabled>Select Room No</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="check-in">Check In Date</label>
                        <input type="date" id="check-in" name="check_in" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="check-out">Check Out Date</label>
                        <input type="date" id="check-out" name="check_out" required>
                    </div>
                </div>

                <h2>Customer Detail :</h2>
                <div class="customer-info">
                    <div class="form-group">
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" name="last_name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="contact">Contact Number</label>
                        <input type="text" id="contact" name="contact" required>
                    </div>
                    <div class="form-group">
                        <label for="id-card-type">ID Card Type</label>
                        <select id="id-card-type" name="id_card_type" required>
                            <option selected disabled>Select ID Card Type</option>
                            <?php
                            // Fetch ID card types
                            $query  = "SELECT * FROM id_card_type";
                            $result = mysqli_query($con, $query);
                            if (mysqli_num_rows($result) > 0) {
                                while ($id_card_type = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $id_card_type['id_card_type_id'] . '">' . $id_card_type['id_card_type'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="id-card-number">ID Card Number</label>
                        <input type="text" id="id-card-number" name="id_card_number" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="residential-address">Residential Address</label>
                        <input type="text" id="residential-address" name="residential_address" required>
                    </div>
                </div>

                <button class="submit-btn" type="submit">Submit</button>
            </form>
        </div>
    </div>
    <?php
    // Close database connection
    mysqli_close($con);
    ?>
</body>
</html>
