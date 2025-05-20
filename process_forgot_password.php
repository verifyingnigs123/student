<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    $conn = new mysqli("localhost", "root", "", "student_registration");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
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
        $defaultPassword = "Lathougs"; // Use password_hash if security is needed

        $updateStmt = $conn->prepare("UPDATE login SET password = ? WHERE student_id = ?");
        $updateStmt->bind_param("ss", $defaultPassword, $student_id);

        if ($updateStmt->execute()) {
            echo "The password for student ID <strong>$student_id</strong> has been reset to default: <strong>Lathougs</strong>.";
        } else {
            echo "Failed to reset the password in the login table.";
        }

        $updateStmt->close();
    } else {
        echo "This email is not registered in our system.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
