<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $attendance = $_POST['attendance'];

    // Prepare the insert statement for attendance
    $stmt = $conn->prepare("INSERT INTO attendance (date, student_id, status) VALUES (?, ?, ?)");

    // Check for each student's ID before inserting into attendance
    foreach ($attendance as $student_id => $status) {
        // Verify if student_id exists in the students table
        $check_stmt = $conn->prepare("SELECT student_id FROM students WHERE student_id = ?");
        $check_stmt->bind_param("s", $student_id);
        $check_stmt->execute();
        $check_stmt->store_result();

        // If student exists, insert attendance
        if ($check_stmt->num_rows > 0) {
            // Bind and execute the statement to insert attendance
            $stmt->bind_param("sis", $date, $student_id, $status);
        }

        $check_stmt->close();
    }

    $stmt->close();
    $conn->close();

    echo "<script>alert('Attendance marked successfully!'); window.location.href = 'attendance.php';</script>";
} else {
    header("Location: attendance.php");
    exit();
}
?>
