<?php
include 'db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect all 20 fields—including the new 'place'
    $first_name     = $_POST['fName'];
    $middle_name    = $_POST['mName'];
    $last_name      = $_POST['lName'];
    $ext_Name       = $_POST['extName'];
    $gender         = $_POST['gender'];
    $birthdate      = $_POST['birthdate'];
    $age            = $_POST['age'];
    $place          = $_POST['place'];           
    $student_id     = $_POST['studentID'];
    $street         = $_POST['street'];
    $city           = $_POST['city'];
    $state          = $_POST['state'];
    $country        = $_POST['country'];
    $zip            = $_POST['zip'];
    $email          = $_POST['email'];
    $contact_number = $_POST['contactNumber'];
    $strand         = $_POST['strand'];
    $semester       = $_POST['semester'];
    $school_year    = $_POST['school_year'];
    $level          = $_POST['level'];

    // 20 columns → 20 placeholders
    $sql = "INSERT INTO students (
                fName, mName, lName, extName, gender, birthdate, age, place, 
                student_id, street, city, state, country, zip, email, 
                contactNumber, strand, semester, school_year, level
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL Prepare failed: " . $conn->error);
    }

    // bind 20 parameters (all as strings)
    $stmt->bind_param(
        "ssssssssssssssssssss",
        $first_name, $middle_name, $last_name, $ext_Name, $gender,
        $birthdate, $age, $place,
        $student_id, $street, $city, $state, $country, $zip, $email,
        $contact_number, $strand, $semester, $school_year, $level
    );

    if ($stmt->execute()) {
        echo "<script>
                alert('Student Added Successfully!');
                window.location.href='add_users.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $stmt->error . "');
                window.history.back();
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
    <script>
        function calculateAge() {
            const birthdate = document.querySelector('input[name="birthdate"]').value;
            if (birthdate) {
                const today = new Date();
                const birthDate = new Date(birthdate);
                let age = today.getFullYear() - birthDate.getFullYear();
                const m = today.getMonth() - birthDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                document.querySelector('input[name="age"]').value = age;
            }
        }

        function validateForm() {
            calculateAge(); // Ensure age is filled
            return true;
        }
    </script>
</head>
<body>
    <h1>Add New Student</h1>
    <form action="insert_student.php" method="POST" onsubmit="return validateForm()">
        <input type="text" name="fName" placeholder="First Name" required>
        <input type="text" name="mName" placeholder="Middle Name">
        <input type="text" name="lName" placeholder="Last Name" required>
        <input type="text" name="extName" placeholder="Extension (Jr., III, etc.)">

        <select name="gender" required>
            <option value="">Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        
        <input type="date" name="birthdate" onchange="calculateAge()" required>
        <input type="number" name="age" placeholder="Age" readonly required>

        <!-- ← NEW: place of birth input → -->
        <input type="text" name="place" placeholder="Place of Birth" required>

        <input type="text" name="studentID" placeholder="Student ID" required>
        <input type="text" name="contactNumber" placeholder="Contact Number" required>
        <input type="text" name="school_year" placeholder="School Year (e.g. 2024-2025)" required>

        <input type="text" name="street" placeholder="Street Address" required>
        <input type="text" name="city" placeholder="City" required>
        <input type="text" name="state" placeholder="State / Province" required>
        <input type="text" name="country" placeholder="Country" required>
        <input type="text" name="zip" placeholder="ZIP Code" required>
        <input type="email" name="email" placeholder="E-mail" required>
        
        <select name="strand" required>
            <option value="">Strand</option>
            <option value="ABM">ABM</option>
            <option value="HUMSS">HUMSS</option>
            <option value="STEM">STEM</option>
            <option value="GAS">GAS</option>
            <option value="TVL">TVL</option>
        </select>

        <select name="semester" required>
            <option value="">Semester</option>
            <option value="1st Semester">1st Semester</option>
            <option value="2nd Semester">2nd Semester</option>
        </select>

        <select name="level" required>
            <option value="">Level</option>
            <option value="Grade 11">Grade 11</option>
            <option value="Grade 12">Grade 12</option>
        </select>

        <button type="submit">Add Student</button>
    </form>

    <a href="add_users.php"><button>Back</button></a>
</body>
</html>
