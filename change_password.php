<?php
include "config.php";
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['reset_user'])) {
    echo json_encode(["message" => "Unauthorized access!"]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $username = $_SESSION['reset_user'];

    if (strlen($new_password) < 7) {
        echo json_encode(["message" => "⚠️ Password must be at least 7 characters long."]);
        exit();
    }

    if ($new_password !== $confirm_password) {
        echo json_encode(["message" => "⚠️ Passwords do not match."]);
        exit();
    }   

    $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
    $query = "UPDATE team_users SET password='$hashedPassword', change_password=0 WHERE username='$username'";

    if (mysqli_query($conn, $query)) {
        unset($_SESSION['reset_user']);
        echo json_encode(["message" => "✅ Password updated successfully!"]);
    } else {
        echo json_encode(["message" => "❌ Error updating password."]);
    }
}
?>
