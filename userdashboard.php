<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "student_registration";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: Signin.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Fetch user details from the database (Admin or User)
$query = "SELECT * FROM students WHERE student_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    // Store fetched values in session for later use
    $_SESSION['first_name'] = $user['first_name'] ?? "";
    $_SESSION['last_name'] = $user['last_name'] ?? "";
    $_SESSION['email'] = $user['email'] ?? "Not Available";
    $_SESSION['birthdate'] = $user['birthdate'] ?? "Not Available";
    $_SESSION['role'] = $user['role'] ?? "User"; // Default to User if no role is found
    $_SESSION['address'] = ($user['street_address'] ?? "Unknown") . ', ' . ($user['city'] ?? "Unknown") . ', ' . ($user['state_province'] ?? "Unknown");
}

// Assign session values to variables
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
$email = $_SESSION['email'];
$birthdate = $_SESSION['birthdate'];
$role = $_SESSION['role'];
$address = $_SESSION['address'];
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
        <div class="menu">
    <button class="menu-btn" onclick="loadPage('overview')"><span class="icon">⏹</span> Overview</button>
    <button class="menu-btn" onclick="loadPage('student_profile')"><span class="icon">👤</span> Student Profile</button>
    <button class="menu-btn" onclick="loadPage('view_grades')"><span class="icon">📖</span> View Grades</button>
    <button class="menu-btn" onclick="loadPage('view_schedule')"><span class="icon">📅</span> Class Schedule & Subjects</button>
    <button class="menu-btn" onclick="loadPage('view_balance')"><span class="icon">💰</span> Account & Balance</button>
    <button class="menu-btn" onclick="loadPage('view_permits')"><span class="icon">📝</span> Permits</button>
</div>

    </div>

    <div class="main-content">
        <div class="header">
            <div class="profile-section">
                <div>
                <h3><?php echo htmlspecialchars($first_name . " " . $last_name); ?></h3>
                
                </div>
            </div>
            <div class="header-buttons">
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
       <script src="user.js"></script>
</body>
</html>