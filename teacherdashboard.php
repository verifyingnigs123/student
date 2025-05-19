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

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: Signin.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="teacher.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

<div class="sidebar">
    <div class="logo">
        <img src="log1.jpg" alt="Lathougs Univ Logo">
        <h2>Lathougs Univ</h2>
    </div>
    <div class="menu">
        <button class="menu-btn" onclick="loadPage('dashboard')"><span class="icon">🏠</span> Dashboard</button>
        <button class="menu-btn" onclick="loadPage('teacherprofile')"><span class="icon">👤</span> Teacher Profile</button>
        <button class="menu-btn" onclick="loadPage('grades')"><span class="icon">📖</span> Grades</button>
        <button class="menu-btn" onclick="loadPage('schedule')"><span class="icon">📅</span> Class Schedule & Subjects</button>
        <button class="menu-btn" onclick="loadPage('balance')"><span class="icon">💰</span> Account & Balance</button>
        <button class="menu-btn" onclick="loadPage('permits')"><span class="icon">📝</span> Permits</button>
        <button class="menu-btn" onclick="loadPage('add_users')"><span class="icon">🎓</span> Student List</button>
        <button class="menu-btn" onclick="loadPage('approvals')"><span class="icon">✅</span> Approvals</button>
        <button class="menu-btn logout" onclick="logout()"><span class="icon">🚪</span> Logout</button>
    </div>
</div>


    <div class="main-content">
        <div class="header">
            <h1> DashBoard</h1>
        </div>

        <script src="admin.js"></script>
</body>
</html>
