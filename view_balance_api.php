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

    // Query to fetch balance from the account_balance table
    $stmt = $conn->prepare("SELECT balance FROM account_balance WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Return the balance if found
        echo json_encode(["balance" => $row['balance']]);
    } else {
        // If no balance is found, return an error
        echo json_encode(["error" => "No account balance found for your account"]);
    }
} else {
    echo json_encode(["error" => "Student ID not provided"]);
}
?>
