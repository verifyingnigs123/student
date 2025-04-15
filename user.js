function loadPage(page) {
    // Highlight the active menu button
    document.querySelectorAll('.menu-btn').forEach(btn => btn.classList.remove('active'));
    const activeBtn = document.querySelector(`.menu-btn[onclick="loadPage('${page}')"]`);
    if (activeBtn) {
        activeBtn.classList.add('active');
    }
    
    // Navigate to the selected page
    switch (page) {
        case 'overview':
            window.location.href = 'overview.php';
            break;
        case 'student_profile':
            window.location.href = 'student_profile.php';
            break;
        case 'view_grades':
            window.location.href = 'view_grades.php';
            break;
        case 'view_schedule':
            window.location.href = 'view_schedule.php';
            break;
        case 'view_balance':
            window.location.href = 'view_balance.php';
            break;
        case 'view_permits':
            window.location.href = 'view_permits.php';
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
