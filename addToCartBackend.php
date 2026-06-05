<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root"; 
    $password = ""; 
    $dbname = "aura_mobile";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }

    $product_id = intval($_POST['product_id']);
    $product_name = $_POST['product_name'];
    $price = floatval(str_replace(',', '', $_POST['product_price']));
    $color = $_POST['color'];
    $qty = intval($_POST['qty']);
    $product_img = $_POST['product_img'];
    
    $capacity = $_POST['capacity'];
    $description = $_POST['product_desc'];
    $combined_capacity_desc = "Capacity: " . $capacity . " | Description: " . $description;

    $stmt = $conn->prepare("INSERT INTO cart_tb (product_id, product_name, price, color, capacity_desc, product_image, quantity) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isdsssi", $product_id, $product_name, $price, $color, $combined_capacity_desc, $product_img, $qty);

    if ($stmt->execute()) {
        header("Location: cartPage.php");
    } else {
        echo "Error adding item to cart: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: productPage.php");
    exit();
}
?>