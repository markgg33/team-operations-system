<?php
include "config.php"; // Database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ticketId = $_POST["ticket_id"];
    $ticketStatus = $_POST["ticket_status"];

    // Ensure ticket ID and status are provided
    if (!empty($ticketId) && !empty($ticketStatus)) {
        // Update only the status, ignore title
        $stmt = $conn->prepare("UPDATE tickets SET ticket_status = ? WHERE ticket_id = ?");
        $stmt->bind_param("si", $ticketStatus, $ticketId);

        if ($stmt->execute()) {
            echo json_encode(["message" => "✅ Ticket status updated successfully."]);
        } else {
            echo json_encode(["message" => "❌ Failed to update ticket status."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["message" => "❌ Invalid data."]);
    }
} else {
    echo json_encode(["message" => "❌ Unauthorized request."]);
}

$conn->close();
?>
