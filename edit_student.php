<?php
include 'db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM students WHERE id=$id");
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['fName'];
    $middle_name = $_POST['mName'];
    $last_name = $_POST['lName'];
    $strand = $_POST['strand'];
    $level = $_POST['level'];

    $sql = "UPDATE students SET first_name='$first_name', middle_name='$middle_name', last_name='$last_name', strand='$strand', level='$level' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Student Updated Successfully'); window.location.href='student.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student List</title>
    <link rel="stylesheet" href="addstudent.css">
</head>
<body>
    <h1>Edit Student List</h1>
    <form method="POST">
        <input type="text" name="fName" value="<?= $row['fName'] ?>" required>
        <input type="text" name="mName" value="<?= $row['mName'] ?>">
        <input type="text" name="lName" value="<?= $row['lName'] ?>" required>
        <select name="strand">
            <option value="<?= $row['strand'] ?>"><?= $row['strand'] ?></option>
            <option value="ABM">ABM</option>
            <option value="HUMSS">HUMSS</option>
            <option value="STEM">STEM</option>
            <option value="GAS">GAS</option>
            <option value="TVL">TVL</option>
        </select>
        <select name="level">
            <option value="<?= $row['level'] ?>"><?= $row['level'] ?></option>
            <option value="Grade 11">Grade 11</option>
            <option value="Grade 12">Grade 12</option>
        </select>
        <button type="submit">Update</button> 
    </form>
</body>
</html>
