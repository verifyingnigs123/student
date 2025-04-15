<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: Signin.php");
    exit();
}

// Assign session values
$first_name = $_SESSION['first_name'] ?? "";
$last_name = $_SESSION['last_name'] ?? "";
$email = $_SESSION['email'] ?? "";
$birthdate = $_SESSION['birthdate'] ?? "";
$role = $_SESSION['role'] ?? "";
$address = $_SESSION['address'] ?? "";
$student_id = $_SESSION['student_id'] ?? "";
?>

<div class="profile-section">
    <div>
        <h3><?php echo htmlspecialchars($first_name . " " . $last_name); ?></h3>
        <p>LRN: <?php echo htmlspecialchars($student_id); ?></p>
        <p>Email: <?php echo htmlspecialchars($email); ?></p>
        <p>Birthdate: <?php echo htmlspecialchars($birthdate); ?></p>
        <p>Address: <?php echo htmlspecialchars($address); ?></p>
        <p>Role: <?php echo htmlspecialchars($role); ?></p>
    </div>
</div>
