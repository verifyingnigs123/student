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
    font-family: 'Segoe UI', sans-serif;
}

body {
    display: flex;
    min-height: 100vh;
    background: #eef2f7;
    color: #2c3e50;
}

/* Sidebar (currently unused on mobile, still included for larger viewports) */
.sidebar {
    width: 240px;
    background: #ffffff;
    color: #2c3e50;
    padding: 20px;
    border-right: 1px solid #ccc;
}

.sidebar h2 {
    margin-bottom: 30px;
}

.sidebar a {
    display: block;
    color: #2c3e50;
    padding: 12px 0;
    text-decoration: none;
    border-bottom: 1px solid #e0e0e0;
}

.sidebar a:hover {
    background: #d0e6ff;
}

/* Main content */
.main {
    flex: 1;
    padding: 30px;
}

.card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    padding: 30px;
    max-width: 1000px;
    margin: 0 auto;
}

.profile-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 30px;
    position: relative;
    flex-wrap: wrap;
}

.profile-pic-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.profile-pic-container img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #ccc;
}

.upload-form {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 8px;
}

.upload-form input[type="file"] {
    font-size: 12px;
    padding: 2px;
}

.upload-form .btn-edit {
    margin-top: 5px;
    padding: 6px 12px;
    font-size: 13px;
}

.profile-info {
    display: flex;
    flex-direction: column;
    justify-content: center;
    line-height: 1.4;
    min-width: 0;
}

.btn-settings {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 8px;
    background: #1f3b75;
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
    background: #f5f8fb;
    padding: 16px 20px;
    border-radius: 10px;
    border: 1px solid #d0d0d0;
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
}

.back-btn {
    position: absolute;
    top: 20px;
    right: 20px;
    font-size: 24px;
    background-color: transparent;
    border: none;
    color: #2c3e50;
    cursor: pointer;
}

    </style>
</head>
<body>
        

<div class="main">
<button class="back-btn" onclick="window.location.href='userdashboard.php';">X</button>
    <div class="card">
      <div class="profile-header">
    <div class="profile-pic-container">
        <img src="uploads/<?php echo htmlspecialchars($student['profile_pic'] ?? 'profile.png'); ?>" alt="Profile Picture">
        <form action="upload.php" method="POST" enctype="multipart/form-data" class="upload-form" id="uploadForm">
    <input type="file" name="profile_pic" accept="image/*" required onchange="document.getElementById('uploadForm').submit();">
</form>

    </div>

    <div class="profile-info">
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

