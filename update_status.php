<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_registration";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;
$status = $data->status;

$sql = "UPDATE students SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('si', $status, $id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Student status updated successfully"]);
} else {
    echo json_encode(["message" => "Failed to update student status"]);
}

$stmt->close();
$conn->close();
?>
