<?php
include "config.php";

$query = "SELECT team_id, password FROM team_users";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $userId = $row['team_id'];
    $plainTextPassword = $row['password'];

    // Check if the password is already hashed (to avoid double hashing)
    if (!password_needs_rehash($plainTextPassword, PASSWORD_DEFAULT)) {
        continue;
    }

    $hashedPassword = password_hash($plainTextPassword, PASSWORD_DEFAULT);

    $updateQuery = "UPDATE team_users SET password = '$hashedPassword' WHERE team_id = $userId";
    mysqli_query($conn, $updateQuery);
}

echo "All plain text passwords have been hashed successfully!";
?>
