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

    // SQL query to sum total_price where payment_status is '0'
    $sql = "SELECT SUM(total_price) AS total_sum FROM booking WHERE payment_status = '0'";
    
    // Execute the query
    $amountsum = mysqli_query($con, $sql) or die(mysqli_error($con));
    
    // Fetch the result
    // $row_amountsum = mysqli_fetch_assoc($amountsum);
    
    // // Output the result
    // echo $row_amountsum['total_sum'];

    // Close the connection
    mysqli_close($con);
?>
