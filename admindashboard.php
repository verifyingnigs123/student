<?php
include 'db.php'; // Include your database connection

// DELETE TEACHER if 'delete_id' is present in URL
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM teachers WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    // Redirect to avoid resubmission on refresh
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

// UPDATE TEACHER if form submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $id = intval($_POST['update_id']);
    $fName = $_POST['fName'];
    $mName = $_POST['mName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $subject = $_POST['subject'];

    $stmt = $conn->prepare("UPDATE teachers SET fName=?, mName=?, lName=?, email=?, contact=?, subject=? WHERE id=?");
    $stmt->bind_param("ssssssi", $fName, $mName, $lName, $email, $contact, $subject, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
    
}

?>

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

.user-dropdown {
  display: none;
  position: absolute;
  right: 20px;
  top: 60px;
  background: white;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  z-index: 999;
}
.user-dropdown ul {
  list-style: none;
  margin: 0;
  padding: 10px 0;
}
.user-dropdown li {
  padding: 10px 20px;
  cursor: pointer;
}
.user-dropdown li:hover {
  background-color: #f0f0f0;
}

.user-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  overflow: hidden;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.avatar-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.portal-title {
  cursor: pointer;
}



  </style>
</head>
<body>
  <div class="sidebar" id="sidebar">
    <div class="logo-container">
      <div class="logo">RV</div>
      <div class="portal-title" id="portalTitle">Admin Dashboard</div>
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
      <div class="menu-item" data-section="classs/chedule">
        <i class= "fas fa-calendar-alt"></i><span>Class Schedule & Subject</span>
      </div>
      <div class="menu-item" data-section="Account/Balance">
        <i class="fas fa-wallet"></i><span>Account/Balance</span>
      </div>
      <div class="menu-item" data-section="permit">
        <i class="fas fa-file-alt"></i><span>Permit</span>
      </div>
      <div class="menu-item" data-section="Approval">
        <i class="fas fa-check"></i><span>Approval</span>
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
      <div class="user-avatar">
  <img src="profile.jpg" alt="User Avatar" class="avatar-img">
</div>
    </div>

    <div class="user-dropdown" id="userDropdown">
  <ul>
    <li onclick="openProfile()">Profile</li>
   <div class="menu-item" data-section="logout" style="color: black;">
  <i class="fas fa-sign-out-alt"></i><span>Logout</span>
</div>
  </ul>
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
    <div class="card card-events">
      <div class="card-content">
        <i class="fas fa-chalkboard-teacher"></i>
        <div class="card-label">Total Teachers: <span id="teacher-count">...</span></div>
      </div>
    </div>
    <div class="card card-payments">
      <div class="card-content">
        <i class="fas fa-user-graduate"></i>
        <div class="card-label">Total Students: <span id="student-count">...</span></div>
      </div>
    </div>
  </div>
      `, // unchanged for brevity
      teachers: `...`,  // unchanged for brevity
      students: `...`,  // unchanged for brevity
      logout: null
    };

    // Initial load - show dashboard content
    mainSection.innerHTML = contentMap['dashboard'];

    // Function to load counts
    function loadCounts() {
      fetch('dashboard_stats.php')
        .then(response => response.json())
        .then(data => {
          const teacherCount = document.getElementById('teacher-count');
          const studentCount = document.getElementById('student-count');
          if (teacherCount && studentCount) {
            teacherCount.textContent = data.teachers;
            studentCount.textContent = data.students;
          }
        })
        .catch(error => console.error('Error fetching counts:', error));
    }

    setTimeout(() => {
      loadCounts();
    }, 100);

    // Sidebar toggle event
    menuToggle.addEventListener('click', () => {
      sidebar.classList.toggle('collapsed');
    });
    

    menuItems.forEach(item => {
      item.addEventListener('click', function () {
        const section = this.getAttribute('data-section');

        if (section === 'logout') {
          logoutModal.style.display = 'flex';
        } else if (section === 'students') {
  fetch('add_users.php')
    .then(response => response.text())
    .then(data => {
      mainSection.innerHTML = data;
    })
    .catch(error => {
      mainSection.innerHTML = '<p>Error loading student page.</p>';
      console.error('Error loading students:', error);
    });
    
    } else if (section === 'classs/chedule') {
  fetch('schedule.php')
    .then(response => response.text())
    .then(data => {
      mainSection.innerHTML = data;
    })
    .catch(error => {
      mainSection.innerHTML = '<p>Error loading student page.</p>';
      console.error('Error loading students:', error);
    });

    } else if (section === 'Account/Balance') {
  fetch('balance.php')
    .then(response => response.text())
    .then(data => {
      mainSection.innerHTML = data;
    })
    .catch(error => {
      mainSection.innerHTML = '<p>Error loading student page.</p>';
      console.error('Error loading students:', error);
    });

     } else if (section === 'permit') {
  fetch('permits.php')
    .then(response => response.text())
    .then(data => {
      mainSection.innerHTML = data;
    })
    .catch(error => {
      mainSection.innerHTML = '<p>Error loading student page.</p>';
      console.error('Error loading students:', error);
    });

     } else if (section === 'Approval') {
  fetch('approvals.php')
    .then(response => response.text())
    .then(data => {
      mainSection.innerHTML = data;
    })
    .catch(error => {
      mainSection.innerHTML = '<p>Error loading student page.</p>';
      console.error('Error loading students:', error);
    });


} else if (section === 'teachers') {
  fetch('teachers.php')
    .then(response => response.text())
    .then(data => {
      mainSection.innerHTML = data;

      // After content is injected, hook up the edit buttons
      document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function (e) {
          e.preventDefault();
          const editId = this.dataset.id;

          fetch(`teachers.php?edit_id=${editId}`)
            .then(response => response.text())
            .then(html => {
              mainSection.innerHTML = html; // Replace content with edit form
            })
            .catch(error => {
              console.error('Failed to load edit form:', error);
            });
        });
      });
    })
    .catch(error => {
      mainSection.innerHTML = '<p>Error loading teacher page.</p>';
      console.error('Error loading teachers:', error);
    });
}


        else {
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

    // === New Code Added ===
    const userAvatar = document.querySelector('.user-avatar');
    const userDropdown = document.getElementById('userDropdown');
    const logo = document.querySelector('.logo');

    // Toggle user dropdown
    userAvatar.addEventListener('click', () => {
      userDropdown.style.display = userDropdown.style.display === 'block' ? 'none' : 'block';
    });

    // Hide dropdown on outside click
    document.addEventListener('click', (e) => {
      if (!userAvatar.contains(e.target) && !userDropdown.contains(e.target)) {
        userDropdown.style.display = 'none';
      }
    });

    // RV logo click → go to profile
    logo.addEventListener('click', () => {
      openProfile();
    });

    const portalTitle = document.getElementById('portalTitle');

portalTitle.addEventListener('click', () => {
  openProfile(); // Or any other function you want to call
});

    // Profile function
    function openProfile() {
      mainSection.innerHTML = `
        <div class="main-section">
          <h2>Admin Profile</h2>
          <p><strong>Name:</strong> Admin User</p>
          <p><strong>Email:</strong> admin@example.com</p>
          <p><strong>Role:</strong> Administrator</p>
        </div>
      `;
      menuItems.forEach(i => i.classList.remove('active'));
    }
    // === End New Code ===
  </script>

</body>
</html>