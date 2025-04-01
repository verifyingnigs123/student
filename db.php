<?php
$host = "localhost";
$user = "root";  
$pass = "";   
$dbname = "student_registration"; 

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
