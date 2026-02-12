<?php
include "config.php";
global $conn;

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $name    = $conn->real_escape_string(trim($_POST['name']));
    $email   = $conn->real_escape_string(trim($_POST['email']));
    $gender  = isset($_POST['gender']) ? $conn->real_escape_string($_POST['gender']) : NULL;
    $country = isset($_POST['country']) ? $conn->real_escape_string($_POST['country']) : NULL;
    $hobbies = isset($_POST['hobbies']) ? implode(", ", $_POST['hobbies']) : NULL;
    $about   = $conn->real_escape_string(trim($_POST['about'] ?? ''));

    // Check if email taken by another user
    $check = $conn->query("SELECT id FROM users WHERE email='$email' AND id != $user_id");
    if ($check->num_rows > 0) {
        echo "<script>alert('Email already taken!'); window.history.back();</script>";
        exit;
    }

    // Update
    $sql = "UPDATE users SET 
                name='$name', 
                email='$email', 
                gender=" . ($gender ? "'$gender'" : "NULL") . ", 
                country=" . ($country ? "'$country'" : "NULL") . ", 
                hobbies=" . ($hobbies ? "'" . $conn->real_escape_string($hobbies) . "'" : "NULL") . ", 
                about=" . ($about ? "'$about'" : "NULL") . " 
            WHERE id=$user_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "<script>alert('Update failed: " . $conn->error . "'); window.history.back();</script>";
    }
} else {
    header("Location: edit.php");
    exit;
}
?>