<!-- Modal
<div class="modal fade" id="announcementModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">ADD ANNOUNCEMENT</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid upload-container">
                    <form action="add_announcement.php" class="form-upload" method="POST" enctype="multipart/form-data">
                        <div class="col">
                            <div class="input-group">
                                <span class="input-group-text">Title:</span>
                                <input type="text" class="form-control" name="announce_title" placeholder="Sample Announcement Title" autofocus required oninput="this.value = this.value.toUpperCase();">
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
                            <button type="submit" class="btn-temp" name="submit_announce">POST ANNOUNCEMENT</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->

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
                    <form id="announcementForm" class="form-upload" method="POST">
                        <div class="col">
                            <div class="input-group">
                                <span class="input-group-text">Title:</span>
                                <input type="text" class="form-control" name="announce_title" placeholder="Sample Announcement Title" autofocus required oninput="this.value = this.value.toUpperCase();">
                            </div>
                        </div>
                        <br>
                        <div class="textarea-section">
                            <label>Description:</label>
                            <br>
                            <textarea class="form-control textarea-form" placeholder="Input your description here" name="announce_desc" required></textarea>
                        </div>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn-temp-close" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="submit_announce" class="btn-temp">POST ANNOUNCEMENT</button>
                        </div>
                        <!-- Loading Indicator -->
                        <div id="loadingIndicator" class="text-center mt-3" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Sending announcement...</span>
                            </div>
                            <p>📨 Sending announcement... Please wait.</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("announcementForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission

        let submitButton = document.getElementById("submit_announce");
        let loadingIndicator = document.getElementById("loadingIndicator");

        // Show loading indicator & disable button
        loadingIndicator.style.display = "block";
        submitButton.disabled = true;

        // Send form data via AJAX
        let formData = new FormData(this);
        fetch("add_announcement.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert("✅ Announcement added successfully!");
                window.location.reload(); // Refresh the page to show the new announcement
            })
            .catch(error => {
                alert("❌ Error posting announcement!");
                console.error("Error:", error);
            })
            .finally(() => {
                loadingIndicator.style.display = "none";
                submitButton.disabled = false;
            });
    });
</script>