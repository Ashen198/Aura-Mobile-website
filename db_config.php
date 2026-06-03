<?php
$servername = "localhost";
$username = "root";     
$password = "";         
$dbname = "aura_mobile"; // Matched exactly to your screenshot

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>