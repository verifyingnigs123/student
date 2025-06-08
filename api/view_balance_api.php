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

    // Query to fetch all required fields from the account_balance table
    $stmt = $conn->prepare("
        SELECT student_id, balance, description, semester, school_year, grade_level, strand, date_updated
        FROM account_balance
        WHERE student_id = ?
        ORDER BY date_updated DESC
        LIMIT 1
    ");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Return the fetched data as JSON
        echo json_encode($row);
    } else {
        // No record found
        echo json_encode(["error" => "No account balance found for your account"]);
    }
} else {
    echo json_encode(["error" => "Student ID not provided"]);
}
?>
