<?php
include 'db.php'; // Include your database connection

// DELETE TEACHER if 'delete_id' is present in URL
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM teachers WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    // Redirect to avoid resubmission on refresh
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

// UPDATE TEACHER if form submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $id = intval($_POST['update_id']);
    $fName = $_POST['fName'];
    $mName = $_POST['mName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $subject = $_POST['subject'];

    $stmt = $conn->prepare("UPDATE teachers SET fName=?, mName=?, lName=?, email=?, contact=?, subject=? WHERE id=?");
    $stmt->bind_param("ssssssi", $fName, $mName, $lName, $email, $contact, $subject, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

// Fetch all teachers
$result = $conn->query("SELECT * FROM teachers");

// If 'edit_id' is present, fetch the teacher data to show the edit form
$edit_teacher = null;
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $stmt = $conn->prepare("SELECT * FROM teachers WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $edit_teacher = $res->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Teacher List</title>
  <link rel="stylesheet" href="addstudent.css">
</head>
<body>

  <div class="container">
    <a href="admindashboard.php" class="close-btn" title="Back to Dashboard">×</a>

    <h2>Teacher List</h2>

    <a href="add_teacher.php" class="btn btn-add-teacher">Add Teacher</a>

    <!-- Edit form appears here if editing -->
    <?php if ($edit_teacher): ?>
     <h3 style="margin-top: 30px;">Edit Teacher ID <?= htmlspecialchars($edit_teacher['id']) ?></h3>
      <form method="POST" class="edit-form">
        <input type="hidden" name="update_id" value="<?= htmlspecialchars($edit_teacher['id']) ?>">
        
        <label>First Name:</label><br>
        <input type="text" name="fName" value="<?= htmlspecialchars($edit_teacher['fName']) ?>" required><br>
        
        <label>Middle Name:</label><br>
        <input type="text" name="mName" value="<?= htmlspecialchars($edit_teacher['mName']) ?>"><br>
        
        <label>Last Name:</label><br>
        <input type="text" name="lName" value="<?= htmlspecialchars($edit_teacher['lName']) ?>" required><br>
        
        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($edit_teacher['email']) ?>"><br>
        
        <label>Contact:</label><br>
        <input type="text" name="contact" value="<?= htmlspecialchars($edit_teacher['contact']) ?>"><br>
        
        <label>Subject/Strand:</label><br>
        <input type="text" name="subject" value="<?= htmlspecialchars($edit_teacher['subject']) ?>"><br><br>
        
        <button type="submit" class="btn btn-update">Update Teacher</button>
      </form>
      <hr>
    <?php endif; ?>

    <div class="search-bar">
      <input type="text" id="searchInput" placeholder="Search by Last Name or Email" onkeyup="searchTable()">
    </div>

    <table id="studentTable">
      <thead>
        <tr>
          <th>ID</th>
          <th>Firstname</th>
          <th>Middlename</th>
          <th>Lastname</th>
          <th>Email</th>
          <th>Contact no.</th>
          <th>Subject/Strand</th>
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
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['contact']) ?></td>
          <td><?= htmlspecialchars($row['subject']) ?></td>
          <td>
            <a href="?edit_id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
            <a href="?delete_id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this teacher?')">Delete</a>
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
        const emailCell = rows[i].getElementsByTagName("td")[4];

        if (lastNameCell && emailCell) {
          const lastName = lastNameCell.textContent.toLowerCase();
          const email = emailCell.textContent.toLowerCase();

          if (lastName.includes(input) || email.includes(input)) {
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
