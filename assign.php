<?php
include "config.php";
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


<!---?php
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
                      "$admin_name\n Cat Dumplings Productions";*/

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
}
?>