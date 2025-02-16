<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["ticket_id"];
    $title = $_POST["ticket_title"];
    $assigned_to = $_POST["assigned_to"];
    $status = $_POST["ticket_status"];

    // Prepare and execute the update query
    $stmt = $conn->prepare("UPDATE tickets SET ticket_title=?, assigned_to=?, ticket_status=? WHERE ticket_id=?");
    $stmt->bind_param("sisi", $title, $assigned_to, $status, $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "✅ Ticket updated successfully."]);
    } else {
        echo json_encode(["message" => "❌ Failed to update ticket."]);
    }

    $stmt->close();
    $conn->close();
}
?>
