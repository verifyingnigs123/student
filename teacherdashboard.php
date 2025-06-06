<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "student_registration";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if logged in user is a teacher
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: teacherdashboard.php");
    exit();
}

// Get teacher email from session
$teacher_email = $_SESSION['user_id'];

// Fetch teacher last name
$stmt = $conn->prepare("SELECT lName FROM teachers WHERE email = ?");
$stmt->bind_param("s", $teacher_email);
$stmt->execute();
$result = $stmt->get_result();

$teacher_last_name = "Teacher"; // default if not found
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $teacher_last_name = $row['lName'];
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Teacher Dashboard</title>
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
        <a href="#" onclick="loadSection('profile', this)"><i class="fas fa-user"></i> Teacher Profile</a>
        <a href="#" onclick="loadSection('grades', this)"><i class="fas fa-graduation-cap"></i>  Grades</a>
        <a href="#" onclick="loadSection('schedule', this)"><i class="fas fa-calendar-alt"></i> Class Schedule & Subjects</a>
        
      </div>
    </div>
  
  </div>

  <div class="main-content" id="main-content">
    <div class="header">
      <button class="burger" onclick="toggleSidebar()">☰</button>
      <h1> Teacher Dashboard</h1>
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

    <div class="welcome-box" id="content" style="padding: 20px; background: #f0f4ff; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
  <h2>Welcome, <?php echo "Prof. " . htmlspecialchars($teacher_last_name); ?>! 🎉</h2>
  <p style="font-size: 16px; margin-top: 10px;">We're glad to have you back on the platform.</p>

  <ul style="margin-top: 15px; padding-left: 20px; line-height: 1.6;">
    <li>📚 <strong>View and manage your subjects</strong> – Check assigned classes and topics.</li>
    <li>🧑‍🎓 <strong>Access student lists</strong> – Track enrolled students and view profiles.</li>
    <li>📝 <strong>Upload grades and feedback</strong> – Provide academic updates to students.</li>
    <li>📅 <strong>Check your schedule</strong> – Stay on top of your weekly teaching commitments.</li>
    <li>🔐 <strong>Manage your account</strong> – Update your personal information or change your password.</li>
  </ul>

  <p style="margin-top: 15px; color: #555;">Need help? Reach out to the academic office or visit the support section.</p>
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
      fetch('teacherprofile.php')
        .then(response => response.text())
        .then(data => {
          content.innerHTML = `<div class="welcome-box">${data}</div>`;
        });
      break;

case 'grades':
  fetch('grades.php')
        .then(response => response.text())
        .then(data => {
          content.innerHTML = `<div class="welcome-box">${data}</div>`;
        });
  break;


    case 'schedule':
   fetch('schedule.php')
        .then(response => response.text())
        .then(data => {
          content.innerHTML = `<div class="welcome-box">${data}</div>`;
        });
  break;


    case 'balance':
  fetch('balance.php')
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
  fetch('permits.php')
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
  case 'add_user':
    fetch('teachadd_user.php')
        .then(response => response.text())
        .then(data => {
          content.innerHTML = `<div class="welcome-box">${data}</div>`;
        });

  break;
  case 'approval':
    fetch('approvals.php')
        .then(response => response.text())
        .then(data => {
          content.innerHTML = `<div class="welcome-box">${data}</div>`;
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
  function loadSection(section, el = null) {
  const content = document.getElementById('content');
  const links = document.querySelectorAll('.menu a');
  links.forEach(link => link.classList.remove('active'));
  if (el) el.classList.add('active');

  let url = '';

  switch (section) {
        case 'profile':
      url = 'teacherprofile.php';
      break;
    case 'grades':
      url = 'grades.php';
      break;
    case 'schedule':
      url = 'view_schedule.php';
      break;
    // add other cases as needed
  }

  if (!url) return;

  fetch(url)
    .then(res => res.text())
    .then(data => {
      content.innerHTML = `<div class="welcome-box">${data}</div>`;

      // Run inline scripts inside loaded content (if any)
      const div = document.createElement('div');
      div.innerHTML = data;
      const scripts = div.querySelectorAll('script');
      scripts.forEach(script => {
        const newScript = document.createElement('script');
        if (script.src) {
          newScript.src = script.src;
        } else {
          newScript.textContent = script.textContent;
        }
        document.body.appendChild(newScript);
      });

      // Attach event delegation for dynamic edit links inside loaded content
      content.addEventListener('click', function handler(e) {
        // Remove this handler to avoid duplicates on reload
        content.removeEventListener('click', handler);

        // Map section to corresponding edit class prefix & query param
        const editMap = {
          grades: {className: 'edit-grade', param: 'edit_lrn'},
          schedule: {className: 'edit-schedule', param: 'edit_id'},
          balance: {className: 'edit-balance', param: 'edit_id'},
          permits: {className: 'edit-permit', param: 'edit_id'},
          add_user: {className: 'edit-user', param: 'edit_id'},
          approval: {className: 'edit-approval', param: 'edit_id'},
        };

        // Find which edit class was clicked (supports multiple sections)
        for (const key in editMap) {
          const {className, param} = editMap[key];
          if (e.target.classList.contains(className)) {
            e.preventDefault();
            const id = e.target.getAttribute('data-lrn') || e.target.getAttribute('data-id');
            fetch(`${key}.php?${param}=${encodeURIComponent(id)}`)
              .then(res => res.text())
              .then(html => {
                content.innerHTML = `<div class="welcome-box">${html}</div>`;
              });
            return;
          }
        }

        // Fallback: toggle any inline edit forms (optional)
        if (e.target.classList.contains('edit-button')) {
          const form = e.target.closest('.item-row').querySelector('.edit-form');
          if (form) {
            form.style.display = form.style.display === 'block' ? 'none' : 'block';
          }
          return;
        }
      }, { once: true });
    });
}



    
  </script>
</body>
</html>
