<?php
include "config.php";
global $conn;

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch user data
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            /*background: linear-gradient(135deg, #667eea, #764ba2);*/
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            width: 520px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 8px;
            font-size: 26px;
        }

        .welcome {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
            font-size: 15px;
        }

        .profile-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .profile-table tr {
            border-bottom: 1px solid #eee;
        }

        .profile-table tr:last-child {
            border-bottom: none;
        }

        .profile-table td {
            padding: 12px 15px;
            font-size: 15px;
            vertical-align: top;
        }

        .profile-table td:first-child {
            font-weight: 600;
            color: #555;
            width: 30%;
            background: #f8f9fa;
            border-radius: 6px 0 0 6px;
        }

        .profile-table td:last-child {
            color: #333;
        }

        .not-set {
            color: #aaa;
            font-style: italic;
        }

        .btn-group {
            display: flex;
            gap: 15px;
        }

        .btn {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: block;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-edit {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
        }

        .btn-edit:hover {
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-logout {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: #fff;
        }

        .btn-logout:hover {
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.4);
        }
    </style>
</head>
<body>
<div class="container">
    <h2>📊 Dashboard</h2>
    <p class="welcome">Welcome back, <?= htmlspecialchars($user['name']) ?>!</p>

    <table class="profile-table">
        <tr>
            <td>Name</td>
            <td><?= htmlspecialchars($user['name']) ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?= htmlspecialchars($user['email']) ?></td>
        </tr>
        <tr>
            <td>Gender</td>
            <td><?= $user['gender'] ? htmlspecialchars($user['gender']) : '<span class="not-set">Not set</span>' ?></td>
        </tr>
        <tr>
            <td>Country</td>
            <td><?= $user['country'] ? htmlspecialchars($user['country']) : '<span class="not-set">Not set</span>' ?></td>
        </tr>
        <tr>
            <td>Hobbies</td>
            <td><?= $user['hobbies'] ? htmlspecialchars($user['hobbies']) : '<span class="not-set">Not set</span>' ?></td>
        </tr>
        <tr>
            <td>About</td>
            <td><?= $user['about'] ? htmlspecialchars($user['about']) : '<span class="not-set">Not set</span>' ?></td>
        </tr>
    </table>

    <div class="btn-group">
        <a href="edit.php" class="btn btn-edit">✏️ Edit Profile</a>
        <a href="logout.php" class="btn btn-logout">🚪 Logout</a>
    </div>
</div>
</body>
</html>