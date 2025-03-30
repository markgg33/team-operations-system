<?php

include "config.php";
session_start();

if (isset($_POST['btn-submit'])) {
    $team_username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['userPass'];

    // Fetch user only by username
    $select = "SELECT * FROM team_users WHERE username = '$team_username'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        // Verify password (Use password_verify if passwords are hashed)
        if (password_verify($password, $row['password'])) {
            if ($row['usertype'] == 'admin') {

                // Check if an admin is already logged in
                $check_admin = "SELECT * FROM team_users WHERE usertype = 'admin' AND is_logged_in = 1";
                $admin_result = mysqli_query($conn, $check_admin);

                if (mysqli_num_rows($admin_result) > 0) {
                    echo '<script>alert("An admin is already logged in. Only one admin can be online at a time."); window.location.href="index.php";</script>';
                    exit();
                }

                // Mark admin as logged in
                $update_status = "UPDATE team_users SET is_logged_in = 1 WHERE username = '$team_username'";
                mysqli_query($conn, $update_status);
                 // ✅ Ensure the correct team_id is stored
                $_SESSION['team_id'] = $team_id;
                $_SESSION['admin_team_username'] = $row['username'];
                $_SESSION['admin_first_name'] = $row['first_name'];
                $_SESSION['admin_middle_name'] = $row['middle_name'];
                $_SESSION['admin_surname'] = $row['surname'];
                $_SESSION['admin_dob'] = $row['dob'];
                $_SESSION['admin_gender'] = $row['gender'];
                $_SESSION['admin_photo'] = $row['photo'];
                $_SESSION['admin_created'] = $row['email'];
                $_SESSION['admin_usertype'] = $row['usertype'];
                header('location: adminDashboard.php');
                exit();
            } else if ($row['usertype'] == 'user') {
                $username = $row['username'];

                // ✅ Check if the user needs to change their password
                if ($row['change_password'] == 1) {
                    $_SESSION['reset_user'] = $username;  // ✅ Set session to trigger change password modal
                }

                // Check if this specific user is already logged in
                $check_user = "SELECT * FROM team_users WHERE username = '$username' AND is_logged_in = 1";
                $user_result = mysqli_query($conn, $check_user);

                if (mysqli_num_rows($user_result) > 0) {
                    echo '<script>alert("This account is already logged in on another device. Please log out first."); window.location.href="index.php";</script>';
                    exit();
                }

                // Mark the current user as logged in
                $update_status = "UPDATE team_users SET is_logged_in = 1 WHERE username = '$username'";
                mysqli_query($conn, $update_status);

                // Store user session data
                $_SESSION['user_id'] = $row['id']; // Store user ID for reference
                $_SESSION['user_team_username'] = $row['username'];
                $_SESSION['user_first_name'] = $row['first_name'];
                $_SESSION['user_middle_name'] = $row['middle_name'];
                $_SESSION['user_surname'] = $row['surname'];
                $_SESSION['user_dob'] = $row['dob'];
                $_SESSION['user_gender'] = $row['gender'];
                $_SESSION['user_photo'] = $row['photo'];
                $_SESSION['user_created'] = $row['email'];
                $_SESSION['user_usertype'] = $row['usertype'];

                header('location: userDashboard.php');
                exit();
            }
        } else {
            // Password is incorrect
            echo '<script>alert("Password is incorrect. Try again."); window.location.href="index.php";
            </script>';
        }
    } else {
        // Username is incorrect
        echo '<script>alert("Username is incorrect. Try again."); window.location.href="index.php";
            </script>';
    }
}

/*include "config.php";
session_start();

if (isset($_POST['btn-submit'])) {
    $team_username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['userPass'];

    // Fetch user only by username
    $select = "SELECT * FROM team_users WHERE username = '$team_username'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        // Verify password (Use password_verify if passwords are hashed)
        if (password_verify($password, $row['password'])) {
            if ($row['usertype'] == 'admin') {

                // Check if an admin is already logged in
                $check_admin = "SELECT * FROM team_users WHERE usertype = 'admin' AND is_logged_in = 1";
                $admin_result = mysqli_query($conn, $check_admin);

                if (mysqli_num_rows($admin_result) > 0) {
                    echo '<script>alert("An admin is already logged in. Only one admin can be online at a time."); window.location.href="index.php";</script>';
                    exit();
                }

                // Mark admin as logged in
                $update_status = "UPDATE team_users SET is_logged_in = 1 WHERE username = '$team_username'";
                mysqli_query($conn, $update_status);

                // ✅ Store session data for admin
                $_SESSION['team_id'] = $row['team_id'];
                $_SESSION['admin_team_username'] = $row['username'];
                $_SESSION['admin_first_name'] = $row['first_name'];
                $_SESSION['admin_middle_name'] = $row['middle_name'];
                $_SESSION['admin_surname'] = $row['surname'];
                $_SESSION['admin_dob'] = $row['dob'];
                $_SESSION['admin_gender'] = $row['gender'];
                $_SESSION['admin_photo'] = $row['photo'];
                $_SESSION['admin_created'] = $row['email'];
                $_SESSION['admin_usertype'] = $row['usertype'];

                header('location: adminDashboard.php');
                exit();
            } else if ($row['usertype'] == 'user') {
                $username = $row['username'];

                // Check if this specific user is already logged in
                $check_user = "SELECT * FROM team_users WHERE username = '$username' AND is_logged_in = 1";
                $user_result = mysqli_query($conn, $check_user);

                if (mysqli_num_rows($user_result) > 0) {
                    echo '<script>alert("This account is already logged in on another device. Please log out first."); window.location.href="index.php";</script>';
                    exit();
                }

                // Mark the current user as logged in
                $update_status = "UPDATE team_users SET is_logged_in = 1 WHERE username = '$username'";
                mysqli_query($conn, $update_status);

                // ✅ Store user session data
                $_SESSION['team_id'] = $row['team_id'];
                $_SESSION['user_team_username'] = $row['username'];
                $_SESSION['user_first_name'] = $row['first_name'];
                $_SESSION['user_middle_name'] = $row['middle_name'];
                $_SESSION['user_surname'] = $row['surname'];
                $_SESSION['user_dob'] = $row['dob'];
                $_SESSION['user_gender'] = $row['gender'];
                $_SESSION['user_photo'] = $row['photo'];
                $_SESSION['user_created'] = $row['email'];
                $_SESSION['user_usertype'] = $row['usertype'];

                // ✅ Check if the user needs to change their password
                if ($row['change_password'] == 1) {
                    $_SESSION['reset_user'] = $username;  // ✅ Set session to trigger change password modal
                }

                header('location: userDashboard.php');
                exit();
            }
        } else {
            // Password is incorrect
            echo '<script>alert("Password is incorrect. Try again.")</script>';
        }
    } else {
        // Username is incorrect
        $_SESSION['error'] = "Incorrect Username. Please try again.";
        header("location: index.php");
        exit();
    }
}*/



/*include "config.php";
session_start();

if (isset($_POST['btn-submit'])) {
    $team_username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['userPass'];

    // Fetch user only by username
    $select = "SELECT * FROM team_users WHERE username = '$team_username'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        // Verify password (Use password_verify if passwords are hashed)
        if (password_verify($password, $row['password'])) {
            if ($row['usertype'] == 'admin') {

                // Check if an admin is already logged in
                $check_admin = "SELECT * FROM team_users WHERE usertype = 'admin' AND is_logged_in = 1";
                $admin_result = mysqli_query($conn, $check_admin);

                if (mysqli_num_rows($admin_result) > 0) {
                    echo '<script>alert("An admin is already logged in. Only one admin can be online at a time."); window.location.href="index.php";</script>';
                    exit();
                }

                // Mark admin as logged in
                $update_status = "UPDATE team_users SET is_logged_in = 1 WHERE username = '$team_username'";
                mysqli_query($conn, $update_status);
                $_SESSION['admin_team_username'] = $row['username'];
                $_SESSION['admin_first_name'] = $row['first_name'];
                $_SESSION['admin_middle_name'] = $row['middle_name'];
                $_SESSION['admin_surname'] = $row['surname'];
                $_SESSION['admin_dob'] = $row['dob'];
                $_SESSION['admin_gender'] = $row['gender'];
                $_SESSION['admin_photo'] = $row['photo'];
                $_SESSION['admin_created'] = $row['email'];
                $_SESSION['admin_usertype'] = $row['usertype'];
                header('location: adminDashboard.php');
                exit();
            } else if ($row['usertype'] == 'user') {
                $username = $row['username'];

                // ✅ Check if the user needs to change their password
                if ($row['change_password'] == 1) {
                    $_SESSION['reset_user'] = $username;  // ✅ Set session to trigger change password modal
                }

                // Check if this specific user is already logged in
                $check_user = "SELECT * FROM team_users WHERE username = '$username' AND is_logged_in = 1";
                $user_result = mysqli_query($conn, $check_user);

                if (mysqli_num_rows($user_result) > 0) {
                    echo '<script>alert("This account is already logged in on another device. Please log out first."); window.location.href="index.php";</script>';
                    exit();
                }

                // Mark the current user as logged in
                $update_status = "UPDATE team_users SET is_logged_in = 1 WHERE username = '$username'";
                mysqli_query($conn, $update_status);

                // Store user session data
                $_SESSION['user_id'] = $row['id']; // Store user ID for reference
                $_SESSION['user_team_username'] = $row['username'];
                $_SESSION['user_first_name'] = $row['first_name'];
                $_SESSION['user_middle_name'] = $row['middle_name'];
                $_SESSION['user_surname'] = $row['surname'];
                $_SESSION['user_dob'] = $row['dob'];
                $_SESSION['user_gender'] = $row['gender'];
                $_SESSION['user_photo'] = $row['photo'];
                $_SESSION['user_created'] = $row['email'];
                $_SESSION['user_usertype'] = $row['usertype'];

                header('location: userDashboard.php');
                exit();
            }
        } else {
            // Password is incorrect
            echo '<script>alert("Password is incorrect. Try again."); window.location.href="index.php";
            </script>';
        }
    } else {
        // Username is incorrect
        echo '<script>alert("Username is incorrect. Try again."); window.location.href="index.php";
            </script>';
    }
}*/
