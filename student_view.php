<?php
require 'db.php';

if (!isset($_GET['student_id'])) {
    die("Student ID not provided.");
}

$student_id = $_GET['student_id'];
$sql = "SELECT * FROM students WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    die("Student not found.");
}

$student = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View and Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>View and Edit Student</h1>
        
        <!-- Display Profile Picture at the Top -->
        <label>Current Profile Picture:</label>
        <?php if (!empty($student['profile_picture'])): ?>
            <img src="uploads/<?= htmlspecialchars($student['profile_picture']) ?>" alt="Profile Picture" width="100" onerror="this.onerror=null;this.src='default.png';">
        <?php else: ?>
            <img src="default.png" alt="No Profile Picture" width="100">
        <?php endif; ?>

        <form action="update_student.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="student_id" value="<?= htmlspecialchars($student['student_id']) ?>">
            
            <label>ID Number:</label>
            <input type="text" name="student_id" value="<?= htmlspecialchars($student['student_id']) ?>" required readonly>

            <label>Student Name:</label>
            <input type="text" name="student_name" value="<?= htmlspecialchars($student['student_name']) ?>" required>

            <label>Contact Number:</label>
            <input type="text" name="contact_number" value="<?= htmlspecialchars($student['contact_number']) ?>" required>

            <label>Sex:</label>
            <select name="sex" required>
                <option value="Male" <?= $student['sex'] == 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $student['sex'] == 'Female' ? 'selected' : '' ?>>Female</option>
            </select>

            <label>Address:</label>
            <textarea name="address" required><?= htmlspecialchars($student['address']) ?></textarea>

            <h2>Update Profile Picture</h2>
            <input type="file" name="profile_picture" accept="image/*">

            <button type="submit">Update Student Details</button>
        </form>
        <br>
        <a href="view.php" class="button-grey">Back to Student List</a>
    </div>
</body>
</html>
