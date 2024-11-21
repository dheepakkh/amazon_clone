<?php
try {
    $con = mysqli_connect("localhost", "root", "MySQL@1754", "e_com");
    
    // Check connection
    if (mysqli_connect_errno()) {
        throw new Exception("Failed to connect to MySQL: " . mysqli_connect_error());
    }
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}
?>



