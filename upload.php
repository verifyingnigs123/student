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

if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
    $fileTmp = $_FILES['profile_pic']['tmp_name'];
    $fileName = basename($_FILES['profile_pic']['name']);
    $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
    $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array(strtolower($fileExt), $allowedExt)) {
        $newFileName = uniqid('profile_', true) . "." . $fileExt;
        $uploadDir = 'uploads/';
        $uploadPath = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmp, $uploadPath)) {
            // Update database
            $stmt = $mysqli->prepare("UPDATE students SET profile_pic = ? WHERE student_id = ?");
            $stmt->bind_param("ss", $newFileName, $student_id);
            $stmt->execute();
        }
    }
}

header("Location: userdashboard.php"); // Redirect back to profile
exit();
