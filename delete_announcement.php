<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["announce_id"];

    $stmt = $conn->prepare("DELETE FROM announcements WHERE announce_id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Announcement deleted successfully."]);
    } else {
        echo json_encode(["message" => "Failed to delete announcement."]);
    }

    $stmt->close();
    $conn->close();
}
?>
