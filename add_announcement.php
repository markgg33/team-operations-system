<?php

/*include "config.php";
session_start();

if (isset($_POST['submit_announce'])) {
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
}*/

include "config.php";
include "send_email.php"; // Ensure PHPMailer is configured

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['announce_title']);
    $description = mysqli_real_escape_string($conn, $_POST['announce_desc']);
    $date_posted = date("Y-m-d H:i:s");

    // ✅ Insert only one announcement
    $sql = "INSERT INTO announcements (announce_title, announce_desc, date_posted) 
            VALUES ('$title', '$description', '$date_posted')";

    if (mysqli_query($conn, $sql)) {
        // ✅ Fetch all user emails
        $users_query = "SELECT email FROM team_users WHERE usertype != 'admin'";
        $result = mysqli_query($conn, $users_query);

        $emails = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $emails[] = $row['email'];
        }

        // ✅ Send email to all users (BCC for efficiency)
        if (!empty($emails)) {
            $to = array_shift($emails); // Take the first user's email as the main recipient
            $subject = "📢 New Announcement: $title";
            $body = "<h3>$title</h3><p>$description</p><p>📅 Date: $date_posted</p>";

            sendEmail($to, $subject, $body, $emails); // Add the rest as BCC
        }

        echo "✅ Announcement added successfully!";
    } else {
        echo "❌ Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
