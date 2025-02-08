<?php
session_start();
include "config.php";

if (isset($_SESSION['admin_team_username'])) {
    $username = $_SESSION['admin_team_username'];
    
    // Reset is_logged_in before destroying session
    $updateLogoutStatus = "UPDATE team_users SET is_logged_in = 0 WHERE username = '$username'";
    mysqli_query($conn, $updateLogoutStatus);

    // Remove only admin-related session variables
    unset($_SESSION['admin_team_username']);
    unset($_SESSION['admin_first_name']);
    unset($_SESSION['admin_middle_name']);
    unset($_SESSION['admin_surname']);
    unset($_SESSION['admin_dob']);
    unset($_SESSION['admin_gender']);
    unset($_SESSION['admin_photo']);
    unset($_SESSION['admin_created']);
    unset($_SESSION['admin_usertype']);
}

// Redirect without destroying the whole session
header("Location: index.php");
exit();
?>
