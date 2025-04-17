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
    <title>View Schedule</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        h2 { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; display: none; }
        th, td { border: 1px solid #888; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        #message { margin-top: 15px; color: red; }

        .back-btn {
      position: absolute;
      top: 20px;
      right: 20px; 
      font-size: 24px;
      background-color: transparent;
      border: none;
      color: #000;
      cursor: pointer;
    }
    
    </style>
</head>
<body>

<h2>Your Class Schedule</h2>
<button class="back-btn" onclick="window.history.back();">X</button>

<p id="message"></p>

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

<script>
    const studentId = <?php echo json_encode($studentId); ?>;

    document.addEventListener('DOMContentLoaded', fetchSchedule);

    function fetchSchedule() {
        const message = document.getElementById('message');
        const table = document.getElementById('scheduleTable');
        const tbody = table.querySelector('tbody');
        tbody.innerHTML = '';
        table.style.display = 'none';
        message.textContent = 'Loading...';

        fetch('view_schedule_api.php?student_id=' + studentId)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    data.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${row.subject}</td>
                            <td>${row.day}</td>
                            <td>${row.time}</td>
                             <td>${row.room}</td>
                        `;
                        tbody.appendChild(tr);
                    });
                    table.style.display = 'table';
                    message.textContent = '';
                } else {
                    message.textContent = 'No schedule found for your account.';
                }
            })
            .catch(error => {
                message.textContent = 'Error fetching schedule.';
                console.error(error);
            });
    }
</script>

</body>
</html>
