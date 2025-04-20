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

<div class="profile-section">
    <h2>Student Profile</h2>
    <div>
        <h3>
            <?php echo htmlspecialchars($student['fName'] . ' ' . $student['mName'] . ' ' . $student['lName'] . ' ' . $student['extName']); ?>
        </h3>
        <p><strong>LRN:</strong> <?php echo htmlspecialchars($student['student_id']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
        <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($student['contactNumber']); ?></p>
        <p><strong>Birthdate:</strong> <?php echo htmlspecialchars($student['birthdate']); ?></p>
        <p><strong>Age:</strong> <?php echo htmlspecialchars($student['age']); ?></p>
        <p><strong>Gender:</strong> <?php echo htmlspecialchars($student['gender']); ?></p>
        <p><strong>Place of Birth:</strong> <?php echo htmlspecialchars($student['place']); ?></p>
        <p><strong>Religion:</strong> <?php echo htmlspecialchars($student['religion']); ?></p>
        <p><strong>Address:</strong> 
            <?php 
                echo htmlspecialchars($student['street'] . ', ' . 
                                      $student['city'] . ', ' . 
                                      $student['state'] . ', ' . 
                                      $student['country'] . ', ' . 
                                      $student['zip']); 
            ?>
        </p>
        <p><strong>Strand:</strong> <?php echo htmlspecialchars($student['strand']); ?></p>
        <p><strong>Grade Level:</strong> <?php echo htmlspecialchars($student['level']); ?></p>
        <p><strong>Semester:</strong> <?php echo htmlspecialchars($student['semester']); ?></p>
        <p><strong>School Year:</strong> <?php echo htmlspecialchars($student['school_year']); ?></p>
        <p><strong>Role:</strong> <?php echo htmlspecialchars($student['role']); ?></p>
        <p><strong>Registered At:</strong> <?php echo htmlspecialchars($student['created_at']); ?></p>
    </div>
</div>
