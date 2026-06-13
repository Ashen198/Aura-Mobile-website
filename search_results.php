<?php 
// 1. Database Connection
$conn = new mysqli('localhost', 'root', '', 'aura_mobile');
$search = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : '';

// 2. Fetch results
$sql = "SELECT * FROM product_tb WHERE pname LIKE '%$search%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/productStyle.css"> <title>Search Results</title>
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
               <form action="search_results.php">
                   <input type="search" id="searchInput" name="q" placeholder="Search products..." onkeyup="filterProducts()" />
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


    <div class="product-grid" style="margin-top: 150px;">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="product-card">
                    <img src="<?php echo $row['pimage']; ?>" alt="<?php echo $row['pname']; ?>">
                    <h3><?php echo $row['pname']; ?></h3>
                    <div class="price">Rs <?php echo number_format($row['pprice'], 2); ?></div>
                    <a href="productDetails.php?id=<?php echo $row['pid']; ?>" class="glass-btn">View Details</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No products found matching "<?php echo htmlspecialchars($search); ?>"</p>
        <?php endif; ?>
    </div>

    <script src="js/menu.js"></script>

    </body>
</html>