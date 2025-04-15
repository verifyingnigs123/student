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

    $stmt = $conn->prepare("SELECT permit_id, permit_type, status,issue_date,expiration_date FROM permits WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $permits = [];
    while ($row = $result->fetch_assoc()) {
        $permits[] = $row;
    }

    if (count($permits) > 0) {
        echo json_encode($permits);
    } else {
        echo json_encode(["error" => "No permit found for this Student ID"]);
    }
} else {
    echo json_encode(["error" => "Student ID not provided"]);
}
?>
