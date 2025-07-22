<?php
// Database credentials
$host = "localhost";
$user = "root";       // change if needed
$password = "";       // your MySQL root password if set
$database = "spectrum_db";

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Uncomment for debugging
// echo "✅ Database connected successfully!";
?>
