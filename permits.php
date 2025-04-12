<?php
// Include database connection
include 'db.php'; 

// ADD Permit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
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

// UPDATE Permit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $student_id = $_POST['student_id'];
    $permit_type = $_POST['permit_type'];
    $status = $_POST['status'];

    $sql = "UPDATE permits SET permit_type='$permit_type', status='$status' WHERE student_id='$student_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Permit updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// DELETE Permit
if (isset($_GET['delete'])) {
    $student_id = $_GET['delete'];
    $conn->query("DELETE FROM permits WHERE student_id='$student_id'");
}

// Fetch permits from the database for display
$permits = $conn->query("SELECT * FROM permits");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permits</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
</head>
<body>

<h2>Add Permit</h2>
<form method="POST" action="permits.php">
    <input type="hidden" name="add" value="1">
    LRN: <input type="text" name="student_id" required><br>
    Permit Type: 
    <select name="permit_type" required>
        <option value="Prelim">Prelim</option>
        <option value="Midterm">Midterm</option>
        <option value="Final">Final</option>
    </select><br>
    Status: 
    <select name="status" required>
        <option value="Approved">Approved</option>
        <option value="Pending">Pending</option>
        <option value="Denied">Denied</option>
    </select><br>
    <input type="submit" value="Add Permit">
</form>

<h3>Existing Permits</h3>
<table border="1" cellpadding="5">
    <tr><th>LRN</th><th>Permit Type</th><th>Status</th><th>Actions</th></tr>
    <?php while($row = $permits->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['student_id']; ?></td>
            <td><?php echo $row['permit_type']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>
                <a href="permits.php?edit=<?php echo $row['student_id']; ?>">Edit</a> | 
                <a href="permits.php?delete=<?php echo $row['student_id']; ?>" onclick="return confirm('Delete this permit?')">Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>

<?php
// Edit Permit Form
if (isset($_GET['edit'])) {
    $student_id = $_GET['edit'];
    $edit_permit = $conn->query("SELECT * FROM permits WHERE student_id='$student_id'")->fetch_assoc();
?>
    <h3>Edit Permit</h3>
    <form method="POST" action="permits.php">
        <input type="hidden" name="update" value="1">
        <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($edit_permit['student_id']); ?>">
        LRN: <input type="text" value="<?php echo htmlspecialchars($edit_permit['student_id']); ?>" readonly><br>
        Permit Type:
        <select name="permit_type" required>
            <option value="Prelim" <?php echo ($edit_permit['permit_type'] == 'Prelim') ? 'selected' : ''; ?>>Prelim</option>
            <option value="Midterm" <?php echo ($edit_permit['permit_type'] == 'Midterm') ? 'selected' : ''; ?>>Midterm</option>
            <option value="Final" <?php echo ($edit_permit['permit_type'] == 'Final') ? 'selected' : ''; ?>>Final</option>
        </select><br>
        Status:
        <select name="status" required>
            <option value="Approved" <?php echo ($edit_permit['status'] == 'Approved') ? 'selected' : ''; ?>>Approved</option>
            <option value="Pending" <?php echo ($edit_permit['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
            <option value="Denied" <?php echo ($edit_permit['status'] == 'Denied') ? 'selected' : ''; ?>>Denied</option>
        </select><br>
        <input type="submit" value="Update Permit">
    </form>
<?php } ?>

</body>
</html>
