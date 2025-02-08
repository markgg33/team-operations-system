<?php
session_start();
include "config.php";

if (isset($_SESSION["user_team_username"])) {
    $team_username = $_SESSION["user_team_username"];
    $query = "UPDATE team_users SET is_online = 0 WHERE username = '$team_username'";
    mysqli_query($conn, $query);

    // Remove only user-related session variables
    unset($_SESSION["user_team_username"]);
    unset($_SESSION["user_first_name"]);
    unset($_SESSION["user_middle_name"]);
    unset($_SESSION["user_surname"]);
    unset($_SESSION["user_dob"]);
    unset($_SESSION["user_gender"]);
    unset($_SESSION["user_photo"]);
    unset($_SESSION["user_created"]);
    unset($_SESSION["user_usertype"]);
}

// Redirect without destroying the whole session
header("Location: index.php");
exit();
