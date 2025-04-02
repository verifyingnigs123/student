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

    // Check if the user is an admin (login with username instead of student ID)
    if ($user_input === $default_admin_username && $password_input === $default_admin_password) {
        $_SESSION['user_id'] = $default_admin_username;
        $_SESSION['role'] = "admin";
        header("Location: admindashboard.php");
        exit();
    }

    // Check if the user is a student
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $user_input);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['student_id'] = $user['student_id'];

        // If password matches default password
        if ($password_input === $default_student_password) {
            
            // Check if student ID already exists in `login` table
            $checkStmt = $conn->prepare("SELECT * FROM login WHERE student_id = ?");
            $checkStmt->bind_param("s", $user_input);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows === 0) {
                // Insert new student record into login table
                $insertStmt = $conn->prepare("INSERT INTO login (student_id, password) VALUES (?, ?)");
                $insertStmt->bind_param("ss", $user_input, $default_student_password);
                $insertStmt->execute();
                $insertStmt->close();
            }

            // Redirect based on role
            $_SESSION['role'] = "user";
            header("Location: userdashboard.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password.'); window.location.href='Signin.php';</script>";
        }
    } else {
        echo "<script>alert('Student ID not found.'); window.location.href='Signin.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
