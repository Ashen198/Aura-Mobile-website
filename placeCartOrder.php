<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "aura_mobile";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// Start database transaction processing
$conn->begin_transaction();

try {
    // 1. Copy everything over from cart_tb to orders_tb
    $copySql = "INSERT INTO orders_tb (product_id, product_name, price, color, capacity_desc, product_image, quantity) 
                SELECT product_id, product_name, price, color, capacity_desc, product_image, quantity 
                FROM cart_tb";
    
    if (!$conn->query($copySql)) {
        throw new Exception("Error compiling items into orders record: " . $conn->error);
    }

    // 2. Clear out the user's cart table
    $clearCartSql = "DELETE FROM cart_tb";
    if (!$conn->query($clearCartSql)) {
        throw new Exception("Error resetting active shopping cart: " . $conn->error);
    }

    // Commit changes safely if both statements succeed
    $conn->commit();
    
    echo "<script>alert('All cart orders successfully verified and placed!'); window.location.href='cartPage.php';</script>";

} catch (Exception $e) {
    // Fallback if an issue takes place
    $conn->rollback();
    echo "Transaction Failed: " . $e->getMessage();
}

$conn->close();
?>