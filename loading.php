<!-- loading.php -->
<?php
session_start();
$redirectPage = $_GET['redirect'] ?? 'userdashboard.php';
$redirectPage = $_GET['redirect'] ?? 'teacherdashboard.php';
$redirectPage = $_GET['redirect'] ?? 'admindashboard.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Loading...</title>
<style>
    body {
        margin: 0;
        padding: 0;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        font-family: sans-serif;
    }
    .logo-container {
        text-align: center;
    }
    .logo {
        width: 150px;
        height: 150px;      /* Equal width and height */
        border-radius: 50%; /* Circle shape */
        object-fit: cover;  /* Fill circle nicely */
        animation: pulse 1.5s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); opacity: 0.8; }
        50% { transform: scale(1.1); opacity: 1; }
        100% { transform: scale(1); opacity: 0.8; }
    }
</style>

    <script>
        // Redirect after 2 seconds
        setTimeout(function () {
            window.location.href = "<?php echo htmlspecialchars($redirectPage); ?>";
        }, 2000);
    </script>
</head>
<body>
    <div class="logo-container">
        <img src="log1.jpg" alt="Loading..." class="logo">
        <p>Loading, please wait...</p>
    </div>
</body>
</html>
