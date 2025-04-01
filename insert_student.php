<?php
include 'db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['fName'];
    $middle_name = $_POST['mName'];
    $last_name = $_POST['lName'];
    $birthdate = $_POST['birthdate'];
    $student_id = $_POST['studentID'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $zip = $_POST['zip'];
    $email = $_POST['email'];
    $strand = $_POST['strand'];
    $level = $_POST['level'];

    // Insert data into the database
    $sql = "INSERT INTO students (first_name, middle_name, last_name, birthdate, student_id, street_address, city, state_province, country, zip_code, email, strand, level) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssss", $first_name, $middle_name, $last_name, $birthdate, $student_id, $street, $city, $state, $country, $zip, $email, $strand, $level);

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
