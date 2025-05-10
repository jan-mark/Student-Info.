<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_name = $_POST['student_name'];
    $contact_number = $_POST['contact_number'];
    $sex = $_POST['sex'];
    $address = $_POST['address'];
    $profile_picture = null;

    $student_id = $_POST['student_id']; 

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
        } else {
            echo "<script>alert('Failed to upload file.'); window.history.back();</script>";
            exit;
        }
    }

    $sql = "INSERT INTO students (student_id, student_name, contact_number, sex, address, profile_picture) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $student_id, $student_name, $contact_number, $sex, $address, $profile_picture);

    if ($stmt->execute()) {
        echo "<script>alert('Student added successfully!'); window.location.href = 'view.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
