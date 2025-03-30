<?php
include "config.php";
include "functions.php";

session_start();

/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/



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

//FETCH TICKETS ASSIGNED
$tickets = getUserTickets($team_username);

// Fetch videos from the database
$query = "SELECT * FROM upload_session ORDER BY session_id DESC";
$result = mysqli_query($conn, $query);

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
    <script src="fetchTables.js"></script>

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
                                <h2><strong>${announcement.announce_title}</strong></h2>
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

    <script>
        window.addEventListener("beforeunload", function() {
            navigator.sendBeacon("userlogoutAjax.php");
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
                <li class="sidebar-list-item" data-page="session" onclick="changePage('link-launchers')">
                    <i class="fa-solid fa-video"></i> LINK LAUNCHERS
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
                <div class="container-lg  announcement-container" id="announcements-container">
                    <p>Loading announcements...</p>
                </div>
            </div>

            <!---END OF DASHBOARD--->

            <!---Link Launchers Page--->

            <div id="link-launchers-page" class="page-content">
                <div class="main-title">
                    <h1>LINK LAUNCHERS</h1>
                </div>

                <div class="container-fluid link-container">
                    <div class="main-buttons">

                        <a href="https://jet-p-001.sitecorecontenthub.cloud/en-us/Account?ReturnUrl=%2Fen-us" class="btn-cards" target="_blank">
                            <div class="btn-cards-inner">

                                <br>
                                <p>JETSTAR ACCOUNT SIGN-IN</p>
                            </div>
                        </a>
                        <a href="https://jetstarairways-my.sharepoint.com/:x:/r/personal/justin_black_jetstar_com/_layouts/15/doc2.aspx?sourcedoc=%7BD31F2C8A-2F46-46B0-B7DF-C0A522AB3BD6%7D&file=Content%20Hub%20Help%20Migration%20CIM%20-%20Monstars.xlsx&fromShare=true&action=default&mobileredirect=true&wdOrigin=TEAMS-MAGLEV.p2p_ns.rwc&wdExp=TEAMS-TREATMENT&wdhostclicktime=1721275896240&web=1
" class="btn-cards" target="_blank">
                            <div class="btn-cards-inner">
                                <br>
                                <p>CH MIGRATION HELP SHARED FILE</p>
                            </div>
                        </a>

                        <a href="https://jetstarairways.sharepoint.com/:x:/r/sites/DigitalContent-allteam/_layouts/15/doc2.aspx?sourcedoc=%7BA5BBF8FF-9674-4DBA-ABE7-86FAA9281EDA%7D&file=Permanent%20page%20build%20tracker.xlsx&wdOrigin=TEAMS-MAGLEV.p2p_ns.rwc&action=default&mobileredirect=true" class="btn-cards" target="_blank">
                            <div class="btn-cards-inner">
                                <br>
                                <p>PERMANENT PAGE</p>
                            </div>
                        </a>

                        <a href="https://docs.google.com/spreadsheets/d/13SzCoBkmCyStxu7JAoR02O1fBdG9GSUC/edit?gid=367423830#gid=367423830" class="btn-cards" target="_blank">
                            <div class="btn-cards-inner">
                                <br>
                                <p>WORK TRACKER</p>
                            </div>
                        </a>

                        <a href="https://docs.google.com/forms/d/e/1FAIpQLScZXCWDRhdgBiJrYmIoNUYUZY81SbVAaq0N8wfLAvvIJ6rROw/viewform?c=0&w=1" class="btn-cards" target="_blank">
                            <div class="btn-cards-inner">
                                <br>
                                <p>VL and SL FORMS</p>
                            </div>
                        </a>

                    </div>
                </div>
            </div>

            <!-- End of Link of Launchers Page -->

            <!---Tickets Page--->
            <div id="tickets-page" class="page-content">
                <div class="main-title">
                    <h1>ASSIGNED TICKETS</h1>
                </div>

                <div class="row">
                    <?php if (!empty($tickets)): ?>
                        <?php foreach ($tickets as $ticket): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow d-flex flex-column justify-content-between">
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="text-muted">Ticket Number:
                                            <strong><?php echo htmlspecialchars($ticket['ticket_number']); ?></strong>
                                        </h6>
                                        <h5 class="card-title text-uppercase fw-bold">
                                            <?php echo htmlspecialchars($ticket['ticket_title']); ?>
                                        </h5>
                                        <hr>

                                        <?php
                                        $max_length = 100; // Limit before truncation
                                        $desc = htmlspecialchars($ticket['ticket_desc']); // Ensure safety
                                        $short_desc = (strlen($desc) > $max_length) ? substr($desc, 0, $max_length) . '...' : $desc;
                                        ?>

                                        <div class="letter-format flex-grow-1">
                                            <p class="ticket-description d-flex flex-column">
                                                <span class="short-text"><?php echo nl2br($short_desc); ?></span>
                                                <span class="full-text d-none"><?php echo nl2br($desc); ?></span>
                                                <br>
                                                <span class="read-more-container">
                                                    <?php if (strlen($desc) > $max_length): ?>
                                                        <button class="read-more-btn btn btn-sm mt-2" style="border: none; padding: 10px; background-color: #242424; color: white; text-decoration: none;" data-id="<?php echo $ticket['ticket_id']; ?>">
                                                            Read More
                                                        </button>
                                                    <?php endif; ?>
                                                </span>
                                            </p>
                                        </div>



                                        <!---div class="letter-format flex-grow-1">
                                            <p><!?php echo nl2br(htmlspecialchars($ticket['ticket_desc'])); ?></p>
                                        </div--->

                                        <hr>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge 
                                    <?php
                                    $status = strtoupper($ticket['ticket_status']); // Normalize status

                                    if ($status == "IN PROGRESS") {
                                        echo "bg-primary";
                                    } elseif ($status == "ON HOLD") {
                                        echo "bg-warning";
                                    } elseif ($status == "DONE") {
                                        echo "bg-success";
                                    } elseif ($status == "OPEN") {
                                        echo "bg-danger";
                                    } elseif ($status == "FOR REVIEW") {
                                        echo "bg-info";
                                    } else {
                                        echo "bg-secondary";
                                    }
                                    ?>">
                                                <?php echo htmlspecialchars($ticket['ticket_status']); ?>
                                            </span>

                                            <small class="text-muted">Assigned:
                                                <?php echo timeAgo($ticket['created_at']); ?>
                                            </small>
                                        </div>

                                        <!-- ✅ Priority Level Badge -->
                                        <div class="mt-2">
                                            <span class="badge 
                                    <?php
                                    $priority = $ticket['priority'];
                                    if ($priority == 1) {
                                        echo "bg-danger"; // 🔴 Critical
                                    } elseif ($priority == 2) {
                                        echo "bg-warning"; // 🟡 Medium
                                    } else {
                                        echo "bg-primary"; // 🔵 Low
                                    }
                                    ?>">
                                                <?php
                                                echo ($priority == 1) ? "Critical" : (($priority == 2) ? "Medium" : "Low");
                                                ?>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- ✅ Edit Button (User Can Update Status) -->
                                    <div class="card-footer text-center">
                                        <button class="editUserTicketBtn w-100"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editUserTicketModal"
                                            data-id="<?php echo htmlspecialchars($ticket['ticket_id']); ?>"
                                            data-desc="<?php echo htmlspecialchars($ticket['ticket_desc']); ?>"
                                            data-status="<?php echo htmlspecialchars($ticket['ticket_status']); ?>">
                                            <i class="fa-solid fa-pen"></i> Edit Ticket
                                        </button>

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

                <!-- ✅ Include the Update Ticket Status Modal -->
                <?php include "modals/update_user_ticket_modal.php"; ?>
            </div>


            <!---end of ticket page--->

            <!---START OF SESSION PAGE--->

            <div id="session-page" class="page-content">
                <div class="main-title">
                    <h1>SESSIONS</h1>
                </div>

                <div class="row">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <div class="col-md-4 mb-4">
                            <div class="video-card h-100 d-flex flex-column">
                                <video class="flex-grow-1" controls>
                                    <source src="uploads/videos/<?php echo htmlspecialchars($row['session_vid']); ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                <div class="video-info p-3 text-center">
                                    <h5><strong><?php echo htmlspecialchars($row['session_title']); ?></strong></h5>
                                    <p><?php echo htmlspecialchars($row['session_desc']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>


            <!---END OF SESSION PAGE--->

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

            <?php include "modals/change_password_modal.php"; ?>

        </main>
    </div>

    <script src="sidebar.js"></script>
    <script src="generateLinks.js"> </script>
    <script src="fetchTables.js"></script>

    <script>
        $(document).ready(function() {
            // Check if user needs to change password
            $.ajax({
                url: "check_password_status.php", // A new PHP script to check the password status
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.change_password == 1) {
                        $("#changePasswordModal").modal("show"); // Show the modal if required
                    }
                },
                error: function() {
                    console.error("Error checking password status.");
                }
            });
        });

        $(document).on("click", ".read-more-btn", function() {
            let parent = $(this).closest(".ticket-description");
            let shortText = parent.find(".short-text");
            let fullText = parent.find(".full-text");

            if (fullText.hasClass("d-none")) {
                fullText.removeClass("d-none");
                shortText.addClass("d-none");
                $(this).text("Read Less");
            } else {
                fullText.addClass("d-none");
                shortText.removeClass("d-none");
                $(this).text("Read More");
            }
        });
    </script>


</body>

</html>