<?php 
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
    if ($totalSum === null) {
        echo "Total Price: 0"; // or handle it however you wish
    } else {
        echo "Total Price: " . $totalSum;
    }

    // Close the connection
    mysqli_close($con);
?>
