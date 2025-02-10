<?php
include "config.php";
session_start();

header("Content-Type: application/json"); // Ensure JSON response

$target_dir = "uploads/videos/";
$allowed_types = ['video/mp4', 'video/avi', 'video/quicktime', 'video/x-ms-wmv'];
$max_file_size = 800 * 1024 * 1024; // 800MB

$response = ["status" => "error", "message" => "An unknown error occurred."];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $session_title = mysqli_real_escape_string($conn, $_POST['session_title']);
    $session_desc = mysqli_real_escape_string($conn, $_POST['session_desc']);

    if (isset($_FILES['session_vid']) && $_FILES['session_vid']['error'] == 0) {
        $file_name = $_FILES['session_vid']['name'];
        $file_tmp = $_FILES['session_vid']['tmp_name'];
        $file_size = $_FILES['session_vid']['size'];
        $file_type = mime_content_type($file_tmp);

        // Validate file type
        if (!in_array($file_type, $allowed_types)) {
            echo json_encode(["status" => "error", "message" => "Invalid file format! Only MP4, AVI, MOV, and WMV allowed."]);
            exit();
        }

        // Validate file size
        if ($file_size > $max_file_size) {
            echo json_encode(["status" => "error", "message" => "File size exceeds the 800MB limit."]);
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

        // Move uploaded file
        if (move_uploaded_file($file_tmp, $target_file)) {
            // Save video details in the database
            $query = "INSERT INTO upload_session (session_title, session_desc, session_vid) 
                      VALUES ('$session_title', '$session_desc', '$new_filename')";

            if (mysqli_query($conn, $query)) {
                echo json_encode(["status" => "success", "message" => "Video uploaded successfully!", "filename" => $new_filename]);
                exit();
            } else {
                echo json_encode(["status" => "error", "message" => "Database error: " . mysqli_error($conn)]);
                exit();
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to upload video."]);
            exit();
        }
    } else {
        echo json_encode(["status" => "error", "message" => "No file uploaded or an error occurred."]);
        exit();
    }
}
?>
