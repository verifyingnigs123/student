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
    <link rel="stylesheet" href="your-dashboard-style.css">
    <style>
        .edit-profile-container {
            max-width: 900px;
            margin: 2rem auto;
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }

        .edit-profile-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        label {
            font-weight: 600;
            color: #444;
            margin-bottom: 4px;
            display: block;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"] {
            width: 100%;
            padding: 0.5rem;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button[type="submit"] {
            width: 100%;
            padding: 0.75rem;
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            margin-top: 1.5rem;
        }

        .section-toggle {
            margin-top: 1rem;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            background-color: #f0f0f0;
            border: none;
            padding: 0.6rem 1rem;
            border-radius: 6px;
            text-align: left;
        }

        .collapsible {
            margin-top: 0.5rem;
            display: none;
        }

        .error {
            color: red;
            font-size: 0.9rem;
        }
        .close-button {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: transparent;
    border: none;
    font-size: 1.5rem;
    font-weight: bold;
    color: #999;
    cursor: pointer;
    transition: color 0.2s;
}

.close-button:hover {
    color: #e74c3c;
}

.edit-profile-container {
    position: relative;
    max-width: 900px;
    margin: 2rem auto;
    background: #fff;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0,0,0,0.05);
}

    </style>
</head>
<body>
    <div class="edit-profile-container">
        <h2>Edit Profile</h2>
        <button class="close-button" onclick="closeEditProfile()">×</button>

        <form method="POST" id="editProfileForm">
            <div class="form-grid">
                <div>
                    <label for="fName">First Name *</label>
                    <input type="text" name="fName" required value="<?= htmlspecialchars($student['fName']) ?>">
                </div>

                <div>
                    <label for="mName">Middle Name</label>
                    <input type="text" name="mName" value="<?= htmlspecialchars($student['mName']) ?>">
                </div>

                <div>
                    <label for="lName">Last Name *</label>
                    <input type="text" name="lName" required value="<?= htmlspecialchars($student['lName']) ?>">
                </div>

                <div>
                    <label for="email">Email *</label>
                    <input type="email" name="email" required value="<?= htmlspecialchars($student['email']) ?>">
                </div>

                <div>
                    <label for="contactNumber">Contact Number</label>
                    <input type="text" name="contactNumber" pattern="\d*" title="Only numbers allowed" value="<?= htmlspecialchars($student['contactNumber']) ?>">
                </div>

                <div>
                    <label for="birthdate">Birthdate *</label>
                    <input type="date" name="birthdate" id="birthdate" required value="<?= htmlspecialchars($student['birthdate']) ?>">
                    <div class="error" id="birthdateError"></div>
                </div>

                <div>
                    <label for="age">Age</label>
                    <input type="text" name="age" id="age" readonly value="<?= htmlspecialchars($student['age']) ?>">
                </div>

                <div>
                    <label for="gender">Gender</label>
                    <input type="text" name="gender" value="<?= htmlspecialchars($student['gender']) ?>">
                </div>

                <div>
                    <label for="place">Place of Birth</label>
                    <input type="text" name="place" value="<?= htmlspecialchars($student['place']) ?>">
                </div>

                <div>
                    <label for="religion">Religion</label>
                    <input type="text" name="religion" value="<?= htmlspecialchars($student['religion']) ?>">
                </div>
            </div>

            <button type="button" class="section-toggle" onclick="toggleSection('addressSection')">+ Address Details</button>
            <div class="form-grid collapsible" id="addressSection">
                <div>
                    <label for="street">Street</label>
                    <input type="text" name="street" value="<?= htmlspecialchars($student['street']) ?>">
                </div>
                <div>
                    <label for="city">City</label>
                    <input type="text" name="city" value="<?= htmlspecialchars($student['city']) ?>">
                </div>
                <div>
                    <label for="state">State</label>
                    <input type="text" name="state" value="<?= htmlspecialchars($student['state']) ?>">
                </div>
                <div>
                    <label for="country">Country</label>
                    <input type="text" name="country" value="<?= htmlspecialchars($student['country']) ?>">
                </div>
                <div>
                    <label for="zip">ZIP Code</label>
                    <input type="text" name="zip" pattern="\d*" title="Only numbers allowed" value="<?= htmlspecialchars($student['zip']) ?>">
                </div>
            </div>

            <button type="button" class="section-toggle" onclick="toggleSection('academicSection')">+ Academic Details</button>
            <div class="form-grid collapsible" id="academicSection">
                <div>
                    <label for="strand">Strand</label>
                    <input type="text" name="strand" value="<?= htmlspecialchars($student['strand']) ?>">
                </div>
                <div>
                    <label for="level">Grade Level</label>
                    <input type="text" name="level" value="<?= htmlspecialchars($student['level']) ?>">
                </div>
                <div>
                    <label for="semester">Semester</label>
                    <input type="text" name="semester" value="<?= htmlspecialchars($student['semester']) ?>">
                </div>
                <div>
                    <label for="school_year">School Year</label>
                    <input type="text" name="school_year" value="<?= htmlspecialchars($student['school_year']) ?>">
                </div>
            </div>

            <button type="submit">Save Changes</button>
        </form>
    </div>

    <script>
        function toggleSection(id) {
            const section = document.getElementById(id);
            section.style.display = section.style.display === 'grid' ? 'none' : 'grid';
        }

        document.getElementById("birthdate").addEventListener("change", function () {
            const birthdate = new Date(this.value);
            const today = new Date();
            const age = today.getFullYear() - birthdate.getFullYear();
            const m = today.getMonth() - birthdate.getMonth();
            const d = today.getDate() - birthdate.getDate();
            let finalAge = age;

            if (m < 0 || (m === 0 && d < 0)) {
                finalAge--;
            }

            document.getElementById("age").value = finalAge;

            const errorDiv = document.getElementById("birthdateError");
            if (finalAge < 17) {
                errorDiv.textContent = "You must be at least 17 years old.";
            } else {
                errorDiv.textContent = "";
            }
        });

        document.getElementById("editProfileForm").addEventListener("submit", function (e) {
            const age = parseInt(document.getElementById("age").value);
            const errorDiv = document.getElementById("birthdateError");
            if (age < 17) {
                e.preventDefault();
                errorDiv.textContent = "You must be at least 17 years old to update your profile.";
            }
        });
    </script>
    <script>
    function closeEditProfile() {
        window.location.href = "settings.php"; // Redirect to settings page
    }
</script>

</body>
</html>
