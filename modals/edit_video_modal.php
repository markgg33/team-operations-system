<!-- Edit Video Modal -->
<div class="modal fade" id="editVideoModal" tabindex="-1" aria-labelledby="editVideoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Video Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateVideoForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- ✅ Alert for Video Update -->
                    <div class="alert text-center" id="updateVideoAlert" style="display: none;"></div>

                    <input type="hidden" id="editVideoId" name="session_id">

                    <div class="mb-3">
                        <label for="editVideoTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="editVideoTitle" name="session_title" required>
                    </div>

                    <div class="mb-3">
                        <label for="editVideoDesc" class="form-label">Description</label>
                        <textarea class="form-control" id="editVideoDesc" name="session_desc" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="editVideoFile" class="form-label">Upload New Video (Optional)</label>
                        <input type="file" class="form-control" id="editVideoFile" name="session_vid">
                        <small class="text-muted">Leave blank to keep the current video.</small>
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
