<?php

/*include "config.php"; // Database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["ticket_id"];
    $desc = $_POST["ticket_desc"];
    $assigned_to = $_POST["assigned_to"];
    $status = $_POST["ticket_status"];
    $priority = $_POST["priority"];

    $stmt = $conn->prepare("UPDATE tickets SET ticket_desc=?, assigned_to=?, ticket_status=?, priority=? WHERE ticket_id=?");
    $stmt->bind_param("ssssi", $desc, $assigned_to, $status, $priority, $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "✅ Ticket updated successfully."]);
    } else {
        echo json_encode(["message" => "❌ Failed to update ticket."]);
    }

    $stmt->close();
    $conn->close();
}*/

include "config.php"; // Database connection
include "send_email.php"; // Include PHPMailer email function

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST["ticket_id"];
    $desc = $_POST["ticket_desc"];
    $assigned_to = $_POST["assigned_to"];
    $status = $_POST["ticket_status"];
    $priority = $_POST["priority"];

    $stmt = $conn->prepare("UPDATE tickets SET ticket_desc=?, assigned_to=?, ticket_status=?, priority=? WHERE ticket_id=?");
    $stmt->bind_param("ssssi", $desc, $assigned_to, $status, $priority, $id);

    if ($stmt->execute()) {
        // ✅ Fetch the actual ticket number and assigned user's email
        $stmt = $conn->prepare("SELECT ticket_number, email FROM team_users 
                                JOIN tickets ON team_users.team_id = tickets.assigned_to 
                                WHERE tickets.ticket_id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $ticket_number = $user['ticket_number']; // Use the actual ticket number
            $to = $user['email'];

            $subject = "Ticket #$ticket_number Updated";
            $body = "<p>Your assigned ticket has been updated:</p>
                     <p><strong>Ticket Number:</strong> $ticket_number</p>
                     <p><strong>Status:</strong> $status</p>
                     <p><strong>Priority:</strong> $priority</p>
                     <p><strong>Description:</strong> $desc</p>
                     <p>Check your dashboard for more details.</p>";

            sendEmail($to, $subject, $body);
        }

        echo json_encode(["message" => "✅ Ticket #$ticket_number updated successfully and user notified."]);
    } else {
        echo json_encode(["message" => "❌ Failed to update ticket."]);
    }

    $stmt->close();
    $conn->close();
}
