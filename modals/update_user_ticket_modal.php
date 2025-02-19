<!-- Edit Ticket Status Modal -->
<div class="modal fade" id="editUserTicketModal" tabindex="-1" aria-labelledby="editUserTicketLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Ticket Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateUserTicketForm">
                <div class="modal-body">
                    <input type="hidden" id="userTicketId" name="ticket_id">

                    <div class="alert alert-info" id="updateAlert" style="display: none;"></div> <!-- Alert here -->

                    <div class="mb-3">
                        <label for="userTicketStatus" class="form-label">Update Status</label>
                        <select class="form-select" id="userTicketStatus" name="ticket_status" required>
                            <option value="OPEN">Open</option>
                            <option value="IN PROGRESS">In progress</option>
                            <option value="ON HOLD">On hold</option>
                            <option value="FOR REVIEW">For review</option>
                            <option value="DONE">Done</option>
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