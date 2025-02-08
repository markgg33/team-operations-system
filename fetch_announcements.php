<?php
include "config.php";
include "functions.php";

$announcements = getAnnouncements(); // Fetch latest announcements

header('Content-Type: application/json');
echo json_encode($announcements);
