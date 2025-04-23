<?php
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: Signin.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Database connection
$mysqli = new mysqli("localhost", "root", "", "student_registration");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
// Function to calculate age from birthdate
function calculateAge($birthdate) {
    $birthDate = new DateTime($birthdate);
    $currentDate = new DateTime();
    $age = $birthDate->diff($currentDate)->y;
    return $age;
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form values
    $fName = $_POST['fName'];
    $mName = $_POST['mName'];
    $lName = $_POST['lName'];
    $email = $_POST['email'];
    $contactNumber = $_POST['contactNumber'];
    $birthdate = $_POST['birthdate'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $place = $_POST['place'];
    $religion = $_POST['religion'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $zip = $_POST['zip'];
    $strand = $_POST['strand'];
    $level = $_POST['level'];
    $semester = $_POST['semester'];
    $school_year = $_POST['school_year'];

    // Update query
    $sql = "UPDATE students 
            SET fName = ?, mName = ?, lName = ?, email = ?, contactNumber = ?, birthdate = ?, age = ?, gender = ?, place = ?, religion = ?, street = ?, city = ?, state = ?, country = ?, zip = ?, strand = ?, level = ?, semester = ?, school_year = ? 
            WHERE student_id = ?";

    $stmt = $mysqli->prepare($sql);
    
    if ($stmt === false) {
        die("Error preparing statement: " . $mysqli->error);
    }

    // Bind parameters
    $stmt->bind_param("ssssssssssssssssssss", $fName, $mName, $lName, $email, $contactNumber, $birthdate, $age ,$gender, $place, $religion, $street, $city, $state, $country, $zip, $strand, $level, $semester, $school_year, $student_id);



    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating profile: " . addslashes($stmt->error) . "');</script>";
    }
    
    // Close the statement
    $stmt->close();
}

// Fetch student data for displaying in the form (to populate input fields)
$sql = "SELECT * FROM students WHERE student_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $student = $result->fetch_assoc();
} else {
    echo "Student not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
</head>
<body>
    <h2>Edit Profile</h2>
    <form method="POST">
        <label for="fName">First Name:</label>
        <input type="text" name="fName" value="<?php echo htmlspecialchars($student['fName']); ?>" required><br><br>

        <label for="mName">Middle Name:</label>
        <input type="text" name="mName" value="<?php echo htmlspecialchars($student['mName']); ?>"><br><br>

        <label for="lName">Last Name:</label>
        <input type="text" name="lName" value="<?php echo htmlspecialchars($student['lName']); ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required><br><br>

        <label for="contactNumber">Contact Number:</label>
        <input type="text" name="contactNumber" value="<?php echo htmlspecialchars($student['contactNumber']); ?>"><br><br>

        <label for="birthdate">Birthdate:</label>
        <input type="date" name="birthdate" value="<?php echo htmlspecialchars($student['birthdate']); ?>"><br><br>

        <label for="age">Age:</label>
        <input type="text" name="age" value="<?php echo htmlspecialchars($student['age']); ?>"><br><br>

        <label for="gender">Gender:</label>
        <input type="text" name="gender" value="<?php echo htmlspecialchars($student['gender']); ?>"><br><br>

        <label for="place">Place of Birth:</label>
        <input type="text" name="place" value="<?php echo htmlspecialchars($student['place']); ?>"><br><br>

        <label for="religion">Religion:</label>
        <input type="text" name="religion" value="<?php echo htmlspecialchars($student['religion']); ?>"><br><br>

        <label for="street">Street:</label>
        <input type="text" name="street" value="<?php echo htmlspecialchars($student['street']); ?>"><br><br>

        <label for="city">City:</label>
        <input type="text" name="city" value="<?php echo htmlspecialchars($student['city']); ?>"><br><br>

        <label for="state">State:</label>
        <input type="text" name="state" value="<?php echo htmlspecialchars($student['state']); ?>"><br><br>

        <label for="country">Country:</label>
        <input type="text" name="country" value="<?php echo htmlspecialchars($student['country']); ?>"><br><br>

        <label for="zip">ZIP Code:</label>
        <input type="text" name="zip" value="<?php echo htmlspecialchars($student['zip']); ?>"><br><br>

        <label for="strand">Strand:</label>
        <input type="text" name="strand" value="<?php echo htmlspecialchars($student['strand']); ?>"><br><br>

        <label for="level">Grade Level:</label>
        <input type="text" name="level" value="<?php echo htmlspecialchars($student['level']); ?>"><br><br>

        <label for="semester">Semester:</label>
        <input type="text" name="semester" value="<?php echo htmlspecialchars($student['semester']); ?>"><br><br>

        <label for="school_year">School Year:</label>
        <input type="text" name="school_year" value="<?php echo htmlspecialchars($student['school_year']); ?>"><br><br>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
