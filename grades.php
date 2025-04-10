<?php
// Include database connection
include 'db.php';

// CREATE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $student_id = $_POST['student_id'];
    $subject = $_POST['subject'];
    $grade = $_POST['grade'];

    $sql = "INSERT INTO grades (student_id, subject, grade) 
            VALUES ('$student_id', '$subject', '$grade')";
    $conn->query($sql);
}

// UPDATE
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $student_id = $_POST['student_id'];
    $subject = $_POST['subject'];
    $grade = $_POST['grade'];

    $sql = "UPDATE grades SET 
            student_id='$student_id', subject='$subject', grade='$grade' 
            WHERE id=$id";
    $conn->query($sql);
}

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM grades WHERE id=$id");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Grades Management</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        input[type="text"] { margin: 5px; }
        table, th, td { border: 1px solid #444; border-collapse: collapse; padding: 8px; }
        table { margin-top: 20px; width: 100%; }
        button { margin-top: 10px; }
        .edit-form { background: #f9f9f9; padding: 10px; margin-top: 20px; border: 1px solid #ccc; }
    </style>
</head>
<body>

<h2>Add Grade</h2>
<form method="POST" action="grades.php">
    <input type="hidden" name="add" value="1">
    LRN: <input type="text" name="student_id" required><br>
    Subject: <input type="text" name="subject" required><br>
    Grade: <input type="text" name="grade" required><br>
    <input type="submit" value="Add Grade">
</form>

<h3>Existing Grades</h3>
<table>
    <tr><th>LRN</th><th>Subject</th><th>Grade</th><th>Actions</th></tr>
    <?php
    $result = $conn->query("SELECT * FROM grades");
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['student_id']}</td>
                <td>{$row['subject']}</td>
                <td>{$row['grade']}</td>
                <td>
                    <a href='grades.php?edit={$row['id']}'> Edit</a> | 
                    <a href='grades.php?delete={$row['id']}' onclick=\"return confirm('Delete this grade?')\"> Delete</a>
                </td>
              </tr>";
    }
    ?>
</table>

<?php
// Show Edit Form
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editResult = $conn->query("SELECT * FROM grades WHERE id=$id");
    $data = $editResult->fetch_assoc();
?>
    <div class="edit-form">
        <h3>Edit Grade</h3>
        <form method="POST" action="grades.php">
            <input type="hidden" name="update" value="1">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
            LRN: <input type="text" name="student_id" value="<?php echo $data['student_id']; ?>" required><br>
            Subject: <input type="text" name="subject" value="<?php echo $data['subject']; ?>" required><br>
            Grade: <input type="text" name="grade" value="<?php echo $data['grade']; ?>" required><br>
            <input type="submit" value="Update Grade">
        </form>
    </div>
<?php } ?>

</body>
</html>
