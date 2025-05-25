<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: Signin.php");
    exit();
}

$studentId = $_SESSION['student_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Permits</title>
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
            width: 700px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }

        th, td {
            border: 1px solid #888;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        #message {
            margin-top: 15px;
            color: red;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>

<h2>Your Permits</h2>

<!-- Modal -->
<div id="permitModal" class="modal">
    <div class="modal-content">
        <button class="close-btn" id="closeModalBtn">&times;</button>
        <h2 style="color: #1d3c6a; font-weight: 800;">Lathoug's University</h2>
        <h4 style="margin-top: 20px; font-weight: bold; color: #1d3c6a;">PERMIT RECORD</h4>
        <hr />
        

        <!-- Message and Table -->
        <p id="message">Loading your permits...</p>

        <table id="permitTable" style="display: none;">
            <thead>
                <tr>
                    <th>Permit ID</th>
                    <th>Permit Type</th>
                    <th>Status</th>
                    <th>Issue Date</th>
                    <th>Expiration Date</th>
                </tr>
            </thead>
            
            <tbody></tbody>
        </table>
            <p style="color: #d9534f; font-weight: 600; font-size: 13px; margin-bottom: 15px; margin-top: 30px;">
            Please settle your permit with the Finance Office to avoid any delays in processing.
        </p>
    </div>
</div>

<script>
const studentId = <?php echo json_encode($studentId); ?>;

const modal = document.getElementById('permitModal');
const closeBtn = document.getElementById('closeModalBtn');
const message = document.getElementById('message');
const table = document.getElementById('permitTable');
const tbody = table.querySelector('tbody');

// Show modal on load
window.addEventListener('DOMContentLoaded', () => {
    modal.style.display = 'block';
    fetchPermits();
});

// Close modal
closeBtn.addEventListener('click', () => {
    modal.style.display = 'none';
    message.textContent = '';
    table.style.display = 'none';
    tbody.innerHTML = '';
});

// Close if click outside modal
window.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.style.display = 'none';
        message.textContent = '';
        table.style.display = 'none';
        tbody.innerHTML = '';
    }
});

function fetchPermits() {
    fetch('view_permits_api.php?student_id=' + encodeURIComponent(studentId))
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                message.textContent = data.error;
            } else if (Array.isArray(data) && data.length > 0) {
                tbody.innerHTML = '';
                data.forEach(permit => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${permit.permit_id}</td>
                        <td>${permit.permit_type}</td>
                        <td>${permit.status}</td>
                        <td>${permit.issue_date}</td>
                        <td>${permit.expiration_date}</td>
                    `;
                    tbody.appendChild(tr);
                });
                table.style.display = 'table';
                message.textContent = '';
            } else {
                message.textContent = 'No permits found.';
            }
        })
        .catch(error => {
            message.textContent = 'Error fetching permit information.';
            console.error(error);
        });
}
</script>

</body>
</html>
