<?php

//V2

/*session_start();
include "config.php";

if (isset($_SESSION["user_" . $_SESSION['team_id']])) {
    $team_id = $_SESSION['team_id'];

    // Reset `is_logged_in`
    $updateLogoutStatus = "UPDATE team_users SET is_logged_in = 0 WHERE team_id = '$team_id'";
    mysqli_query($conn, $updateLogoutStatus);

    // ✅ Remove only this user’s session
    unset($_SESSION["user_" . $team_id]);
}

// Redirect to login page
header("Location: index.php");
exit();*/


//V1 WORKING
session_start();
include "config.php";

if (isset($_SESSION["user_team_username"])) {
    $team_username = $_SESSION["user_team_username"];

    // Update both is_online and is_logged_in to 0
    $query = "UPDATE team_users SET is_online = 0, is_logged_in = 0 WHERE username = '$team_username'";
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

// Redirect to login page
header("Location: index.php");
exit();