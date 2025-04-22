<?php
session_start();

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$db_name = "hotel_management";

$con = mysqli_connect($host, $user, $password, $db_name);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get room ID and payment amount from the URL
$room_id = intval($_GET['room_id']);
$payment_amount = floatval($_GET['payment_amount']);

// Update booking status to paid (set payment_status to 1)
$update_payment_query = "UPDATE booking SET remaining_price = 0, payment_status = 1 WHERE room_id = ?";
$stmt = $con->prepare($update_payment_query);
$stmt->bind_param("i", $room_id);

if ($stmt->execute()) {
    // Update room status to available and not checked in
    $update_room_query = "UPDATE room SET status = NULL, check_in_status = 0 WHERE room_id = ?";
    $stmt_room = $con->prepare($update_room_query);
    $stmt_room->bind_param("i", $room_id);
    
    if ($stmt_room->execute()) {
        $_SESSION['message'] = 'Payment Successful, Check-out Completed';
        header("Location: managerooms.php");
        exit();
    } else {
        error_log("Error updating room status: " . $stmt_room->error);
        echo "<script>alert('Error updating room status: " . $stmt_room->error . "');</script>";
    }
    $stmt_room->close();
} else {
    error_log("Error updating payment: " . $stmt->error);
    echo "<script>alert('Error updating payment: " . $stmt->error . "');</script>";
}

// Close the database connection
mysqli_close($con);
?>
