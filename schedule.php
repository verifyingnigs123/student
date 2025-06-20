<?php
// Include DB connection
include 'db.php';

// CREATE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $student_id = $_POST['student_id'];
    $subjects = $_POST['subject'];
    $days = $_POST['day'];
    $times = $_POST['time'];
    $rooms = $_POST['room']; // New line for room data

    for ($i = 0; $i < count($subjects); $i++) {
        $subject = $conn->real_escape_string($subjects[$i]);
        $day = $conn->real_escape_string($days[$i]);
        $time = $conn->real_escape_string($times[$i]);
        $room = $conn->real_escape_string($rooms[$i]); // New line for room data

        $sql = "INSERT INTO schedules (student_id, subject, day, time, room)
                VALUES ('$student_id', '$subject', '$day', '$time', '$room')"; // Modified query to include room
        $conn->query($sql);
        header("Location: teacherdashboard.php");
    exit;
    }
}

// UPDATE
if (isset($_POST['update'])) {
    $student_id = $_POST['student_id'];
    $subjects = $_POST['subject'];
    $days = $_POST['day'];
    $times = $_POST['time'];
    $rooms = $_POST['room']; // New line for room data

    // Update each schedule for the given student_id
    for ($i = 0; $i < count($subjects); $i++) {
        $subject = $conn->real_escape_string($subjects[$i]);
        $day = $conn->real_escape_string($days[$i]);
        $time = $conn->real_escape_string($times[$i]);
        $room = $conn->real_escape_string($rooms[$i]); // New line for room data

        // Update the respective schedule
        $sql = "UPDATE schedules SET subject='$subject', day='$day', time='$time', room='$room' 
                WHERE student_id='$student_id' AND subject='$subject'"; // Modified query to include room
        $conn->query($sql);
        header("Location: teacherdashboard.php");
    exit;
    }
}

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM schedules WHERE id=$id");
    header("Location: teacherdashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Schedules & Subjects</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
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
            Time: <input type="text" name="time[]" required>
            Room: <input type="text" name="room[]" required><br><br> <!-- Added room input -->
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
        Time: <input type="text" name="time[]" required>
        Room: <input type="text" name="room[]" required><br><br> <!-- Added room input -->
    `;
    container.appendChild(newGroup);
}
</script>

<h3>Existing Schedules</h3>
<div style="margin: 20px 0;">
    <input type="text" id="searchInput" placeholder="Search" 
           style="padding: 8px; width: 300px; border: 1px solid #ccc; border-radius: 4px;">
</div>
<table>
    <tr><th>LRN</th><th>Subject</th><th>Day</th><th>Time</th><th>Room</th><th>Actions</th></tr>
    <?php
    $result = $conn->query("SELECT * FROM schedules");
    while($row = $result->fetch_assoc()) {
echo "<tr>
    <td>" . htmlspecialchars($row['student_id']) . "</td>
    <td>" . htmlspecialchars($row['subject']) . "</td>
    <td>" . htmlspecialchars($row['day']) . "</td>
    <td>" . htmlspecialchars($row['time']) . "</td>
    <td>" . htmlspecialchars($row['room']) . "</td>
    <td>
        <a href=\"#\" class=\"edit-schedule\" data-lrn=\"" . htmlspecialchars($row['student_id']) . "\">Edit</a> | 
        <a href='schedule.php?delete=" . urlencode($row['id']) . "' onclick=\"return confirm('Delete this schedule?')\">Delete</a>
    </td>
</tr>";

    }
    ?>
</table>

<?php
// Show Edit Form for all schedules by student_id
if (isset($_GET['edit'])) {
    $student_id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM schedules WHERE student_id=?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all schedules for the student_id
    $schedules = [];
    while ($row = $result->fetch_assoc()) {
        $schedules[] = $row;
    }
    $stmt->close();

    if (count($schedules) > 0):
?>
    <div class="edit-form">
        <h3>Edit Schedule for LRN: <?php echo htmlspecialchars($student_id); ?></h3>
        <form method="POST" action="schedule.php">
            <input type="hidden" name="update" value="1">
            <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">

            <div id="editSubjects">
                <?php foreach ($schedules as $schedule): ?>
                <div>
                    Subject: <input type="text" name="subject[]" value="<?php echo htmlspecialchars($schedule['subject']); ?>" required>
                    Day: <input type="text" name="day[]" value="<?php echo htmlspecialchars($schedule['day']); ?>" required>
                    Time: <input type="text" name="time[]" value="<?php echo htmlspecialchars($schedule['time']); ?>" required>
                    Room: <input type="text" name="room[]" value="<?php echo htmlspecialchars($schedule['room']); ?>" required> <!-- Added room input -->
                </div>
                <br>
                <?php endforeach; ?>
            </div>

            <input type="submit" value="Update All Schedules">
        </form>
    </div>
<?php endif; } ?>

<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    const filter = this.value.toUpperCase();
    const rows = document.querySelectorAll('table tr:not(:first-child)');

    rows.forEach(row => {
        const lrn = row.cells[0].textContent.toUpperCase();
        const subject = row.cells[1].textContent.toUpperCase();
        if (lrn.includes(filter) || subject.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Assuming your table or main container has id="content"
document.getElementById('content').addEventListener('click', function(e) {
  if (e.target.classList.contains('edit-schedule')) {
    e.preventDefault();
    const lrn = e.target.getAttribute('data-lrn');

    fetch(`schedule.php?edit=${encodeURIComponent(lrn)}`)
      .then(response => response.text())
      .then(data => {
        // Replace container content with the fetched edit form
        this.innerHTML = data;
      })
      .catch(err => {
        console.error('Error loading edit form:', err);
      });
  }
});



</script>


</body>
</html>
