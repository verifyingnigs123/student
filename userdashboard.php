






<?php
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: Signin.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$mysqli = new mysqli("localhost", "root", "", "student_registration");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "SELECT * FROM students WHERE student_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $student = $result->fetch_assoc();
} else {
    echo "Student not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Student Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
  />
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", sans-serif;
    }

    body {
      background-color: #eef2f7;
      display: flex;
    }

    .sidebar {
      background: #ffffff;
      width: 250px;
      min-height: 100vh;
      padding: 20px;
      border-right: 2px solid #ccc;
      transition: transform 0.3s ease;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .sidebar.collapsed {
      transform: translateX(-100%);
    }

    .logo {
      text-align: center;
      margin-bottom: 30px;
    }

    .logo img {
      width: 80px;
    }

    .logo h2 {
      font-size: 18px;
      margin-top: 10px;
      color: #222;
    }

    .menu a {
      display: flex;
      align-items: center;
      padding: 12px;
      margin-bottom: 10px;
      background-color: #f5f8fb;
      color: #2b3e50;
      text-decoration: none;
      border-radius: 8px;
      transition: background-color 0.3s;
    }

    .menu a:hover,
    .menu a.active {
      background-color: #d0e6ff;
    }

    .menu i {
      margin-right: 10px;
    }

    .logout-sidebar-btn {
      background-color: #e74c3c;
      color: #fff;
      padding: 10px 15px;
      border: none;
      border-radius: 8px;
      margin-top: 20px;
      cursor: pointer;
      text-align: center;
    }

    .main-content {
      flex: 1;
      padding: 20px;
    }

    .header {
      background-color: #1f3b75;
      color: #fff;
      padding: 15px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-radius: 10px;
      position: relative;
    }

    .burger {
      background: none;
      border: none;
      font-size: 24px;
      color: #fff;
      cursor: pointer;
    }

    .avatar-button {
      background: none;
      border: none;
      cursor: pointer;
      position: relative;
    }

    .avatar-button img {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      border: 2px solid #fff;
    }

    .dropdown {
      display: none;
      position: absolute;
      top: 60px;
      right: 20px;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
      overflow: hidden;
      z-index: 100;
    }

    .dropdown a {
      display: block;
      padding: 10px 15px;
      color: #2c3e50;
      text-decoration: none;
      border-bottom: 1px solid #eee;
    }

    .dropdown a:hover {
      background-color: #f0f0f0;
    }

    .welcome-box {
      margin-top: 20px;
      padding: 30px;
      background-color: #ffffff;
      border-radius: 15px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .modal-overlay {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 100vw;
      background: rgba(0, 0, 0, 0.4);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 1000;
    }

    .modal {
      background-color: #fff;
      padding: 25px 30px;
      border-radius: 10px;
      text-align: center;
      width: 300px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .modal h2 {
      margin-bottom: 20px;
      font-size: 18px;
    }

    .modal button {
      padding: 10px 20px;
      border: none;
      margin: 0 10px;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
    }

    .modal .cancel {
      background-color: #bdc3c7;
    }

    .modal .confirm {
      background-color: #e74c3c;
      color: white;
    }

    @media (max-width: 768px) {
      .sidebar {
        position: absolute;
        z-index: 999;
        top: 0;
        left: 0;
        height: 100vh;
        transform: translateX(-100%);
      }

      .sidebar.collapsed {
        transform: translateX(0);
      }

      .main-content {
        margin-left: 0;
      }

      .overview-section {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  margin-top: 20px;
}

.overview-card {
  background: #f9f9f9;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  flex: 1 1 250px;
}

.reminders {
  margin-top: 40px;
}

.reminders ul {
  padding-left: 20px;
}



    }
  </style>
</head>
<body>
  <div id="sidebar" class="sidebar">
    <div>
      <div class="logo">
        <img src="log1.jpg" alt="Logo" />
        <h2>Lathougs.univ</h2>
      </div>
      <div class="menu" id="menuLinks">
        <a href="#" onclick="loadSection('overview', this)"><i class="fas fa-chart-line"></i> Overview</a>
        <a href="#" onclick="loadSection('profile', this)"><i class="fas fa-user"></i> Student Profile</a>
        <a href="#" onclick="loadSection('grades', this)"><i class="fas fa-graduation-cap"></i> View Grades</a>
        <a href="#" onclick="loadSection('schedule', this)"><i class="fas fa-calendar-alt"></i> Schedule & Subjects</a>
        <a href="#" onclick="loadSection('balance', this)"><i class="fas fa-wallet"></i> Account & Balance</a>
        <a href="#" onclick="loadSection('permits', this)"><i class="fas fa-file-alt"></i> Permits</a>
      </div>
    </div>
  
  </div>

  <div class="main-content" id="main-content">
    <div class="header">
      <button class="burger" onclick="toggleSidebar()">☰</button>
      <h1>Dashboard</h1>
      <div class="avatar-container">
        <button class="avatar-button" onclick="toggleDropdown()">
          <img src="https://i.pravatar.cc/150?img=3" alt="User Avatar" />
        </button>
        <div id="dropdownMenu" class="dropdown">
          <a href="#" onclick="loadSection('profile')"><i class="fas fa-user-circle"></i> View Profile</a>
          <a href="#" onclick="showLogoutModal()"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
      </div>
    </div>

    <div class="welcome-box" id="content">
      <h2>Welcome, <?php echo htmlspecialchars($student['fName']); ?>! 🎉</h2>
      <p>Manage your academic journey with ease.</p>
    </div>
  </div>

  <!-- Logout Modal -->
  <div id="logoutModal" class="modal-overlay" onclick="handleModalClick(event)">
    <div class="modal">
      <h2>Are you sure you want to log out?</h2>
      <button class="cancel" onclick="hideLogoutModal()">Cancel</button>
      <button class="confirm" onclick="logout()">Logout</button>
    </div>
  </div>

  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('collapsed');
    }

    function toggleDropdown() {
      const dropdown = document.getElementById("dropdownMenu");
      dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    }

    window.onclick = function(event) {
      if (!event.target.closest('.avatar-button')) {
        document.getElementById("dropdownMenu").style.display = "none";
      }
    };

    function handleModalClick(event) {
      if (event.target.id === "logoutModal") {
        hideLogoutModal();
      }
    }

    function loadSection(section, el = null) {
  const content = document.getElementById('content');
  const links = document.querySelectorAll('.menu a');
  links.forEach(link => link.classList.remove('active'));
  if (el) el.classList.add('active');

  switch (section) {
    case 'overview':
      fetch('overview.php')
        .then(response => response.text())
        .then(data => {
          content.innerHTML = `<div class="welcome-box">${data}</div>`;
        });
      break;

    case 'profile':
      fetch('student_profile.php')
        .then(response => response.text())
        .then(data => {
          content.innerHTML = `<div class="welcome-box">${data}</div>`;
        });
      break;

case 'grades':
  fetch('view_grades.php')
    .then(response => response.text())
    .then(data => {
      content.innerHTML = data; // inject HTML including modal & script

      // Extract <script> tags from the fetched data and run their JS code
      const div = document.createElement('div');
      div.innerHTML = data;
      const scripts = div.querySelectorAll('script');

      scripts.forEach(script => {
        const newScript = document.createElement('script');
        if (script.src) {
          newScript.src = script.src; // external script
        } else {
          newScript.textContent = script.textContent; // inline script
        }
        document.body.appendChild(newScript);
      });

      // Now call your function to show modal and fetch grades
      setTimeout(() => {
        if (typeof showModalAndFetchGrades === 'function') {
          showModalAndFetchGrades();
        } else {
          const modal = document.getElementById('gradesModal');
          if (modal) modal.style.display = 'block';
        }
      }, 100);
    });
  break;


    case 'schedule':
  fetch('view_schedule.php')
    .then(response => response.text())
    .then(data => {
      content.innerHTML = data; // inject HTML including modal & script

      // Extract <script> tags from the fetched data and run their JS code
      const div = document.createElement('div');
      div.innerHTML = data;
      const scripts = div.querySelectorAll('script');

      scripts.forEach(script => {
        const newScript = document.createElement('script');
        if (script.src) {
          newScript.src = script.src; // external script
        } else {
          newScript.textContent = script.textContent; // inline script
        }
        document.body.appendChild(newScript);
      });

      // Call your function to show modal and fetch schedule (if defined)
      setTimeout(() => {
        if (typeof showModalAndFetchSchedule === 'function') {
          showModalAndFetchSchedule();
        } else {
          const modal = document.getElementById('scheduleModal');
          if (modal) modal.style.display = 'block';
        }
      }, 100);
    });
  break;


    case 'balance':
  fetch('view_balance.php')
    .then(res => res.text())
    .then(data => {
      content.innerHTML = data; // inject full HTML including modal & scripts

      // Extract <script> tags and run their JS code
      const div = document.createElement('div');
      div.innerHTML = data;
      const scripts = div.querySelectorAll('script');

      scripts.forEach(script => {
        const newScript = document.createElement('script');
        if (script.src) {
          newScript.src = script.src; // external script
        } else {
          newScript.textContent = script.textContent; // inline script
        }
        document.body.appendChild(newScript);
      });

      // Optionally call a function to show modal or just display the modal
      setTimeout(() => {
        if (typeof showModalAndFetchBalance === 'function') {
          showModalAndFetchBalance();
        } else {
          const modal = document.getElementById('balanceModal');
          if (modal) modal.style.display = 'block';
        }
      }, 100);
    });
  break;

   case 'permits':
  fetch('view_permits.php')
    .then(res => res.text())
    .then(data => {
      content.innerHTML = data;

      // Extract and run scripts in fetched HTML
      const div = document.createElement('div');
      div.innerHTML = data;
      const scripts = div.querySelectorAll('script');

      const scriptPromises = [];

      scripts.forEach(script => {
        const newScript = document.createElement('script');
        if (script.src) {
          newScript.src = script.src;
          const p = new Promise((resolve) => {
            newScript.onload = resolve;
            newScript.onerror = resolve;
          });
          scriptPromises.push(p);
        } else {
          newScript.textContent = script.textContent;
        }
        document.body.appendChild(newScript);
      });

      Promise.all(scriptPromises).then(() => {
        // Call modal show + fetch function explicitly
        if (typeof showModalAndFetchPermits === 'function') {
          showModalAndFetchPermits();
        } else {
          const modal = document.getElementById('permitModal');
          if (modal) modal.style.display = 'block';
        }
      });
    });
  break;

    default:
      content.innerHTML = `<div class="welcome-box"><h2>Welcome</h2><p>Select an option from the sidebar to continue.</p></div>`;
  }
}

    function showLogoutModal() {
      document.getElementById('logoutModal').style.display = 'flex';
    }

    function hideLogoutModal() {
      document.getElementById('logoutModal').style.display = 'none';
    }

    function logout() {
      window.location.href = "loading.php?redirect=Signin.php";
    }
    
  </script>
</body>
</html>
