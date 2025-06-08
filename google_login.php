<?php
session_start();
header('Content-Type: application/json');

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['email'])) {
    echo json_encode(['status' => 'error', 'message' => 'Email is required']);
    exit;
}

$email = $data['email'];

// DB connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_registration";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

$stmt = $conn->prepare("SELECT id, fName, email FROM teachers WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $teacher = $result->fetch_assoc();
} else {
    $insertStmt = $conn->prepare("INSERT INTO teachers (email) VALUES (?)");
    $insertStmt->bind_param("s", $email);
    if ($insertStmt->execute()) {
        $teacher = [
            'id' => $insertStmt->insert_id,
            'fName' => '', // no name yet
            'email' => $email
        ];
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to insert teacher']);
        exit;
    }
    $insertStmt->close();
}

// Set session variables
$_SESSION['teacher_id'] = $teacher['id'];
$_SESSION['teacher_name'] = $teacher['fName'];
$_SESSION['teacher_email'] = $teacher['email'];

$stmt->close();
$conn->close();

// Send success response with redirect URL
echo json_encode(['status' => 'success', 'redirect' => 'teacherdashboard.php']);
exit;
?>
