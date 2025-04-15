<!DOCTYPE html>
<html>
<head>
    <title>View Schedule</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        h2 { margin-bottom: 10px; }
        input[type="text"] { padding: 5px; margin-right: 10px; }
        button { padding: 6px 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; display: none; }
        th, td { border: 1px solid #888; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        #message { margin-top: 15px; color: red; }
    </style>
</head>
<body>

<h2>Enter Student ID to View Schedule</h2>
<input type="text" id="studentIdInput" placeholder="Enter Student ID">
<button onclick="fetchSchedule()">View Schedule</button>

<p id="message"></p>

<table id="scheduleTable">
    <thead>
        <tr>
            <th>Subject</th>
            <th>Day</th>
            <th>Time</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<script>
function fetchSchedule() {
    const studentId = document.getElementById('studentIdInput').value.trim();
    const message = document.getElementById('message');
    const table = document.getElementById('scheduleTable');
    const tbody = table.querySelector('tbody');
    tbody.innerHTML = '';
    table.style.display = 'none';
    message.textContent = 'Loading...';

    if (studentId === '') {
        message.textContent = 'Please enter a Student ID.';
        return;
    }

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
                    `;
                    tbody.appendChild(tr);
                });
                table.style.display = 'table';
                message.textContent = '';
            } else {
                message.textContent = 'No schedule found for this Student ID.';
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
