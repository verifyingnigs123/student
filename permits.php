<?php
// Include database connection
include 'db.php'; 

// ADD Permit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $student_id = $_POST['student_id'];
    $permit_type = $_POST['permit_type'];
    $status = $_POST['status'];
    $issue_date = $_POST['issue_date'];
    $expiration_date = $_POST['expiration_date'];

    // Insert permit into the database
    $sql = "INSERT INTO permits (student_id, permit_type, status, issue_date, expiration_date) VALUES ('$student_id', '$permit_type', '$status', '$issue_date', '$expiration_date')";
    if ($conn->query($sql) === TRUE) {
        echo "Permit added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
    header("Location: teacherdashboard.php");
    exit;

    
}


// UPDATE Permit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $student_id = $_POST['student_id'];
    $permit_type = $_POST['permit_type'];
    $status = $_POST['status'];
    $issue_date = $_POST['issue_date'];
    $expiration_date = $_POST['expiration_date'];

    $sql = "UPDATE permits SET permit_type='$permit_type', status='$status', issue_date='$issue_date', expiration_date='$expiration_date' WHERE student_id='$student_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Permit updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
    header("Location: teacherdashboard.php");
    exit;
}

// DELETE Permit
if (isset($_GET['delete'])) {
    $student_id = $_GET['delete'];
    $conn->query("DELETE FROM permits WHERE student_id='$student_id'");
    header("Location: teacherdashboard.php");
    exit;
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
    Issue Date: <input type="date" name="issue_date" required><br>
    Expiration Date: <input type="date" name="expiration_date" required><br>
    <input type="submit" value="Add Permit">
</form>

<h3>Existing Permits</h3>

<input type="text" id="searchInput" placeholder="Search" style="margin-top: 20px; padding: 5px; width: 300px;">

<table border="1" cellpadding="5">
    <tr><th>LRN</th><th>Permit Type</th><th>Status</th><th>Issue Date</th><th>Expiration Date</th><th>Actions</th></tr>
   <?php while($row = $permits->fetch_assoc()) {
    $student_id = htmlspecialchars($row['student_id']);
    $permit_type = htmlspecialchars($row['permit_type']);
    $status = htmlspecialchars($row['status']);
    $issue_date = htmlspecialchars($row['issue_date']);
    $expiration_date = htmlspecialchars($row['expiration_date']);
?>
<tr>
    <td><?= $student_id ?></td>
    <td><?= $permit_type ?></td>
    <td><?= $status ?></td>
    <td><?= $issue_date ?></td>
    <td><?= $expiration_date ?></td>
    <td>
        <a href="#" class="edit-permit" data-id="<?= $student_id ?>">Edit</a> |
        <a href="permits.php?delete=<?= urlencode($row['student_id']) ?>" onclick="return confirm('Delete this permit?')">Delete</a>
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
        Issue Date: <input type="date" name="issue_date" value="<?php echo htmlspecialchars($edit_permit['issue_date']); ?>" required><br>
        Expiration Date: <input type="date" name="expiration_date" value="<?php echo htmlspecialchars($edit_permit['expiration_date']); ?>" required><br>
        <input type="submit" value="Update Permit">
    </form>
<?php } ?>

<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    const filter = this.value.toUpperCase();
    const rows = document.querySelectorAll('table tr:not(:first-child)');

    rows.forEach(row => {
        const lrn = row.cells[0].textContent.toUpperCase();
        const permitType = row.cells[1].textContent.toUpperCase();
        const status = row.cells[2].textContent.toUpperCase();
        if (lrn.includes(filter) || permitType.includes(filter) || status.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

document.getElementById('content').addEventListener('click', function(e) {
    if (e.target.classList.contains('edit-permit')) {
        e.preventDefault();
        const studentId = e.target.getAttribute('data-id');

        fetch(`permits.php?edit=${encodeURIComponent(studentId)}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('content').innerHTML = data;
            })
            .catch(error => {
                console.error('Error loading edit form:', error);
            });
    }
});

</script>

</body>
</html>
