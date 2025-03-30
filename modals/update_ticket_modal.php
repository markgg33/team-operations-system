<!-- Update Ticket Modal -->
<div class="modal fade" id="updateTicketModal" tabindex="-1" aria-labelledby="updateTicketLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateTicketForm">
                <div class="modal-body">
                    <div class="alert alert-info" id="updateAlert" style="display: none;"></div> <!-- Alert here -->

                    <input type="hidden" id="updateTicketId" name="ticket_id">

                    <!-- ✅ Title (Disabled) -->
                    <div class="mb-3">
                        <label for="updateTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="updateTitle" name="ticket_title" disabled>
                    </div>

                    <!-- ✅ Description (Editable) -->
                    <div class="mb-3">
                        <label for="updateDesc" class="form-label">Description</label>
                        <textarea class="form-control" id="updateDesc" name="ticket_desc" rows="4" required></textarea>
                    </div>

                    <!-- ✅ Assigned User -->
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

                    <!-- ✅ Status -->
                    <div class="mb-3">
                        <label for="updateStatus" class="form-label">Status</label>
                        <select class="form-select" id="updateStatus" name="ticket_status" required>
                            <option value="OPEN">Open</option>
                            <option value="IN PROGRESS">In Progress</option>
                            <option value="ON HOLD">On Hold</option>
                            <option value="FOR REVIEW">For Review</option>
                            <option value="DONE">Done</option>
                        </select>
                    </div>

                    <!-- ✅ Priority -->
                    <div class="mb-3">
                        <label for="updatePriority" class="form-label">Priority Level</label>
                        <select class="form-select" id="updatePriority" name="priority" required>
                            <option value="1" class="text-danger">Critical</option>
                            <option value="2" class="text-warning">Medium</option>
                            <option value="3" class="text-primary">Low</option>
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