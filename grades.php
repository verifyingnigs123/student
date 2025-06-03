<?php
// Include database connection
include 'db.php';

// CREATE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $student_id = $_POST['student_id'];
    $subjects = $_POST['subject'];
    $grades = $_POST['grade'];

    // Insert the grades
    $stmt = $conn->prepare("INSERT INTO grades (student_id, subject, grade) VALUES (?, ?, ?)");
    for ($i = 0; $i < count($subjects); $i++) {
        $stmt->bind_param("sss", $student_id, $subjects[$i], $grades[$i]);
        $stmt->execute();
    }
    $stmt->close();
    
     header("Location: teacherdashboard.php");
    exit;
}

// UPDATE MULTIPLE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_all'])) {
    $student_id = $_POST['student_id'];
    $subjects = $_POST['subject'];
    $grades = $_POST['grade'];

    // Delete existing grades for that LRN
    $stmt = $conn->prepare("DELETE FROM grades WHERE student_id=?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $stmt->close();

    // Insert updated grades
    $stmt = $conn->prepare("INSERT INTO grades (student_id, subject, grade) VALUES (?, ?, ?)");
    for ($i = 0; $i < count($subjects); $i++) {
        $stmt->bind_param("sss", $student_id, $subjects[$i], $grades[$i]);
        $stmt->execute();
    }
    $stmt->close();

    header("Location: teacherdashboard.php");
    exit;
}

// DELETE
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM grades WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: teacherdashboard.php");
exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Grades Management</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
    <style>
        body { font-family: Arial; padding: 20px; }
        input[type="text"] { margin: 5px; }
        table, th, td { border: 1px solid #444; border-collapse: collapse; padding: 8px; }
        table { margin-top: 20px; width: 100%; }
        button { margin-top: 10px; }
        .edit-form { background: #f9f9f9; padding: 10px; margin-top: 20px; border: 1px solid #ccc; }
        .subject-row { margin-bottom: 10px; }
    </style>
</head>
<body>

<h2>Add Grade</h2>
<form method="POST" action="grades.php">
    <input type="hidden" name="add" value="1">
    LRN: <input type="text" name="student_id" required><br>
    <div id="addSubjects">
        Subject: <input type="text" name="subject[]" required>
        Grade: <input type="text" name="grade[]" required><br>
    </div>
    <button type="button" onclick="addMore()">Add More Subjects</button><br><br>
    <input type="submit" value="Add Grade">
</form>

<h3>Existing Grades</h3>

<input type="text" id="searchInput" placeholder="Search" style="margin-top: 20px; padding: 5px; width: 300px;">

<table>
    <tr><th>LRN</th><th>Subject</th><th>Grade</th><th>Actions</th></tr>
    <?php
    $result = $conn->query("SELECT * FROM grades ORDER BY student_id");
    if ($result) {
        while($row = $result->fetch_assoc()) {
      echo "<tr>
    <td>" . htmlspecialchars($row['student_id']) . "</td>
    <td>" . htmlspecialchars($row['subject']) . "</td>
    <td>" . htmlspecialchars($row['grade']) . "</td>
    <td>
        <a href=\"#\" class=\"edit-grade\" data-lrn=\"" . htmlspecialchars($row['student_id']) . "\">Edit</a> |
        <a href='grades.php?delete=" . urlencode($row['id']) . "' onclick=\"return confirm('Delete this grade?')\">Delete</a>
    </td>
</tr>";

        }
    }
    ?>
</table>

<?php
// Show Edit Form for ALL grades by student_id
if (isset($_GET['edit_lrn'])) {
    $student_id = $_GET['edit_lrn'];
    $stmt = $conn->prepare("SELECT * FROM grades WHERE student_id=?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $grades = [];
    while ($row = $result->fetch_assoc()) {
        $grades[] = $row;
    }
    $stmt->close();

    if (count($grades) > 0):
?>
    <div class="edit-form">
        <h3>Edit Grades for LRN: <?php echo htmlspecialchars($student_id); ?></h3>
        <form method="POST" action="grades.php">
            <input type="hidden" name="update_all" value="1">
            <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>">
            <div id="editSubjects">
                <?php foreach ($grades as $g): ?>
                <div class="subject-row">
                    Subject: <input type="text" name="subject[]" value="<?php echo htmlspecialchars($g['subject']); ?>" required>
                    Grade: <input type="text" name="grade[]" value="<?php echo htmlspecialchars($g['grade']); ?>" required>
                </div>
                <?php endforeach; ?>
            </div>
            <input type="submit" value="Update All Grades">
        </form>
    </div>
<?php
    endif;
}
?>

<script>
function addMore() {
    const div = document.createElement("div");
    div.classList.add("subject-row");
    div.innerHTML = `
        Subject: <input type="text" name="subject[]" required>
        Grade: <input type="text" name="grade[]" required><br>
    `;
    document.getElementById("addSubjects").appendChild(div);
}
document.getElementById("searchInput").addEventListener("keyup", function () {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll("table tr:not(:first-child)");

    rows.forEach(row => {
        const lrn = row.cells[0].textContent.toLowerCase();
        const subject = row.cells[1].textContent.toLowerCase();
        if (lrn.includes(filter) || subject.includes(filter)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});
// Delegate click event to the content container for dynamically loaded links
document.getElementById('content').addEventListener('click', function(e) {
  if (e.target.classList.contains('edit-grade')) {
    e.preventDefault();
    const lrn = e.target.getAttribute('data-lrn');

    fetch(`grades.php?edit_lrn=${encodeURIComponent(lrn)}`)
      .then(response => response.text())
      .then(data => {
        // Replace content with the full grades page but with edit form shown
        // Or, better, just replace the part that shows the form (you can adjust)
        this.innerHTML = `<div class="welcome-box">${data}</div>`;
      });
  }
});


</script>

</body>
</html>
