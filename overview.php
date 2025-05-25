<?php
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: Signin.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Connect to DB
$mysqli = new mysqli("localhost", "root", "", "student_registration");
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

$sql = "SELECT * FROM students WHERE student_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $student = $result->fetch_assoc();
} else {
    echo "Student record not found.";
    exit();
}

$first_name = $student['fName'];
$last_name = $student['lName'];
$email = $student['email'];
$birthdate = $student['birthdate'];
$address = $student['street'] . ', ' . $student['city'] . ', ' . $student['state'] . ', ' . $student['country'] . ', ' . $student['zip'];
$student_type = $student['student_type'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Overview - Student Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
    <style>
      /* Overview Section Styling */

.overview-section {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  margin-top: 20px;
}

.overview-card {
  background: #fff;
  padding: 25px 30px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(31, 59, 117, 0.1);
  flex: 1 1 280px;
  min-width: 280px;
  transition: transform 0.3s ease;
}

.overview-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(31, 59, 117, 0.15);
}

.overview-card h3 {
  margin-bottom: 15px;
  font-weight: 600;
  font-size: 1.3rem;
  color: #1f3b75;
}

.overview-card p {
  font-size: 1rem;
  color: #444;
  line-height: 1.4;
}

/* Optional: responsive stacking on small devices */
@media (max-width: 720px) {
  .overview-section {
    flex-direction: column;
  }

  .overview-card {
    flex: 1 1 100%;
  }
}

    </style>
</head>
<body>
    <div class="dashboard-content">
        <h1>📊 Dashboard Overview</h1>
        <p>Here's a summary of your profile and academic information:</p>

        <div class="overview-section">
            <div class="overview-card">
                <h3>📛 Full Name</h3>
                <p><?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></p>
            </div>

            <div class="overview-card">
                <h3>📧 Email</h3>
                <p><?php echo htmlspecialchars($email); ?></p>
            </div>

            <div class="overview-card">
                <h3>🎂 Birthdate</h3>
                <p><?php echo htmlspecialchars($birthdate); ?></p>
            </div>

            <div class="overview-card">
                <h3>🏠 Address</h3>
                <p><?php echo htmlspecialchars($address); ?></p>
            </div>

            <div class="overview-card">
                <h3>🧾 Student Type</h3>
                <p><?php echo htmlspecialchars($student_type); ?></p>
            </div>
        </div>

        <div class="reminders">
            <h2>📌 Reminders</h2>
            <ul>
                <li>📖 Review your grades regularly to monitor your progress.</li>
                <li>📅 Stay updated with your class schedule.</li>
                <li>💳 Settle any balances before deadlines to avoid penalties.</li>
                <li>📝 Always check for exam permit availability before exam week.</li>
            </ul>
        </div>
    </div>
</body>
</html>
