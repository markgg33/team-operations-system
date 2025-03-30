<?php
include "config.php"; // Database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ticketId = $_POST["ticket_id"];
    $ticketDesc = $_POST["ticket_desc"];
    $ticketStatus = $_POST["ticket_status"];

    if (!empty($ticketId) && !empty($ticketDesc) && !empty($ticketStatus)) {
        $stmt = $conn->prepare("UPDATE tickets SET ticket_desc = ?, ticket_status = ? WHERE ticket_id = ?");
        $stmt->bind_param("ssi", $ticketDesc, $ticketStatus, $ticketId);

        if ($stmt->execute()) {
            echo json_encode(["message" => "✅ Ticket updated successfully."]);
        } else {
            echo json_encode(["message" => "❌ Failed to update ticket."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["message" => "❌ Invalid data."]);
    }
} else {
    echo json_encode(["message" => "❌ Unauthorized request."]);
}

$conn->close();
