<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "student_registration");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the student details to pre-fill the form
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM students WHERE id = $id");
    $student = $result->fetch_assoc();
}

// Update the student information
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $level = $_POST['level'];
    $strand = $_POST['strand'];

    if ($conn->query("UPDATE students SET level = '$level', strand = '$strand' WHERE id = $id")) {
        $message = "Student information updated successfully!";
        $message_type = "success";
    } else {
        $message = "Failed to update student information.";
        $message_type = "error";
    }
    header("Location: update.php?id=$id&message=$message&type=$message_type");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Student Information</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 p-6">

    <h1 class="text-3xl font-bold mb-4">Update Student Information</h1>

    <!-- Display Success/Error Messages -->
    <?php
    if (isset($message)) {
        $message_class = $message_type == "success" ? "bg-green-500" : "bg-red-500";
        echo "<div class='mb-4 text-white $message_class p-3 rounded'>" . htmlspecialchars($message) . "</div>";
    }
    ?>

    <form action="update.php" method="POST" class="bg-white shadow-md rounded-lg p-6">
        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">
        
        <div class="mb-4">
            <label for="level" class="block text-sm font-medium text-gray-700">Level</label>
            <input type="text" name="level" id="level" value="<?php echo htmlspecialchars($student['level']); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="mb-4">
            <label for="strand" class="block text-sm font-medium text-gray-700">Strand</label>
            <input type="text" name="strand" id="strand" value="<?php echo htmlspecialchars($student['strand']); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <button type="submit" name="update" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Update Student</button>
    </form>

</body>
</html>
