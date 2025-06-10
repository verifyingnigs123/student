<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.'); window.history.back();</script>";
        exit();
    }

    // DB Connection
    $conn = new mysqli("localhost", "root", "", "student_registration");
    if ($conn->connect_error) {
        echo "<script>alert('Database connection failed.'); window.history.back();</script>";
        exit();
    }

    // Check if email exists
    $stmt = $conn->prepare("SELECT student_id FROM students WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $student_id = $row["student_id"];

        // Generate OTP
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['reset_email'] = $email;

        // Send OTP via email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'lagsilrence@gmail.com'; // <-- Your Gmail
            $mail->Password = 'xdegqjyhsqrtlijl';       // <-- Your App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Set sender and recipient
            $mail->setFrom('lagsilrence@gmail.com', 'Lathougs University');
            $mail->addAddress($email);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Lathougs University - OTP Code for Password Reset';
            $mail->Body    = "
                <p>Dear Student,</p>
                <p>Your OTP for resetting your Lathougs University account password is:</p>
                <h2>$otp</h2>
                <p>This code is valid for <strong>5 minutes</strong>.</p>
                <br>
                <p>Regards,<br>Lathougs University</p>
            ";
            $mail->AltBody = "Your OTP code for Lathougs University is: $otp (valid for 5 minutes)";

            $mail->send();
            echo "<script>
                alert('OTP has been sent to your email.');
                window.location.href = 'verify_otp.php';
            </script>";
        } catch (Exception $e) {
            echo "<script>alert('Failed to send OTP. Mailer Error: {$mail->ErrorInfo}'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('This email is not registered.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
?>
