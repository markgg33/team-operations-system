<?php
// Database connection
$conn = mysqli_connect('localhost', 'root', 'P@ssword3309807', 'team_operations_db');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 

// Set default timezone
date_default_timezone_set('Asia/Manila');

// Auto-logout if session is lost
if (isset($_SESSION['admin_team_username'])) {
    $username = $_SESSION['admin_team_username'];

    // Check if session still exists
    if (!isset($_SESSION['admin_usertype'])) {
        $updateLogoutStatus = "UPDATE team_users SET is_logged_in = 0 WHERE username = '$username'";
        mysqli_query($conn, $updateLogoutStatus);
        
        // Destroy session and redirect to login
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }
}

// Set session timeout (e.g., 30 minutes)
$session_timeout = 1800; // 1800 seconds = 30 minutes
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $session_timeout)) {
    if (isset($_SESSION['admin_team_username'])) {
        $username = $_SESSION['admin_team_username'];
        $updateLogoutStatus = "UPDATE team_users SET is_logged_in = 0 WHERE username = '$username'";
        mysqli_query($conn, $updateLogoutStatus);
    }

    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time(); // Update last activity timestamp
?>
