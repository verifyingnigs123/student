<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "student_registration";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = ['emailExists' => false, 'numberExists' => false];

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $stmt = $conn->prepare("SELECT * FROM students WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $response['emailExists'] = $stmt->num_rows > 0;
    $stmt->close();
}

if (isset($_POST['contactNumber'])) {
    $contact = $_POST['contactNumber'];
    $stmt = $conn->prepare("SELECT * FROM students WHERE contact_number = ?");
    $stmt->bind_param("s", $contact);
    $stmt->execute();
    $stmt->store_result();
    $response['numberExists'] = $stmt->num_rows > 0;
    $stmt->close();
}

$conn->close();
echo json_encode($response);
?>
