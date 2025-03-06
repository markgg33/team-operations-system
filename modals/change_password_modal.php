<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">WELCOME, USER. PLEASE CHANGE YOUR PASSWORD.</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="changePasswordForm">
                <div class="modal-body">
                    <?php if (isset($_SESSION['reset_user'])): ?>
                        <input type="hidden" id="changePasswordUsername" name="username" value="<?php echo htmlspecialchars($_SESSION['reset_user']); ?>">
                    <?php else: ?>
                        <div class="alert alert-danger">Session expired. Please log in again.</div>
                    <?php endif; ?>

                    <div class="alert alert-info" id="changePasswordAlert" style="display: none;"></div> <!-- Alert here -->

                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <div class="input-group" style="cursor:pointer;">
                            <input type="password" class="form-control" id="newPassword" name="new_password" required>
                            <span class="input-group-text toggle-password" onclick="togglePassword('newPassword')">
                                <i class="fa-solid fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <div class="input-group" style="cursor:pointer;">
                            <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
                            <span class="input-group-text toggle-password" onclick="togglePassword('confirmPassword')">
                                <i class="fa-solid fa-eye"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Password Toggle Script -->
<script>
function togglePassword(fieldId) {
    let passwordField = document.getElementById(fieldId);
    let icon = event.target;

    if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        passwordField.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
    }
}
</script>
