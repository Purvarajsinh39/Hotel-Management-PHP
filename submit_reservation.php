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

// Fetch form data
$room_type_id = $_POST['room_type_id'];
$room_no = $_POST['room_no'];
$check_in = $_POST['check_in'];
$check_out = $_POST['check_out'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$contact = $_POST['contact'];
$id_card_type = $_POST['id_card_type'];
$id_card_number = $_POST['id_card_number'];
$residential_address = $_POST['residential_address'];

// Calculate total days between check-in and check-out
$check_in_date = new DateTime($check_in);
$check_out_date = new DateTime($check_out);
$interval = $check_in_date->diff($check_out_date);
$total_days = $interval->days;

if ($total_days <= 0) {
    echo "<script>alert('Invalid dates. Check-out date must be after check-in date.');</script>";
    exit;
}

// Fetch room price based on room type
$query_price = "SELECT price FROM room_type WHERE room_type_id = ?";
$stmt_price = $con->prepare($query_price);
$stmt_price->bind_param("i", $room_type_id);
$stmt_price->execute();
$result_price = $stmt_price->get_result();

if ($result_price->num_rows > 0) {
    $row = $result_price->fetch_assoc();
    $room_price = $row['price'];
    $total_amount = $room_price * $total_days;
} else {
    echo "<script>alert('Room type not found.');</script>";
    exit;
 }

// Fetch room_id from room table using room_no
$query_room = "SELECT room_id FROM room WHERE room_no = ? AND room_type_id = ?";
$stmt_room = $con->prepare($query_room);
$stmt_room->bind_param("si", $room_no, $room_type_id);
$stmt_room->execute();
$result_room = $stmt_room->get_result();

if ($result_room->num_rows > 0) {
    $room_row = $result_room->fetch_assoc();
    $room_id = $room_row['room_id'];
} else {
    echo "<script>alert('Room not found for room_no: $room_no');</script>";
    exit;
}

// Check if customer already exists
$query_customer = "SELECT customer_id FROM customer WHERE email = ?";
$stmt_customer = $con->prepare($query_customer);
$stmt_customer->bind_param("s", $email);
$stmt_customer->execute();
$result_customer = $stmt_customer->get_result();

if ($result_customer->num_rows > 0) {
    // Customer exists, fetch their ID
    $customer_row = $result_customer->fetch_assoc();
    $customer_id = $customer_row['customer_id'];
} else {
    // Insert new customer
    $insert_customer = "INSERT INTO customer (first_name, last_name, email, contact, id_card_type, id_card_number, residential_address) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert_customer = $con->prepare($insert_customer);
    $stmt_insert_customer->bind_param("sssssss", $first_name, $last_name, $email, $contact, $id_card_type, $id_card_number, $residential_address);
    
    if ($stmt_insert_customer->execute()) {
        $customer_id = $stmt_insert_customer->insert_id;
    } else {
        echo "<script>alert('Error inserting customer: " . mysqli_error($con) . "');</script>";
        exit;
    }
}

// Insert reservation into booking table
$query_booking = "INSERT INTO booking (customer_id, room_id, check_in, check_out, total_price, remaining_price, payment_status) 
                  VALUES (?, ?, ?, ?, ?, ?, 0)"; // 0 = unpaid
$stmt_booking = $con->prepare($query_booking);
$stmt_booking->bind_param("iissii", $customer_id, $room_id, $check_in, $check_out, $total_amount, $total_amount);

if ($stmt_booking->execute()) {
    // Update room status to booked
    $update_room_query = "UPDATE room SET status = 1, check_in_status = 1 WHERE room_id = ?";
    $stmt_update_room = $con->prepare($update_room_query);
    $stmt_update_room->bind_param("i", $room_id);
    $stmt_update_room->execute();
    $stmt_update_room->close();

    $message = "Reservation successfully submitted! Total Amount: $" . $total_amount;
    echo "<script>alert('$message');window.location.href = 'reservation.php';</script>";
} else {
    $error_message = "Error: " . mysqli_error($con);
    echo "<script>alert('$error_message');</script>";
}

// Close the database connection
mysqli_close($con);
?>