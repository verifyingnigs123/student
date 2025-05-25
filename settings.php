<?php
session_start(); 

$servername = "localhost";
$username = "root";
$password = "";
$database = "student_registration";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle the change password request
    if (isset($_POST['current-password']) && isset($_POST['new-password']) && isset($_POST['confirm-password'])) {
        $current_password = $_POST['current-password'];
        $new_password = $_POST['new-password'];
        $confirm_password = $_POST['confirm-password'];
        
        $student_id = $_SESSION['student_id']; // Assuming the student is logged in
        
        // Validate current password
        $stmt = $conn->prepare("SELECT password FROM login WHERE student_id = ?");
        $stmt->bind_param("s", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stored_password = $row['password'];

            // Check if the current password is correct
            if ($current_password === $stored_password) {
                // Check if new password matches the confirmation
                if ($new_password === $confirm_password) {
                    // Update the password in the database
                    $updateStmt = $conn->prepare("UPDATE login SET password = ? WHERE student_id = ?");
                    $updateStmt->bind_param("ss", $new_password, $student_id);
                    $updateStmt->execute();

                    echo "<script>alert('Password changed successfully!'); window.location.href='settings.php';</script>";
                } else {
                    echo "<script>alert('New passwords do not match.'); window.location.href='settings.php';</script>";
                }
            } else {
                echo "<script>alert('Current password is incorrect.'); window.location.href='settings.php';</script>";
            }
        } else {
            echo "<script>alert('No user found.'); window.location.href='settings.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Settings</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }

        .card {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 480px;
            padding: 40px;
        }

        .settings-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            align-items: center;
        }

        .settings-header h2 {
            font-size: 24px;
            font-weight: 600;
            color: #333;
        }

        .btn-back {
            padding: 8px 16px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-back:hover {
            background-color: #2980b9;
        }

        .section-header {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        .btn-edit, .btn-password-toggle {
            display: block;
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-edit:hover, .btn-password-toggle:hover {
            background-color: #2980b9;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            border-color: #3498db;
            outline: none;
        }

        .form-group input::placeholder {
            color: #bbb;
        }

        .change-password {
            display: none;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="card">
    <div class="settings-header">
        <h2>Settings</h2>
        <a href="userdashboard.php" class="btn-back">X</a>
    </div>

    <!-- Edit Profile Section -->
    <div class="form-group">
        <a href="edit_profile.php" class="btn-edit">Edit Profile</a>
    </div>

    <!-- Toggle Change Password Section -->
    <div class="form-group">
        <button class="btn-password-toggle" onclick="toggleChangePassword()">Change Password</button>
    </div>

    <!-- Change Password Form (hidden by default) -->
    <div class="form-group change-password" id="change-password-section">
        <h3 class="section-header">Change Password</h3>
        <form action="settings.php" method="POST">
            <label for="current-password">Current Password</label>
            <input type="password" id="current-password" name="current-password" placeholder="Enter current password" required>

            <label for="new-password">New Password</label>
            <input type="password" id="new-password" name="new-password" placeholder="Enter new password" required>

            <label for="confirm-password">Confirm New Password</label>
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Re-enter new password" required>

            <button type="submit" class="btn-password">Change Password</button>
        </form>
    </div>
</div>

<script>
    function toggleChangePassword() {
        var changePasswordSection = document.getElementById('change-password-section');
        changePasswordSection.style.display = (changePasswordSection.style.display === 'none' || changePasswordSection.style.display === '') ? 'block' : 'none';
    }
</script>

</body>
</html>
