<?php
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
    echo "Table cart_tb created successfully or already exists";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
