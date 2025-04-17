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
  <title>Student Grade Viewer</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    h2 { margin-bottom: 10px; }
    table { border-collapse: collapse; width: 100%; margin-top: 20px; display: none; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
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

<h2>Your Grades</h2> 

<button class="back-btn" onclick="window.history.back();">X</button>

<p id="message"></p>

<table id="gradesTable">
  <thead>
    <tr><th>Subject</th><th>Grade</th></tr>
  </thead>
  <tbody>
    <!-- Grades will be inserted here -->
  </tbody>
</table>

<script>
  const studentId = <?php echo json_encode($studentId); ?>;

  document.addEventListener("DOMContentLoaded", loadGrades);

  function loadGrades() {
    const table = document.getElementById("gradesTable");
    const tbody = table.querySelector("tbody");
    const message = document.getElementById("message");

    tbody.innerHTML = "";
    message.textContent = "Loading...";
    table.style.display = "none";

    fetch(`view_grades_api.php?student_id=${studentId}`)
      .then(response => response.json())
      .then(data => {
        if (data.length === 0 || data.error) {
          message.textContent = "No grades found for your account.";
          return;
        }

        data.forEach(row => {
          const tr = document.createElement("tr");
          tr.innerHTML = `<td>${row.subject}</td><td>${row.grade}</td>`;
          tbody.appendChild(tr);
        });

        message.textContent = "";
        table.style.display = "table";
      })
      .catch(error => {
        console.error(error);
        message.textContent = "Failed to load grades.";
      });
  }
</script>

</body>
</html>
