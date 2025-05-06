function loadPage(page) {
    // Highlight the active menu button
    document.querySelectorAll('.menu-btn').forEach(btn => btn.classList.remove('active'));
    const activeBtn = document.querySelector(`.menu-btn[onclick="loadPage('${page}')"]`);
    if (activeBtn) {
        activeBtn.classList.add('active');
    }
    
    // Navigate to the selected page
    switch (page) {
        case 'dashboard':
            window.location.href = 'dashboard.php';
            break;
        case 'adminprofile':
            window.location.href = 'adminprofile.php';
            break;
        case 'grades':
            window.location.href = 'grades.php';
            break;
        case 'schedule':
            window.location.href = 'schedule.php';
            break;
        case 'balance':
            window.location.href = 'balance.php';
            break;
        case 'permits':
            window.location.href = 'permits.php';
            break;
        case 'add_teachers':
            window.location.href = 'teachers.php';
            break;
        case 'add_users':
            window.location.href = 'add_users.php';
            break;
        case 'approvals':
            window.location.href = 'approvals.php';
            break;
        default:
            alert('Page not found');
    }
}

function profile() {
    if (confirm('Do you want to go to the admin profile?')) {
        window.location.href = "adminprofile.php";
    }
}

function logout() {
    if (confirm('Are you sure you want to logout?')) {
        window.location.href = "Signin.php";
    }
}
