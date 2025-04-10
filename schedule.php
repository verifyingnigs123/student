<?php
// Include DB connection
include 'db.php';

// CREATE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $student_id = $_POST['student_id'];
    $subjects = $_POST['subject'];
    $days = $_POST['day'];
    $times = $_POST['time'];

    for ($i = 0; $i < count($subjects); $i++) {
        $subject = $conn->real_escape_string($subjects[$i]);
        $day = $conn->real_escape_string($days[$i]);
        $time = $conn->real_escape_string($times[$i]);

        $sql = "INSERT INTO schedules (student_id, subject, day, time)
                VALUES ('$student_id', '$subject', '$day', '$time')";
        $conn->query($sql);
    }
}

// UPDATE
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $student_id = $_POST['student_id'];
    $subject = $_POST['subject'];
    $day = $_POST['day'];
    $time = $_POST['time'];

    $sql = "UPDATE schedules SET 
            student_id='$student_id', subject='$subject', day='$day', time='$time' 
            WHERE id=$id";
    $conn->query($sql);
}

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM schedules WHERE id=$id");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Schedules & Subjects</title>
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

<h2>Add Class Schedule</h2>
<form method="POST" action="schedule.php">
    <input type="hidden" name="add" value="1">
    LRN: <input type="text" name="student_id" required><br><br>
    <div id="scheduleFields">
        <div>
            Subject: <input type="text" name="subject[]" required>
            Day: <input type="text" name="day[]" required>
            Time: <input type="text" name="time[]" required><br><br>
        </div>
    </div>
    <button type="button" onclick="addMore()">Add More Subject</button><br><br>
    <input type="submit" value="Add Schedule">
</form>

<script>
function addMore() {
    const container = document.getElementById('scheduleFields');
    const newGroup = document.createElement('div');
    newGroup.innerHTML = `
        Subject: <input type="text" name="subject[]" required>
        Day: <input type="text" name="day[]" required>
        Time: <input type="text" name="time[]" required><br><br>
    `;
    container.appendChild(newGroup);
}
</script>

<h3>Existing Schedules</h3>
<table>
    <tr><th>LRN</th><th>Subject</th><th>Day</th><th>Time</th><th>Actions</th></tr>
    <?php
    $result = $conn->query("SELECT * FROM schedules");
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['student_id']}</td>
                <td>{$row['subject']}</td>
                <td>{$row['day']}</td>
                <td>{$row['time']}</td>
                <td>
                    <a href='?edit={$row['id']}'>Edit</a> | 
                    <a href='?delete={$row['id']}' onclick=\"return confirm('Delete this schedule?')\">Delete</a>
                </td>
              </tr>";
    }
    ?>
</table>

<?php
// Show Edit Form
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $editResult = $conn->query("SELECT * FROM schedules WHERE id=$id");
    $data = $editResult->fetch_assoc();
?>
    <div class="edit-form">
        <h3>Edit Schedule</h3>
        <form method="POST" action="schedule.php">
            <input type="hidden" name="update" value="1">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
            LRN: <input type="text" name="student_id" value="<?php echo $data['student_id']; ?>" required><br>
            Subject: <input type="text" name="subject" value="<?php echo $data['subject']; ?>" required><br>
            Day: <input type="text" name="day" value="<?php echo $data['day']; ?>" required><br>
            Time: <input type="text" name="time" value="<?php echo $data['time']; ?>" required><br><br>
            <input type="submit" value="Update Schedule">
        </form>
    </div>
<?php } ?>

</body>
</html>
