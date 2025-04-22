<?php 
      $host = "localhost";  
      $user = "root";  
      $password = '';  
      $db_name = "hotel_management";  
    $con = mysqli_connect($host, $user, $password, $db_name);  
    
    if(mysqli_connect_errno()) {  
        die("Failed to connect with MySQL: ". mysqli_connect_error());  
    }  
    $sql = "SELECT * FROM room WHERE check_in_status = '1'";
    $query = $con->query($sql);

    echo "$query->num_rows";

?>