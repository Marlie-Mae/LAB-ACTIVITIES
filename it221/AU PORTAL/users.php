<?php
    include("cn.php");
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("location: login.php");
        exit();
    }

    $user_id = mysqli_real_escape_string($connection, $_SESSION['user_id']);
    $query = mysqli_query($connection, "SELECT * FROM tbl_users WHERE user_id = '$user_id'");
    $row = mysqli_fetch_assoc($query);

    $message_display = ""; 
    $modalOpen = false;

    $successMessage = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // ADD USER FUNCTION
        if (isset($_POST['add_user'])) {
            $new_user_id = mysqli_real_escape_string($connection, $_POST['user_id']);
            $new_password = mysqli_real_escape_string($connection, $_POST['password']);
            $hashed_password = md5($new_password);
            $new_account_type = mysqli_real_escape_string($connection, $_POST['account_type']);
            $new_status = mysqli_real_escape_string($connection, $_POST['status']);
    
            // Check if user already exists
            $check_existing_user = mysqli_query($connection, "SELECT * FROM tbl_users WHERE user_id = '$new_user_id'");
            if (mysqli_num_rows($check_existing_user) > 0) {
                $message_display = "<div class='message error'>User ID already exists.</div>";
                $modalOpen = true;
            } else {
                $insert_user_query = "INSERT INTO tbl_users (user_id, password, account_type, status) 
                                      VALUES ('$new_user_id', '$hashed_password', '$new_account_type', '$new_status')";
    
                if (mysqli_query($connection, $insert_user_query)) {
                    $successMessage = "Users added successfully!";
                } else {
                    echo "<script>alert('Failed to add subject.');</script>";
                }
            }
        }
    
        // EDIT USER FUNCTION
        if (isset($_POST['edit_user'])) {
            $edit_user_id = mysqli_real_escape_string($connection, $_POST['edit_user_id']); 
            $edit_password = mysqli_real_escape_string($connection, $_POST['edit_password']);
            $edit_account_type = mysqli_real_escape_string($connection, $_POST['edit_account_type']); 
            $edit_status = mysqli_real_escape_string($connection, $_POST['edit_status']); 

            // If a new password is provided, hash it; otherwise, keep the current password
            if (!empty($edit_password)) {
                $hashed_password = md5($edit_password); 
                $update_query = "UPDATE tbl_users 
                                SET account_type = '$edit_account_type', 
                                    status = '$edit_status', 
                                    password = '$hashed_password' 
                                WHERE user_id = '$edit_user_id'";
            } else {
                $update_query = "UPDATE tbl_users 
                                SET account_type = '$edit_account_type', 
                                    status = '$edit_status' 
                                WHERE user_id = '$edit_user_id'";
            }

            if (mysqli_query($connection, $update_query)) {
                $successMessage = "User updated successfully!";
            } else {
                echo "<script>alert('Failed to update user.');</script>";
            }
        }

    }

    // Handle User Deletion
    if (isset($_GET["delete"])) {
        $delete_user_id = mysqli_real_escape_string($connection, $_GET["delete"]);
        $delete_query = "DELETE FROM tbl_users WHERE user_id = '$delete_user_id'";

        if (mysqli_query($connection, $delete_query)) {
            header("Location: users.php?success=User deleted successfully");
            exit();
        } else {
            header("Location: users.php?error=Failed to delete user");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AU Portal | Users</title>
        <link type="image/png" rel="icon" href="images/au_logo.png">
        <link rel="stylesheet" href="css/table.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

        <script>
            function closeSuccessModal() {
                document.getElementById("successModal").style.display = "none";
            }
        </script>
    
    </head>
    <body>

        <?php if ($successMessage): ?>
            <div id="successModal" class="success-modal" style="display:block;">
                <div class="success-modal-content">
                    <p><?php echo $successMessage; ?></p>
                    <button onclick="closeSuccessModal()">OK</button>
                </div>
            </div>
        <?php endif; ?>

   <!-- Sidebar Navigation -->
   <nav class="sidebar">
        <div class="sidebar-header">
            <div class="user-con">
                <div class="img-con">
                    <img src="images/default.jpg" alt="Admin Image">
                </div>
                <div class="user-info">
                    <strong>Admin</strong><br><?php echo $row["user_id"]; ?>
                </div>
            </div>
            <div class="close-icon" onclick="toggleSidebar()">&times;</div>
        </div>

        <ul class="nav-links">
            <li><a href="admin-profile.php"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="users.php" class="active"><i class="fas fa-users"></i> Users</a></li>
            <li><a href="school-year.php"><i class="fas fa-calendar"></i> School Year</a></li>
            <li><a href="department.php"><i class="fas fa-building"></i> Department</a></li>
            <li><a href="course.php"><i class="fas fa-book"></i> Course</a></li>
            <li><a href="subject.php"><i class="fas fa-chalkboard-teacher"></i> Subject</a></li>
            <li><a href="student.php"><i class="fas fa-user-graduate"></i> Student</a></li>
            <li><a href="faculty.php"><i class="fas fa-user-tie"></i> Faculty</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>

     <!-- Main Content -->
     <section class="main-content">
        <div class="top-con">
            <!-- Hamburger Icon for Mobile -->
            <div class="hamburger" onclick="toggleSidebar()">&#9776;</div>

            <div class="top-nav">
                <img src="images/au_logo.png" alt="Arellano University Logo" class="brand">
                <h2>Arellano University</h2>
            </div>
        </div>

        <div class="table-container">

            <h1 class="title">Users Information</h1>

            <button class="add-btn" onclick="openModal()"> <i class="fas fa-plus"></i> Add New User</button>

        <?php
            include("cn.php");
            $query = mysqli_query($connection, "SELECT * FROM tbl_users");
            $rows = mysqli_num_rows($query); 
            if ($rows > 0) {
        ?>

        <table id="users" class="styled-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Account Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($data = mysqli_fetch_assoc($query)) {
                ?>
                <tr>
                    <td><?php echo $data['user_id']; ?></td>
                    <td><?php echo $data['account_type']; ?></td>
                    <td><?php echo $data['status']; ?></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-edit" onclick="openEditModal('<?php echo $data['user_id']; ?>', '<?php echo $data['account_type']; ?>', '<?php echo $data['status']; ?>')"> <i class="fas fa-edit"></i> Edit</button>
                            <a href="javascript:void(0);" class="btn-delete" onclick="openDeleteModal('<?php echo $data['user_id']; ?>')"> <i class="fas fa-trash"></i> Delete</a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="delete-modal">
                <div class="delete-modal-content">
                    <h2>Are you sure?</h2>
                    <p>Do you really want to delete this user? This action cannot be undone.</p>
                    <input type="hidden" id="delete_user_id">
                    <button class="btn-confirm" onclick="confirmDelete()">Yes, Delete</button>
                    <button class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                </div>
            </div>

            <script>
                function openDeleteModal(user_id) {
                    document.getElementById("delete_user_id").value = user_id;
                    document.getElementById("deleteModal").style.display = "block";
                }

                function closeDeleteModal() {
                    document.getElementById("deleteModal").style.display = "none";
                }

                function confirmDelete() {
                    var user_id = document.getElementById("delete_user_id").value;
                    window.location.href = "users.php?delete=" + user_id;
                }
            </script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                $('#users').DataTable();

                // Check if modal should be open
                if (document.getElementById("modal_status").value === "open") {
                    openModal();
                }
            });

            function toggleSidebar() {
                var sidebar = document.querySelector('.sidebar');
                sidebar.classList.toggle('active');
            }

            function openModal() {
                document.getElementById("userModal").style.display = "block";
            }

            function closeModal() {
                document.getElementById("userModal").style.display = "none";
            }

            function openEditModal(userId, accountType, status) {
                document.getElementById("edit_user_id").value = userId; 
                document.getElementById("edit_account_type").value = accountType; 
                document.getElementById("edit_status").value = status; 
                document.getElementById("editUserModal").style.display = "block";
            }

            function closeEditModal() {
                document.getElementById("editUserModal").style.display = "none";
            }

        </script>

        <!-- Add Modal -->
        <div id="userModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h1>Add New User</h1>

                <?php if (!empty($message_display)) echo $message_display; ?>

                <form action="" method="POST">
                    <input type="hidden" id="modal_status" value="<?php echo $modalOpen ? 'open' : 'closed'; ?>">

                    <label for="user_id">User ID:</label>
                    <input type="text" name="user_id" placeholder="User ID" required> <br>

                    <label for="password">Password:</label>
                    <input type="password" name="password" placeholder="Password" required> <br>

                    <label for="account_type">Account Type:</label>
                    <select name="account_type" required>
                        <option value="" disabled selected>Select Account Type</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select> <br>

                    <label for="status">Status:</label>
                    <select name="status" required>
                        <option value="" disabled selected>Select Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select> <br>

                    <input type="submit" name="add_user" value="Insert">
                </form>
            </div>
        </div>
        
        <!-- Edit Modal -->
        <div id="editUserModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeEditModal()">&times;</span>
                <h1>Edit User</h1>

                <form method="POST">
                    <label for="edit_user_id">User ID:</label>
                    <input type="text" name="edit_user_id" id="edit_user_id" readonly> 
                    <br>

                    <!--
                    <input type="hidden" name="edit_user_id" id="edit_user_id"> 
                     -->

                    <label for="edit_password">New Password (Leave blank to keep current):</label>
                    <input type="password" name="edit_password" id="edit_password" placeholder="Enter new password">
                    <br>

                    <label for="edit_account_type">Account Type:</label>
                    <select name="edit_account_type" id="edit_account_type" required> 
                        <option value="" disabled selected>Select Account Type</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select> 
                    <br>

                    <label for="edit_status">Status:</label>
                    <select name="edit_status" id="edit_status" required> 
                        <option value="" disabled selected>Select Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select> 
                    <br>

                    <input type="submit" name="edit_user" value="Update">
                </form>
            </div>
        </div>


        <?php } ?>
        </div>
    </section>

    </body>
</html>