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
    $user_input = $_POST['studentID'] ?? "";
    $password_input = $_POST['password'] ?? "";

    // Default admin credentials
    $default_admin_username = "admin";
    $default_admin_password = "admin123";

    // Default student password
    $default_student_password = "Lathougs";

    // Admin login
    if ($user_input === $default_admin_username && $password_input === $default_admin_password) {
        $_SESSION['user_id'] = $default_admin_username;
        $_SESSION['role'] = "admin";
        header("Location: admindashboard.php");
        exit();
    }

   // Student login
$stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
$stmt->bind_param("s", $user_input);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

  
    if ($password_input !== $default_student_password) {
        echo "<script>alert('Incorrect password.'); window.location.href='Signin.php';</script>";
        exit();
    }

    if (strtolower($user['is_approved']) !== 'approved') {
        echo "<script>alert('Your account is still pending. Please wait for admin approval.'); window.location.href='Signin.php';</script>";
        exit();
    }
    
    $_SESSION['student_id'] = $user['student_id'];

 
    $checkStmt = $conn->prepare("SELECT * FROM login WHERE student_id = ?");
    $checkStmt->bind_param("s", $user_input);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows === 0) {
       
        $insertStmt = $conn->prepare("INSERT INTO login (student_id, password) VALUES (?, ?)");
        $insertStmt->bind_param("ss", $user_input, $default_student_password);
        $insertStmt->execute();
        $insertStmt->close();
    }

    $_SESSION['role'] = "user";
    header("Location: userdashboard.php");
    exit();

} else {
    echo "<script>alert('LRN not found.'); window.location.href='Signin.php';</script>";
    exit();
}

    $stmt->close();
}

$conn->close();
?>
