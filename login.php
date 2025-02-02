<?php

include "config.php";

session_start();

//reference submit
if (isset($_POST['btn-submit'])) {

    $team_username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['userPass'];

    $select = "SELECT * FROM team_users WHERE username = '$team_username' && password = '$password' ";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_array($result);
        if ($row['password'] == $password) {
            if ($row['usertype'] == 'admin') {
                $_SESSION['admin_team_username'] = $row['username'];
                $_SESSION['admin_first_name'] = $row['first_name'];
                $_SESSION['admin_middle_name'] = $row['middle_name'];
                $_SESSION['admin_surname'] = $row['surname'];
                $_SESSION['admin_dob'] = $row['dob'];
                $_SESSION['admin_gender'] = $row['gender'];
                $_SESSION['admin_photo'] = $row['photo'];
                $_SESSION['admin_created'] = $row['email'];
                $_SESSION['admin_usertype'] = $row['usertype'];
                $_SESSION['admin_photo'] = $row['photo'];
                header('location: adminDashboard.php');
            } else if ($row['usertype'] == 'user') {
                $_SESSION['user_team_username'] = $row['username'];
                $_SESSION['user_first_name'] = $row['first_name'];
                $_SESSION['user_middle_name'] = $row['middle_name'];
                $_SESSION['user_surname'] = $row['surname'];
                $_SESSION['user_dob'] = $row['dob'];
                $_SESSION['user_gender'] = $row['gender'];
                $_SESSION['user_photo'] = $row['photo'];
                $_SESSION['user_created'] = $row['email'];
                $_SESSION['user_usertype'] = $row['usertype'];
                $_SESSION['user_photo'] = $row['photo'];
                header('location: userDashboard.php');
            } else {
                // Password is incorrect, display error message
                $error = "Incorrect Password. Please try again.";
                echo "<script>alert('$error');</script>";
            }
        } else {
            // Username is incorrect, display error message
            $error = "Incorrect Username. Please try again.";
            echo "<script>alert('$error');</script>";
        }
    }
}

?>