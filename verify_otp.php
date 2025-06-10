<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredOtp = trim($_POST['otp']);
    $correctOtp = $_SESSION['otp'] ?? '';
    $email = $_SESSION['reset_email'] ?? '';

    if ($enteredOtp == $correctOtp && !empty($email)) {
        $conn = new mysqli("localhost", "root", "", "student_registration");
        if ($conn->connect_error) {
            echo "<script>alert('Database connection failed.'); window.history.back();</script>";
            exit();
        }

        $stmt = $conn->prepare("SELECT student_id FROM students WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $student_id = $row['student_id'];

            $update = $conn->prepare("UPDATE login SET password = 'Lathougs' WHERE student_id = ?");
            $update->bind_param("s", $student_id);
            if ($update->execute()) {
                session_unset();
                session_destroy();
                echo "<script>
                    alert('Password reset to default! Please log in.');
                    window.location.href = 'Signin.php';
                </script>";
            } else {
                echo "<script>alert('Failed to update password.'); window.history.back();</script>";
            }

            $update->close();
        } else {
            echo "<script>alert('Student ID not found.'); window.history.back();</script>";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "<script>alert('Invalid OTP.'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <link rel="stylesheet" href="style.css"> <!-- Optional: Link external CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f9fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: white;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            width: 300px;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #2a74da;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #195bc3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Enter OTP</h2>
        <form method="post" action="">
            <input type="text" name="otp" placeholder="Enter OTP" required>
            <input type="submit" value="Verify OTP">
        </form>
    </div>
</body>
</html>
