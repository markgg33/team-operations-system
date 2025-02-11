<?php
include 'config.php'; // Your database connection

header('Content-Type: application/json');

// Fetch Tickets
$ticketsQuery = "SELECT t.ticket_id, t.ticket_title, t.ticket_desc, t.ticket_status, u.first_name, u.surname 
                 FROM tickets t 
                 JOIN team_users u ON t.assigned_to = u.team_id";
$ticketsResult = mysqli_query($conn, $ticketsQuery);
$tickets = [];
while ($row = mysqli_fetch_assoc($ticketsResult)) {
    $tickets[] = $row;
}

// Fetch Users
$usersQuery = "SELECT team_id, first_name, middle_name, surname, username, email, gender, dob, usertype FROM team_users";
$usersResult = mysqli_query($conn, $usersQuery);
$users = [];
while ($row = mysqli_fetch_assoc($usersResult)) {
    $users[] = $row;
}

// Fetch Video Sessions
$sessionsQuery = "SELECT session_id, session_title, session_desc FROM upload_session";
$sessionsResult = mysqli_query($conn, $sessionsQuery);
$sessions = [];
while ($row = mysqli_fetch_assoc($sessionsResult)) {
    $sessions[] = $row;
}

// Return JSON Response
echo json_encode(["tickets" => $tickets, "users" => $users, "sessions" => $sessions]);
