
<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "student_registration";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['fName'] ?? "";
    $middle_name = $_POST['mName'] ?? "";
    $last_name = $_POST['lName'] ?? "";
    $birthdate = $_POST['birthdate'] ?? "";
    $student_id = $_POST['studentID'] ?? "";
    $street_address = $_POST['street'] ?? "";
    $city = $_POST['city'] ?? "";
    $state_province = $_POST['state'] ?? "";
    $country = $_POST['country'] ?? "";
    $zip_code = $_POST['zip'] ?? "";
    $email = $_POST['email'] ?? "";
    $strand = $_POST['strand'] ?? "";
    $level = $_POST['level'] ?? "";
    $role = "user"; // Automatically set role as 'user'

    // Check for required fields
    if (empty($first_name) || empty($last_name) || empty($birthdate) || empty($student_id) || empty($email) || empty($strand) || empty($level)) {
        echo "<script>alert('Error: Required fields are missing.');</script>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO students (first_name, middle_name, last_name, birthdate, student_id, street_address, city, state_province, country, zip_code, email, strand, level, role) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssss", $first_name, $middle_name, $last_name, $birthdate, $student_id, $street_address, $city, $state_province, $country, $zip_code, $email, $strand, $level, $role);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location.href='Signin.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
