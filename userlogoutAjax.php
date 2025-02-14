<?php
session_start();
include "config.php";

if (isset($_SESSION['user_team_username'])) {
    $username = $_SESSION['user_team_username'];
    $updateLogoutStatus = "UPDATE team_users SET is_logged_in = 0 WHERE username = '$username'";
    mysqli_query($conn, $updateLogoutStatus);
}
?>
