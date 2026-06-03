<?php
// Include database connection
require_once 'db_config.php';

if (isset($_POST['register_btn'])) {
    
    // Retrieve form data from the HTML form
    $fullname        = trim($_POST['fullname']);
    $email           = trim($_POST['email']);
    $address         = trim($_POST['address']);
    $password        = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // 1. Check if passwords match
    if ($password !== $confirmPassword) {
        echo "<script>alert('Error: Passwords do not match!'); window.history.back();</script>";
        exit();
    }

    // 2. Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // 3. Prepared SQL Query (Matching your table: register_tb and column: Address)
    $sql = "INSERT INTO register_tb (fullname, email, Address, password) VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // "ssss" indicates 4 string parameters
        $stmt->bind_param("ssss", $fullname, $email, $address, $hashed_password);
        
        // Execute the query
        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!'); window.location.href='loginPage.html';</script>";
        } else {
            echo "Error saving data: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

$conn->close();
?>