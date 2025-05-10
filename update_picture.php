<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];
    $profile_picture = null;

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $target_dir = "uploads/";

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $original_filename = basename($_FILES["profile_picture"]["name"]);
        $imageFileType = strtolower(pathinfo($original_filename, PATHINFO_EXTENSION));

        $new_filename = uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $new_filename;

        $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
        if ($check === false) {
            echo "<script>alert('File is not an image.'); window.history.back();</script>";
            exit;
        }

        if ($_FILES["profile_picture"]["size"] > 2000000) {
            echo "<script>alert('Sorry, your file is too large. (2MB max)'); window.history.back();</script>";
            exit;
        }

        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "<script>alert('Only JPG, JPEG, PNG, GIF files allowed.'); window.history.back();</script>";
            exit;
        }

        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $profile_picture = $new_filename;

            // Update the database with the new profile picture
            $sql = "UPDATE students SET profile_picture = ? WHERE student_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $profile_picture, $student_id);

            if ($stmt->execute()) {
                echo "<script>alert('Profile picture updated successfully!'); window.location.href = 'student_view.php?student_id=" . urlencode($student_id) . "';</script>";
            } else {
                echo "Error updating profile picture: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "<script>alert('Failed to upload file.'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('No file uploaded.'); window.history.back();</script>";
        exit;
    }
}
$conn->close();
?>
