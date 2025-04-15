<!DOCTYPE html>
<html>
<head>
  <title>Student Grade Viewer</title>
</head>
<body>
  <h2>View Your Grades</h2>
  <label>Enter Student ID (LRN):</label>
  <input type="text" id="studentId">
  <button onclick="loadGrades()">View Grades</button>

  <table border="1" style="margin-top: 20px;">
    <thead>
      <tr><th>Subject</th><th>Grade</th></tr>
    </thead>
    <tbody id="gradesTable">
      <!-- Grades will be loaded here -->
    </tbody>
  </table>

  <script>
    function loadGrades() {
      const studentId = document.getElementById("studentId").value;
      fetch(`view_grades_api.php?student_id=${studentId}`)
        .then(response => response.json())
        .then(data => {
          const table = document.getElementById("gradesTable");
          table.innerHTML = ""; // Clear previous results

          if (data.length === 0 || data.error) {
            table.innerHTML = "<tr><td colspan='2'>No grades found or invalid ID.</td></tr>";
            return;
          }

          data.forEach(row => {
            const tr = document.createElement("tr");
            tr.innerHTML = `<td>${row.subject}</td><td>${row.grade}</td>`;
            table.appendChild(tr);
          });
        })
        .catch(err => {
          console.error(err);
          alert("Failed to load grades.");
        });
    }
  </script>
</body>
</html>
