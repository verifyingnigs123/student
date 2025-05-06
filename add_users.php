<?php
include 'db.php'; // Include your database connection

// Fetch all students
$result = $conn->query("SELECT * FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student List</title>
  <link rel="stylesheet" href="addstudent.css">
</head>
<body>

  <div class="container">
   <a href="admindashboard.php" class="close-btn" title="Back to Dashboard">×</a>
    <h2>Student List</h2>

    <div class="search-bar">
      <input type="text" id="searchInput" placeholder="Search by Last Name or LRN" onkeyup="searchTable()">
    </div>

    <table id="studentTable">
      <thead>
        <tr>
          <th>ID</th>
          <th>Firstname</th>
          <th>Middlename</th>
          <th>Lastname</th>
          <th>Student LRN</th>
          <th>Email</th>
          <th>Strand</th>
          <th>Level</th>
          <th>Semester</th>
          <th>School Year</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['id']) ?></td>
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
            <a href="edit_student.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
            <a href="delete_student.php?id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <script>
    function searchTable() {
      const input = document.getElementById("searchInput").value.toLowerCase();
      const table = document.getElementById("studentTable");
      const rows = table.getElementsByTagName("tr");

      for (let i = 1; i < rows.length; i++) {
        const lastNameCell = rows[i].getElementsByTagName("td")[3];
        const lrnCell = rows[i].getElementsByTagName("td")[4];

        if (lastNameCell && lrnCell) {
          const lastName = lastNameCell.textContent.toLowerCase();
          const lrn = lrnCell.textContent.toLowerCase();

          if (lastName.includes(input) || lrn.includes(input)) {
            rows[i].style.display = "";
          } else {
            rows[i].style.display = "none";
          }
        }
      }
    }
  </script>

</body>
</html>