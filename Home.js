document.addEventListener("DOMContentLoaded", function() {
    const scrollElements = document.querySelectorAll(".scroll-animation");

    function handleScroll() {
        scrollElements.forEach(el => {
            const elementTop = el.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            if (elementTop < windowHeight - 50) {
                el.classList.add("show");
            }
        });
    }

    window.addEventListener("scroll", handleScroll);
    handleScroll();
});
  document.addEventListener("DOMContentLoaded", function() {
        const scrollElements = document.querySelectorAll(".scroll-animation");

        function handleScroll() {
            scrollElements.forEach(el => {
                const elementTop = el.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;
                if (elementTop < windowHeight - 50) {
                    el.classList.add("show");
                }
            });
        }

        window.addEventListener("scroll", handleScroll);
        handleScroll();
    });

    // Sticky Navbar Function
    window.addEventListener("scroll", function() {
        const header = document.querySelector("header");
        if (window.scrollY > 50) {
            header.classList.add("sticky");
        } else {
            header.classList.remove("sticky");
        }
    });

    // Smooth Scrolling for Navigation Links
    document.querySelectorAll("nav ul li a").forEach(anchor => {
        anchor.addEventListener("click", function(event) {
            event.preventDefault();
            const targetId = this.getAttribute("href").substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 70,
                    behavior: "smooth"
                });
            }
        });
    });

    // Functionality for Home, About, Admission, and Login
    document.getElementById("home-link").addEventListener("click", function() {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });

    document.getElementById("about-link").addEventListener("click", function() {
        const aboutSection = document.getElementById("about");
        if (aboutSection) {
            aboutSection.scrollIntoView({ behavior: "smooth" });
        }
    });

    document.getElementById("admission-link").addEventListener("click", function(event) {
        event.preventDefault();
        window.location.href = "adminsign.php";
    });

    document.getElementById("login-link").addEventListener("click", function(event) {
        event.preventDefault();
        window.location.href = "Signin.php";
    });
    function toggleDropdown() {
        document.querySelector('.dropdown-menu').style.display = 
            document.querySelector('.dropdown-menu').style.display === 'block' ? 'none' : 'block';
    }

    function selectGender(value) {
        document.getElementById("selected-text").textContent = value;
        document.querySelector('.dropdown-menu').style.display = "none";
    }

    // Close dropdown when clicking outside
    document.addEventListener("click", function(event) {
        if (!document.querySelector(".dropdown").contains(event.target)) {
            document.querySelector(".dropdown-menu").style.display = "none";
        }
    });