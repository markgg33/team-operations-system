<?php
// Pagination settings
$limit = 3; // Number of tickets per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$totalTickets = getTotalTickets();
$totalPages = ceil($totalTickets / $limit);
$tickets = getAllTickets($page, $limit);

// Function to determine badge color based on status
function getStatusColor($status)
{
    switch ($status) {
        case 'In Progress':
            return 'primary'; // BLUE
        case 'On Hold':
            return 'warning'; // YELLOW
        case 'Done':
            return 'success'; // Green
        default:
            return 'secondary'; // Gray for unknown status
    }
}
