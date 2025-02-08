<?php
include "config.php";
include "functions.php";

session_start();

if (isset($_SESSION["user_team_username"])) {
    $team_username = $_SESSION['user_team_username'];

    // Set the user as online
    $query = "UPDATE team_users SET is_online = 1 WHERE username = '$team_username'";
    mysqli_query($conn, $query);
} else {
    echo '<script>
        alert("Unauthorized access of System. Redirecting to Login Page.");
        window.location.href = "index.php";
    </script>';
    exit();
}

$tickets = getUserTickets($team_username);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://kit.fontawesome.com/92cde7fc6f.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css" />
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/userDashboard.css" />

    <script>
        $(document).ready(function() {
            function loadAnnouncements() {
                $.ajax({
                    url: "fetch_announcements.php", // Fetch from new PHP file
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        let announcementsHtml = "";
                        if (data.length > 0) {
                            data.forEach(function(announcement) {
                                announcementsHtml += `
                            <div class="announcement">
                                <hr>
                                <h3><strong>${announcement.announce_title}</strong></h3>
                                <p>${announcement.announce_desc.replace(/\n/g, "<br>")}</p>
                                <small class="text-muted">
                                    Posted on: ${new Date(announcement.date_posted).toLocaleString()}
                                </small>
                                <hr>
                            </div>
                        `;
                            });
                        } else {
                            announcementsHtml = "<p>No announcements available.</p>";
                        }
                        $("#announcements-container").html(announcementsHtml);
                    },
                    error: function() {
                        $("#announcements-container").html("<p class='text-danger'>Failed to load announcements.</p>");
                    }
                });
            }

            loadAnnouncements(); // Load initially
            setInterval(loadAnnouncements, 10000); // Refresh every 10 seconds
        });
    </script>

</head>

<body>
    <div class="grid-container">

        <!-----HEADER------>

        <header class="header">
            <div class="info-title">
                Team Operations System: User
            </div>
            <div class="btn-group">
                <div class="info-title">
                    Welcome, <?php echo $_SESSION['user_first_name'] ?>
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
                <li class="sidebar-list-item" data-page="tickets" onclick="changePage('tickets')">
                    <i class="fa-solid fa-ticket"></i> TICKETS
                </li>
                <li class="sidebar-list-item" data-page="link-generator" onclick="changePage('link-generator')">
                    <i class="fa-solid fa-link"></i> LINK GENERATOR
                </li>
                <li class="sidebar-list-item" data-page="session" onclick="changePage('session')">
                    <i class="fa-solid fa-video"></i> SESSIONS
                </li>
            </ul>
        </aside>

        <!-----END OF SIDEBAR------>



        <main class="main-container">

            <!---START OF DASHBOARD--->

            <div id="dashboard-page" class="page-content">
                <div class="main-title">
                    <h1>DASHBOARD</h1>
                </div>
                <div class="container-lg my-3" id="announcements-container">
                    <p>Loading announcements...</p>
                </div>
            </div>

            <!---END OF DASHBOARD--->

            <!---Tickets Page--->

            <div id="tickets-page" class="page-content">
                <div class="main-title">
                    <h1>ASSIGNED TICKETS</h1>
                </div>

                <div class="main-cards">
                    <?php if (!empty($tickets)): ?>
                        <?php foreach ($tickets as $ticket): ?>
                            <div class="card p-4 shadow">
                                <div class="card-body">
                                    <h5 class="card-title text-uppercase fw-bold"><?php echo htmlspecialchars($ticket['ticket_title']); ?></h5>
                                    <hr>

                                    <!-- Display ticket as a formal letter -->
                                    <div class="letter-format">
                                        <p><?php echo nl2br(htmlspecialchars($ticket['ticket_desc'])); ?></p>
                                    </div>

                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge badge-status 
                            <?php
                            echo ($ticket['ticket_status'] == 'Done') ? 'bg-success' : (($ticket['ticket_status'] == 'On Hold') ? 'bg-warning' : 'bg-primary');
                            ?>">
                                            <?php echo htmlspecialchars($ticket['ticket_status']); ?>
                                        </span>
                                        <small class="text-muted">Assigned: <?php echo timeAgo($ticket['created_at']); ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-info text-center mt-4">
                            No tickets assigned to you.
                        </div>
                    <?php endif; ?>
                </div>
            </div>


            <!-- End of Tickets Page -->
        </main>
    </div>

    <script src="sidebar.js"></script>
</body>

</html>