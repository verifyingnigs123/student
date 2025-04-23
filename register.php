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

    // Bind all 22 strings (change types if necessary, e.g., 'i' for integer)
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);

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
