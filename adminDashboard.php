<?php

include "config.php";
include "registration.php";
include "functions.php";

session_start();

if (isset($_SESSION["admin_team_username"])) {
    $team_username = $_SESSION['admin_team_username'];
} else {
    echo '<script>
        alert("Unauthorized access of System. Redirecting to Login Page.");
        window.location.href = "index.php"; // Redirect after showing alert
    </script>';
    exit(); // Stop execution
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://kit.fontawesome.com/92cde7fc6f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/adminDashboard.css" />
</head>

<body>

    <div class="grid-container">

        <!-----HEADER------>

        <header class="header">
            <div class="info-title">
                Team Operations System: Admin
            </div>
            <div class="btn-group">
                <div class="info-title">
                    Welcome, <?php echo $_SESSION['admin_team_username'] ?>
                </div>
                <button type="button" class="btn-dropdown dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"></button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </div>


        </header>

        <!-----END OF HEADER------>

        <!-----SIDEBAR------>

        <aside id="team-sidebar">

            <!-----php echo isset($_GET['page']) && $_GET['page'] === 'dashboard' ? 'active' : ''; ?>---->

            <ul class="sidebar-list">
                <li class="sidebar-list-item active" data-page="dashboard" onclick="changePage('dashboard')">
                    <i class="fa-solid fa-chart-line"></i>DASHBOARD
                </li>
                <li class="sidebar-list-item" data-page="students" onclick="changePage('link-launchers')">
                    <i class="fa-solid fa-link"></i> LINK LAUNCHERS
                </li>
                <li class="sidebar-list-item" data-page="students" onclick="changePage('link-generator')">
                    <i class="fa-solid fa-link"></i> LINK GENERATOR
                </li>
                <li class="sidebar-list-item" onclick="changePage('crud-operations')">
                    <i class="fa-regular fa-id-card"></i> CRUD OPERATIONS
                </li>
                <li class="sidebar-list-item" onclick="changePage('master-tables')">
                    <i class="fa-regular fa-id-card"></i> MASTER TABLES
                </li>
            </ul>
        </aside>

        <!-----END OF SIDEBAR------>



        <main class="main-container">
            <!-- Dashboard Page -->
            <div id="dashboard-page" class="page-content">

                <div class="main-title">
                    <h1>DASHBOARD</h1>
                </div>

                <div class="main-cards">

                    <div class="card">
                        <div class="card-inner">
                            <i class="fa-solid fa-user"></i>
                            <p>USERS ONLINE</p>
                        </div>
                        <h2>150</h2> <!--CHANGE VALUE ACCORDING TO CODE THAT IDENTIFIES USERS ONLINE-->
                    </div>

                    <div class="card">
                        <div class="card-inner">
                            <i class="fa-solid fa-folder"></i>
                            <p>GSDs ACTIVE</p>
                        </div>
                        <h2>10</h2> <!--CHANGE VALUE ACCORDING TO CODE THAT IDENTIFIES USERS ONLINE-->
                    </div>

                    <div class="card">
                        <div class="card-inner">
                            <i class="fa-solid fa-keyboard"></i>
                            <p>USERS REGISTERED</p>
                        </div>
                        <h2><?php echo getUserCount('team_users'); ?></h2> <!--CHANGE VALUE ACCORDING TO CODE THAT IDENTIFIES USERS ONLINE-->
                    </div>
                </div>

                <div class="charts">

                    <div class="charts-card">
                        <p class="chart-title">CALENDAR</p>
                        <!-- Calendar HTML Structure -->
                        <div class="calendar">
                            <div class="calendar-header">
                                <button id="prevMonthBtn" class="prev-month">❮</button>
                                <h3 id="monthYear" class="month-year"></h3>
                                <button id="nextMonthBtn" class="next-month">❯</button>
                            </div>
                            <div class="calendar-weekdays">
                                <div>SUN</div>
                                <div>MON</div>
                                <div>TUE</div>
                                <div>WED</div>
                                <div>THU</div>
                                <div>FRI</div>
                                <div>SAT</div>
                            </div>
                            <div id="calendarDays" class="calendar-days"></div>
                        </div>
                        <script src="dynamicCalendar.js"></script>
                    </div>

                    <div class="charts-card">
                        <p class="chart-title">GSDs STATUS</p>
                        <div id="area-chart"></div>
                    </div>
                </div>

            </div>

            <!-- End of Dashboard Page -->

            <!---Link Launchers Page--->

            <div id="link-launchers-page" class="page-content">
                <div class="main-title">
                    <h1>LINK LAUNCHERS</h1>
                </div>

                <div class="container-fluid link-container">
                    <div class="main-buttons">

                        <a href="https://jet-p-001.sitecorecontenthub.cloud/en-us/Account?ReturnUrl=%2Fen-us" class="btn-cards" target="_blank">
                            <div class="btn-cards-inner">
                                <img src="images/jetstarLogo.png" alt="Logo">
                                <br>
                                <p>JETSTAR ACCOUNT SIGN-IN</p>
                            </div>
                        </a>
                        <a href="https://jetstarairways-my.sharepoint.com/:x:/r/personal/justin_black_jetstar_com/_layouts/15/doc2.aspx?sourcedoc=%7BD31F2C8A-2F46-46B0-B7DF-C0A522AB3BD6%7D&file=Content%20Hub%20Help%20Migration%20CIM%20-%20Monstars.xlsx&fromShare=true&action=default&mobileredirect=true&wdOrigin=TEAMS-MAGLEV.p2p_ns.rwc&wdExp=TEAMS-TREATMENT&wdhostclicktime=1721275896240&web=1
" class="btn-cards" target="_blank">
                            <div class="btn-cards-inner">
                                <img src="images/cdpLogo.png" alt="Logo">
                                <br>
                                <p>CH MIGRATION HELP SHARED FILE</p>
                            </div>
                        </a>

                        <a href="https://jet-p-001.sitecorecontenthub.cloud/en-us/Account?ReturnUrl=%2Fen-us" class="btn-cards" target="_blank">
                            <div class="btn-cards-inner">
                                <img src="images/cdpLogo.png" alt="Logo">
                                <br>
                                <p>JETSTAR ACCOUNT SIGN-IN</p>
                            </div>
                        </a>

                        <a href="https://jet-p-001.sitecorecontenthub.cloud/en-us/Account?ReturnUrl=%2Fen-us" class="btn-cards" target="_blank">
                            <div class="btn-cards-inner">
                                <img src="images/cdpLogo.png" alt="Logo">
                                <br>
                                <p>VL and SL Google Forms</p>
                            </div>
                        </a>

                        <a href="https://jet-p-001.sitecorecontenthub.cloud/en-us/Account?ReturnUrl=%2Fen-us" class="btn-cards" target="_blank">
                            <div class="btn-cards-inner">
                                <img src="images/cdpLogo.png" alt="Logo">
                                <br>
                                <p>JETSTAR ACCOUNT SIGN-IN</p>
                            </div>
                        </a>

                    </div>
                </div>
            </div>

            <!-- End of Link of Launchers Page -->

            <!---CRUD Operations Page--->

            <div id="crud-operations-page" class="page-content">
                <div class="main-title">
                    <h1>CRUD OPERATIONS</h1>
                </div>

                <div class="container-fluid link-container">
                    <div class="main-buttons">

                        <!-- Button trigger modal -->
                        <button type="button" class="btn-crud" data-bs-toggle="modal" data-bs-target="#addUsersModal">
                            ADD USERS
                        </button>

                        <button type="button" class="btn-crud" data-bs-toggle="modal" data-bs-target="#uploadSessionModal">
                            UPLOAD SESSION
                        </button>

                        <?php
                        /*ADD USERS MODAL */
                        include "modals/add_users.php";

                        /*ADD ANNOUNCEMENT MODAL */
                        include "modals/upload_session.php";
                        ?>

                    </div>
                </div>
            </div>

            <!-- End of CRUD Operations Page -->

        </main>

    </div>

    <script src="sidebar.js"></script>

</body>

</html>