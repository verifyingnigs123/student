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
       // Check birthdate eligibility (17 or older)
    $birthdate = $_POST['birthdate'] ?? '';
    $dob = new DateTime($birthdate);
    $today = new DateTime();
    $ageInterval = $dob->diff($today);

    if ($ageInterval->y < 17) {
        echo "<script>
                alert('Oopss! Your age does not meet the registration requirements.');
                window.history.back();
              </script>";
        exit;
    }

    // Assign contact number to variable for checking
    $contact_number = $_POST['contactNumber'] ?? '';

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

    // Prepare SQL without 'status' (since you have 'is_approved' column)
    $sql = "INSERT INTO students (
        student_type, fName, mName, lName, extName, birthdate, age, place, student_id,
        religion, gender, street, city, state, country, zip, email, contactNumber, strand,
        level, semester, school_year, is_approved
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Add is_approved default value (0)
    $params = [];
    foreach ($fields as $field) {
        $params[] = $_POST[$field] ?? '';
    }
    $params[] = 0; // is_approved default to 0 (Pending approval)

    // Bind all parameters (string type for most, but is_approved is integer)
    $types = str_repeat('s', count($fields)) . 'i'; // 22 's' + 1 'i'

    $stmt->bind_param($types, ...$params);

    // Execute and redirect
    if ($stmt->execute()) {
        echo "<script>
                alert('Registration successful! Please wait for admin approval.');
                window.location.href = 'Signin.php';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
