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

// Parse hobbies into array
$user_hobbies = $user['hobbies'] ? explode(", ", $user['hobbies']) : [];

// Options
$countries = ["India", "USA", "UK", "Canada", "Australia", "Germany", "Japan", "France"];
$hobbies_list = ["Reading", "Gaming", "Cooking", "Traveling", "Music", "Sports", "Photography", "Coding"];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
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
            padding: 20px;
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
            margin-bottom: 25px;
            font-size: 26px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #555;
            font-weight: 600;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        .radio-group,
        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 6px;
        }

        .radio-group label,
        .checkbox-group label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: normal;
            cursor: pointer;
            padding: 6px 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .radio-group label:hover,
        .checkbox-group label:hover {
            border-color: #667eea;
            background: #f0f0ff;
        }

        .radio-group input,
        .checkbox-group input {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .btn-group {
            display: flex;
            gap: 15px;
            margin-top: 10px;
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

        .btn-save {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
        }

        .btn-save:hover {
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-cancel {
            background: #eee;
            color: #555;
        }

        .btn-cancel:hover {
            background: #ddd;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>✏️ Edit Profile</h2>

    <form method="POST" action="update.php">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="form-group">
            <label>Gender</label>
            <div class="radio-group">
                <label>
                    <input type="radio" name="gender" value="Male" <?= ($user['gender'] === 'Male') ? 'checked' : '' ?>>
                    Male
                </label>
                <label>
                    <input type="radio" name="gender" value="Female" <?= ($user['gender'] === 'Female') ? 'checked' : '' ?>>
                    Female
                </label>
                <label>
                    <input type="radio" name="gender" value="Other" <?= ($user['gender'] === 'Other') ? 'checked' : '' ?>>
                    Other
                </label>
            </div>
        </div>

        <div class="form-group">
            <label>Country</label>
            <select name="country">
                <option value="">-- Select Country --</option>
                <?php foreach ($countries as $country): ?>
                    <option value="<?= $country ?>" <?= ($user['country'] === $country) ? 'selected' : '' ?>>
                        <?= $country ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Hobbies</label>
            <div class="checkbox-group">
                <?php foreach ($hobbies_list as $hobby): ?>
                    <label>
                        <input type="checkbox" name="hobbies[]" value="<?= $hobby ?>"
                            <?= in_array($hobby, $user_hobbies) ? 'checked' : '' ?>>
                        <?= $hobby ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="form-group">
            <label>About</label>
            <textarea name="about" placeholder="Tell us about yourself..."><?= htmlspecialchars($user['about'] ?? '') ?></textarea>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-save">💾 Save Changes</button>
            <a href="dashboard.php" class="btn btn-cancel">❌ Cancel</a>
        </div>
    </form>
</div>
</body>
</html>