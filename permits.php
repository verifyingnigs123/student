<?php
// Include database connection
include 'db.php'; 

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $permit_type = $_POST['permit_type'];
    $status = $_POST['status'];

    // Insert permit into the database
    $sql = "INSERT INTO permits (student_id, permit_type, status) VALUES ('$student_id', '$permit_type', '$status')";
    if ($conn->query($sql) === TRUE) {
        echo "Permit added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<h2>Add Permit</h2>
<form method="POST" action="permits.php">
    LRN: <input type="text" name="student_id" required><br>
    Permit Type: <input type="text" name="permit_type" required><br>
    Status: 
    <select name="status" required>
        <option value="Approved">Approved</option>
        <option value="Pending">Pending</option>
        <option value="Denied">Denied</option>
    </select><br>
    <input type="submit" value="Add Permit">
</form>

<h3>Existing Permits</h3>
<table>
    <tr><th>LRN</th><th>Permit Type</th><th>Status</th></tr>
    <?php
    // Fetch permits from the database
    $result = $conn->query("SELECT * FROM permits");
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['student_id']}</td><td>{$row['permit_type']}</td><td>{$row['status']}</td></tr>";
    }
    ?>
</table>
