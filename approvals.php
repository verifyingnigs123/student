<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "student_registration");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle approval
if (isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    
    // Update student's approval status
    $query = "UPDATE students SET is_approved = 1 WHERE id = $id";
    if ($conn->query($query)) {
        // Success message for approval
        $message = "Student approved successfully!";
        $message_type = "success";
    } else {
        // Error message if approval fails
        $message = "Failed to approve student: " . $conn->error;
        $message_type = "error";
    }

    // Redirect back with the success or error message
    header("Location: approvals.php?message=$message&type=$message_type");
    exit();
}

// Handle rejection
if (isset($_GET['reject'])) {
    $id = intval($_GET['reject']);
    
    // Delete student record
    $query = "DELETE FROM students WHERE id = $id";
    if ($conn->query($query)) {
        // Success message for rejection
        $message = "Student rejected successfully!";
        $message_type = "success";
    } else {
        // Error message if rejection fails
        $message = "Failed to reject student: " . $conn->error;
        $message_type = "error";
    }

    // Redirect back with the success or error message
    header("Location: approvals.php?message=$message&type=$message_type");
    exit();
}

// Display message if any
if (isset($_GET['message']) && isset($_GET['type'])) {
    $message = $_GET['message'];
    $message_type = $_GET['type'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Approval</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 p-6">

    
<div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-bold">Pending Students Approval</h1>
        <!-- X Button to go back to the dashboard -->
        <a href="teacherdashboard.php" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-red-600">
            X
        </a>
    </div>

    <?php
    // Display any message after an action is taken
    if (isset($message) && isset($message_type)) {
        echo "<div class='bg-$message_type-100 text-$message_type-800 p-4 mb-4 rounded'>$message</div>";
    }
    ?>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Full Name</th>
                    <th class="px-6 py-3">Student LRN</th>
                    <th class="px-6 py-3">Level</th>
                    <th class="px-6 py-3">Strand</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch all students who are not approved yet
                $result = $conn->query("SELECT * FROM students WHERE is_approved = 0");

                while ($row = $result->fetch_assoc()) {
                    echo "<tr class='border-t'>";
                    echo "<td class='px-6 py-4'>" . htmlspecialchars($row['student_type']) . "</td>";
                    echo "<td class='px-6 py-4'>" . htmlspecialchars($row['fName'] . " " . $row['lName']) . "</td>";
                    echo "<td class='px-6 py-4'>" . htmlspecialchars($row['student_id']) . "</td>";
                    echo "<td class='px-6 py-4'>" . htmlspecialchars($row['level']) . "</td>";
                    echo "<td class='px-6 py-4'>" . htmlspecialchars($row['strand']) . "</td>";
                    echo "<td class='px-6 py-4'>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td class='px-6 py-4 space-x-2'>
                            <a href='approvals.php?approve=" . $row['id'] . "' class='bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600'>Approve</a>
                            <a href='approvals.php?reject=" . $row['id'] . "' class='bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600'>Reject</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
