<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'db_config.php';

$sql = "CREATE TABLE IF NOT EXISTS cart_tb (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    color VARCHAR(50),
    capacity_desc TEXT,
    product_image VARCHAR(255),
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "<h1>Success!</h1>";
    echo "<p>Table <strong>cart_tb</strong> has been created successfully (or already exists).</p>";
    echo "<p><a href='productPage.php'>Go back to Products</a></p>";
} else {
    echo "<h1>Error</h1>";
    echo "<p>Error creating table: " . $conn->error . "</p>";
}

$conn->close();
?>
