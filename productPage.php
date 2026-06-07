<?php
// 1. Establish Database Connection Settings
$servername = "localhost";
$username = "root";       // Replace with your database username
$password = "";           // Replace with your database password
$dbname = "aura_mobile";    // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// 2. Fetch all products from your confirmed database table
$sql = "SELECT pid, pname, pprice, pdesc, pimage FROM product_tb";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/productStyle.css">
    <title>Product Aura</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header">
        <div class="searchlogo">
            <div class="left-logo">
               <a href="homePage.html"><img src="rsc/logo.png"></a> 
            </div>
            <div class="search-bar">
               <form action="/search/">
                   <input type="search" id="searchInput" placeholder="Search products..." onkeyup="filterProducts()" />
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

    <div class="allproducts" id="productList">
        <div class="container">
            <div id="productGrid" class="product-grid">
                
                <?php
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $pid = intval($row['pid']);
                        $name = htmlspecialchars($row['pname']);
                        $price = number_format($row['pprice'], 2);
                        $desc = htmlspecialchars($row['pdesc']);
                        $image = htmlspecialchars($row['pimage']);
                        ?>
                        
                        <div class="product-card">
                            <img src="<?php echo $image; ?>" alt="<?php echo $name; ?>">
                            <h3><?php echo $name; ?></h3>
                            <div class="price">Rs <?php echo $price; ?></div>
                           
                            <br>
                            <a href="productDetails.php?id=<?php echo $pid; ?>" class="glass-btn">View Details</a>
                        </div>

                        <?php
                    }
                } else {
                    echo "<p class='no-products'>No products found.</p>";
                }
                $conn->close();
                ?>

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