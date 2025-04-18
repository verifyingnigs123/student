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
<html>
<head>
    <title>View Permits</title>
    <button class="back-btn" onclick="window.history.back();">X</button>
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

<h2>Permits</h2>
<p id="message">Loading your permits...</p>

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
    const studentId = "<?php echo $studentId; ?>";

    window.onload = function() {
        const message = document.getElementById('message');
        const table = document.getElementById('permitTable');
        const tbody = table.querySelector('tbody');

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
    };
</script>

</body>
</html>
