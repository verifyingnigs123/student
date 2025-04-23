<?php
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: Signin.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

$valid_extensions = ["jpg", "jpeg", "png", "gif"];
$uploadOk = 1;

if (!in_array($imageFileType, $valid_extensions)) {
    echo "Only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

if ($_FILES["profile_pic"]["size"] > 5000000) {
    echo "File is too large.";
    $uploadOk = 0;
}

if ($uploadOk && move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
    $mysqli = new mysqli("localhost", "root", "", "student_registration");
    $sql = "UPDATE students SET profile_img = ? WHERE student_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $target_file, $student_id);
    $stmt->execute();

    header("Location: profile.php");
    exit();
} else {
    echo "Error uploading file.";
}
?>
