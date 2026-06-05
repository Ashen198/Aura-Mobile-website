<?php
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the actual session tracking mechanism
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

// Redirect clean to login layout page
header("Location: loginPage.html");
exit();
?>