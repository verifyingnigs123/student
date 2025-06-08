<?php
include 'db.php';

// CREATE
if (isset($_POST['add'])) {
    $email = $_POST['email'];
    if (!empty($_POST['section']) && is_array($_POST['section'])) {
        $stmt = $conn->prepare("INSERT INTO teacher_schedule (email, section) VALUES (?, ?)");
        foreach ($_POST['section'] as $section) {
            $stmt->bind_param("ss", $email, $section);
            $stmt->execute();
        }
        $stmt->close();
    }

    header("Location: teacher_sched.php");
    exit;
}

// UPDATE
if (isset($_POST['update'])) {
    // Single update expects id and section
    $id = intval($_POST['id']);
    $section = $_POST['section'];

    $stmt = $conn->prepare("UPDATE teacher_schedule SET section=? WHERE id=?");
    $stmt->bind_param("si", $section, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: teacher_sched.php");
    exit;
}

// DELETE
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM teacher_schedule WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    header("Location: teacher_sched.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Schedule Management</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        input[type="text"] { margin: 5px; }
        table, th, td { border: 1px solid #444; border-collapse: collapse; padding: 8px; }
        table { margin-top: 20px; width: 100%; }
        button { margin-top: 10px; }
    </style>
</head>
<body>

<h2>Add Teacher Schedule</h2>
<form method="POST" action="teacher_sched.php">
    <input type="hidden" name="add" value="1">
    Email: <input type="text" name="email" required><br><br>
    <div id="scheduleFields">
        <div>
            Section: <input type="text" name="section[]" required><br><br>
        </div>
    </div>
    <button type="button" onclick="addMore()">Add More</button><br><br>
    <input type="submit" value="Add Schedule">
</form>

<script>
function addMore() {
    const container = document.getElementById('scheduleFields');
    const newGroup = document.createElement('div');
    newGroup.innerHTML = `Section: <input type="text" name="section[]" required><br><br>`;
    container.appendChild(newGroup);
}
</script>

<h3>Existing Sections</h3>
<table>
    <tr>
        <th>ID</th><th>Email</th><th>Section</th><th>Actions</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM teacher_schedule ORDER BY id DESC");
    while ($row = $result->fetch_assoc()):
    ?>
    <tr>
        <td><?= htmlspecialchars($row['id']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['section']) ?></td>
        <td>
            <a href="teacher_sched.php?edit=<?= $row['id'] ?>">Edit</a> | 
            <a href="teacher_sched.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this entry?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php
// Edit Form (single edit)
if (isset($_GET['edit'])):
    $id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM teacher_schedule WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $editResult = $stmt->get_result();
    if ($editResult->num_rows > 0):
        $row = $editResult->fetch_assoc();
?>
    <h3>Edit Section ID: <?= htmlspecialchars($row['id']) ?></h3>
    <form method="POST" action="teacher_sched.php">
        <input type="hidden" name="update" value="1">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        Section: <input type="text" name="section" value="<?= htmlspecialchars($row['section']) ?>" required><br><br>
        <input type="submit" value="Update Section">
    </form>
<?php
    endif;
    $stmt->close();
endif;
?>

</body>
</html>
