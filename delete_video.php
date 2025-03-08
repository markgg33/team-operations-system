<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["session_id"])) {
    $session_id = mysqli_real_escape_string($conn, $_POST["session_id"]);

    // Fetch the video filename before deleting
    $query = "SELECT session_vid FROM upload_session WHERE session_id = '$session_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $videoFile = "uploads/videos/" . $row["session_vid"];

        // Delete the video file from the server
        if (file_exists($videoFile)) {
            unlink($videoFile); // Remove file
        }

        // Delete video record from database
        $deleteQuery = "DELETE FROM upload_session WHERE session_id = '$session_id'";
        if (mysqli_query($conn, $deleteQuery)) {
            echo json_encode(["success" => true, "message" => "✅ Video deleted successfully."]);
            exit();
        } else {
            echo json_encode(["success" => false, "message" => "❌ Error deleting video from database."]);
            exit();
        }
    } else {
        echo json_encode(["success" => false, "message" => "❌ Video not found."]);
        exit();
    }
} else {
    echo json_encode(["success" => false, "message" => "❌ Invalid request."]);
    exit();
}
