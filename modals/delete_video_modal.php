<!-- Delete Video Modal -->
<div class="modal fade" id="deleteVideoModal" tabindex="-1" aria-labelledby="deleteVideoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- ✅ Alert for delete session (Inside Modal) -->
                <div class="alert alert-success text-center" id="deleteVideoAlert" style="display: none;"></div> 
                <p>Are you sure you want to delete this video?</p>
                <input type="hidden" id="deleteVideoId" name="session_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteVideo">Delete</button>
            </div>
        </div>
    </div>
</div>
