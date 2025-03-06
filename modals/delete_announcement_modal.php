<!-- 🗑️ Delete Announcement Modal -->
<div class="modal fade" id="deleteAnnouncementModal" tabindex="-1" aria-labelledby="deleteAnnouncementLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- Alert message will show here -->
                <div id="deleteAnnounceAlert" class="alert alert-success" style="display:none;"></div>

                Are you sure you want to delete this announcement?
                <input type="hidden" id="deleteAnnouncementId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteAnnouncement">Delete</button>
            </div>
        </div>
    </div>
</div>