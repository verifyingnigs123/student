<?php
// dashboard_stats.php
require 'db.php'; // your DB connection file

header('Content-Type: application/json');

// Count teachers
$teacherQuery = "SELECT COUNT(*) AS total_teachers FROM teachers";
$teacherResult = mysqli_query($conn, $teacherQuery);
$teacherData = mysqli_fetch_assoc($teacherResult);

// Count students
$studentQuery = "SELECT COUNT(*) AS total_students FROM students";
$studentResult = mysqli_query($conn, $studentQuery);
$studentData = mysqli_fetch_assoc($studentResult);

// Output JSON
echo json_encode([
    'teachers' => $teacherData['total_teachers'],
    'students' => $studentData['total_students']
]);
?>
