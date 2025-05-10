<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>2A Students List</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 p-6">
  <div class="max-w-5xl mx-auto bg-white rounded-lg p-6 shadow-md">
    <h1 class="text-2xl font-extrabold text-slate-900 mb-6 text-center">2A Students List</h1>

    <?php
    require 'db.php';
    $sql = "SELECT * FROM students ORDER BY SUBSTRING_INDEX(student_name, ' ', -1) ASC";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0): ?>
      <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border border-slate-300">
          <thead>
            <tr class="bg-slate-100 text-slate-900 font-semibold">
              <th class="border border-slate-200 px-4 py-2 text-center">Student ID</th>
              <th class="border border-slate-300 px-4 py-2 text-center">Student Name</th>
              <th class="border border-slate-300 px-4 py-2 whitespace-nowrap">Contact Number</th>
              <th class="border border-slate-300 px-4 py-2 text-center">Sex</th>
              <th class="border border-slate-300 px-4 py-2 text-center">Address</th>
              <th class="border border-slate-300 px-4 py-2 whitespace-nowrap">Profile Picture</th>
              <th class="border border-slate-300 px-10 py-2 text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr class="odd:bg-white even:bg-slate-50 text-slate-900">
                <td class="border border-slate-300 px-4 py-2 align-top whitespace-nowrap"><?= htmlspecialchars($row['student_id']) ?></td>
                <td class="border border-slate-300 px-4 py-2 align-top whitespace-nowrap"><?= htmlspecialchars($row['student_name']) ?></td>
                <td class="border border-slate-300 px-4 py-2 align-top whitespace-nowrap"><?= htmlspecialchars($row['contact_number']) ?></td>
                <td class="border border-slate-300 px-4 py-2 align-top whitespace-nowrap"><?= htmlspecialchars($row['sex']) ?></td>
                <td class="border border-slate-300 px-4 py-2 align-top whitespace-nowrap"><?= htmlspecialchars($row['address']) ?></td>
                <td class="border border-slate-300 px-4 py-2 align-top whitespace-nowrap">
                <?php if (!empty($row['profile_picture'])): ?>
                  <img src="uploads/<?= htmlspecialchars($row['profile_picture']) ?>" alt="Profile Picture" width="100" onerror="this.onerror=null;this.src='default.png';">
                <?php else: ?>
                  <img src="default.png" alt="No Profile Picture" width="100">
                <?php endif; ?>
                </td>
                <td class="border border-slate-300 px-10 py-2 text-center">
                  <a href="student_view.php?student_id=<?= urlencode($row['student_id']) ?>" class="inline-block border border-green-500 text-green-500 rounded-md px-3 py-1 hover:bg-green-50 transition">Edit</a>
                  <a href="delete.php?student_id=<?= urlencode($row['student_id']) ?>" class="inline-block border border-red-500 text-red-500 rounded-md px-3 py-1 hover:bg-red-50 transition" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <h2 class="text-center text-slate-700">No students found.</h2>
    <?php endif;
    $conn->close();
    ?>

    <div class="mt-8 text-center">
      <a href="index.html" class="inline-block border border-slate-400 text-slate-500 rounded-md px-6 py-2 cursor-pointer hover:bg-slate-100 transition">Back to Add Student</a>
    </div>
  </div>
</body>
</html>
