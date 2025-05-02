<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lathougs University</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <div class="body-overlay"></div>
    
    <header>
        <div class="logo">
            <img src="log1.jpg" alt="Lathougs University Logo">
            <h1>Lathougs University</h1>
        </div>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#admission">Admission</a></li>
                <li><a href="index.php" id="student-login"><i class="fas fa-sign-in-alt"></i> Login</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <section class="welcome">
            <h2>Welcome to</h2>
            <h1>Lathougs <br> <span>University</span></h1>
            <p>Empowering minds, shaping the future.</p>
        </section>
        <section class="images scroll-animation">
            <img src="illustration.png" alt="Illustration" class="illustration">
            <img src="students1.jpg" alt="Students" class="students">
            <img src="students2.webp" alt="More Students" class="students">
        </section>

    </main>

    <section id="about">
        <h2>About Us</h2>
        <p>
            Lathougs University is a center for academic excellence and innovation. Our mission is to provide students with an engaging, technology-driven learning environment that fosters growth and success.
        </p>
        
        <div class="features">
            <div class="feature-box">
                <i class="fas fa-sync-alt"></i>
                <h3>Real-Time Updates</h3>
                <p>Stay informed with instant access to grades, schedules, and enrollment details.</p>
            </div>
            <div class="feature-box">
                <i class="fas fa-cogs"></i>
                <h3>Flexible Learning</h3>
                <p>Manage records conveniently, whether on campus or remote.</p>
            </div>
            <div class="feature-box">
                <i class="fas fa-shield-alt"></i>
                <h3>Fast & Secure</h3>
                <p>High-speed performance and strong security to keep your academic info safe.</p>
            </div>
        </div>
    </section>

    <section id="MissionAndVision">
        <h2>Mission & Vision</h2>
        <div class="features1">
            <div class="feature1-box">
                <i class="fas fa-bullseye"></i>
                <h3>Mission</h3>
                <p>To nurture intellectual growth, promote critical thinking, and develop future leaders.</p>
            </div>
            <div class="feature1-box">
                <i class="fas fa-eye"></i>
                <h3>Vision</h3>
                <p>To be a globally recognized institution known for academic excellence and innovation.</p>
            </div>
        </div>
    </section>

    <section id="admission">
    <h2>Admission Process</h2>
    <p>Start your journey at Lathougs University by following these simple steps.</p>

    <div class="admission-steps">
        <div class="step-box">
            <i class="fas fa-file-alt"></i>
            <h3>Step 1: Online Application</h3>
            <p>Complete the registration form and provide the necessary details.</p>
        </div>

        <div class="step-box">
            <i class="fas fa-id-card"></i>
            <h3>Step 2: Submit Registration Form</h3>
            <p>Click the submit button to send your application for review.</p>
        </div>

        <div class="step-box">
            <i class="fas fa-check-circle"></i>
            <h3>Step 3: Enrollment Confirmation</h3>
            <p>Once your application is approved, you will receive a confirmation email with your student credentials. </p>
        </div>
    </div>

    <a href="enroll.php" class="apply-btn">Apply Now</a>
</section>



    <script src="Home.js"></script>
</body>
</html>
