<?php
// Include database connection
include 'db.php';

// ADD balance
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $student_id = $_POST['student_id'];
    $balance = number_format((float)$_POST['balance'], 2, '.', '');
    $description = $_POST['description'];
    $semester = $_POST['semester'];
    $school_year = $_POST['school_year'];
    $grade_level = $_POST['grade_level'];
    $strand = $_POST['strand'];

    $sql = "INSERT INTO account_balance (student_id, balance, description, semester, school_year, grade_level, strand)
            VALUES ('$student_id', '$balance', '$description', '$semester', '$school_year', '$grade_level', '$strand')";
    $conn->query($sql);
     header("Location: teacherdashboard.php");
    exit;
}

// UPDATE balance
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $student_id = $_POST['student_id'];
    $balance = number_format((float)$_POST['balance'], 2, '.', '');
    $sql = "UPDATE account_balance SET balance='$balance' WHERE student_id='$student_id'";
    $conn->query($sql);
}

// DELETE balance
if (isset($_GET['delete'])) {
    $student_id = $_GET['delete'];
    $conn->query("DELETE FROM account_balance WHERE student_id='$student_id'");
      header("Location: teacherdashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Balances</title>
    <link rel="stylesheet" href="css/admin.css">
    <style>
        #soaModal {
            display: none;
            position: fixed; top: 0; left: 0;
            width: 100vw; height: 100vh;
            background: rgba(0,0,0,0.4);
            align-items: center; justify-content: center;
        }
        #soaModalContent {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            min-width: 300px;
            position: relative;
        }
        #soaModalContent span {
            position: absolute;
            top: 10px; right: 15px;
            cursor: pointer;
            font-size: 20px;
        }
    </style>
</head>
<body>

<!-- Statement of Account Modal -->
<div id="soaModal">
    <div id="soaModalContent">
        <span onclick="closeSOA()">&times;</span>
        <div id="soaContent"></div>
    </div>
</div>

<h2>Add Account Balance</h2>
<form method="POST" action="balance.php">
    <input type="hidden" name="add" value="1">
    LRN: <input type="text" name="student_id" required><br>
    Balance (₱): <input type="number" step="0.01" name="balance" required><br>
    Description: <input type="text" name="description" placeholder="e.g., Tuition Fee" required><br>
    Semester: 
    <select name="semester" required>
        <option value="1st Semester">1st Semester</option>
        <option value="2nd Semester">2nd Semester</option>
    </select><br>
    School Year: <input type="text" name="school_year" placeholder="e.g., 2024-2025" required><br>
    Grade Level: 
    <select name="grade_level" required>
        <option value="Grade 11">Grade 11</option>
        <option value="Grade 12">Grade 12</option>
    </select><br>
    Strand:
    <select name="strand" required>
        <option value="STEM">STEM</option>
        <option value="ABM">ABM</option>
        <option value="HUMSS">HUMSS</option>
        <option value="TVL">TVL</option>
        <option value="GAS">GAS</option>
    </select><br>
    <input type="submit" value="Add Balance">
</form>

<h3>Existing Account Balances</h3>

<input type="text" id="searchInput" placeholder="Search" style="margin-top: 20px; padding: 5px; width: 300px;">

<table border="1" cellpadding="5">
<tr>
    <th>LRN</th>
    <th>Balance (₱)</th>
    <th>Description</th>
    <th>Semester</th>
    <th>School Year</th>
    <th>Grade</th>
    <th>Strand</th>
    <th>Last Updated</th>
    <th>Actions</th>
</tr>
<?php
$result = $conn->query("SELECT * FROM account_balance");
while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['student_id']}</td>
        <td>₱" . number_format($row['balance'], 2) . "</td>
        <td>{$row['description']}</td>
        <td>{$row['semester']}</td>
        <td>{$row['school_year']}</td>
        <td>{$row['grade_level']}</td>
        <td>{$row['strand']}</td>
        <td>{$row['date_updated']}</td>
        <td>
            <a href='balance.php?edit={$row['student_id']}'>Edit</a> 
            <a href='balance.php?delete={$row['student_id']}' onclick='return confirm(\"Delete this balance?\")'>Delete</a>
            <button type='button' onclick='generateSOA(\"{$row['student_id']}\", \"{$row['balance']}\", \"{$row['description']}\", \"{$row['semester']}\", \"{$row['school_year']}\", \"{$row['grade_level']}\", \"{$row['strand']}\")'>SOA</button>
        </td>
    </tr>";
}
?>
</table>

<?php
// Edit form
if (isset($_GET['edit'])) {
    $student_id = $_GET['edit'];
    $edit = $conn->query("SELECT * FROM account_balance WHERE student_id='$student_id'")->fetch_assoc();
?>
    <h3>Edit Account Balance</h3>
    <form method="POST" action="balance.php">
        <input type="hidden" name="update" value="1">
        <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($edit['student_id']); ?>">
        LRN: <input type="text" value="<?php echo htmlspecialchars($edit['student_id']); ?>" readonly><br>
        Balance: <input type="number" step="0.01" name="balance" value="<?php echo htmlspecialchars($edit['balance']); ?>" required><br>
        <input type="submit" value="Update Balance">
    </form>
<?php } ?>

<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    const filter = this.value.toUpperCase();
    const rows = document.querySelectorAll('table tr:not(:first-child)');
    rows.forEach(row => {
        const lrn = row.cells[0].textContent.toUpperCase();
        const balance = row.cells[1].textContent.toUpperCase();
        row.style.display = (lrn.includes(filter) || balance.includes(filter)) ? '' : 'none';
    });
});

function generateSOA(studentId, balance, description, semester, schoolYear, gradeLevel, strand) {
    const now = new Date();
    const dateStr = now.toLocaleString();

    document.getElementById('soaContent').innerHTML = `
        <div style="text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 30px;">
            <h2 style="margin: 0;">Lathoug's University</h2>
            <h3 style="margin-top: 10px;">STATEMENT OF ACCOUNT</h3>
        </div>

        <table style="width: 100%; font-size: 16px; margin-bottom: 20px;">
            <tr>
                <td><strong>LRN:</strong></td>
                <td>${studentId}</td>
                <td><strong>Date Generated:</strong></td>
                <td>${dateStr}</td>
            </tr>
            <tr>
                <td><strong>Grade & Strand:</strong></td>
                <td>${gradeLevel} - ${strand}</td>
                <td><strong>School Year:</strong></td>
                <td>${schoolYear}</td>
            </tr>
            <tr>
                <td><strong>Semester:</strong></td>
                <td>${semester}</td>
                <td><strong>Description:</strong></td>
                <td>${description}</td>
            </tr>
            <tr>
                <td><strong>Balance:</strong></td>
                <td colspan="3" style="color: red; font-size: 18px;"><strong>₱${parseFloat(balance).toFixed(2)}</strong></td>
            </tr>
        </table>

        <p style="font-style: italic;">This is your official Statement of Account. Please visit the cashier's office to settle your balance.</p>
    `;

    document.getElementById('soaModal').style.display = 'flex';
}

function closeSOA() {
    document.getElementById('soaModal').style.display = 'none';
}
</script>

</body>
</html>
