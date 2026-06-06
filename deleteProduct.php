<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aura_mobile";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit();
}

// Listen for incoming dynamic POST requests containing a product ID
if (isset($_POST['pid'])) {
    $pid = intval($_POST['pid']);
    
    // Using a prepared statement to prevent SQL injection errors
    $stmt = $conn->prepare("DELETE FROM product_tb WHERE pid = ?");
    $stmt->bind_param("i", $pid);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Product removed successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete item: " . $conn->error]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "No product ID specified"]);
}

$conn->close();
?>