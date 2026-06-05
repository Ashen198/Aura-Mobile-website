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
    <link rel="stylesheet" href="CSS/paymentStyle.css">
    <title>Payment Aura - History & Tracking</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    
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
    <div class="header">
        <div class="searchlogo">
            <div class="left-logo">
               <a href="homePage.html"><img src="rsc/logo.png" alt="Logo"></a> 
            </div>
            <div class="search-bar">
               <form action="/search/">
                    <input type="search" id="movie" name="q" placeholder="Search" />
                    <button type="submit">🔍</button>
               </form>
            </div>
        </div>
        
        <ul>
            <li><a href="homePage.html" class="glass-btn">Home</a></li>
            <li><a href="productPage.php" class="glass-btn">Product</a></li>
            <li><a href="aboutPage.html" class="glass-btn">About</a></li>
            <li><a href="cartPage.php" class="glass-btn">Cart</a></li>
            <li><button class="profile-btn" onclick="toggleMenu()">👤</button></li>
        </ul>
    </div>

    <div class="profile-container">
        <div class="profile-menu" id="profileMenu">
            <a href="loginPage.html">Login</a>
            <a href="register.html">Register</a>
            <a href="paymentDetails.php">Payments</a>
            <a href="profile.php">My Profile</a>
            <a href="termspage.html">T & C</a>
            <a href="loginPage.html">Logout</a>
        </div>
    </div>

    <br><br>

    <div class="aboutfull">
        <div class="part1">
            <div class="transaction-container">
                <h2>- Transaction History & Order Tracking -</h2>

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
    </div>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>Quick Links</h3>
                <a href="homePage.html">Home</a>
                <a href="productPage.php">Products</a>
                <a href="aboutPage.html">About Us</a>
                <a href="cartPage.php">Cart</a>
                <a href="contactPage.html">Contact</a>
            </div>
            <div class="footer-section">
                <h3>Account</h3>
                <a href="loginPage.html">Login</a>
                <a href="register.html">Register</a>
                <a href="profile.php">My Profile</a>
                <a href="paymentDetails.php">Payments</a>
                <a href="termspage.html">Terms & Conditions</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2026 Product Aura | All Rights Reserved</p>
        </div>
    </footer>

    <script src="js/menu.js"></script>
</body>
</html>
<?php 
$conn->close(); 
?>