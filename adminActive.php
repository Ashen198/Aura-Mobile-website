<?php
$servername = "localhost";
$username = "root";       
$password = "";           
$dbname = "aura_mobile";

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch active products
$sql = "SELECT pid, pname, pprice, pstock, pdesc, pimage FROM product_tb";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Listing Dashboard</title>
    <link rel="stylesheet" href="CSS/adActive.css">
</head>
<body>

<div class="container">

    <div class="sidebar">
        <div class="logo">
            <img src="rsc/logo.jpeg" alt="Logo">
        </div>
        <a href="adminItem.html" class="menu-btn">List an item</a>
        <a href="adminActive.php" class="menu-btn active">Update item</a>
        <a href="adminOrders.php" class="menu-btn">Orders</a>
        <a href="adminTran.html" class="menu-btn">Transaction</a>
        <a href="adminAnalysis.html" class="menu-btn">Analysis</a>
        <a href="loginPage.html" class="menu-btn">Log Out</a>
    </div>

    <div class="main">
        <div id="products" class="page">
            <h2>Active Items</h2>
            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="productTable">
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $imgSrc = !empty($row['pimage']) ? $row['pimage'] : 'https://media.istockphoto.com/id/629628952/photo/bonnet-monkey.jpg?s=612x612&w=0&k=20&c=UlCED-gnWw3fgiYQxIGEf-Fqbn-H0nJ0aH9rfj-12ac=';
                            echo "<tr>";
                            echo "<td><img src='" . $imgSrc . "' width='50' height='50' style='object-fit:cover; border-radius:8px;'></td>";
                            echo "<td>" . htmlspecialchars($row['pname']) . "</td>";
                            echo "<td>$" . number_format($row['pprice'], 2) . "</td>";
                            echo "<td>" . htmlspecialchars($row['pstock']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['pdesc']) . "</td>";
                            echo "<td>
                                    <button onclick='editProduct(" . $row['pid'] . ")' style='background:#4CAF50; color:white; border:none; padding:6px 12px; border-radius:5px; cursor:pointer; margin-right:5px;'>Update</button>
                                    <button onclick='deleteProduct(" . $row['pid'] . ")' style='background:#dc3545; color:white; border:none; padding:6px 12px; border-radius:5px; cursor:pointer;'>Delete</button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' style='text-align:center;'>No active items found in database.</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Handle Delete Product
function deleteProduct(pid) {
    if (!confirm("Are you sure you want to delete this product?")) return;

    let formData = new FormData();
    formData.append('pid', pid);

    fetch('deleteProduct.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            location.reload(); // Instantly refresh the page to show it's gone
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => console.error("Error executing delete:", error));
}

// Handle Update routing
function editProduct(pid) {
    window.location.href = `adminItem.html?edit_pid=${pid}`;
}
</script>
</body>
</html>