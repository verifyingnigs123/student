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
    $ext_name = $_POST['extName'] ?? "";
    $birthdate = $_POST['birthdate'] ?? "";
    $age = $_POST['age'] ?? "";
    $place_of_birth = $_POST['place'] ?? "";
    $student_id = $_POST['studentID'] ?? "";
    $religion = $_POST['religion'] ?? "";
    $gender = $_POST['gender'] ?? "";
    $street_address = $_POST['street'] ?? "";
    $city = $_POST['city'] ?? "";
    $state_province = $_POST['state'] ?? "";
    $country = $_POST['country'] ?? "";
    $zip_code = $_POST['zip'] ?? "";
    $email = $_POST['email'] ?? "";
    $contact_number = $_POST['contactNumber'] ?? "";
    $strand = $_POST['strand'] ?? "";
    $level = $_POST['level'] ?? "";
    $role = "user";// Automatically set role as 'user'

    // Check for required fields
    if (empty($first_name) || empty($last_name) || empty($birthdate) || empty($student_id) || empty($email) || empty($strand) || empty($level)) {
        echo "<script>alert('Error: Required fields are missing.');</script>";
        exit;
    }

    $checkEmail = $conn->prepare("SELECT email FROM students WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->store_result();
    if ($checkEmail->num_rows > 0) {
        echo "<script>alert('Email already exists. Please use a different one.'); window.history.back();</script>";
        exit;
    }
    $checkEmail->close();

    // Check for existing contact number
    $checkContact = $conn->prepare("SELECT contactNumber FROM students WHERE contactNumber = ?");
    $checkContact->bind_param("s", $contact_number);
    $checkContact->execute();
    $checkContact->store_result();
    if ($checkContact->num_rows > 0) {
        echo "<script>alert('Contact number already exists. Please use a different one.'); window.history.back();</script>";
        exit;
    }
    $checkContact->close();

    // Proceed with insert
    $stmt = $conn->prepare("INSERT INTO students (fName, mName, lName, extName, birthdate, age, place, student_id, religion, gender, street, city, state, country, zip, email, contactNumber, strand, level, role) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssssssssss", $first_name, $middle_name, $last_name, $ext_name, $birthdate, $age, $place_of_birth, $student_id, $religion, $gender, $street_address, $city, $state_province, $country, $zip_code, $email, $contact_number, $strand, $level, $role);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location.href='Signin.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
