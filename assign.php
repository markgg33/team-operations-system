<?php

include "config.php"; // Database connection
include "send_email.php"; // PHPMailer email function

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = mysqli_real_escape_string($conn, $_POST["ticket_title"]);
    $desc = mysqli_real_escape_string($conn, $_POST["ticket_desc"]);
    $priority = $_POST["priority"];
    $status = $_POST["ticket_status"];
    $assigned_to = $_POST["assigned_user"];
    $created_at = date("Y-m-d H:i:s"); // Get current timestamp

    // Get the latest ticket number from the database
    $latestQuery = "SELECT ticket_number FROM tickets ORDER BY ticket_id DESC LIMIT 1";
    $latestResult = mysqli_query($conn, $latestQuery);
    $latestTicket = mysqli_fetch_assoc($latestResult);

    // Extract numeric part and increment
    if ($latestTicket) {
        $latestNumber = (int) str_replace("CDP-", "", $latestTicket["ticket_number"]);
        $newNumber = $latestNumber + 1;
    } else {
        $newNumber = 1; // First ticket
    }

    // Format ticket number as CDP-XXXXXX
    $ticketNumber = "CDP-" . str_pad($newNumber, 6, "0", STR_PAD_LEFT);

    // Ensure the generated ticket number is unique (single query instead of loop)
    $checkQuery = "SELECT COUNT(*) AS count FROM tickets WHERE ticket_number = '$ticketNumber'";
    $checkResult = mysqli_query($conn, $checkQuery);
    $row = mysqli_fetch_assoc($checkResult);

    if ($row['count'] > 0) {
        echo "<script>alert('❌ Ticket number conflict. Please try again.');</script>";
        exit();
    }

    // Insert ticket into database
    $stmt = $conn->prepare("INSERT INTO tickets (ticket_number, ticket_title, ticket_desc, priority, ticket_status, assigned_to, created_at) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $ticketNumber, $title, $desc, $priority, $status, $assigned_to, $created_at);

    if ($stmt->execute()) {
        // Fetch assigned user's email (Make sure this runs only once)
        $stmt = $conn->prepare("SELECT email, first_name FROM team_users WHERE team_id = ? LIMIT 1");
        $stmt->bind_param("s", $assigned_to);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            $to = $user['email'];
            $subject = "🔔 New Ticket Assigned: $ticketNumber - $title";
            $body = "<p>Hello <b>{$user['first_name']}</b>,</p>
                     <p>A new ticket has been assigned to you.</p>
                     <p><b>Ticket Number:</b> $ticketNumber</p>
                     <p><b>Title:</b> $title</p>
                     <p><b>Description:</b> $desc</p>
                     <p><b>Priority:</b> $priority</p>
                     <p><b>Status:</b> $status</p>
                     <p>📅 <b>Date Created:</b> $created_at</p>
                     <p>Check your dashboard for more details.</p>";

            sendEmail($to, $subject, $body);
        }

        echo "<script>alert('✅ Ticket $ticketNumber created and email sent successfully!'); window.location.href='adminDashboard.php';</script>";
    } else {
        echo "<script>alert('❌ Failed to create ticket.');</script>";
    }

    $stmt->close();
    $conn->close();
}

?>






<!----include "config.php";
session_start();

if (isset($_POST['assign'])) {
    // Sanitize user input
    $title = mysqli_real_escape_string($conn, $_POST['ticket_title']);
    $description = mysqli_real_escape_string($conn, $_POST['ticket_desc']);
    $status = mysqli_real_escape_string($conn, $_POST['ticket_status']);
    $assigned_to = mysqli_real_escape_string($conn, $_POST['assigned_user']);
    $priority = isset($_POST['priority']) ? (int) $_POST['priority'] : 3; // Default priority 3 (Low)
    $date_created = date("Y-m-d H:i:s"); // Current timestamp

    // Ensure required fields are not empty
    if (empty($title) || empty($description) || empty($assigned_to)) {
        echo "<script>alert('Please fill in all required fields.'); window.history.back();</script>";
        exit();
    }

    // Get the latest ticket number
    $latestQuery = "SELECT ticket_number FROM tickets ORDER BY ticket_id DESC LIMIT 1";
    $latestResult = mysqli_query($conn, $latestQuery);
    $latestTicket = mysqli_fetch_assoc($latestResult);

    // Extract numeric part and increment
    if ($latestTicket) {
        $latestNumber = (int) str_replace("CDP-", "", $latestTicket["ticket_number"]);
        $newNumber = $latestNumber + 1;
    } else {
        $newNumber = 1; // First ticket
    }

    // Format ticket number as CDP-XXXXXX
    $ticketNumber = "CDP-" . str_pad($newNumber, 6, "0", STR_PAD_LEFT);

    // Insert into the database (Including Priority)
    $sql = "INSERT INTO tickets (ticket_number, ticket_title, ticket_desc, ticket_status, assigned_to, priority, created_at) 
            VALUES ('$ticketNumber', '$title', '$description', '$status', '$assigned_to', '$priority', '$date_created')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Ticket $ticketNumber created successfully!'); window.location.href='adminDashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }

    // Close connection
    mysqli_close($conn);
}
?>


<----?php
include "config.php";
session_start();

if (isset($_POST['assign'])) {
    // Sanitize user input
    $title = mysqli_real_escape_string($conn, $_POST['ticket_title']);
    $description = mysqli_real_escape_string($conn, $_POST['ticket_desc']);
    $status = mysqli_real_escape_string($conn, $_POST['ticket_status']);
    $assigned_to = mysqli_real_escape_string($conn, $_POST['assigned_user']);
    //$recipient_name = mysqli_real_escape_string($conn, $_POST['recipient_name']); // Manually entered
    //$admin_name = mysqli_real_escape_string($conn, $_POST['admin_name']); // Manually entered
    $date_created = date("Y-m-d H:i:s"); // Current timestamp

    // Format the ticket description as a **formal letter**
    /*$formatted_desc = "Dear $recipient_name,\n\n" .
                      ucfirst($description) . "\n\n" .
                      "Best regards,\n" .
                      "$admin_name\n Cat Dumplings Productions";

    // Ensure required fields are not empty
    if (empty($title) || empty($description) || empty($assigned_to)) {
        echo "<script>alert('Please fill in all required fields.'); window.history.back();</script>";
        exit();
    }

    // Insert into the database
    $sql = "INSERT INTO tickets (ticket_title, ticket_desc, ticket_status, assigned_to, created_at) 
            VALUES ('$title', '$description', '$status', '$assigned_to', '$date_created')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Ticket created successfully!'); window.location.href='adminDashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }

    // Close connection
    mysqli_close($conn);
}--->