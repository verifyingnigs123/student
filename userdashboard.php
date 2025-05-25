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
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e4/Academic_Cap.svg/1200px-Academic_Cap.svg.png" alt="Logo" />
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
    <button class="logout-sidebar-btn" onclick="showLogoutModal()">Logout</button>
  </div>

  <div class="main-content" id="main-content">
    <div class="header">
      <button class="burger" onclick="toggleSidebar()">☰</button>
      <h1><?php echo htmlspecialchars($student['fName'] . ' ' . $student['lName']); ?></h1>
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

      let html = '';
      switch (section) {
       case 'overview':
  html = `
    <h2>📊 Dashboard Overview</h2>
    <p>Here's a summary of your profile and academic information:</p>

    <div class="overview-section">
      <div class="overview-card">
        <h3>📛 Full Name</h3>
        <p><?php echo htmlspecialchars($student['fName'] . ' ' . $student['lName']); ?></p>
      </div>
      <div class="overview-card">
        <h3>📧 Email</h3>
        <p><?php echo htmlspecialchars($student['email']); ?></p>
      </div>
      <div class="overview-card">
        <h3>🎂 Birthdate</h3>
        <p><?php echo htmlspecialchars($student['birthdate']); ?></p>
      </div>
      <div class="overview-card">
        <h3>🏠 Address</h3>
        <p><?php echo htmlspecialchars($student['street'] . ', ' . $student['city'] . ', ' . $student['state'] . ', ' . $student['country'] . ', ' . $student['zip']); ?></p>
      </div>
      <div class="overview-card">
        <h3>🧾 Student Type</h3>
        <p><?php echo htmlspecialchars($student['student_type']); ?></p>
      </div>
    </div>

    <div class="reminders">
      <h2>📌 Reminders</h2>
      <ul>
        <li>📖 Review your grades regularly to monitor your progress.</li>
        <li>📅 Stay updated with your class schedule.</li>
        <li>💳 Settle any balances before deadlines to avoid penalties.</li>
        <li>📝 Always check for exam permit availability before exam week.</li>
      </ul>
    </div>
  `;
  break;

        case 'profile':
          html = `
            <h2>Student Profile</h2>
            <div class="info-grid">
              <div class="info-item"><strong>Full Name:</strong> <?php echo htmlspecialchars($student['fName'] . ' ' . $student['mName'] . ' ' . $student['lName']); ?></div>
              <div class="info-item"><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></div>
              <div class="info-item"><strong>Student Type:</strong> <?php echo htmlspecialchars($student['student_type']); ?></div>
              <div class="info-item"><strong>LRN:</strong> <?php echo htmlspecialchars($student['student_id']); ?></div>
              <div class="info-item"><strong>Contact:</strong> <?php echo htmlspecialchars($student['contactNumber']); ?></div>
              <div class="info-item"><strong>Birthdate:</strong> <?php echo htmlspecialchars($student['birthdate']); ?></div>
              <div class="info-item"><strong>Age:</strong> <?php echo htmlspecialchars($student['age']); ?></div>
              <div class="info-item"><strong>Gender:</strong> <?php echo htmlspecialchars($student['gender']); ?></div>
            </div>
          `;
          break;
        case 'grades':
          html = `<h2>Grades</h2><p>Your academic performance and results.</p>`;
          break;
        case 'schedule':
          html = `<h2>Schedule & Subjects</h2><p>Your class schedules and enrolled subjects.</p>`;
          break;
        case 'balance':
          html = `<h2>Account & Balance</h2><p>Your account statements and outstanding balance.</p>`;
          break;
        case 'permits':
          html = `<h2>Permits</h2><p>Permits required for exams or activities.</p>`;
          break;
        default:
          html = `<h2>Welcome</h2><p>Select an option from the sidebar to continue.</p>`;
      }
      content.innerHTML = `<div class="welcome-box">${html}</div>`;
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
