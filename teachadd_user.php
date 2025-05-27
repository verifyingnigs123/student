<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "student_registration";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: teacherdashboard.php");
    exit();
}

$result = $conn->query("SELECT * FROM students");
?>

<div class="welcome-box">
  <h2>Student List</h2>

  <div class="search-bar" style="margin-bottom: 20px;">
    <input type="text" id="searchInput" placeholder="Search by Last Name or LRN" onkeyup="searchTable()"
           style="padding: 8px; width: 100%; max-width: 300px; font-size: 14px; border: 1px solid #ccc; border-radius: 6px;">
  </div>

  <div style="overflow-x: auto;">
    <table id="studentTable" style="width: 100%; font-size: 13px; border-collapse: collapse; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
      <thead style="background-color: #1f3b75; color: white;">
        <tr>
          <th style="padding: 10px; text-align: left;">ID</th>
          <th style="padding: 10px; text-align: left;">Type</th>
          <th style="padding: 10px; text-align: left;">First</th>
          <th style="padding: 10px; text-align: left;">Middle</th>
          <th style="padding: 10px; text-align: left;">Last</th>
          <th style="padding: 10px; text-align: left;">LRN</th>
          <th style="padding: 10px; text-align: left;">Email</th>
          <th style="padding: 10px; text-align: left;">Strand</th>
          <th style="padding: 10px; text-align: left;">Level</th>
          <th style="padding: 10px; text-align: left;">Sem</th>
          <th style="padding: 10px; text-align: left;">S.Y.</th>
          <th style="padding: 10px; text-align: center;">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr style="border-bottom: 1px solid #f0f0f0; transition: background 0.2s ease;" onmouseover="this.style.background='#f4f6fb'" onmouseout="this.style.background='white'">
          <td style="padding: 8px;"><?= htmlspecialchars($row['id']) ?></td>
          <td style="padding: 8px;"><?= htmlspecialchars($row['student_type']) ?></td>
          <td style="padding: 8px;"><?= htmlspecialchars($row['fName']) ?></td>
          <td style="padding: 8px;"><?= htmlspecialchars($row['mName']) ?></td>
          <td style="padding: 8px;"><?= htmlspecialchars($row['lName']) ?></td>
          <td style="padding: 8px;"><?= htmlspecialchars($row['student_id']) ?></td>
          <td style="padding: 8px;"><?= htmlspecialchars($row['email']) ?></td>
          <td style="padding: 8px;"><?= htmlspecialchars($row['strand']) ?></td>
          <td style="padding: 8px;"><?= htmlspecialchars($row['level']) ?></td>
          <td style="padding: 8px;"><?= htmlspecialchars($row['semester']) ?></td>
          <td style="padding: 8px;"><?= htmlspecialchars($row['school_year']) ?></td>
          <td style="padding: 8px; text-align: center; white-space: nowrap;">
            <div style="display: inline-flex; gap: 6px;">
              <a href="edit_students.php?id=<?= $row['id'] ?>" style="color: white; background-color: #3498db; padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 500;">Edit</a>
              <a href="delete_student.php?id=<?= $row['id'] ?>" style="color: white; background-color: #e74c3c; padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 500;" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
            </div>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  function searchTable() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const table = document.getElementById("studentTable");
    const rows = table.getElementsByTagName("tr");

    for (let i = 1; i < rows.length; i++) {
      const lastNameCell = rows[i].getElementsByTagName("td")[4];
      const lrnCell = rows[i].getElementsByTagName("td")[5];

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
