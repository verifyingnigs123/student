<?php
include 'db.php';

$id = $_GET['id'];

// Fetch current student data
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['fName'];
    $middle_name = $_POST['mName'];
    $last_name = $_POST['lName'];
    $strand = $_POST['strand'];
    $level = $_POST['level'];
    $semester = $_POST['semester'];

    // Prepare the update statement
    $updateStmt = $conn->prepare("UPDATE students SET fName = ?, mName = ?, lName = ?, strand = ?, level = ?, semester = ? WHERE id = ?");
    
    if (!$updateStmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $updateStmt->bind_param("ssssssi", $first_name, $middle_name, $last_name, $strand, $level,$semester, $id);

    if ($updateStmt->execute()) {
        echo "<script>alert('Student Updated Successfully'); window.location.href='add_users.php';</script>";
    } else {
        echo "Execute failed: (" . $updateStmt->errno . ") " . $updateStmt->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<button class="back-btn" onclick="window.location.href='admindashboard.php';">X</button>
    <title>Edit Student List</title>
    <link rel="stylesheet" href="addstudent.css">
</head>
<body>
    <style>
              .back-btn {
      position: absolute;
      top: 20px;
      right: 20px; /* Move the button to the right side */
      font-size: 24px;
      background-color: transparent;
      border: none;
      color: #000;
      cursor: pointer;
    }
    </style>
    <h1>Edit Student List</h1>
    <form method="POST">
        <input type="text" name="fName" value="<?= htmlspecialchars($row['fName']) ?>" required>
        <input type="text" name="mName" value="<?= htmlspecialchars($row['mName']) ?>">
        <input type="text" name="lName" value="<?= htmlspecialchars($row['lName']) ?>" required>
        <select name="strand" required>
            <option value="<?= $row['strand'] ?>"><?= $row['strand'] ?></option>
            <option value="ABM">ABM</option>
            <option value="HUMSS">HUMSS</option>
            <option value="STEM">STEM</option>
            <option value="GAS">GAS</option>
            <option value="TVL">TVL</option>
        </select>
        <select name="level" required>
            <option value="<?= $row['level'] ?>"><?= $row['level'] ?></option>
            <option value="Grade 11">Grade 11</option>
            <option value="Grade 12">Grade 12</option>
        </select>
        <select name="semester" required>
            <option value="<?= $row['semester'] ?>"><?= $row['semester'] ?></option>
            <option value="1st Semester">1st Semester</option>
            <option value="2nd Semester">2nd Semester</option>
        </select>
        <button type="submit">Update</button> 
    </form>
</body>
</html>
