<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $contact_number = $_POST['contact_number'];
    $sex = $_POST['sex'];
    $address = $_POST['address'];
    
    // Handle profile picture upload
    $profile_picture = '';
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = $_FILES['profile_picture']['name'];
        $fileSize = $_FILES['profile_picture']['size'];
        $fileType = $_FILES['profile_picture']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Generate unique file name
            $newFileName = uniqid('IMG-', true) . '.' . $fileExtension;
            $uploadFileDir = 'uploads/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $profile_picture = $newFileName;

                // Update including new profile picture
                $sql = "UPDATE students SET student_name=?, contact_number=?, sex=?, address=?, profile_picture=? WHERE student_id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssss", $student_name, $contact_number, $sex, $address, $profile_picture, $student_id);
            } else {
                die("Error uploading the profile picture.");
            }
        } else {
            die("Upload failed. Only JPG, JPEG, PNG, and GIF files are allowed.");
        }
    } else {
        $sql = "UPDATE students SET student_name=?, contact_number=?, sex=?, address=? WHERE student_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $student_name, $contact_number, $sex, $address, $student_id);
    }

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: view.php?update=success");
        exit();
    } else {
        die("Error updating student: " . $stmt->error);
    }
} else {
    die("Invalid request.");
}
?>
