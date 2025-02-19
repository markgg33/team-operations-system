<?php

include "config.php";

?>

<!-- Modal -->
<div class="modal fade" id="assignTicketModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">CREATE TICKET</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid upload-container">
                    <form action="assign.php" class="form-upload" method="POST" enctype="multipart/form-data">

                        <!-- Ticket Title -->
                        <div class="col">
                            <div class="input-group">
                                <span class="input-group-text">Ticket Title:</span>
                                <input type="text" class="form-control" name="ticket_title"
                                    placeholder="E.g: Fix Login Issue" autofocus required
                                    oninput="this.value = this.value.toUpperCase();">
                            </div>
                        </div>
                        <br>

                        <!-- Ticket Description -->
                        <div class="textarea-section">
                            <label>Description:</label>
                            <textarea class="form-control textarea-form"
                                placeholder="Enter ticket description"
                                name="ticket_desc" required></textarea>
                        </div>
                        <br>

                        <!-- Ticket Priority -->
                        <div class="col">
                            <label for="priority">Priority Level:</label>
                            <select id="priority" name="priority" class="form-select" required>
                                <option value="1">1 - Critical</option>
                                <option value="2">2 - Medium Priority</option>
                                <option value="3">3 - Low Priority</option>
                            </select>
                        </div>
                        <br>

                        <!-- Ticket Status -->
                        <div class="col">
                            <label for="status">Ticket Status:</label>
                            <select id="status" name="ticket_status" class="form-select">
                                <option value="OPEN">Open</option>
                                <option value="IN PROGRESS">In progress</option>
                                <option value="ON HOLD">On hold</option>
                                <option value="FOR REVIEW">For review</option>
                                <option value="DONE">Done</option>
                            </select>
                        </div>
                        <br>

                        <!-- Assign To Dropdown -->
                        <div class="col">
                            <label for="assigned_user">Assign To:</label>
                            <select class="form-control" id="assigned_user" name="assigned_user" required>
                                <option value="">Select a user</option>
                                <?php
                                $query = "SELECT team_id, first_name, surname FROM team_users WHERE usertype != 'admin'";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['team_id'] . "'>" . $row['first_name'] . " " . $row['surname'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <br>

                        <!-- Manually Enter Recipient's Name
                        <div class="col">
                            <div class="input-group">
                                <span class="input-group-text">Recipient's Name:</span>
                                <input type="text" class="form-control" name="recipient_name" 
                                       placeholder="Enter recipient's full name" required>
                            </div>
                        </div>
                        <br>

                        
                        <div class="col">
                            <div class="input-group">
                                <span class="input-group-text">Your Name (Admin):</span>
                                <input type="text" class="form-control" name="admin_name" 
                                       placeholder="Enter your full name" required>
                            </div>
                        </div>
                        <br--->

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn-temp-close" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn-temp" name="assign">CREATE TICKET</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>