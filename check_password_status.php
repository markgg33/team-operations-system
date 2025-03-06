<?php
include "config.php";
session_start();

$response = ["change_password" => 0];

if (isset($_SESSION["user_team_username"])) {
    $username = $_SESSION["user_team_username"];

    $query = "SELECT change_password FROM team_users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $response["change_password"] = $row["change_password"];
    }
}

echo json_encode($response);
?>
