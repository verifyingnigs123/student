<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="admin.css" />
  <style>
    @media screen and (max-width: 768px) {
      .sidebar {
        position: absolute;
        z-index: 1000;
        height: 100%;
        left: -250px;
        transition: left 0.3s ease;
      }
      .sidebar.collapsed {
        left: 0;
      }
      .content {
        margin-left: 0;
        width: 100%;
      }
    }
    .main-section {
      padding: 20px;
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
      margin-top: 20px;
    }
    .modal-overlay {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
      z-index: 2000;
    }
    .modal-box {
      background-color: #fff;
      padding: 30px;
      border-radius: 8px;
      text-align: center;
      max-width: 400px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    .modal-buttons {
      margin-top: 20px;
      display: flex;
      justify-content: center;
      gap: 20px;
    }
    .modal-buttons button {
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .btn-yes { background-color: #d9534f; color: #fff; }
    .btn-no { background-color: #5bc0de; color: #fff; }
    .student-table-container {
      overflow-x: auto;
      font-size: 0.8em;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 6px 8px;
      text-align: center;
    }
    th {
      background-color: #f4f4f4;
    }
    .search-bar {
      margin: 15px 0;
    }
    .search-bar input {
      padding: 8px;
      width: 100%;
      max-width: 300px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    .btn-edit, .btn-delete {
      padding: 4px 8px;
      margin: 2px;
      text-decoration: none;
      border-radius: 4px;
      font-size: 0.8em;
    }
    .btn-edit { background-color: #5cb85c; color: white; }
    .btn-delete { background-color: #d9534f; color: white; }
    
    .btn-add-teacher {
  display: inline-block;
  background-color: #007bff;
  color: white;
  padding: 6px 12px;
  border-radius: 5px;
  text-decoration: none;
  margin-bottom: 10px;
  font-size: 0.85em;
}

  </style>
</head>
<body>
  <div class="sidebar" id="sidebar">
    <div class="logo-container">
      <div class="logo">RV</div>
      <div class="portal-title">Admin Dashboard</div>
    </div>
    <div class="menu">
      <div class="menu-item active" data-section="dashboard">
        <i class="fas fa-home"></i><span>Dashboard</span>
      </div>
      <div class="menu-item" data-section="teachers">
        <i class="fas fa-chalkboard-teacher"></i><span>Teachers</span>
      </div>
      <div class="menu-item" data-section="students">
        <i class="fas fa-user-graduate"></i><span>Students</span>
      </div>
      <div class="menu-item" data-section="logout">
        <i class="fas fa-sign-out-alt"></i><span>Logout</span>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="topbar">
      <div class="topbar-left">
        <div class="menu-toggle" id="menu-toggle">
          <i class="fas fa-bars"></i>
        </div>
        <div>Home</div>
      </div>
      <div class="topbar-right">
        <i class="fas fa-bell"></i>
        <div class="user-avatar">A</div>
      </div>
    </div>

    <div class="dashboard">
      <h1 class="dashboard-title">User Management</h1>
      <div id="main-section" class="main-section">
        <!-- Content will be inserted here -->
      </div>
    </div>
  </div>

  <!-- Logout Modal -->
  <div id="logoutModal" class="modal-overlay">
    <div class="modal-box">
      <h3>Do you really want to log out?</h3>
      <div class="modal-buttons">
        <button class="btn-yes" onclick="confirmLogout(true)">Yes</button>
        <button class="btn-no" onclick="confirmLogout(false)">No</button>
      </div>
    </div>
  </div>

  <script>
    const sidebar = document.getElementById('sidebar');
    const menuToggle = document.getElementById('menu-toggle');
    const menuItems = document.querySelectorAll('.menu-item');
    const mainSection = document.getElementById('main-section');
    const logoutModal = document.getElementById('logoutModal');

    const contentMap = {
      dashboard: `
        <div class="dashboard-cards">
          <div class="card card-events" onclick="location.href='teachers.php'">
            <div class="card-content">
              <i class="fas fa-chalkboard-teacher"></i>
              <div class="card-label">Manage Teachers</div>
            </div>
          </div>
          <div class="card card-payments" onclick="location.href='add_users.php'">
            <div class="card-content">
              <i class="fas fa-user-graduate"></i>
              <div class="card-label">Manage Students</div>
            </div>
          </div>
        </div>
      `,
      teachers: `
      <div class="student-table-container">
    <h2>Teacher List</h2>

    <a href="add_teacher.php" class="btn btn-add-teacher">Add Teacher</a>

    <div class="search-bar">
      <input type="text" id="searchInput" placeholder="Search by Last Name or Email" onkeyup="searchTable()">
    </div>

    <table id="studentTable">
      <thead>
        <tr>
          <th>ID</th>
          <th>Firstname</th>
          <th>Middlename</th>
          <th>Lastname</th>
          <th>Email</th>
          <th>Contact no.</th>
          <th>Subject/Strand</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Maria</td>
          <td>L.</td>
          <td>Santos</td>
          <td>maria.santos@example.com</td>
          <td>09171234567</td>
          <td>English</td>
          <td>
            <a href="#" class="btn btn-edit">Edit</a>
            <a href="#" class="btn btn-delete" onclick="return confirm('Delete this teacher?')">Delete</a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
      `,
      students: `
        <div class="student-table-container">
          <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search by Last Name or LRN" onkeyup="searchTable()">
          </div>
          <table id="studentTable">
            <thead>
              <tr>
                <th>ID</th>
                <th>Student Type</th>
                <th>Firstname</th>
                <th>Middlename</th>
                <th>Lastname</th>
                <th>Student LRN</th>
                <th>Email</th>
                <th>Strand</th>
                <th>Level</th>
                <th>Semester</th>
                <th>School Year</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td><td>Regular</td><td>John</td><td>A.</td><td>Doe</td><td>1234567890</td><td>john@example.com</td><td>STEM</td><td>11</td><td>1st</td><td>2024-2025</td>
                <td>
                  <a href="#" class="btn btn-edit">Edit</a>
                  <a href="#" class="btn btn-delete" onclick="return confirm('Delete this student?')">Delete</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      `,
      logout: null
    };

    // Initial load - show dashboard
    mainSection.innerHTML = contentMap['dashboard'];

    menuToggle.addEventListener('click', () => {
      sidebar.classList.toggle('collapsed');
    });

menuItems.forEach(item => {
  item.addEventListener('click', function () {
    const section = this.getAttribute('data-section');

    if (section === 'logout') {
      logoutModal.style.display = 'flex';
    } else if (section === 'students') {
      window.location.href = 'add_users.php';
    } else if (section === 'teachers') {
      window.location.href = 'teachers.php';
    } else {
      menuItems.forEach(i => i.classList.remove('active'));
      this.classList.add('active');
      mainSection.innerHTML = contentMap[section] || '<p>Section not found.</p>';
    }
  });
});


    function confirmLogout(confirmed) {
      logoutModal.style.display = 'none';
      if (confirmed) {
        window.location.href = "loading.php?redirect= Signin.php";
      }
    }

    function searchTable() {
      const input = document.getElementById("searchInput").value.toLowerCase();
      const rows = document.querySelectorAll("#studentTable tbody tr");
      rows.forEach(row => {
        const cells = row.querySelectorAll("td");
        const lastName = cells[4]?.textContent.toLowerCase();
        const lrn = cells[5]?.textContent.toLowerCase();
        row.style.display = (lastName.includes(input) || lrn.includes(input)) ? "" : "none";
      });
    }
  </script>
</body>
</html>