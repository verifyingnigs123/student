<!DOCTYPE html>
<html>
<head>
    <title>View Balance</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        h2 { margin-bottom: 10px; }
        input[type="text"] { padding: 5px; margin-right: 10px; }
        button { padding: 6px 12px; }
        #message { margin-top: 15px; color: red; }
        #balance { margin-top: 20px; font-size: 18px; color: green; }
    </style>
</head>
<body>

<h2>Enter Student ID to View Balance</h2>
<input type="text" id="studentIdInput" placeholder="Enter Student ID">
<button onclick="fetchBalance()">View Balance</button>

<p id="message"></p>
<p id="balance"></p>

<script>
function fetchBalance() {
    const studentId = document.getElementById('studentIdInput').value.trim();
    const message = document.getElementById('message');
    const balance = document.getElementById('balance');
    balance.textContent = '';
    message.textContent = 'Loading...';

    if (studentId === '') {
        message.textContent = 'Please enter a Student ID.';
        return;
    }

    fetch('view_balance_api.php?student_id=' + studentId)
        .then(response => response.json())
        .then(data => {
            if (data.balance !== undefined) {
                balance.textContent = 'Balance: ' + data.balance;
                message.textContent = '';
            } else {
                message.textContent = data.error || 'No balance found for this Student ID.';
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
