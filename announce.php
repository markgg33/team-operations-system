<?php
include "config.php";
session_start();

if (isset($_POST['announce'])) {
    $title = mysqli_real_escape_string($conn, $_POST['announce_title']);
    $description = mysqli_real_escape_string($conn, $_POST['announce_desc']);
    $date_posted = date("Y-m-d H:i:s"); // Current timestamp

    // Insert into the database
    $sql = "INSERT INTO announcements (announce_title, announce_desc, date_posted) 
            VALUES ('$title', '$description', '$date_posted')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Announcement added successfully!'); window.location.href='adminDashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }

    mysqli_close($conn);
}
