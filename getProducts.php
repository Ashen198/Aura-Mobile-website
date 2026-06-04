<?php
// Force error reporting on to catch hidden typos
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

$servername = "localhost";
$username = "root";       
$password = "";           
$dbname = "aura_mobile";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

// Select the exact columns visible in your phpMyAdmin table structure
$sql = "SELECT pname, pprice, pstock, pdesc, pimage FROM product_tb";
$result = $conn->query($sql);

$products = [];

if ($result) {
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $products[] = [
                "name" => $row['pname'],
                "price" => $row['pprice'],
                "stock" => $row['pstock'],
                "description" => $row['pdesc'],
                "image" => $row['pimage'] 
            ];
        }
    }
    // Return clean JSON array
    echo json_encode($products);
} else {
    // If the SQL query itself breaks, show the exact reason why
    echo json_encode(["status" => "error", "message" => "SQL Query Failed: " . $conn->error]);
}

$conn->close();
?>