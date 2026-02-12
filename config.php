<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$conn = new mysqli("localhost", "phpuser", "php123", "login_system");
if ($conn->connect_error) {
    die("DB Error: " . $conn->connect_error);
}

// Auto-login from cookie if session not set
if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
    $token = $conn->real_escape_string($_COOKIE['remember_token']);
    $result = $conn->query("SELECT id FROM users WHERE remember_token = '$token'");

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
    } else {
        setcookie("remember_token", "", time() - 3600, "/");
    }
}
?>