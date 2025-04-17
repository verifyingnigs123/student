<?php
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: Signin.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Connect to DB
$mysqli = new mysqli("localhost", "root", "", "student_registration");
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}


$sql = "SELECT * FROM students WHERE student_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $student = $result->fetch_assoc();
} else {
    echo "Student record not found.";
    exit();
}


$first_name = $student['fName'];
$last_name = $student['lName'];
$email = $student['email'];
$birthdate = $student['birthdate'];
$address = $student['street'] . ', ' . $student['city'] . ', ' . $student['state'] . ', ' . $student['country'] . ', ' . $student['zip'];
$role = $student['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Overview - Student Portal</title>
    <link rel="stylesheet" href="dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

    <div class="main-content">
        <div class="header">
            <div class="profile-section">
                <h3><?php echo htmlspecialchars($first_name . " " . $last_name); ?> 
                 <p><?php echo htmlspecialchars($student_id); ?></p>
            </div>
            <div class="header-buttons">
                <a href="userdashboard.php" class="back-btn">✖️</a>
            </div>
        </div>

        <div class="dashboard-content">
            <h1>📊 Dashboard Overview</h1>
            <p>Here's a summary of your profile and academic information:</p>

            <div class="overview-section">
                <div class="overview-card">
                    <h3>📛 Full Name</h3>
                    <p><?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></p>
                </div>
                <div class="overview-card">
                    <h3>📧 Email</h3>
                    <p><?php echo htmlspecialchars($email); ?></p>
                </div>
                <div class="overview-card">
                    <h3>🎂 Birthdate</h3>
                    <p><?php echo htmlspecialchars($birthdate); ?></p>
                </div>
                <div class="overview-card">
                    <h3>🏠 Address</h3>
                    <p><?php echo htmlspecialchars($address); ?></p>
                </div>
                <div class="overview-card">
                    <h3>🧾 Role</h3>
                    <p><?php echo htmlspecialchars($role); ?></p>
                </div>
            </div>

            <div class="reminders">
                <h2>📌 Reminders</h2>
                <ul>
                    <li>📖 Review your grades regularly to monitor your progress.</li>
                    <li>📅 Stay updated with your class schedule.</li>
                    <li>💳 Settle any balances before deadlines to avoid penalties.</li>
                    <li>📝 Always check for exam permit availability before exam week.</li>
                </ul>
            </div>
        </div>
    </div>

    <style>
        .overview-section {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }

        .overview-card {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            flex: 1 1 250px;
        }

        .reminders {
            margin-top: 40px;
        }

        .reminders ul {
            padding-left: 20px;
        }

        .header-buttons .back-btn {
            padding: 10px 16px;
    
            color: white;
            border: none;
            text-decoration: none;
            font-weight: 500;
            border-radius: 8px;
        }

    </style>

</body>
</html>
