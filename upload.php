<?php
include "config.php";
session_start();

// Check if form was submitted
if (isset($_POST['upload'])) {
    // File upload settings
    $target_dir = "uploads/videos/"; // Directory where videos will be saved
    $allowed_types = ['video/mp4', 'video/avi', 'video/quicktime', 'video/x-ms-wmv']; // Allowed video MIME types
    $max_file_size = 600 * 1024 * 1024; // 600MB limit

    // Get form inputs
    $session_title = mysqli_real_escape_string($conn, $_POST['session_title']);
    $session_desc = mysqli_real_escape_string($conn, $_POST['session_desc']);

    // Check if file was uploaded without errors
    if (isset($_FILES['session_vid']) && $_FILES['session_vid']['error'] == 0) {
        $file_name = $_FILES['session_vid']['name'];
        $file_tmp = $_FILES['session_vid']['tmp_name'];
        $file_size = $_FILES['session_vid']['size'];
        $file_type = mime_content_type($file_tmp);

        // Validate file type
        if (!in_array($file_type, $allowed_types)) {
            $_SESSION['error'] = "Invalid file format! Only MP4, AVI, MOV, and WMV allowed.";
            header("Location: upload_page.php");
            exit();
        }

        // Validate file size (600MB limit)
        if ($file_size > $max_file_size) {
            $_SESSION['error'] = "File size exceeds the 600MB limit.";
            header("Location: upload_page.php");
            exit();
        }

        // Ensure the uploads directory exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Generate unique filename
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $new_filename = uniqid("video_", true) . "." . $file_ext;
        $target_file = $target_dir . $new_filename;

        // Move uploaded file to the target directory
        if (move_uploaded_file($file_tmp, $target_file)) {
            // Save video details in the database (session_vid stores filename only)
            $query = "INSERT INTO upload_session (session_title, session_desc, session_vid) 
                      VALUES ('$session_title', '$session_desc', '$new_filename')";

            if (mysqli_query($conn, $query)) {
                $_SESSION['success'] = "Video uploaded successfully!";
                header("Location: adminDashboard.php");
                exit();
            } else {
                $_SESSION['error'] = "Database error: " . mysqli_error($conn);
                header("Location: adminDashboard.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Failed to upload video.";
            header("Location: adminDashboard.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "No file uploaded or an error occurred.";
        header("Location: adminDashboard.php");
        exit();
    }
}
?>
