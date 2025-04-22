<?php 
$host = "localhost";  
$user = "root";  
$password = '';  
$db_name = "hotel_management";  

// Establish database connection
$con = mysqli_connect($host, $user, $password, $db_name);  

if(mysqli_connect_errno()) {  
    die("Failed to connect with MySQL: " . mysqli_connect_error());  
}

// Modify the query to use appropriate conditions
$sql = "SELECT * FROM room WHERE status IS NULL AND deleteStatus = 0";
$query = $con->query($sql);

// Check if the query is successful
if ($query) {
    // Output number of rows
    echo  $query->num_rows;
} else {
    // Output error in case the query fails
    echo "Query failed: " . mysqli_error($con);
}
?>