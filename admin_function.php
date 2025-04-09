<?php
function addGrade($conn, $student_id, $subject, $grade) {
    $stmt = $conn->prepare("INSERT INTO grades (student_id, subject, grade) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $student_id, $subject, $grade);
    return $stmt->execute();
}

function addScheduleAndSubject($conn, $class_name, $subject, $day, $time) {
    $stmt = $conn->prepare("INSERT INTO schedules (class_name, subject, day, time) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $class_name, $subject, $day, $time);
    return $stmt->execute();
}

function addAccountBalance($conn, $student_id, $balance) {
    $stmt = $conn->prepare("UPDATE students SET balance = ? WHERE id = ?");
    $stmt->bind_param("di", $balance, $student_id);
    return $stmt->execute();
}

function addPermit($conn, $student_id, $status) {
    $stmt = $conn->prepare("INSERT INTO permits (student_id, status) VALUES (?, ?)");
    $stmt->bind_param("is", $student_id, $status);
    return $stmt->execute();
}
?>
