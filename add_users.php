<?php
include 'db.php'; // Database connection

// Fetch all students from the database
$result = $conn->query("SELECT * FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link rel="stylesheet" href="addstudent.css">

</head>
<body>
    <div class="container">
        <h1>Student List</h1>
        <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search by Last Name or Student ID..." style="margin-bottom: 15px; padding: 8px; width: 100%; font-size: 16px;">

        <table>
            <tr>
                <th>ID</th>
                <th>Student Type</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Student ID</th>
                <th>Email</th>
                <th>Strand</th>
                <th>Level</th>
                <th>Semester</th>
                <th>School Year</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['student_type']) ?></td>
                <td><?= htmlspecialchars($row['fName']) ?></td>
                <td><?= htmlspecialchars($row['mName']) ?></td>
                <td><?= htmlspecialchars($row['lName']) ?></td>
                <td><?= htmlspecialchars($row['student_id']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['strand']) ?></td>
                <td><?= htmlspecialchars($row['level']) ?></td>
                <td><?= htmlspecialchars($row['semester']) ?></td>
                <td><?= htmlspecialchars($row['school_year']) ?></td>
                <td>
                    <a href="edit_student.php?id=<?= $row['id'] ?>" class="btn edit-btn">Edit</a>
                    <a href="delete_student.php?id=<?= $row['id'] ?>" class="btn delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <script>
function filterTable() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const rows = document.querySelectorAll("table tr:not(:first-child)"); // exclude header row

    rows.forEach(row => {
        const lastName = row.cells[4]?.textContent.toLowerCase(); // Last Name column
        const studentID = row.cells[5]?.textContent.toLowerCase(); // Student ID column

        if (lastName.includes(input) || studentID.includes(input)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}
</script>

</body>
</html>