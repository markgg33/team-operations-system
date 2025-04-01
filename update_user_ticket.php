<?php
/*include "config.php"; // Database connection

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

$conn->close();*/

include "config.php"; // Database connection
include "send_email.php"; // Include PHPMailer email function

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ticketId = $_POST["ticket_id"];
    $ticketDesc = $_POST["ticket_desc"];
    $ticketStatus = $_POST["ticket_status"];

    if (!empty($ticketId) && !empty($ticketDesc) && !empty($ticketStatus)) {
        $stmt = $conn->prepare("UPDATE tickets SET ticket_desc = ?, ticket_status = ? WHERE ticket_id = ?");
        $stmt->bind_param("ssi", $ticketDesc, $ticketStatus, $ticketId);

        if ($stmt->execute()) {
            // ✅ Fetch the actual ticket number
            $stmt = $conn->prepare("SELECT ticket_number FROM tickets WHERE ticket_id = ?");
            $stmt->bind_param("i", $ticketId);
            $stmt->execute();
            $result = $stmt->get_result();
            $ticket = $result->fetch_assoc();
            $ticketNumber = $ticket ? $ticket['ticket_number'] : $ticketId; // Use ticket number if available

            // ✅ Get the admin email
            $stmt = $conn->prepare("SELECT email FROM team_users WHERE usertype = 'admin' LIMIT 1");
            $stmt->execute();
            $result = $stmt->get_result();
            $admin = $result->fetch_assoc();

            if ($admin) {
                $to = $admin['email'];
                $subject = "Ticket #$ticketNumber Updated by User";
                $body = "<p>A user has updated ticket #$ticketNumber.</p>
                         <p><strong>New Status:</strong> $ticketStatus</p>
                         <p><strong>Description:</strong> $ticketDesc</p>
                         <p>Check the admin panel for details.</p>";

                sendEmail($to, $subject, $body);
            }

            echo json_encode(["message" => "✅ Ticket #$ticketNumber updated successfully and admin notified."]);
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
