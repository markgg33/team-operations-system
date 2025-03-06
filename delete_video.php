<?php
include "config.php";
$id = $_POST["session_id"];
$query = "DELETE FROM upload_session WHERE session_id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
echo json_encode(["message" => "✅ Video deleted successfully!"]);
