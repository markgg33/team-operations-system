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
                    <form id="uploadForm" class="form-upload" enctype="multipart/form-data">
                        <div class="col">
                            <label>Title:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="session_title" placeholder="Enter Session Title" required>
                            </div>
                        </div>
                        <br>
                        <div class="textarea-section">
                            <label>Description:</label>
                            <textarea class="form-control textarea-form" placeholder="Enter description here" name="session_desc"></textarea>
                        </div>
                        <br>
                        <div class="col">
                            <label for="Video">Session Upload:</label>
                            <div class="input-group">
                                <input type="file" id="session_vid" name="session_vid" class="form-control" accept="video/*" required>
                                <span class="input-group-text"><i class="fa-solid fa-camera"></i></span>
                            </div>
                        </div>
                        <br>

                        <!-- Progress Bar -->
                        <div class="progress" style="height: 25px; display: none;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated"
                                role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                0%
                            </div>
                        </div>
                        <br>

                        <!-- Success Message -->
                        <div id="successMessage" style="display: none; color: green; font-weight: bold;"></div>

                        <div class="modal-footer">
                            <button type="button" class="btn-temp-close" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn-temp">UPLOAD SESSION</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $("#uploadForm").submit(function(e) {
            e.preventDefault(); // Prevent default form submission

            var formData = new FormData(this);
            var progressBar = $(".progress-bar");
            var progressContainer = $(".progress");

            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                            progressContainer.show();
                            progressBar.css("width", percentComplete + "%").text(percentComplete + "%");
                        }
                    }, false);
                    return xhr;
                },
                type: "POST",
                url: "upload.php", // Upload handler script
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === "success") {
                        progressBar.css("width", "100%").text("Upload Complete!");

                        // Delay for 1.5 seconds then redirect
                        setTimeout(function() {
                            window.location.href = "adminDashboard.php";
                        }, 1500);
                    } else {
                        alert(response.message); // Show error message
                    }
                },
                error: function() {
                    alert("Upload failed. Please try again.");
                }
            });
        });
    });
</script>