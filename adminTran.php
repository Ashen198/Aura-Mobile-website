<?php
// Establish connection to read user purchase history
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "aura_mobile";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// Fetch all customer orders sorted from newest to oldest
$sql = "SELECT * FROM orders_tb ORDER BY order_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Item Listing Dashboard</title>
<link rel="stylesheet" href="CSS/adActive.css">


<style>
        /* Custom pure CSS styling to maintain structural layout without external frameworks */
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
            text-align: center;
        }
        /* Style statuses distinctly based on state */
        .status-placed {
            background-color: #ffeaa7;
            color: #d63031;
        }
        .status-shipped {
            background-color: #74b9ff;
            color: #0984e3;
        }
        .status-delivered {
            background-color: #55efc4;
            color: #00b894;
        }
        .transaction-table th, .transaction-table td {
            padding: 12px 15px;
            text-align: left;
        }
        .prod-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .prod-cell img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>

<body>

<div class="container">

    <!-- Sidebar -->
    <div class="sidebar">

        <div class="logo">
            <img src="rsc/logo.jpeg" alt="Logo">
        </div>



        <a href="adminItem.html" class="menu-btn">List an item</a>

        <a href="adminActive.php" class="menu-btn">Update item</a>

        <a href="adminOrders.php" class="menu-btn">Orders</a>

        <a href="adminTran.php" class="menu-btn">Transaction</a>

        <a href="adminAnalysis.html" class="menu-btn">Analysis</a>

         <a href="loginPage.html" class="menu-btn">Log Out</a>

    </div>


    <!-- Main Content -->
    <div class="main">

        <h2>Transactions</h2>


        <table class="transaction-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Date Ordered</th>
                            <th>Delivery Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // 1. Read individual rows from your table scheme
                                $product_name = $row['product_name'];
                                $quantity = intval($row['quantity']);
                                $price = floatval($row['price']);
                                $product_image = $row['product_image'];
                                $order_status = $row['order_status'];
                                
                                // Calculate cumulative line cost itemization
                                $total_calculated_price = $price * $quantity;
                                $formatted_date = date("d/m/Y", strtotime($row['order_date']));

                                // 2. Map tracking column string dynamically to corresponding badge CSS logic
                                $badge_class = "status-placed";
                                if ($order_status == "Shipped") {
                                    $badge_class = "status-shipped";
                                } elseif ($order_status == "Delivered") {
                                    $badge_class = "status-delivered";
                                }
                                ?>
                                <tr>
                                    <td>
                                        <div class="prod-cell">
                                            <img src="<?php echo htmlspecialchars($product_image); ?>" alt="Item Image">
                                            <div>
                                                <strong><?php echo htmlspecialchars($product_name); ?></strong><br>
                                                <small style="color:#777;"><?php echo htmlspecialchars($row['color']); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo $quantity; ?></td>
                                    <td>LKR <?php echo number_format($total_calculated_price, 2); ?></td>
                                    <td><?php echo $formatted_date; ?></td>
                                    <td>
                                        <span class="status-badge <?php echo $badge_class; ?>">
                                            <?php echo htmlspecialchars($order_status); ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='5' style='text-align:center; padding:20px;'>You have not placed any orders yet.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

    </div>

</div>

</body>
</html>

<?php 
$conn->close(); 
?>