<?php
include 'db.php'; // Make sure this connects to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fName = $_POST['fName'];
    $mName = $_POST['mName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $subject = $_POST['subject'];

    $stmt = $conn->prepare("INSERT INTO teachers (fName, mName, lName, email, contact, subject) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $fName, $mName, $lName, $email, $contact, $subject);

    if ($stmt->execute()) {
        echo "<script>alert('Teacher added successfully!'); window.location.href='teachers.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Teacher</title>
  <link rel="stylesheet" href="addstudent.css">
  <style>
    .form-container {
      max-width: 600px;
      margin: 30px auto;
      padding: 20px;
      background: #f9f9f9;
      border-radius: 8px;
    }

    .form-container h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-container input[type="text"],
    .form-container input[type="email"] {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .form-container button {
      background-color: #28a745;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 10px;
    }

    .form-container button:hover {
      background-color: #218838;
    }

    .back-link {
      display: inline-block;
      margin-bottom: 15px;
      text-decoration: none;
      color: #007bff;
    }

    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <a href="teachers.php" class="back-link">← Back to Teacher List</a>
    <h2>Add Teacher</h2>
    <form method="post" action="addteacher.php">
      <input type="text" name="fName" placeholder="First Name" required>
      <input type="text" name="mName" placeholder="Middle Name" required>
      <input type="text" name="lName" placeholder="Last Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="text" name="contact" placeholder="Contact Number" required>
      <input type="text" name="subject" placeholder="Subject / Strand" required>
      <button type="submit">Add Teacher</button>
    </form>
  </div>

</body>
</html>
