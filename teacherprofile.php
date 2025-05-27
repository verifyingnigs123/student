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

// Check if logged in user is a teacher/admin (adjust role as needed)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<p>Access denied.</p>";
    exit();
}

// Get teacher email from session
$teacher_email = $_SESSION['user_id'];

// Fetch full teacher profile info
$stmt = $conn->prepare("SELECT lName, fName, mName, email, contact, subject FROM teachers WHERE email = ?");
$stmt->bind_param("s", $teacher_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>No profile data found.</p>";
    exit();
}

$teacher = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Teacher Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #eef2f7;
            color: #2c3e50;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px 20px;
        }

        .profile-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            padding: 30px;
            max-width: 600px;
            width: 100%;
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            gap: 15px;
        }

        .profile-icon {
            font-size: 60px;
            color: #1f3b75;
            background: #d0e6ff;
            padding: 15px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile-name {
            font-weight: 600;
            font-size: 28px;
            color: #1f3b75;
            flex: 1;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px 40px;
        }

        .info-item {
            background: #f5f8fb;
            padding: 18px 20px;
            border-radius: 10px;
            border: 1px solid #d0d0d0;
            word-wrap: break-word;
        }

        .info-item strong {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
        }

        @media (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-icon">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="profile-name">
                <?php echo htmlspecialchars($teacher['fName'] . ' ' . $teacher['mName'] . ' ' . $teacher['lName']); ?>
            </div>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <strong>Email</strong>
                <?php echo htmlspecialchars($teacher['email']); ?>
            </div>
            <div class="info-item">
                <strong>Contact</strong>
                <?php echo htmlspecialchars($teacher['contact']); ?>
            </div>
            <div class="info-item">
                <strong>Subject</strong>
                <?php echo htmlspecialchars($teacher['subject']); ?>
            </div>
        </div>
    </div>

</body>
</html>
