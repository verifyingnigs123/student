<?php
header("Content-Type: application/json");

// DB connection
$conn = new mysqli("localhost", "root", "", "student_registration");

// Check connection
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    $stmt = $conn->prepare("SELECT subject, day, time FROM schedules WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $schedules = [];
    while ($row = $result->fetch_assoc()) {
        $schedules[] = $row;
    }

    echo json_encode($schedules);
} else {
    echo json_encode(["error" => "Student ID not provided"]);
}
?>
