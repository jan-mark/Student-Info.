<?php
require 'db.php';

if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    $attendance_stmt = $conn->prepare("DELETE FROM attendance WHERE student_id = ?");
    $attendance_stmt->bind_param("s", $student_id);
    $attendance_stmt->execute();
    $attendance_stmt->close();

    $stmt = $conn->prepare("SELECT profile_picture FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();
    $stmt->close();

    if ($student) {
        $profile_picture = $student['profile_picture'];
        if (!empty($profile_picture) && file_exists('uploads/' . $profile_picture)) {
            unlink('uploads/' . $profile_picture);
        }

        $delete_stmt = $conn->prepare("DELETE FROM students WHERE student_id = ?");
        $delete_stmt->bind_param("s", $student_id);

        if ($delete_stmt->execute()) {
            $delete_stmt->close();
            $conn->close();
            header("Location: view.php");
            exit();
        } else {
            echo "Error deleting student: " . $delete_stmt->error;
        }

        $delete_stmt->close();
    } else {
        echo "Student not found.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
