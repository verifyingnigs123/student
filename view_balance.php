<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: Signin.php");
    exit();
}
$studentId = $_SESSION['student_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>View Balance</title>
    <!-- Google Font for cleaner appearance -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', Arial, sans-serif;
            padding: 20px;
            background-color: #f9f9f9;
        }

        h2 {
            margin-bottom: 10px;
        }

        .back-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 24px;
            background-color: transparent;
            border: none;
            color: #1d3c6a;
            font-weight: bold;
            cursor: pointer;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 30px;
            border: 1px solid #888;
            width: 600px;
            max-width: 95%;
            border-radius: 8px;
            text-align: center;
            position: relative;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            font-size: 15px;
        }

        .close-btn {
            color: #aaa;
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            font-weight: bold;
            border: none;
            background: none;
            cursor: pointer;
        }

        .close-btn:hover {
            color: #000;
        }

        #balance-details {
            margin-top: 20px;
            text-align: left;
            color: #333;
        }

        #balance-details div {
            margin-bottom: 6px;
        }

        #message {
            color: red;
            margin-top: 15px;
            font-weight: bold;
            text-align: center;
        }

        #showBalanceBtn {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
        }

        #showBalanceBtn:hover {
            background-color: #0056b3;
        }

        hr {
            margin: 10px 0;
            border-top: 1.5px solid #333;
        }

        .footer-note {
            font-size: 13px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h2>Your Account</h2>
<button class="back-btn" onclick="window.history.back();">X</button>

<!-- Show balance button -->
<button id="showBalanceBtn">View Account Balance</button>

<!-- Modal -->
<div id="balanceModal" class="modal">
  <div class="modal-content">
    <button class="close-btn" id="closeModalBtn">&times;</button>
    <h2 style="margin-top: 5px; color: #1d3c6a; font-weight: 800;">Lathoug's University</h2>
    <h4 style="margin-top: 20px; font-weight: bold; color: #1d3c6a;">STATEMENT OF ACCOUNT</h4>
    <hr />

    <div id="balance-details">
        <!-- Populated by JavaScript -->
    </div>

    <p class="footer-note">
        This is your official Statement of Account. Please visit the cashier's office to settle your balance.
    </p>
    <div id="message"></div>
  </div>
</div>

<script>
const studentId = <?php echo json_encode($studentId); ?>;

const modal = document.getElementById('balanceModal');
const showBtn = document.getElementById('showBalanceBtn');
const closeBtn = document.getElementById('closeModalBtn');
const messageEl = document.getElementById('message');
const balanceEl = document.getElementById('balance-details');

// Function to show modal and fetch balance
function showModalAndFetchBalance() {
    modal.style.display = 'block';
    fetchBalance();
}

// Automatically show modal when the page loads
window.addEventListener('DOMContentLoaded', () => {
    showModalAndFetchBalance();
});

// (Optional) If you still want the button to work manually
showBtn.addEventListener('click', showModalAndFetchBalance);


closeBtn.addEventListener('click', () => {
    modal.style.display = 'none';
    messageEl.textContent = '';
    balanceEl.textContent = '';
});

window.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.style.display = 'none';
        messageEl.textContent = '';
        balanceEl.textContent = '';
    }
});

function fetchBalance() {
    messageEl.textContent = 'Loading...';
    balanceEl.textContent = '';

    fetch('view_balance_api.php?student_id=' + encodeURIComponent(studentId))
    .then(response => response.json())
    .then(data => {
        if (!data.error) {
            balanceEl.innerHTML = `
                <div><strong>LRN:</strong> ${data.student_id}</div>
                <div><strong>Date Generated:</strong> ${data.date_updated}</div>
                <div><strong>Grade & Strand:</strong> Grade ${data.grade_level} - ${data.strand}</div>
                <div><strong>School Year:</strong> ${data.school_year}</div>
                <div><strong>Semester:</strong> ${data.semester}</div>
                <div><strong>Description:</strong> ${data.description}</div>
                <div><strong>Balance:</strong> <span style="color:red; font-weight:bold;">₱${parseFloat(data.balance).toFixed(2)}</span></div>
            `;
            messageEl.textContent = '';
        } else {
            messageEl.textContent = data.error;
            balanceEl.textContent = '';
        }
    })
    .catch(error => {
        messageEl.textContent = 'Error fetching balance.';
        balanceEl.textContent = '';
        console.error(error);
    });
}
</script>

</body>
</html>
