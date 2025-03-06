<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["session_id"];
    $title = $_POST["session_title"];
    $desc = $_POST["session_desc"];
    $videoFile = $_FILES["session_vid"];

    if (!empty($videoFile["name"])) {
        $videoPath = "uploads/videos/" . basename($videoFile["name"]);
        move_uploaded_file($videoFile["tmp_name"], $videoPath);
        $query = "UPDATE upload_session SET session_title=?, session_desc=?, session_vid=? WHERE session_id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $title, $desc, $videoPath, $id);
    } else {
        $query = "UPDATE upload_session SET session_title=?, session_desc=? WHERE session_id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $title, $desc, $id);
    }

    if ($stmt->execute()) {
        echo json_encode(["message" => "✅ Video updated successfully!"]);
    } else {
        echo json_encode(["message" => "❌ Failed to update video."]);
    }
}
