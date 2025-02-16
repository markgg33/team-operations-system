<!-- Update Ticket Modal -->
<div class="modal fade" id="updateTicketModal" tabindex="-1" aria-labelledby="updateTicketLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateTicketForm">
                <div class="modal-body">
                    <div class="alert alert-info" id="updateAlert" style="display: none;"></div> <!-- Alert here -->

                    <input type="hidden" id="updateTicketId" name="ticket_id">

                    <div class="mb-3">
                        <label for="updateTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="updateTitle" name="ticket_title" required>
                    </div>

                    <div class="mb-3">
                        <label for="updateAssignedTo" class="form-label">Assigned To</label>
                        <select class="form-control" id="updateAssignedTo" name="assigned_to" required>
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

                    <div class="mb-3">
                        <label for="updateStatus" class="form-label">Status</label>
                        <select class="form-select" id="updateStatus" name="ticket_status" required>
                            <option value="ON HOLD">ON HOLD</option>
                            <option value="IN PROGRESS">IN PROGRESS</option>
                            <option value="DONE">DONE</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>