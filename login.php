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

    // Default passwords
    $default_student_password = "Lathougs";
    $default_teacher_password = "Lathougs";
    $default_admin_username = "admin";
    $default_admin_password = "admin123";

    // 1. Admin Login
    if ($user_input === $default_admin_username && $password_input === $default_admin_password) {
        $_SESSION['user_id'] = $default_admin_username;
        $_SESSION['role'] = "admin";
        header("Location: loading.php?redirect=admindashboard.php");
        exit();
    }

    // 2. Teacher Login (via email)
if (filter_var($user_input, FILTER_VALIDATE_EMAIL)) {
    $teacherStmt = $conn->prepare("SELECT * FROM teachers WHERE email = ?");
    $teacherStmt->bind_param("s", $user_input);
    $teacherStmt->execute();
    $teacherResult = $teacherStmt->get_result();

    if ($teacherResult->num_rows === 1) {
        if ($password_input === $default_teacher_password) {
           
            $checkTeacherLoginStmt = $conn->prepare("SELECT * FROM teacher_login WHERE email = ?");
            $checkTeacherLoginStmt->bind_param("s", $user_input);
            $checkTeacherLoginStmt->execute();
            $teacherLoginResult = $checkTeacherLoginStmt->get_result();

            if ($teacherLoginResult->num_rows === 0) {
                $insertTeacherLoginStmt = $conn->prepare("INSERT INTO teacher_login (email, password) VALUES (?, ?)");
                $insertTeacherLoginStmt->bind_param("ss", $user_input, $default_teacher_password);
                $insertTeacherLoginStmt->execute();
                $insertTeacherLoginStmt->close();
            }

            $_SESSION['user_id'] = $user_input;
            $_SESSION['role'] = "admin";
            header("Location: loading.php?redirect=teacherdashboard.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password for teacher.'); window.location.href='Signin.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Teacher email not found.'); window.location.href='Signin.php';</script>";
        exit();
    }
}

    // 3. Student Login (via LRN)
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $user_input);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if user has an entry in login table
        $loginStmt = $conn->prepare("SELECT password FROM login WHERE student_id = ?");
        $loginStmt->bind_param("s", $user_input);
        $loginStmt->execute();
        $loginResult = $loginStmt->get_result();

        if ($loginResult->num_rows === 1) {
            $loginData = $loginResult->fetch_assoc();
            if ($password_input !== $loginData['password']) {
                echo "<script>alert('Incorrect password.'); window.location.href='Signin.php';</script>";
                exit();
            }
        } else {
            // First-time login with default password
            if ($password_input !== $default_student_password) {
                echo "<script>alert('Incorrect password.'); window.location.href='Signin.php';</script>";
                exit();
            }
        }

        // Check approval
        if (strtolower($user['is_approved']) !== 'approved') {
            echo "<script>alert('Your account is still pending. Please wait for admin approval.'); window.location.href='Signin.php';</script>";
            exit();
        }

        $_SESSION['student_id'] = $user['student_id'];
        $_SESSION['role'] = "user";

        // Save login record if first time
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

        header("Location: loading.php?redirect=userdashboard.php");
        exit();
    } else {
        echo "<script>alert('LRN not found.'); window.location.href='Signin.php';</script>";
        exit();
    }
}

$conn->close();
?>
