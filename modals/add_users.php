<!-- Modal -->
<div class="modal fade" id="addUsersModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">ADD USERS</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="registration.php" class="form-login" method="POST" enctype="multipart/form-data">

                    <div class="row gx-3">
                        <div class="col">
                            <label for="FirstName">First Name:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="first_name" placeholder="E.g: Juan" autofocus required>
                            </div>
                        </div>
                        <div class="col">
                            <label for="MiddleName">Middle Name:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="middle_name" placeholder="E.g: Dela Cruz" autofocus required>
                            </div>
                        </div>
                        <div class="mb-3"></div>
                    </div>

                    <div class="row gx-3">
                        <div class="col">
                            <label for="Surname">Surname:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="surname" placeholder="E.g: Dela Cruz" autofocus required>
                            </div>
                        </div>
                        <div class="mb-3"></div>
                    </div>

                    <div class="row gx-3">
                        <div class="col">
                            <label for="Username">Username:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="username" placeholder="E.g: WEB-2024-01" autofocus required>
                                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                            </div>
                        </div>
                        <div class="col">
                            <label for="Email">Email:</label>
                            <div class="input-group">
                                <input type="email" class="form-control" name="email" placeholder="Enter Email" required>
                            </div>
                        </div>
                        <div class="mb-3"></div>
                    </div>

                    <div class="row gx-3">
                        <div class="col">
                            <label for="Gender">Gender:</label>
                            <select class="form-select" aria-label="Default select example" name="gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="preferNTS">Prefer not to say</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="Password">Password:</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" placeholder="Enter Password" autofocus required>
                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            </div>
                        </div>
                        <div class="col">
                            <label for="ConfirmPassword">Confirm Password:</label>
                            <div class="input-group">
                                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" autofocus required>
                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            </div>
                        </div>
                        <div class="mb-3"></div>
                    </div>

                    <div class="row gx-3">
                        <div class="col">
                            <label for="DateOfBirth">Date of Birth:</label>
                            <input type="date" name="dob" class="form-control" autofocus required>
                        </div>
                        <div class="col">
                            <label for="Photo">Photo Upload:</label>
                            <div class="input-group">
                                <input type="file" name="photo" class="form-control" accept="image/*">
                                <span class="input-group-text"><i class="fa-solid fa-camera"></i></span>
                            </div>
                        </div>

                        <div class="col">
                            <label for="AccountType">Account Type:</label>
                            <select name="usertype" class="form-select">
                                <option value="user">User</option>
                                <option value="admin" disabled>Admin</option>
                            </select>
                        </div>
                        <div class="mb-3"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn-temp-close" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn-temp" name="btn-register" >Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>