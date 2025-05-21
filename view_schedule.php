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
    <meta charset="UTF-8">
    <title>View Schedule</title>
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

        #scheduleTable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        #scheduleTable th, #scheduleTable td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        #scheduleTable th {
            background-color: #f2f2f2;
        }

        #message {
            color: red;
            margin-top: 15px;
            font-weight: bold;
            text-align: center;
        }

        #showScheduleBtn {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            background-color: #0056b3;
            color: white;
            border-radius: 5px;
        }

        #showScheduleBtn:hover {
            background-color: #004a9f;
        }

        .footer-note {
            font-size: 13px;
            margin-top: 20px;
            color: #555;
        }
    </style>
</head>
<body>

<h2>Your Class Schedule</h2>
<button class="back-btn" onclick="window.history.back();">X</button>

<button id="showScheduleBtn">View Schedule</button>

<!-- Modal -->
<div id="scheduleModal" class="modal">
    <div class="modal-content">
        <button class="close-btn" id="closeModalBtn">&times;</button>
        <h2 style="margin-top: 5px; color: #1d3c6a; font-weight: 800;">Lathoug's University</h2>
        <h4 style="margin-top: 20px; font-weight: bold; color: #1d3c6a;">STUDENT SCHEDULE</h4>
        <hr />

        <table id="scheduleTable">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Room</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <div id="message"></div>

        <p class="footer-note">
            For any conflict in your schedule, please contact the registrar.
        </p>
    </div>
</div>

<script>
const studentId = <?php echo json_encode($studentId); ?>;

const modal = document.getElementById('scheduleModal');
const showBtn = document.getElementById('showScheduleBtn');
const closeBtn = document.getElementById('closeModalBtn');
const messageEl = document.getElementById('message');
const scheduleTable = document.getElementById('scheduleTable');
const scheduleBody = scheduleTable.querySelector("tbody");

function showModalAndFetchSchedule() {
    modal.style.display = 'block';
    fetchSchedule();
}

window.addEventListener('DOMContentLoaded', () => {
    showModalAndFetchSchedule(); // Auto-show modal on load
});

showBtn.addEventListener('click', showModalAndFetchSchedule);

closeBtn.addEventListener('click', () => {
    modal.style.display = 'none';
    messageEl.textContent = '';
    scheduleBody.innerHTML = '';
});

window.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.style.display = 'none';
        messageEl.textContent = '';
        scheduleBody.innerHTML = '';
    }
});

function fetchSchedule() {
    messageEl.textContent = 'Loading...';
    scheduleBody.innerHTML = '';
    scheduleTable.style.display = 'none';

    fetch(`view_schedule_api.php?student_id=${encodeURIComponent(studentId)}`)
        .then(response => response.json())
        .then(data => {
            if (!Array.isArray(data) || data.length === 0 || data.error) {
                messageEl.textContent = "No schedule found for your account.";
                return;
            }

            data.forEach(row => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${row.subject}</td>
                    <td>${row.day}</td>
                    <td>${row.time}</td>
                    <td>${row.room}</td>
                `;
                scheduleBody.appendChild(tr);
            });

            messageEl.textContent = '';
            scheduleTable.style.display = 'table';
        })
        .catch(error => {
            console.error(error);
            messageEl.textContent = "Failed to load schedule.";
        });
}
</script>

</body>
</html>
