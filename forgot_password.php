<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // TODO: Validate email and check if it exists in the database

    // Example (pseudo code)
    // $user = SELECT * FROM student_registration WHERE email = '$email';

    // if found:
    // - generate a token
    // - save token in DB
    // - send password reset link with token to email

    echo "If the email is registered, a password reset link has been sent.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="style.css"> <!-- optional: link to your styles -->
</head>
<body>
  <div class="container">
    <h2>Forgot Password</h2>
    <p>Please enter your registered email address. We will send you a OTP to reset your password.</p>
    
    <form method="post" action="process_forgot_password.php">
      <input type="email" name="email" placeholder="Enter your email" required>
      <br><br>
      <input type="submit" value="Submit" class="btn">
    </form>
  </div>
</body>
</html>
