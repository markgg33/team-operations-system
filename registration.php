<?php

include "config.php";

// CHANGE VARIABLES INTO LOGIN_USERS TABLE 
// username, password, email, user_lvl, timestamp

if (isset($_POST['btn-register'])) {
    // Sanitize and validate input data
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']); // username = FK to login_users
    $email = mysqli_real_escape_string($conn, $_POST['email']); // email = FK to login_users
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $pass = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $usertype = $_POST['usertype'];

    // Check password length
    if (strlen($pass) <= 7) {
        echo "<script>alert('⚠️ Password must be at least 7 characters long.'); window.history.back();</script>";
        exit();
    }

    // Hash password for security
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

    // Flag new users to change their password on first login
    $change_password = 1; // 1 means they must change password


    // Validate if password and confirm password match
    if ($pass !== $confirm_password) {
        echo '<script>alert("Password and confirm password do not match.");</script>';
        exit; // or handle the error in another way
    }

    // Check if username or email already exists in the database
    $checkQuery = "SELECT * FROM team_users WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        echo '<script>alert("Username or Email already exists. Please use a different one.");</script>';
        echo '<script>
        setTimeout(function() {
            window.location.href = "adminDashboard.php";
        }, 1000); // 2000 milliseconds (2 seconds)
      </script>';
        exit; // Stop further processing
    }

    // Check if a file has been uploaded
    if (isset($_FILES['photo'])) {
        // File upload path
        $targetDir = "uploads/";
        $photoName = basename($_FILES["photo"]["name"]);
        $targetFilePath = $targetDir . $photoName;

        // Move the uploaded file to the specified location
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
            // Insert the file path into the database
            $insert = "INSERT INTO team_users(username, email, first_name, middle_name, surname, gender, dob, password, usertype, photo) 
                VALUES ('$username', '$email', '$first_name', '$middle_name', '$surname', '$gender', '$dob', '$hashedPassword', '$usertype', '$targetFilePath')";

            // Execute the query
            if (mysqli_query($conn, $insert)) {
                // Show success message with JavaScript
                echo '<script>alert("Account created successfully!");</script>';
                echo '<script>
                        setTimeout(function() {
                            window.location.href = "adminDashboard.php";
                        }, 1000); // 5000 milliseconds (5 seconds)
                      </script>';
            }
        } else {
            // Error handling if file upload fails
            echo '<script>alert("Sorry, there was an error uploading your file.")
            </script>';

            echo '<script>
                        setTimeout(function() {
                            window.location.href = "adminDashboard.php";
                        }, 1000); // 1000 milliseconds (2 seconds)
                      </script>';
        }
    } else {
        // Error handling if no file is uploaded
        echo '<script>alert("No file uploaded.");</script>';
    }
}


//($row['password'] == $password) && password = '$password';