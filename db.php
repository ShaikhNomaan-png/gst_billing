<?php
$servername = "localhost";
$username = "root";   // Default MySQL username
$password = "";       // Default MySQL password (empty for XAMPP)
$dbname = "gst_billing";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
