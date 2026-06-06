<?php
// Establish connection to read orders
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "aura_mobile";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// Fetch all orders sorted by newest date
$sql = "SELECT * FROM orders_tb ORDER BY order_date DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Item Listing Dashboard</title>
<link rel="stylesheet" href="CSS/adOrders.css">
</head>

<body>

<div class="container">

    <div class="sidebar">
        <div class="logo">
            <img src="rsc/logo.jpeg" alt="Logo">
        </div>
        <a href="adminItem.html" class="menu-btn">List an item</a>
        <a href="adminActive.php" class="menu-btn">Update item</a>
        <a href="adminOrders.php" class="menu-btn">Orders</a>
        <a href="adminTran.html" class="menu-btn">Transaction</a>
        <a href="adminAnalysis.html" class="menu-btn">Analysis</a>
        <a href="loginPage.html" class="menu-btn">Log Out</a>
    </div>

    <div class="main">
        <h2>Orders</h2>
        <div class="item-list">

        <?php
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Break down date formatting
                $formatted_date = date("m/d/Y", strtotime($row['order_date']));
                ?>
                <div class="item-card">
                    <img src="<?php echo htmlspecialchars($row['product_image']); ?>" alt="product image">
                    <div class="item-details">
                        <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>
                        <p><strong>Order ID:</strong> #<?php echo $row['order_id']; ?></p>
                        <p><strong>Details:</strong> <?php echo htmlspecialchars($row['capacity_desc']); ?></p>
                        <p><strong>Color:</strong> <?php echo htmlspecialchars($row['color']); ?></p>
                        <p><strong>Qty:</strong> <?php echo $row['quantity']; ?> | <strong>Total:</strong> LKR <?php echo number_format(($row['price'] * $row['quantity']), 2); ?></p>
                        <p><strong>Date:</strong> <?php echo $formatted_date; ?></p>
                    </div>

                    <div class="item-actions">
                      <?php 
                         // If the database row is already marked as Delivered, show the static badge
                         if (isset($row['order_status']) && $row['order_status'] === 'Delivered') {
                             ?>
                             <span class="delivered-badge">Delivered</span>
                             <?php 
                         } else { 
                             // Otherwise, show the active button wrapped in a form pointing to your updateStatus.php
                             ?>
                             <form action="updateStatus.php" method="POST" style="margin: 0; padding: 0;">
                                 <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                 <button type="submit" class="deliver">Deliver</button>
                             </form>
                             <?php 
                         } 
                         ?>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p style='padding: 20px;'>No active orders found.</p>";
        }
        $conn->close();
        ?>

        </div>
    </div>
</div>

</body>
</html>