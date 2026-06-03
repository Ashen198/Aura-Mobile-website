<?php
// Start the session to read stored user data
session_start();

// If the session variable is not set, the user is not logged in. Kick them out!
if (!isset($_SESSION['user_id'])) {
    header("Location: loginPage.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Aura Mobile</title>
    <style>
        body { font-family: 'Montserrat', sans-serif; background-color: #1a1a1a; color: white; text-align: center; padding: 50px; }
        .dashboard-box { background: #2a2a2a; padding: 40px; display: inline-block; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.5); }
        .logout-btn { display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #ff4d4d; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;}
        .logout-btn:hover { background-color: #ff3333; }
    </style>
</head>
<body>

<div class="dashboard-box">
    <h1>AURA MOBILE</h1>
    <h2>Welcome to your Dashboard, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
    <p>You have successfully logged in securely.</p>
    
    <a href="logout.php" class="logout-btn">Log Out</a>
</div>

</body>
</html>