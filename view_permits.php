<!DOCTYPE html>
<html>
<head>
    <title>View Permits</title>
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

<h2>Enter Your Student ID to View Permits</h2>
<input type="text" id="studentIdInput" placeholder="Enter Student ID">
<button onclick="fetchPermits()">View Permits</button>

<p id="message"></p>

<!-- Permit Information Table -->
<table id="permitTable">
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

<script>
function fetchPermits() {
    const studentId = document.getElementById('studentIdInput').value.trim();
    const message = document.getElementById('message');
    const table = document.getElementById('permitTable');
    const tbody = table.querySelector('tbody');
    tbody.innerHTML = '';
    table.style.display = 'none';
    message.textContent = 'Loading...';

    if (studentId === '') {
        message.textContent = 'Please enter a Student ID.';
        return;
    }

    fetch('view_permits_api.php?student_id=' + studentId)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                message.textContent = data.error;
            } else {
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
