<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.'); window.history.back();</script>";
        exit();
    }

    $conn = new mysqli("localhost", "root", "", "student_registration");

    if ($conn->connect_error) {
        echo "<script>alert('Database connection failed.'); window.history.back();</script>";
        exit();
    }

    // Step 1: Get the student_id from the students table using email
    $stmt = $conn->prepare("SELECT student_id FROM students WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $student_id = $row["student_id"];

        // Step 2: Update password in the login table
        $defaultPassword = "Lathougs";

        $updateStmt = $conn->prepare("UPDATE login SET password = ? WHERE student_id = ?");
        $updateStmt->bind_param("ss", $defaultPassword, $student_id);

        if ($updateStmt->execute()) {
            echo "<script>
                alert('Password has been reset to default!');
                window.location.href = 'Signin.php';
            </script>";
        } else {
            echo "<script>alert('Failed to reset the password.'); window.history.back();</script>";
        }

        $updateStmt->close();
    } else {
        echo "<script>alert('This email is not registered in our system.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request method.'); window.history.back();</script>";
}
?>
