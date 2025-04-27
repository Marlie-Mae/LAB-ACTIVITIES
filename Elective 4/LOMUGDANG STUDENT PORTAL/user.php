<?php 
include("cn.php"); 

session_start();

if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit();
}

// Redirect regular users to profile.php if they try accessing other pages
if ($_SESSION['account_type'] === 'User' && basename($_SERVER['PHP_SELF']) !== 'USER/users.php') {
    header("location: USER/users.php");
    exit();
}

// Prevent admins from accessing profile.php
if ($_SESSION['account_type'] === 'Admin' && basename($_SERVER['PHP_SELF']) === 'USER/users.php') {
    header("location: user.php"); // Redirect admins elsewhere (e.g., users page)
    exit();
}
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Portal | Users</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="main-con">
        <div class="left-con">
            <div class="user-con">
                <div class="img-con"><img src="images/profile.png"></div>
                <div class="user-info">Admin<br>Lomugdang, Junalyn</div>
            </div>
            <div class="menu-con">
                <a href="school_year.php">SCHOOL YEAR</a>
                <a href="department.php">DEPARTMENTS</a>
                <a href="subject.php">SUBJECTS</a>
                <a href="faculty.php">FACULTY</a>
                <a href="students.php">STUDENTS</a>
                <a href="course.php">COURSES</a>
                <a href="user.php" style="background-color: lightblue; border-radius: 7px; color: darkslategray;">USERS</a>
                <a href="logout.php">LOGOUT</a>
            </div>
        </div>
        <div class="right-con">
            <div class="top-nav">
                <div class="brand">USER PORTAL</div>
            </div>
            <div class="body">
                <div class="content-title"><h1>USERS</h1></div>
                <div class="content">
                    <a id="addUserBtn" class="action-button">+ Add New</a>
                    <?php 
                        $query = mysqli_query($connection, "SELECT * FROM tbl_users");
                        if (mysqli_num_rows($query) > 0) {
                    ?>
                    <table id="user_info" class="display">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Account Type</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while ($data = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?php echo $data['user_id']; ?></td>
                            <td><?php echo $data['account_type']; ?></td>
                            <td><?php echo $data['status']; ?></td>
                            <td>
                                <a href="#" class="edit-user" data-id="<?php echo htmlspecialchars($data['user_id']); ?>">Edit</a>
                                <a href="#" class="change-password" data-id="<?php echo htmlspecialchars($data['user_id']); ?>">Change</a>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('#user_info').DataTable();
                        });
                    </script>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Change Password Modal -->
    <div id="changePasswordModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Change Password</h2>
            <form id="changePasswordForm">
                <input type="hidden" id="change_user_id" name="user_id">
                <label>New Password</label>
                <input type="password" id="new_password" name="new_password" required>
                <label>Re-enter New Password</label>
                <input type="password" id="confirm_password" required>
                <button type="submit" class="save-btn">Change</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(document).on("click", ".change-password", function(e) {
                e.preventDefault();
                var user_id = $(this).data("id");
                $("#change_user_id").val(user_id);
                $("#changePasswordModal").show();
            });
            
            $(".close").click(function() {
                $("#changePasswordModal").hide();
            });
            
            $("#changePasswordForm").submit(function(e) {
                e.preventDefault();
                var newPassword = $("#new_password").val();
                var confirmPassword = $("#confirm_password").val();
                if (newPassword !== confirmPassword) {
                    alert("Passwords do not match!");
                    return;
                }
                $.ajax({
                    url: "change_password.php",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response);
                        $("#changePasswordModal").hide();
                        location.reload();
                    }
                });
            });
        });
    </script>

    <!-- Modal for Adding/Editing User -->
<!-- Add User Modal -->
<div id="addUserModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add User</h2>
        <form id="addUserForm">
            <label>User ID</label>
            <input type="text" id="add_user_id" name="user_id" required>

            <label>Password</label>
            <input type="password" id="add_password" name="password" placeholder="Enter password" required>

           <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-top: -5px; margin-bottom: 10px;">
</div>

<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-top: -5px; margin-bottom: 10px;">
    <div>
        <label style="display: block; font-weight: 500; margin-bottom: 5px;">Account Type</label>
        <select id="add_account_type" name="account_type" required 
            style="width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; box-sizing: border-box;">
            <option></option>
            <option value="User">User</option>
            <option value="Admin">Admin</option>
        </select>
    </div>

    <div>
        <label style="display: block; font-weight: 500; margin-bottom: 5px;">Status</label>
        <select id="add_status" name="status" required 
            style="width: 100%; padding: 5px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; box-sizing: border-box;">
            <option></option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select>
    </div>
</div>


            <button type="submit" class="save-btn">Save</button>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div id="editUserModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit User</h2>
        <form id="editUserForm">
            <input type="hidden" id="edit_user_id" name="user_id">
            <input type="hidden" name="edit_mode" value="true"> <!-- Ensure edit mode is set -->

            <label>Account Type</label>
            <select id="edit_account_type" name="account_type" required>
                <option></option>
                <option value="User">User</option>
                <option value="Admin">Admin</option>
            </select>

            <label>Status</label>
            <select id="edit_status" name="status" required>
                <option></option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>

            <button type="submit" class="save-btn">Update</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Open Add User Modal
        $("#addUserBtn").click(function() {
            $("#addUserForm")[0].reset();
            $("#addUserModal").show();
        });

        // Open Edit User Modal
        $(document).on("click", ".edit-user", function(e) {
            e.preventDefault();
            var user_id = $(this).data("id");

            $.ajax({
                url: "fetch_user.php",
                type: "POST",
                data: { user_id: user_id },
                dataType: "json",
                success: function(data) {
                    if (!data) {
                        alert("No data found!");
                        return;
                    }
                    $("#edit_user_id").val(data.user_id);
                    $("#edit_account_type").val(data.account_type);
                    $("#edit_status").val(data.status);
                    $("#editUserModal").show();
                },
                error: function() {
                    alert("Error fetching user details.");
                }
            });
        });

        // Close modals when clicking "X"
        $(".close").click(function() {
            $(".modal").hide();
        });

        // Handle Add User Form Submission
        $("#addUserForm").submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "save_user.php",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    alert(response);
                    $("#addUserModal").hide();
                    location.reload();
                }
            });
        });

        // Handle Edit User Form Submission
        $("#editUserForm").submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "save_user.php",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if (response.trim() === "success") {
                        alert("User updated successfully!");
                        $("#editUserModal").hide();
                        location.reload();
                    } else {
                        alert(response);
                    }
                },
                error: function() {
                    alert("Error updating user.");
                }
            });
        });

        // Close modals when clicking outside
        $(window).click(function(event) {
            if ($(event.target).hasClass("modal")) {
                $(".modal").hide();
            }
        });
    });
</script>


</body>
</html>
