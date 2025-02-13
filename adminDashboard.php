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

// Fetch announcements right after including functions.php
$announcements = getAnnouncements();


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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="fetchTables.js"></script>
    <script>
        function updateUsersOnline() {
            $.ajax({
                url: "fetch_users_online.php",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $("#usersOnlineCount").text(data.users_online);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching online users:", error);
                }
            });
        }

        // Update every 5 seconds
        setInterval(updateUsersOnline, 5000);

        // Initial call
        updateUsersOnline();
    </script>

    <script>
        window.addEventListener("beforeunload", function() {
            navigator.sendBeacon("logoutAjax.php");
        });
    </script>

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
                    <li><a class="dropdown-item" href="adminLogout.php">Logout</a></li>
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
                <li class="sidebar-list-item" data-page="link-launchers" onclick="changePage('link-launchers')">
                    <i class="fa-solid fa-link"></i> LINK LAUNCHERS
                </li>
                <li class="sidebar-list-item" data-page="link-generator" onclick="changePage('link-generator')">
                    <i class="fa-solid fa-link"></i> LINK GENERATOR
                </li>
                <li class="sidebar-list-item" data-page="crud-operations" onclick="changePage('crud-operations')">
                    <i class="fa-regular fa-id-card"></i> CRUD OPERATIONS
                </li>
                <li class="sidebar-list-item" data-page="master-tables" onclick="changePage('master-tables')">
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
                        <!--AJAX FUNCTION FOR FETCHING ONLINE USERS-->
                        <h2 id="usersOnlineCount">Loading...</h2> <!--CHANGE VALUE ACCORDING TO CODE THAT IDENTIFIES USERS ONLINE-->
                    </div>

                    <div class="card">
                        <div class="card-inner">
                            <i class="fa-solid fa-folder"></i>
                            <p>GSDs ACTIVE</p>
                        </div>
                        <h2><?php echo getActiveGSDs(); ?></h2> <!--CHANGE VALUE ACCORDING TO CODE THAT IDENTIFIES USERS ONLINE-->
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

                        <?php

                        include "ticket_list_status.php";

                        ?>

                        <ul class="list-group">
                            <?php if (!empty($tickets)): ?>
                                <?php foreach ($tickets as $ticket): ?>
                                    <li class="list-group-item d-flex justify-content-center gsd-box">
                                        <span> <strong><?php echo htmlspecialchars($ticket['ticket_title']); ?></strong></span>
                                        <span class="badge bg-primary"><?php echo htmlspecialchars($ticket['assigned_to']); ?></span>
                                        <span class="badge bg-<?php echo getStatusColor($ticket['ticket_status']); ?>">
                                            <?php echo htmlspecialchars($ticket['ticket_status']); ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li class="list-group-item text-center">No tickets found.</li>
                            <?php endif; ?>
                        </ul>

                        <!-- Pagination Controls -->
                        <nav>
                            <ul class="pagination justify-content-center mt-3">
                                <?php if ($page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo ($page - 1); ?>">Previous</a>
                                    </li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>

                                <?php if ($page < $totalPages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo ($page + 1); ?>">Next</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
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


            <!---Link Generator Page--->

            <div id="link-generator-page" class="page-content">
                <div class="main-title">
                    <h1>LINK GENERATOR</h1>
                </div>

                <div class="container-fluid link-gen-container">

                    <div class="input-group input-group-sm link-input">
                        <input type="text" class="form-control" id="urlPath" placeholder="Enter URL path (e.g., help/articles/privacy-policy)" oninput="generateLinks()">
                    </div>

                    <div class="container-fluid link-gen-table">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>NEW PREVIEW</th>
                                </tr>
                            </thead>
                            <tbody id="newPreviewTable"></tbody>
                        </table>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>CD</th>
                                </tr>
                            </thead>
                            <tbody id="cdTable"></tbody>
                        </table>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>LIVE</th>
                                </tr>
                            </thead>
                            <tbody id="liveTable"></tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- End of Link Generator Page -->

            <!---CRUD Operations Page--->

            <div id="crud-operations-page" class="page-content">
                <div class="main-title">
                    <h1>CRUD OPERATIONS</h1>
                </div>

                <div class="container-fluid link-container">
                    <div class="main-modal-buttons">

                        <!-- Button trigger modal -->
                        <button type="button" class="btn-crud" data-bs-toggle="modal" data-bs-target="#addUsersModal">
                            <img src="svg/add_user.svg" alt="">
                            ADD USERS
                        </button>

                        <button type="button" class="btn-crud" data-bs-toggle="modal" data-bs-target="#uploadSessionModal">
                            <img src="svg/video_upload.svg" alt="">
                            UPLOAD SESSION
                        </button>

                        <button type="button" class="btn-crud" data-bs-toggle="modal" data-bs-target="#announcementModal">
                            <img src="svg/add_post.svg" alt="">
                            ADD ANNOUNCEMENTS
                        </button>

                        <button type="button" class="btn-crud" data-bs-toggle="modal" data-bs-target="#assignTicketModal">
                            <img src="svg/assign_tickets.svg" alt="">
                            ASSIGN TICKETS
                        </button>


                        <?php
                        /*ADD USERS MODAL */
                        include "modals/add_users.php";

                        /*UPLOAD SESSION MODAL */
                        include "modals/upload_session.php";

                        /*ADD ANNOUNCEMENT MODAL */
                        include "modals/announcements_modal.php";

                        /*ASSIGN TICKET MODAL */
                        include "modals/assign_ticket.php";
                        ?>

                    </div>
                </div>
            </div>

            <!-- End of CRUD Operations Page -->

            <!---Master Tables Page--->

            <div id="master-tables-page" class="page-content">
                <div class="main-title">
                    <h1>MASTER TABLES</h1>
                </div>

                <div class="container-fluid link-container">
                    <div class="container mt-4">
                        <h2 class="mb-3">📌 TICKETS MANAGEMENT</h2>
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Ticket #</th>
                                    <th>ID</th>
                                    <th>Title</th> 
                                    <th>Assigned To</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="ticketsTable"></tbody>
                        </table>

                        <h2 class="mt-5">👤 USER LIST</h2>
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Full Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Date of Birth</th>
                                    <th>User Type</th>
                                </tr>
                            </thead>
                            <tbody id="usersTable"></tbody>
                        </table>

                        <h2 class="mt-5">🎥 UPLOADED VIDEO SESSIONS</h2>
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Session ID</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody id="sessionsTable"></tbody>
                        </table>
                    </div>
                </div>

                <script src="fetchTables.js"></script>


        </main>
    </div>

    <!-- End of Master Tables Page -->

    <script src="sidebar.js"></script>
    <script src="generateLinks.js"> </script>


</body>

</html>