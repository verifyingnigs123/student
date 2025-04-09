<?php
// Include database connection
include 'db.php'; 

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $class_name = $_POST['subject']; // Correctly assign the value of 'subject' to $class_name
    $day = $_POST['day'];
    $time = $_POST['time'];

    // Insert schedule into database
    $sql = "INSERT INTO schedules (student_id, subject, day, time) VALUES ('$student_id', '$class_name', '$day', '$time')";
    if ($conn->query($sql) === TRUE) {
        echo "Schedule added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<h2>Add Class Schedule</h2>
<form method="POST" action="schedule.php">
    LRN: <input type="text" name="student_id" required><br>
    Subject: <input type="text" name="subject" required><br>
    Day: <input type="text" name="day" required><br>
    Time: <input type="text" name="time" required><br>
    <input type="submit" value="Add Schedule">
</form>

<h3>Existing Schedules</h3>
<table>
    <tr><th>LRN</th><th>Subject</th><th>Day</th><th>Time</th></tr>
    <?php
    // Fetch class schedules from the database
    $result = $conn->query("SELECT * FROM schedules");
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['student_id']}</td><td>{$row['subject']}</td><td>{$row['day']}</td><td>{$row['time']}</td></tr>";
    }
    ?>
</table>
