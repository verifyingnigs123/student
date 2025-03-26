    
    document.addEventListener("DOMContentLoaded", function() {
        const menuButtons = document.querySelectorAll(".menu-btn");

        // Function to handle menu button clicks
        menuButtons.forEach(button => {
            button.addEventListener("click", function() {
                // Remove active class from all buttons
                menuButtons.forEach(btn => btn.classList.remove("active"));
                
                // Add active class to the clicked button
                this.classList.add("active");

                // Define page navigation (adjust href links accordingly)
                let targetPage = "";
                switch (this.innerText.trim()) {
                    case "Overview":
                        targetPage = "overview.php";
                        break;
                    case "Admin Profile":
                        targetPage = "admin_profile.php";
                        break;
                    case "View Grades":
                        targetPage = "grades.php";
                        break;
                    case "Class Schedule & Subjects":
                        targetPage = "schedule.php";
                        break;
                    case "Account & Balance":
                        targetPage = "account.php";
                        break;
                    case "Permits":
                        targetPage = "permits.php";
                        break;
                    case "Add Students":
                        targetPage = "add_students.php";
                        break;
                    case "Approval":
                        targetPage = "approval.php";
                        break;
                }

                // Redirect to the chosen page
                if (targetPage) {
                    window.location.href = targetPage;
                }
            });
        });

        if (logoutButton) {
            logoutButton.addEventListener("click", function() {
                logout();
            });
        }
    });
    
    // Function to log out the user
    function logout() {
        window.location.href = "Signin.php"; // Ensure logout.php exists and clears session
    }



