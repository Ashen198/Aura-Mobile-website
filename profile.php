<?php
// 1. Start the session to catch logged-in user data
session_start();

// 2. If the user is not logged in, redirect them back to the login page
if (!isset($_SESSION['user_id'])) {
    header("Location: loginPage.html");
    exit();
}

// 3. Include database connection
require_once 'db_config.php';

// 4. Fetch the logged-in user's current data from the database
$userId = $_SESSION['user_id'];
$query = "SELECT fullname, email, Address FROM register_tb WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    // If user details can't be fetched, force logout safety measure
    session_destroy();
    header("Location: loginPage.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/paymentStyle.css">
    <title>Payment Aura - Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@900&display=swap" rel="stylesheet">
    <style>
        /* Small styling addition to keep your profile presentation organized */
        .profile-details-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 12px;
            margin-top: -100px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .profile-field {
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        .profile-field strong {
            color: #00026dff; /* Or any theme highlight color you prefer */
        }
        .transaction-container {
            margin-top: 90px;
           
        }

        


    </style>
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
            <a href="logout.php">Logout</a> </div>
    </div>

    <br>

    <div class="aboutfull">
        <div class="part1" >
            <h2><center>- The Profile -</center></h2>
            <div class="transaction-container"   style="width: 800px; height: 150px; " >
                
                
                <div class="profile-details-card">


                   <div><img src="rsc/pro.png" style="width: 150px; height: auto;" alt="17 Pro Silver"> </div>
                   <br>



                    <div class="profile-field">
                        <strong>Full Name:</strong> <?php echo htmlspecialchars($user['fullname']); ?>
                    </div>
                    <div class="profile-field">
                        <strong>Email Address:</strong> <?php echo htmlspecialchars($user['email']); ?>
                    </div>
                    <div class="profile-field">
                        <strong>Shipping Address:</strong> <?php echo htmlspecialchars($user['Address']); ?>
                    </div>
                </div>
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