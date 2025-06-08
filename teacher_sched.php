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
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5faff;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        h2, h3 {
            color: #004080;
        }

        label {
            font-weight: bold;
            color: #003366;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 15px;
            border: 1px solid #b3d1ff;
            border-radius: 4px;
        }

        input[type="submit"], button {
            background-color: #0066cc;
            color: white;
            padding: 10px 20px;
            border: none;
            margin-top: 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover, button:hover {
            background-color: #004080;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table, th, td {
            border: 1px solid #cce0ff;
        }

        th, td {
            text-align: left;
            padding: 10px;
        }

        th {
            background-color: #e6f0ff;
            color: #003366;
        }

        tr:nth-child(even) {
            background-color: #f2f7ff;
        }

        a {
            color: #0066cc;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .form-section {
            margin-top: 20px;
        }
a.edit {
    background-color: darkgreen;
    color: white;
    padding: 6px 12px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: bold;
    display: inline-block;
}


a.delete {
    background-color:darkred;
    color: white;
    padding: 6px 12px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: bold;
    display: inline-block;
}

    </style>
</head>
<body>

<div class="container">
    <h2>Assign Adviser</h2>
    <form method="POST" action="teacher_sched.php">
        <input type="hidden" name="add" value="1">
        <label>Email:</label>
        <input type="text" name="email" required>

        <div id="scheduleFields">
            <label>Section:</label>
            <input type="text" name="section[]" required>
        </div>

        <input type="submit" value="Add Adviser">
    </form>

    <div class="form-section">
        <h3>Existing Adviser</h3>
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
    <a class="edit" href="teacher_sched.php?edit=<?= $row['id'] ?>">Edit</a> | 
    <a class="delete" href="teacher_sched.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this entry?')">Delete</a>
</td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <?php
    if (isset($_GET['edit'])):
        $id = intval($_GET['edit']);
        $stmt = $conn->prepare("SELECT * FROM teacher_schedule WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $editResult = $stmt->get_result();
        if ($editResult->num_rows > 0):
            $row = $editResult->fetch_assoc();
    ?>
    <div class="form-section">
        <h3>Edit Section ID: <?= htmlspecialchars($row['id']) ?></h3>
        <form method="POST" action="teacher_sched.php">
            <input type="hidden" name="update" value="1">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <label>Section:</label>
            <input type="text" name="section" value="<?= htmlspecialchars($row['section']) ?>" required>
            <input type="submit" value="Update Section">
        </form>
    </div>
    <?php
        endif;
        $stmt->close();
    endif;
    ?>
</div>

</body>
</html>
