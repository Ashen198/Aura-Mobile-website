<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "aura_mobile";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// Fetch items added to cart
$sql = "SELECT * FROM cart_tb";
$result = $conn->query($sql);

$totalCost = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Aura Mobile - My Cart</title>
    <link rel="stylesheet" href="CSS/cartStyle.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body>

  <div class="header">
      <div class="searchlogo">
        <div class="left-logo">
           <a href="homePage.html"><img src="rsc/logo.jpeg" alt="Logo"></a> 
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
        <a href="paymentDetails.html">Payments</a>
        <a href="profile.php">My Profile</a>
        <a href="termspage.html">T & C</a>
        <a href="loginPage.html">Logout</a>
    </div>
  </div> 

  <br><br><br><br><br>

  <div class="mainTitle">
    <p>My Cart</p>
  </div>
   
  <div class="products">
    <?php
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $itemSubtotal = $row['price'] * $row['quantity'];
            $totalCost += $itemSubtotal;
            ?>
            <div class="product">
              <div id="elements">
                <div class="productImage">
                   <img src="<?php echo htmlspecialchars($row['product_image']); ?>" alt="Product Image">
                </div>
                 <div class="productDetails">
                   <h3><?php echo htmlspecialchars($row['product_name']); ?></h3>
                   <p>Rs <?php echo number_format($row['price'], 2); ?></p>
                 </div>
              </div>
            </div>
            <?php
        }
    } else {
        echo "<p style='margin: 20px;'>Your cart is currently empty.</p>";
    }
    ?>
  </div>

  <div class="liquid-glass">
   <div class="totalAmount">
      <h2>Shopping Cart Summary</h2>
      <h3 id="total">Total: Rs <?php echo number_format($totalCost, 2); ?></h3>

      <?php if ($totalCost > 0): ?>
          <form action="placeCartOrder.php" method="POST">
              <button type="submit" class="glass-btn">Place Order</button>
          </form>
      <?php endif; ?>
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
        </div>
        <div class="footer-section">
            <h3>Account</h3>
            <a href="loginPage.html">Login</a>
            <a href="register.html">Register</a>
            <a href="profile.php">My Profile</a>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2026 Product Aura | All Rights Reserved</p>
    </div>
  </footer>

  <script src="JS/cart.js"></script>
  <script src="JS/menu.js"></script>
</body>
</html>
<?php $conn->close(); ?>