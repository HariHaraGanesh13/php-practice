<?php
include "config.php";

$user_id = $_SESSION['user_id'] ?? null;

// Clear remember token from database
if ($user_id) {
    $conn->query("UPDATE users SET remember_token = NULL WHERE id = $user_id");
}

// Destroy session
session_unset();
session_destroy();

// Delete cookie
if (isset($_COOKIE['remember_token'])) {
    setcookie("remember_token", "", time() - 3600, "/");
}

// Redirect to login
header("Location: login.php");
exit;
?>