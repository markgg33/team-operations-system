<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["ticket_id"];

    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM tickets WHERE ticket_id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "✅ Ticket deleted successfully."]);
    } else {
        echo json_encode(["message" => "❌ Failed to delete ticket."]);
    }

    $stmt->close();
    $conn->close();
}
?>
