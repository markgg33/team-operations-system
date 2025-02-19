<!-- Delete Ticket Modal -->
<div class="modal fade" id="deleteTicketModal" tabindex="-1" aria-labelledby="deleteTicketLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" id="deleteAlert" style="display: none;"></div> <!-- Alert here -->

                Are you sure you want to delete this ticket?
                <input type="hidden" id="deleteTicketId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteTicket">Delete</button>
            </div>
        </div>
    </div>
</div>