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

    // Prepare SQL
    $sql = "INSERT INTO students (student_type, fName, mName, lName, extName, birthdate, age, place, student_id, religion, gender, street, city, state, country, zip, email, contactNumber, strand, level, semester, school_year)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    $params = [];
    foreach ($fields as $field) {
        $params[] = $_POST[$field] ?? '';
    }

    $stmt->bind_param(str_repeat('s', count($params)), ...$params);

    // Execute and redirect
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
