<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$db_name = "hotel_management";

$con = mysqli_connect($host, $user, $password, $db_name);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['room_type_id'])) {
    $room_type_id = $_GET['room_type_id'];

    // Fetch available room numbers based on selected room type
    $query  = "SELECT room_no FROM room WHERE room_type_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $room_type_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $rooms = [];
    while ($room = $result->fetch_assoc()) {
        $rooms[] = $room;
    }

    // Return the room numbers as a JSON response
    echo json_encode($rooms);
}

// Close the database connection
mysqli_close($con);
?>
