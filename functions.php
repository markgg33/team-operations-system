<?php

// Check if the function is already declared
if (!function_exists('getUserCount')) {
    // TO COUNT THE DATA INSIDE THE TABLE GIVEN BY THE USER
    function getUserCount($tableName)
    {
        global $conn;
        $sql = "SELECT COUNT(*) as count FROM $tableName WHERE usertype != 'admin'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['count'];
        } else {
            return 0;
        }
    }
}


function getuserData()
{
    global $conn;

    $sql = "SELECT * FROM team_users";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = [
                'first_name' => $row['first_name'],
                'middle_name' => $row['middle_name'],
                'surname' => $row['surname'],
                'username' => $row['username'],
                'dob' => $row['dob'],
                'gender' => $row['gender'],
                'usertype' => $row['usertype'],
            ];
        }
        return $data;
    } else {
        return [];
    }
}

// Function to get announcements
function getAnnouncements()
{
    global $conn;

    $sql = "SELECT announce_title, announce_desc, date_posted FROM announcements ORDER BY date_posted DESC";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $announcements = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $announcements[] = $row;
        }
        return $announcements;
    } else {
        return [];
    }
}

// Function to get tickets assigned to a specific user
function getUserTickets($team_username)
{
    global $conn;

    // Fetch the user ID from the database based on username
    $sql = "SELECT team_id FROM team_users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $team_username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $user_id = $row['team_id'];

        // Fetch the tickets assigned to this user
        $ticket_sql = "SELECT * FROM tickets WHERE assigned_to = ? ORDER BY created_at DESC";
        $ticket_stmt = mysqli_prepare($conn, $ticket_sql);
        mysqli_stmt_bind_param($ticket_stmt, "i", $user_id);
        mysqli_stmt_execute($ticket_stmt);
        $ticket_result = mysqli_stmt_get_result($ticket_stmt);

        $tickets = [];
        while ($ticket = mysqli_fetch_assoc($ticket_result)) {
            $tickets[] = $ticket;
        }
        return $tickets;
    } else {
        return [];
    }
}

function timeAgo($datetime)
{
    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;

    if ($diff < 60) {
        return $diff . " sec ago";
    } elseif ($diff < 3600) {
        return round($diff / 60) . " min ago";
    } elseif ($diff < 86400) {
        return round($diff / 3600) . " hr ago";
    } else {
        return date("M d, Y", $timestamp);
    }
}

function getActiveGSDs()
{
    global $conn;
    $query = "SELECT COUNT(*) AS active_gsds FROM tickets WHERE ticket_status IN ('In Progress', 'On Hold')";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['active_gsds'] ?? 0;
}

function getAllTickets($page, $limit)
{
    global $conn;
    $offset = ($page - 1) * $limit;

    $query = "SELECT t.ticket_number, t.ticket_title,
                     CONCAT(u.first_name, ' ', u.surname, ' (' , u.username , ')') AS assigned_to,
                     t.ticket_status
              FROM tickets t
              JOIN team_users u ON t.assigned_to = u.team_id
              ORDER BY t.created_at DESC 
              LIMIT $limit OFFSET $offset";

    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Get total ticket count for pagination
function getTotalTickets()
{
    global $conn;
    $query = "SELECT COUNT(*) AS total FROM tickets";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}


function getUsersOnline()
{
    global $conn;
    $query = "SELECT COUNT(*) AS users_online FROM team_users WHERE is_online = 1 AND usertype != 'admin'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['users_online'] ?? 0;
}
