<?php
include 'db.php';

$successMsg = $errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize inputs
    $fName   = htmlspecialchars(trim($_POST['fName']));
    $mName   = htmlspecialchars(trim($_POST['mName']));
    $lName   = htmlspecialchars(trim($_POST['lName']));
    $email   = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $contact = htmlspecialchars(trim($_POST['contact']));
    $subject = htmlspecialchars(trim($_POST['subject']));

    if ($email) {
        $stmt = $conn->prepare("INSERT INTO teachers (fName, mName, lName, email, contact, subject) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fName, $mName, $lName, $email, $contact, $subject);

        if ($stmt->execute()) {
            $successMsg = "Teacher added successfully!";
        } else {
            $errorMsg = "Database error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $errorMsg = "Invalid email format.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Teacher</title>
  <link rel="stylesheet" href="addstudent.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #eef2f3;
    }

    .form-container {
      max-width: 500px;
      margin: 50px auto;
      padding: 25px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .form-container h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    input[type="text"],
    input[type="email"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    button {
      width: 100%;
      padding: 10px;
      background: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
    }

    button:hover {
      background: #0056b3;
    }

    .message {
      margin: 10px 0;
      padding: 10px;
      border-radius: 5px;
      text-align: center;
    }

    .success {
      background-color: #d4edda;
      color: #155724;
    }

    .error {
      background-color: #f8d7da;
      color: #721c24;
    }

    .back-link {
      display: block;
      margin-bottom: 20px;
      color: #007bff;
      text-decoration: none;
    }

    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <a href="admindashboard.php" class="back-link">Back</a>
    <h2>Add New Teacher</h2>

    <?php if ($successMsg): ?>
      <div class="message success"><?= $successMsg ?></div>
      <script>
        setTimeout(() => window.location.href = 'teachers.php', 2000);
      </script>
    <?php elseif ($errorMsg): ?>
      <div class="message error"><?= $errorMsg ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <input type="text" name="fName" placeholder="First Name" required>
      <input type="text" name="mName" placeholder="Middle Name">
      <input type="text" name="lName" placeholder="Last Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="text" name="contact" placeholder="Contact Number" required>
      <input type="text" name="subject" placeholder="Subject / Strand" required>
      <button type="submit">Add Teacher</button>
    </form>
  </div>

</body>
</html>
