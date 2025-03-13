
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
    $student_id = $_POST['studentID'] ?? "";
    $password_input = $_POST['password'] ?? "";

    // Default password
    $default_password = "Lathougs";

    // Check if the entered password matches the default password
    if ($password_input === $default_password) {
        
        // Verify if Student ID exists in the `students` table
        $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
        $stmt->bind_param("s", $student_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            $_SESSION['student_id'] = $user['student_id'];

            // Check if student ID already exists in `login` table
            $checkStmt = $conn->prepare("SELECT * FROM login WHERE student_id = ?");
            $checkStmt->bind_param("s", $student_id);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows === 0) {
                // If student ID doesn't exist, insert new record
                $insertStmt = $conn->prepare("INSERT INTO login (student_id, password) VALUES (?, ?)");
                $insertStmt->bind_param("ss", $student_id, $default_password);
                $insertStmt->execute();
                $insertStmt->close();
            }

            $checkStmt->close();
            $stmt->close();

            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Student ID not found. Please try again.'); window.location.href='index.php';</script>";
        }

    } else {
        echo "<script>alert('Incorrect password.'); window.location.href='index.php';</script>";
    }
}

$conn->close();
?>
