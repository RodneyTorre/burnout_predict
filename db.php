<?php
$host = "localhost";
$user = "root";        // default XAMPP user
$password = "";        // default is empty
$database = "burnout_predict";

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional success message
// echo "Connected successfully";
?>