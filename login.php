<?php
// Start a secure session to remember the user
session_start();

// Include your database configuration credentials
require_once 'db_config.php';

// Prepare a clean array for our response back to JavaScript
$response = array("status" => "error", "message" => "An unknown error occurred.");

if (isset($_POST['email']) && isset($_POST['password'])) {
    
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Secure prepared statement to check the user in register_tb
    $sql = "SELECT id, fullname, password FROM register_tb WHERE email = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password hash
            if (password_verify($password, $user['password'])) {
                
                // Set session variables to remember them across pages
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['fullname'];
                
                $response['status'] = "success";
                $response['message'] = "Login successful! Welcome back.";
                
            } else {
                $response['message'] = "Invalid password. Please try again.";
            }
        } else {
            $response['message'] = "No account found with that email address.";
        }
        $stmt->close();
    } else {
        $response['message'] = "Database error: " . $conn->error;
    }
}

$conn->close();

// Send the JSON response back to JS/login.js
header('Content-Type: application/json');
echo json_encode($response);
exit();
?>