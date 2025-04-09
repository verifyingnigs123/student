<?php
// Include database connection
include 'db.php'; 

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $balance = $_POST['balance'];

    // Insert account balance into database
    $sql = "INSERT INTO account_balance (student_id, balance) VALUES ('$student_id', '$balance')";
    if ($conn->query($sql) === TRUE) {
        echo "Account balance added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<h2>Add Account Balance</h2>
<form method="POST" action="balance.php">
    LRN: <input type="text" name="student_id" required><br>
    Balance: <input type="number" step="0.01" name="balance" required><br>
    <input type="submit" value="Add Balance">
</form>

<h3>Existing Account Balances</h3>
<table>
    <tr><th>LRN</th><th>Balance</th></tr>
    <?php
    // Fetch account balances from the database
    $result = $conn->query("SELECT * FROM account_balance");
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>{$row['student_id']}</td><td>{$row['balance']}</td></tr>";
    }
    ?>
</table>
