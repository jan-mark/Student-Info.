<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];

    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $original = $result->fetch_assoc();
    $stmt->close();

    if (!$original) {
        die("Student not found.");
    }

    $updates = [];
    $params = [];
    $types = '';

    if ($original['student_name'] !== $_POST['student_name']) {
        $updates[] = "student_name = ?";
        $params[] = $_POST['student_name'];
        $types .= 's';
    }

    if ($original['contact_number'] !== $_POST['contact_number']) {
        $updates[] = "contact_number = ?";
        $params[] = $_POST['contact_number'];
        $types .= 's';
    }

    if ($original['sex'] !== $_POST['sex']) {
        $updates[] = "sex = ?";
        $params[] = $_POST['sex'];
        $types .= 's';
    }

    if ($original['address'] !== $_POST['address']) {
        $updates[] = "address = ?";
        $params[] = $_POST['address'];
        $types .= 's';
    }

    if (count($updates) > 0) {
        $sql = "UPDATE students SET " . implode(", ", $updates) . " WHERE student_id = ?";
        $stmt = $conn->prepare($sql);

        $types .= 's'; 
        $params[] = $student_id;
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            header("Location: view.php");
            exit();
        } else {
            echo "Error updating student: " . $stmt->error;
        }

        $stmt->close();
    } else {
        header("Location: view.php");
        exit();
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
