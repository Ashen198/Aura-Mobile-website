<?php
// updateStatus.php
$servername = "localhost"; $username = "root"; $password = ""; $dbname = "aura_mobile";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);
    
    // Update the tracking status to Delivered
    $stmt = $conn->prepare("UPDATE orders_tb SET order_status = 'Delivered' WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    
    if ($stmt->execute()) {
        header("Location: adminOrders.php");
    } else {
        echo "Error updating status: " . $conn->error;
    }
    $stmt->close();
}
$conn->close();
?>