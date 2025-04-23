<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "student_registration";

$conn = new mysqli($servername, $username, $password, $database);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['firstName'] ?? "";
    $middle_name = $_POST['middleName'] ?? "";
    $last_name = $_POST['lastName'] ?? "";
    $ext_name = $_POST['ext_Name'] ?? "";
    $birthdate = $_POST['birthdate'] ?? "";
    $age = $_POST['Age'] ?? "";
    $place_of_birth = $_POST['Place'] ?? "";
    $student_id = $_POST['StudentID'] ?? "";
    $religion = $_POST['Religion'] ?? "";
    $gender = $_POST['Gender'] ?? "";
    $street_address = $_POST['Street'] ?? "";
    $city = $_POST['City'] ?? "";
    $state_province = $_POST['State'] ?? "";
    $country = $_POST['Country'] ?? "";
    $zip_code = $_POST['Zipcode'] ?? "";
    $email = $_POST['Email'] ?? "";
    $contact_number = $_POST['ContactNumber'] ?? "";
    $strand = $_POST['Strand'] ?? "";
    $level = $_POST['Level'] ?? "";
    $semester = $_POST['Semester']??"";
    $schoolyear = $_POST['School_year']??"";
    $role = "user";// Automatically set role as 'user'

    // Check for required fields
    if (empty($first_name) || empty($last_name) || empty($birthdate) || empty($student_id) || empty($email) || empty($strand) || empty($level) || empty($semester)) {
        echo "<script>alert('Error: Required fields are missing.');</script>";
        exit;
    }

    $checkEmail = $conn->prepare("SELECT email FROM transferee_students WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $checkEmail->store_result();
    if ($checkEmail->num_rows > 0) {
        echo "<script>alert('Email already exists. Please use a different one.'); window.history.back();</script>";
        exit;
    }
    $checkEmail->close();

    // Check for existing contact number
    $checkContact = $conn->prepare("SELECT contactNumber FROM transferee_students WHERE contactNumber = ?");
    $checkContact->bind_param("s", $contact_number);
    $checkContact->execute();
    $checkContact->store_result();
    if ($checkContact->num_rows > 0) {
        echo "<script>alert('Contact number already exists. Please use a different one.'); window.history.back();</script>";
        exit;
    }
    $checkContact->close();

    // Proceed with insert
    $stmt = $conn->prepare("INSERT INTO transferee_students (firstName, middleName, lastName, ext_Name, birthdate, Age, Place, Student_id, Religion, Gender, Street, City, State, Country, Zipcode, Email, ContactNumber, Strand, Level, Semester, School_year, role) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                        
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

    $stmt->bind_param("ssssssssssssssssssssss", $first_name, $middle_name, $last_name, $ext_name, $birthdate, $age, $place_of_birth, $student_id, $religion, $gender, $street_address, $city, $state_province, $country, $zip_code, $email, $contact_number, $strand, $level, $semester, $schoolyear , $role);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location.href='Signin.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
