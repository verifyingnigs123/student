<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Dashboard</title>
 
    <link rel="stylesheet" href="adminn.css" 

</head>
<body>
    <div class="sidebar">
        <div class="logo-container">
            <div class="logo"></div>
            <div class="portal-title">Admin Dashboard</div>
        </div>


        <div class="menu">
            <div class="menu-item active">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Teacher</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-user-graduate"></i>
                <span>Student</span>
            </div>
            <div class="menu-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </div>
        </div>

    </div>

    <div class="content">
        <div class="topbar">
            <div class="topbar-left">
                <div class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </div>
                <div>Home</div>
            </div>
            <div class="topbar-right">
                <i class="fas fa-expand"></i>
            </div>
        </div>

        <div class="dashboard">
            <h1 class="dashboard-title">User Management</h1>

            <div class="dashboard-cards" style="justify-content: start; gap: 40px;">
                <div class="card card-events" onclick="location.href='teacher-login.html'">
                    <div class="card-content">
                        <i class="fas fa-chalkboard-teacher" style="font-size: 50px; margin-bottom: 15px;"></i>
                        <div class="card-label">Manage Teacher Login</div>
                    </div>
                </div>

                <div class="card card-payments" onclick="location.href='student-login.html'">
                    <div class="card-content">
                        <i class="fas fa-user-graduate" style="font-size: 50px; margin-bottom: 15px;"></i>
                        <div class="card-label">Manage Student Login</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar functionality
        document.querySelector('.menu-toggle').addEventListener('click', function () {
            document.querySelector('.sidebar').classList.toggle('collapsed');
        });

        // Highlight active menu item
        const menuItems = document.querySelectorAll('.menu-item');
        menuItems.forEach(item => {
            item.addEventListener('click', function () {
                menuItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>
