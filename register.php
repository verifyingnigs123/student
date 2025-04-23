<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_registration";

// Create connection using OOP mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect form data
    $fields = [
        'studentType', 'fName', 'mName', 'lName', 'extName',
        'birthdate', 'age', 'place', 'student_id', 'religion',
        'gender', 'street', 'city', 'state', 'country',
        'zip', 'email', 'contactNumber', 'strand', 'level',
        'semester', 'school_year'
    ];

    // Prepare SQL and bind parameters
    $sql = "INSERT INTO students (student_type, fName, mName, lName, extName, birthdate, age, place, student_id, religion, gender, street, city, state, country, zip, email, contactNumber, strand, level, semester, school_year)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Dynamically bind parameters
    $params = [];
    foreach ($fields as $field) {
        $params[] = $_POST[$field] ?? '';
    }

<<<<<<< HEAD
    // Bind all 22 strings (change types if necessary, e.g., 'i' for integer)
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
=======
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
    $stmt = $conn->prepare("INSERT INTO students (fName, mName, lName, extName, birthdate, age, place, student_id, religion, gender, street, city, state, country, zip, email, contactNumber, strand, level, semester, school_year, role) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

                        
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

    $stmt->bind_param("ssssssssssssssssssssss", $first_name, $middle_name, $last_name, $ext_name, $birthdate, $age, $place_of_birth, $student_id, $religion, $gender, $street_address, $city, $state_province, $country, $zip_code, $email, $contact_number, $strand, $level, $semester, $schoolyear , $role);
>>>>>>> cd3c65d95d1205791ecba911535382ceb8f9bac7

    // Execute and check result
    if ($stmt->execute()) {
        echo "<script>
                alert('New record created successfully');
                window.location.href = 'Signin.php';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
