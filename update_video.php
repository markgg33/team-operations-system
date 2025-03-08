<?php
include "config.php";

header("Content-Type: application/json"); // Ensure JSON response

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["session_id"];
    $title = trim($_POST["session_title"]);
    $desc = trim($_POST["session_desc"]);
    $videoFile = $_FILES["session_vid"];
    $response = ["success" => false, "message" => "❌ Failed to update video."];

    // Check if required fields are empty
    if (empty($id) || empty($title) || empty($desc)) {
        $response["message"] = "⚠️ Title and Description are required.";
        echo json_encode($response);
        exit();
    }

    // If a new video file is uploaded
    if (!empty($videoFile["name"])) {
        $uploadDir = "uploads/videos/";
        $fileName = basename($videoFile["name"]);
        $targetPath = $uploadDir . $fileName;

        // Ensure unique filename if file already exists
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileBase = pathinfo($fileName, PATHINFO_FILENAME);
        $counter = 1;

        while (file_exists($targetPath)) {
            $fileName = $fileBase . "_" . $counter . "." . $fileExt;
            $targetPath = $uploadDir . $fileName;
            $counter++;
        }

        // Move file & validate upload
        if (move_uploaded_file($videoFile["tmp_name"], $targetPath)) {
            $query = "UPDATE upload_session SET session_title=?, session_desc=?, session_vid=? WHERE session_id=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssi", $title, $desc, $targetPath, $id);
        } else {
            $response["message"] = "❌ Error uploading the video.";
            echo json_encode($response);
            exit();
        }
    } else {
        // Update only title & description if no new video file is uploaded
        $query = "UPDATE upload_session SET session_title=?, session_desc=? WHERE session_id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $title, $desc, $id);
    }

    // Execute Query
    if ($stmt->execute()) {
        $response["success"] = true;
        $response["message"] = "✅ Video updated successfully!";
    } else {
        $response["message"] = "❌ Database update failed.";
    }

    echo json_encode($response);
}
?>
