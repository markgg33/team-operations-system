<!-- Modal -->
<div class="modal fade" id="uploadSessionModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">UPLOAD SESSION</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid upload-container">
                    <form action="upload.php" class="form-upload" method="POST" enctype="multipart/form-data">
                        <div class="col">
                            <div class="input-group">
                                <span class="input-group-text">Title:</span>
                                <input type="text" class="form-control" name="session_title" placeholder="How to rename a content inside Content Hub" autofocus required>
                            </div>
                        </div>
                        <br>
                        <div class="textarea-section" name="session_desc">
                            <label>Description:</label>
                            <br>
                            <textarea class="form-control textarea-form" placeholder="Input your description here"></textarea>
                        </div>
                        <br>
                        <div class="col">
                            <label for="Video">Session Upload:</label>
                            <div class="input-group">
                                <input type="file" name="session_vid" class="form-control" accept="video/*" required>
                                <span class="input-group-text"><i class="fa-solid fa-camera"></i></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-temp-close" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn-temp" name="upload">UPLOAD SESSION</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>