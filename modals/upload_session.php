<!-- Modal -->
<div class="modal fade" id="uploadSessionModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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
                                <input type="text" class="form-control" name="upload-title" placeholder="How to rename a content inside Content Hub" autofocus required>
                            </div>
                        </div>
                        <div class="textarea-section">
                            <label>Description:</label>
                            <br>
                            <textarea class="form-control textarea-form" placeholder="Input your description here"></textarea>
                        </div>
                        <div class="btn-form-container">
                            <button type="submit" name="upload" class="btn-upload">REGISTER</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>

    </div>
</div>