<!-- Modal -->
<div class="modal fade" id="announcementModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">ADD ANNOUNCEMENT</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid upload-container">
                    <form action="announce.php" class="form-upload" method="POST" enctype="multipart/form-data">
                        <div class="col">
                            <div class="input-group">
                                <span class="input-group-text">Title:</span>
                                <input type="text" class="form-control" name="announce_title" placeholder="Sample Announcement Title" autofocus required>
                            </div>
                        </div>
                        <br>
                        <div class="textarea-section">
                            <label>Description:</label>
                            <br>
                            <textarea class="form-control textarea-form" placeholder="Input your description here" name="announce_desc"></textarea>
                        </div>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn-temp-close" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn-temp" name="announce">UPLOAD SESSION</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>