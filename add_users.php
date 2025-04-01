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
        <a href="insert_student.php"><button class="btn" style="background: #007bff;">Add New Student</button></a>
        <table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Student ID</th>
                <th>Email</th>
                <th>Strand</th>
                <th>Level</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['first_name']) ?></td>
                <td><?= htmlspecialchars($row['middle_name']) ?></td>
                <td><?= htmlspecialchars($row['last_name']) ?></td>
                <td><?= htmlspecialchars($row['student_id']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['strand']) ?></td>
                <td><?= htmlspecialchars($row['level']) ?></td>
                <td>
                    <a href="edit_student.php?id=<?= $row['id'] ?>" class="btn edit-btn">Edit</a>
                    <a href="delete_student.php?id=<?= $row['id'] ?>" class="btn delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
