<?php
// Include database connection
include 'db.php'; 

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $subject = $_POST['subject'];
    $grade = $_POST['grade'];

    // Insert grade into database
    $sql = "INSERT INTO grades (student_id, subject, grade) VALUES ('$student_id', '$subject', '$grade')";
    if ($conn->query($sql) === TRUE) {
        echo "Grade added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<h2>Add Grade</h2>
<form method="POST" action="grades.php">
    LRN: <input type="text" name="student_id" required><br>
    Subject: <input type="text" name="subject" required><br>
    Grade: <input type="text" name="grade" required><br>
    <input type="submit" value="Add Grade">
</form>

<h3>Existing Grades</h3>
<table>
    <tr><th>LRN</th><th>Subject</th><th>Grade</th></tr>
    <?php
    // Fetch grades from the database
    $result = $conn->query("SELECT * FROM grades");
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['student_id']}</td><td>{$row['subject']}</td><td>{$row['grade']}</td></tr>";
    }
    ?>
</table>
