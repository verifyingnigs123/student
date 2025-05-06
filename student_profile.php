<?php
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: Signin.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$mysqli = new mysqli("localhost", "root", "", "student_registration");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "SELECT * FROM students WHERE student_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $student = $result->fetch_assoc();
} else {
    echo "Student not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- FontAwesome for the icon -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background: #f4f4f4;
            color: #222;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background: #2c3e50;
            color: #fff;
            padding: 20px;
        }

        .sidebar h2 {
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: #fff;
            padding: 12px 0;
            text-decoration: none;
            border-bottom: 1px solid #3f5871;
        }

        .sidebar a:hover {
            background: #34495e;
        }

        /* Main content */
        .main {
            flex: 1;
            padding: 30px;
        }

        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            padding: 30px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            position: relative;
        }

        .profile-header img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 20px;
            border: 3px solid #ddd;
        }

        .profile-header .btn-edit {
            margin-left: auto;
            padding: 8px 16px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .profile-header .btn-settings {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 8px;
            background: #34495e;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px 40px;
        }

        .info-item {
            background: #f9f9f9;
            padding: 16px 20px;
            border-radius: 10px;
            border: 1px solid #eee;
        }

        .info-item strong {
            color: #555;
            display: block;
            margin-bottom: 5px;
        }

        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
            }

            .sidebar {
                display: none;
            }

            .profile-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-edit {
                margin-top: 10px;
            }
            
        }
        .back-btn {
      position: absolute;
      top: 20px;
      right: 20px; /* Move the button to the right side */
      font-size: 24px;
      background-color: transparent;
      border: none;
      color: #000;
      cursor: pointer;
    }
    </style>
</head>
<body>
        

<div class="main">
<button class="back-btn" onclick="window.location.href='userdashboard.php';">X</button>
    <div class="card">
        <div class="profile-header">
            <img src="profile.png" alt="Profile Picture">
            <div>
                <h2>
                    <?php echo htmlspecialchars($student['fName'] . ' ' . $student['mName'] . ' ' . $student['lName']); ?>
                </h2>
                <p><?php echo htmlspecialchars($student['email']); ?></p>
            </div>
    
            <button class="btn-settings" onclick="window.location.href='settings.php'">
                <i class="fas fa-cogs"></i> 
            </button>
        </div>

        <div class="info-grid">
            <div class="info-item"><strong>Student Type</strong><?php echo htmlspecialchars($student['student_type']); ?></div>
            <div class="info-item"><strong>LRN</strong><?php echo htmlspecialchars($student['student_id']); ?></div>
            <div class="info-item"><strong>Contact Number</strong><?php echo htmlspecialchars($student['contactNumber']); ?></div>
            <div class="info-item"><strong>Birthdate</strong><?php echo htmlspecialchars($student['birthdate']); ?></div>
            <div class="info-item"><strong>Age</strong><?php echo htmlspecialchars($student['age']); ?></div>
            <div class="info-item"><strong>Gender</strong><?php echo htmlspecialchars($student['gender']); ?></div>
            <div class="info-item"><strong>Place of Birth</strong><?php echo htmlspecialchars($student['place']); ?></div>
            <div class="info-item"><strong>Religion</strong><?php echo htmlspecialchars($student['religion']); ?></div>
            <div class="info-item"><strong>Address</strong><?php echo htmlspecialchars($student['street'] . ', ' . $student['city'] . ', ' . $student['state'] . ', ' . $student['country'] . ', ' . $student['zip']); ?></div>
            <div class="info-item"><strong>Strand</strong><?php echo htmlspecialchars($student['strand']); ?></div>
            <div class="info-item"><strong>Grade Level</strong><?php echo htmlspecialchars($student['level']); ?></div>
            <div class="info-item"><strong>Semester</strong><?php echo htmlspecialchars($student['semester']); ?></div>
            <div class="info-item"><strong>School Year</strong><?php echo htmlspecialchars($student['school_year']); ?></div>
            <div class="info-item"><strong>Registered At</strong><?php echo htmlspecialchars($student['registered_at']); ?></div>
        </div>

    </div>
</div>

</body>
</html>

