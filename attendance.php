<?php
require 'db.php';

$sql = "SELECT * FROM students ORDER BY SUBSTRING_INDEX(student_name, ' ', -1) ASC"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mark Attendance</title>
    <link rel="shortcut icon" href="./icon/logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white rounded-lg p-6 shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Mark Attendance</h1>
        
        <form action="mark_attendance_process.php" method="POST" class="space-y-6">
            <div>
                <label class="block font-semibold mb-2">Date:</label>
                <input type="date" name="date" class="border border-gray-300 rounded-md p-2 w-full" required>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 px-4 py-2">Student Name</th>
                            <th class="border border-gray-300 px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="odd:bg-white even:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['student_name']) ?></td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <select name="attendance[<?= $row['student_id'] ?>]" class="border border-gray-300 rounded-md p-1 w-full">
                                        <option value="Present">Present</option>
                                        <option value="Absent">Absent</option>
                                        <option value="Late">Late</option>
                                        <option value="Excuse">Excuse</option>
                                    </select>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="text-center">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition">Submit Attendance</button>
            </div>
        </form>

        <div class="mt-4 text-center">
            <a href="view.php" class="text-blue-500 hover:underline">View All Students</a>
        </div>
    </div>
</body>
</html>
