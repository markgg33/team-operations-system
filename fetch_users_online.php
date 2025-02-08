<?php
include "config.php";
include "functions.php";

header('Content-Type: application/json');

$users_online = getUsersOnline();
echo json_encode(['users_online' => $users_online]);
?>
