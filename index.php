<?php

include "login.php";


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Operations System</title>
    <script src="https://kit.fontawesome.com/92cde7fc6f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/index.css" />
</head>

<body>
    <div class="container-fluid main-container">
        <div class="row">
            <div class="col form-container">
                <form action="#" method="POST">
                    <div class="image-box">
                        <img src="images/undraw_logo.png" alt="IT Logo" />
                        <br>
                        <strong>TEAM OPERATIONS SYSTEM</strong>
                    </div>
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" placeholder="WEB-YEAR-NUMBER"/>
                        <div id="emailHelp" class="form-text">
                            We'll never share information with anyone else.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="userPass" class="form-label">Password</label>
                        <input type="password" class="form-control" name="userPass" required />
                    </div>
                    <br>
                    <div class="btn-center">
                        <button type="submit" name="btn-submit" class="btn-submit"><strong>Submit</strong></button>
                    </div>
                </form>
                <p class="credits">All rights reserved &copy 2025</p>
            </div>
        </div>
    </div>
</body>

</html>