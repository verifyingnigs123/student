<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: Signin.php");
    exit();
}

// Retrieve session variables
$first_name = $_SESSION['first_name'] ?? "Student";
$last_name = $_SESSION['last_name'] ?? "";
$student_id = $_SESSION['student_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
  
    <div class="sidebar">
        <div class="logo">
            <img src="log1.jpg" alt="Lathougs Uni Logo">
            <h2>Lathougs.univ</h2>
        </div>
        <button class="menu-btn"><span class="icon">⏹</span> Overview</button>
        <button class="menu-btn active"><span class="icon">👤</span> Student Profile</button>
        <button class="menu-btn"><span class="icon">📖</span> View Grades</button>
        <button class="menu-btn"><span class="icon">📅</span> Class Schedule & Subjects</button>
        <button class="menu-btn"><span class="icon">💰</span> Account & Balance</button>
        <button class="menu-btn"><span class="icon">📝</span> Permits</button>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="profile-section">
                <div>
                    <h3><?php echo htmlspecialchars($first_name . " " . $last_name); ?></h3>
                    <p>Student ID: <?php echo htmlspecialchars($student_id); ?></p>
                </div>
            </div>
            <div class="header-buttons">
                <button class="edit-profile">Edit Profile</button>
                <button class="logout-btn" onclick="logout()">Logout</button>
            </div>
        </div>

        <div class="dashboard-content">
        <h1>Welcome, <?php echo htmlspecialchars(ucwords($last_name)); ?>! 🎉</h1>
            <p>Manage your academic journey with ease.</p>
        </div>
    </div>

    <script>
        function logout() {
            window.location.href = "Signin.php"; 
        }
    </script>
</body>
</html>