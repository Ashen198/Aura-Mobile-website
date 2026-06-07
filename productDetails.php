<?php
// 1. Establish Database Connection Settings
$servername = "localhost";
$username = "root";       // Replace with your database username
$password = "";           // Replace with your database password
$dbname = "aura_mobile";    // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

// 2. Fetch the ID securely from the URL parameter (?id=X)
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Default values if no product matches or is selected
$product_name = "Product Not Found";
$product_price = "0.00";
$product_desc = "The requested product could not be retrieved.";
$product_img = "rsc/placeholder.jpg";

if ($product_id > 0) {
    // Using Prepared Statements to secure against SQL Injection
    $stmt = $conn->prepare("SELECT pname, pprice, pdesc, pimage FROM product_tb WHERE pid = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $product_name = $product['pname'];
        $product_price = number_format($product['pprice'], 2);
        $product_desc = $product['pdesc'];
        $product_img = $product['pimage'];
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product_name); ?> - Aura Mobile</title>
    <link rel="stylesheet" href="CSS/productDetails1Style.css">
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
            <a href="paymentDetails.php">Payments</a>
            <a href="paymentDetails.php">My Profile</a>
            <a href="termspage.html">T & C</a>
            <a href="loginPage.html">Logout</a>
        </div>
    </div> 

    <br><br><br>

    <div class="mainTitle">
        <p><?php echo htmlspecialchars($product_name); ?></p>
    </div>

    <div class="liquid-glass">
        <div class="product-container1">

            <div class="main-image">
                <img id="mainImage" src="<?php echo htmlspecialchars($product_img); ?>" alt="<?php echo htmlspecialchars($product_name); ?>">
            </div>

            <div class="thumbnail-container">
                <img src="<?php echo htmlspecialchars($product_img); ?>" onclick="changeImage(this)">
                <img src="rsc/airpods4.jpg" onclick="changeImage(this)">
                <img src="rsc/watch11.jpg" onclick="changeImage(this)">
            </div>

            <div class="product-container">
                <div class="right">
                    <p class="price">From LKR <?php echo $product_price; ?></p>

                    <h3>Available colours:</h3>
                    <div class="colors">
                        <div class="color" style="background:#b57edc" onclick="selectColor(this)"></div>
                        <div class="color" style="background:#eee" onclick="selectColor(this)"></div>
                        <div class="color" style="background:#000" onclick="selectColor(this)"></div>
                        <div class="color" style="background:#8a9aa5" onclick="selectColor(this)"></div>
                    </div>

                    <h3>Available capacity:</h3>
                    <div class="storage">
                        <div class="option" onclick="selectOption(this)">256GB</div>
                        <div class="option" onclick="selectOption(this)">512GB</div>
                    </div>

                    <div class="qty">
                        <button class="glass-btn" onclick="changeQty(-1)">-</button>
                        <span id="qty">1</span>
                        <button class="glass-btn" onclick="changeQty(1)">+</button>
                    </div>

                    <button class="buy" onclick="buyNow()">Buy Now</button>
                    <br>
                    <button class="buy-btn" data-id="<?php echo $product_id; ?>" onclick="addToCartDetails()">Add to Cart</button>
                </div>
            </div>

        </div>
    </div>

    <div class="liquid-glass">
        <div class="product-details">
            <h2>Product Details</h2>
            <p><?php echo htmlspecialchars($product_desc); ?></p>
            
            <div class="A19ChipVideo">
                <video controls autoplay muted loop> 
                    <source src="rsc/A19Chip.mp4" type="video/mp4">
                </video>
            </div>
            <br>

            <h3>Features:</h3>
            <p>Super Retina XDR display feature standard configurations</p>
            <p>High tier compute architecture chipsets</p>
            <p>Computational multi-lens array camera system options</p>
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

    <script>
    // Variables to track selections
    let selectedColor = "";
    let selectedCapacity = "";
    let quantity = 1;

    function selectColor(el) {
        document.querySelectorAll(".color").forEach(c => c.classList.remove("active"));
        el.classList.add("active");
        
        // Extract the background color style value
        selectedColor = el.style.background; 
    }

    function selectOption(el) {
        document.querySelectorAll(".option").forEach(o => o.classList.remove("active"));
        el.classList.add("active");
        
        // Extract the text (e.g., "256GB")
        selectedCapacity = el.innerText; 
    }

    function changeQty(val) {
        quantity += val;
        if (quantity < 1) quantity = 1;
        document.getElementById("qty").innerText = quantity;
    }
    
    function changeImage(element) {
        document.getElementById("mainImage").src = element.src;
    }

    // Function executed when 'Buy Now' is clicked
    function buyNow() {
        if (!selectedColor) {
            alert("Please select a color!");
            return;
        }
        if (!selectedCapacity) {
            alert("Please select a capacity!");
            return;
        }

        // Create a dynamic form to submit data to the backend
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = 'placeOrder.php';

        let data = {
            product_id: "<?php echo $product_id; ?>",
            product_name: "<?php echo addslashes($product_name); ?>",
            product_price: "<?php echo $product_price; ?>",
            product_desc: "<?php echo addslashes($product_desc); ?>",
            product_img: "<?php echo addslashes($product_img); ?>",
            color: selectedColor,
            capacity: selectedCapacity,
            qty: quantity
        };

        for (let key in data) {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = data[key];
            form.appendChild(input);
        }

        document.body.appendChild(form);
        form.submit();
    }

    function addToCartDetails() {
        if (!selectedColor) {
            alert("Please select a color!");
            return;
        }
        if (!selectedCapacity) {
            alert("Please select a capacity!");
            return;
        }

        let form = document.createElement('form');
        form.method = 'POST';
        form.action = 'addToCartBackend.php';

        let data = {
            product_id: "<?php echo $product_id; ?>",
            product_name: "<?php echo addslashes($product_name); ?>",
            product_price: "<?php echo $product_price; ?>",
            product_desc: "<?php echo addslashes($product_desc); ?>",
            product_img: "<?php echo addslashes($product_img); ?>",
            color: selectedColor,
            capacity: selectedCapacity,
            qty: quantity
        };

        for (let key in data) {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = data[key];
            form.appendChild(input);
        }

        document.body.appendChild(form);
        form.submit();
    }
</script>

    <script src="JS/proDet1.js"></script>
    <script src="js/menu.js"></script>
</body>
</html>