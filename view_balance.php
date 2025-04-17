<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: Signin.php");
    exit();
}
$studentId = $_SESSION['student_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Balance</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        h2 { margin-bottom: 10px; }
        #message { margin-top: 15px; color: red; }
        #balance { margin-top: 20px; font-size: 18px; color: green; }

        .back-btn {
      position: absolute;
      top: 20px;
      right: 20px; /* Move the button to the right side */
      font-size: 24px;
      background-color: transparent;
      border: none;
      color: #000;
      cursor: pointer;
    }
    
    </style>
</head>
<body>

<h2>Your Account Balance</h2>
<button class="back-btn" onclick="window.history.back();">X</button>
<p id="message"></p>
<p id="balance"></p>

<script>
const studentId = <?php echo json_encode($studentId); ?>;

document.addEventListener('DOMContentLoaded', fetchBalance);

function fetchBalance() {
    const message = document.getElementById('message');
    const balance = document.getElementById('balance');
    balance.textContent = '';
    message.textContent = 'Loading...';

    fetch('view_balance_api.php?student_id=' + studentId)
        .then(response => response.json())
        .then(data => {
            if (data.balance !== undefined) {
                balance.textContent = 'Balance: ₱' + parseFloat(data.balance).toFixed(2);
                message.textContent = '';
            } else {
                message.textContent = data.error || 'No balance found for your account.';
            }
        })
        .catch(error => {
            message.textContent = 'Error fetching balance.';
            console.error(error);
        });
}
</script>

</body>
</html>
