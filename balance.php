<?php
// Include database connection
include 'db.php';

// ADD balance
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $student_id = $_POST['student_id'];
    $balance = $_POST['balance'];

    // Ensure balance ends with "00"
    $balance = number_format((float)$balance, 2, '.', '');

    $sql = "INSERT INTO account_balance (student_id, balance) VALUES ('$student_id', '$balance')";
    $conn->query($sql);
}

// UPDATE balance
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $student_id = $_POST['student_id'];
    $balance = $_POST['balance'];

    // Ensure balance ends with "00"
    $balance = number_format((float)$balance, 2, '.', '');

    $sql = "UPDATE account_balance SET balance='$balance' WHERE student_id='$student_id'";
    $conn->query($sql);
}

// DELETE balance
if (isset($_GET['delete'])) {
    $student_id = $_GET['delete'];
    $conn->query("DELETE FROM account_balance WHERE student_id='$student_id'");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Balances</title>
    <link rel="stylesheet" type="text/css" href="css/admin.css">
</head>
<body>
    
</body>
</html>

<h2>Add Account Balance</h2>
<form method="POST" action="balance.php">
    <input type="hidden" name="add" value="1">
    LRN: <input type="text" name="student_id" required><br>
    Balance: <input type="number" step="0.01" name="balance" required><br>
    <input type="submit" value="Add Balance">
</form>

<h3>Existing Account Balances</h3>

<input type="text" id="searchInput" placeholder="Search" style="margin-top: 20px; padding: 5px; width: 300px;">

<table border="1" cellpadding="5">
    <tr><th>LRN</th><th>Balance</th><th>Actions</th></tr>
    <?php
    $result = $conn->query("SELECT * FROM account_balance");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['student_id']}</td>
            <td>{$row['balance']}</td>
            <td>
                <a href='balance.php?edit={$row['student_id']}'>Edit</a> | 
                <a href='balance.php?delete={$row['student_id']}' onclick='return confirm(\"Delete this balance?\")'>Delete</a>
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
        if (lrn.includes(filter) || balance.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

