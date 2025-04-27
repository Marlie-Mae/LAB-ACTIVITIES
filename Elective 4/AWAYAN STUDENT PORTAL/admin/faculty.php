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

    // Check if user is a regular user (not admin)
    $isUser = ($row['account_type'] === 'user');

    $display = ""; 
    $modalOpen = false;

    $successMessage = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST" && !$isUser) {
        // ADD FACULTY FUNCTION
        if (isset($_POST['add_faculty'])) {
            $faculty_code = mysqli_real_escape_string($connection, $_POST['faculty_code']);
            $faculty_name = mysqli_real_escape_string($connection, $_POST['faculty_name']);
            $department_code = mysqli_real_escape_string($connection, $_POST['department_code']);
            $password = mysqli_real_escape_string($connection, $_POST['password']);
            $hashed_password = md5($password); // Consider using password_hash($password, PASSWORD_BCRYPT)

            // Check if faculty already exists
            $check_faculty = mysqli_query($connection, "SELECT * FROM tbl_faculty WHERE faculty_code = '$faculty_code'");
            if (mysqli_num_rows($check_faculty) > 0) {
                $display = "<div class='message error'>Faculty code already exists.</div>";
                $modalOpen = true;
            } else {
                // Insert new faculty record
                $insert_query = "INSERT INTO tbl_faculty (faculty_code, faculty_name, department_code, password) 
                                VALUES ('$faculty_code', '$faculty_name', '$department_code', '$hashed_password')";

                if (mysqli_query($connection, $insert_query)) {
                    $successMessage = "Faculty added successfully!";
                } else {
                    echo "<script>alert('Failed to add faculty.');</script>";
                }
            }
        }

        // EDIT FACULTY FUNCTION
        if (isset($_POST['edit_faculty']) && !$isUser) {
            $edit_code = mysqli_real_escape_string($connection, $_POST['edit_code']);
            $edit_name = mysqli_real_escape_string($connection, $_POST['edit_name']);
            $edit_department_code = mysqli_real_escape_string($connection, $_POST['edit_department_code']);
            $edit_password = mysqli_real_escape_string($connection, $_POST['edit_password']);

            if (!empty($edit_password)) {
                $hashed_password = md5($edit_password); 
                $update_query = "UPDATE tbl_faculty 
                                SET faculty_name = '$edit_name', department_code = '$edit_department_code', 
                                    password = '$hashed_password' 
                                WHERE faculty_code = '$edit_code'";
            } else {
                $update_query = "UPDATE tbl_faculty 
                                SET faculty_name = '$edit_name', department_code = '$edit_department_code' 
                                WHERE faculty_code = '$edit_code'";
            }

            if (mysqli_query($connection, $update_query)) {
                $successMessage = "Faculty updated successfully!";
            } else {
                echo "<script>alert('Failed to update faculty.');</script>";
            }
        }
}
    
    // Handle department Deletion
    if (isset($_GET["delete"]) && !$isUser) {
        $faculty_code = mysqli_real_escape_string($connection, $_GET["delete"]);
        $delete_query = "DELETE FROM tbl_faculty WHERE faculty_code = '$faculty_code'";

        if (mysqli_query($connection, $delete_query)) {
            header("Location: faculty.php?success=Faculty deleted successfully");
            exit();
        } else {
            header("Location: faculty.php?error=Failed to delete faculty");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AU Portal | Faculty</title>
        <link type="image/png" rel="icon" href="images/au_logo.png">
        <link rel="stylesheet" href="css/table.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
                    <strong><?php echo strtoupper($row["account_type"]); ?></strong><br><?php echo $row["user_id"]; ?>
                </div>
            </div>
            <div class="close-icon" onclick="toggleSidebar()">&times;</div>
        </div>

        <ul class="nav-links">
            <li><a href="admin-profile.php"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="users.php"><i class="fas fa-users"></i> Users</a></li>
            <li><a href="school-year.php"><i class="fas fa-calendar"></i> School Year</a></li>
            <li><a href="department.php"><i class="fas fa-building"></i> Department</a></li>
            <li><a href="course.php"><i class="fas fa-book"></i> Course</a></li>
            <li><a href="subject.php"><i class="fas fa-chalkboard-teacher"></i> Subject</a></li>
            <li><a href="student.php"><i class="fas fa-user-graduate"></i> Student</a></li>
            <li><a href="faculty.php" class="active"><i class="fas fa-user-tie"></i> Faculty</a></li>
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
        <h1 class="title">Faculty Information</h1>

        <button class="add-btn disabled-link" <?php if ($isUser) echo 'disabled'; else echo 'onclick="openModal()"'; ?>> <i class="fas fa-plus"></i> Add New Faculty</button>

        <?php if (isset($message)) echo $message; ?>

        <?php
            include("cn.php");
            $query = mysqli_query($connection, "SELECT * FROM tbl_faculty");
            $rows = mysqli_num_rows($query); 
            if ($rows > 0) {
        ?>

        <table id="faculty" class="styled-table">
            <thead>
                <tr>
                    <th>Faculty Code</th>
                    <th>Faculty Name</th>
                    <th>Department Code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($data = mysqli_fetch_assoc($query)) {
                ?>
                <tr>
                    <td><?php echo $data['faculty_code']; ?></td>
                    <td><?php echo $data['faculty_name']; ?></td>
                    <td><?php echo $data['department_code']; ?></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-edit disabled-link" <?php if ($isUser) echo 'disabled'; else echo 'onclick="openEditModal(\'' . $data['faculty_code'] . '\', \'' . $data['faculty_name'] . '\', \'' . $data['department_code'] . '\')"'; ?>> <i class="fas fa-edit"></i> Edit</button>
                            <?php if ($isUser): ?>
                                <span class="btn-delete disabled-link"> <i class="fas fa-trash"></i> Delete</span>
                            <?php else: ?>
                                <a href="javascript:void(0);" class="btn-delete" onclick="openDeleteModal('<?php echo $data['faculty_code']; ?>')"> <i class="fas fa-trash"></i> Delete</a>
                            <?php endif; ?>
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
                    <p>Do you really want to delete this faculty? This action cannot be undone.</p>
                    <input type="hidden" id="delete_faculty_code">
                    <button class="btn-confirm" onclick="confirmDelete()">Yes, Delete</button>
                    <button class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                </div>
            </div>

            <script>
                function openDeleteModal(faculty_code) {
                    document.getElementById("delete_faculty_code").value = faculty_code;
                    document.getElementById("deleteModal").style.display = "block";
                }

                function closeDeleteModal() {
                    document.getElementById("deleteModal").style.display = "none";
                }

                function confirmDelete() {
                    var faculty_code = document.getElementById("delete_faculty_code").value;
                    window.location.href = "faculty.php?delete=" + faculty_code;
                }
            </script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                $('#faculty').DataTable();

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
                document.getElementById("facultyModal").style.display = "block";
            }

            function closeModal() {
                document.getElementById("facultyModal").style.display = "none";
            }

            function openEditModal(code, name, department) {
                document.getElementById("edit_code").value = code;
                document.getElementById("edit_name").value = name;
                document.getElementById("edit_department_code").value = department;
                document.getElementById("editfacultyModal").style.display = "block";
            }

            function closeEditModal() {
                document.getElementById("editfacultyModal").style.display = "none";
            }
        </script>

        <!-- Add Modal -->
        <div id="facultyModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h1>Add New Faculty</h1>

                <?php if (!empty($display)) echo $display; ?>

                <form action="" method="POST">
                    <input type="hidden" id="modal_status" value="<?php echo $modalOpen ? 'open' : 'closed'; ?>">

                    <label for="faculty_code">Faculty Code</label>
                    <input type="text" name="faculty_code" placeholder="Faculty code" required> <br>

                    <label for="faculty_name">Faculty Name</label>
                    <input type="text" name="faculty_name" placeholder="Faculty name" required> <br>

                    <label for="department_code">Department Code</label>
                    <select name="department_code" id="">
                        <option value="" disabled selected>Select a department</option>
                        <?php
                            $query = mysqli_query($connection, "SELECT * FROM tbl_department"); 
                            $rows = mysqli_num_rows($query);
                            if ($rows > 0) {
                                while ($data = mysqli_fetch_assoc($query)) {
                        ?>
                                    <option value="<?php echo $data['department_code']; ?>">
                                        <?php echo $data['department_code']; ?>
                                    </option>
                        <?php  
                                }
                            }
                        ?>
                    </select>
                    <br>

                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="Password" required> <br>

                    <input type="submit" name="add_faculty" value="Insert">
                </form>
            </div>
        </div>

        <!-- Edit Modal -->
        <div id="editfacultyModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeEditModal()">&times;</span>
                <h1>Edit Faculty</h1>
                <form method="POST">
                    <label for="edit_code">Faculty Code:</label>
                    <input type="text" name="edit_code" id="edit_code" readonly> 
                    <br>
                    
                    <label for="faculty_name">Faculty Name</label>
                    <input type="text" name="edit_name" id="edit_name" required> <br>

                    <label for="department_code">Department Code</label>
                    <select name="edit_department_code" id="edit_department_code">
                        <option value="" disabled selected>Select a department</option>
                        <?php
                        include('cn.php'); 
                        $query = mysqli_query($connection, "SELECT * FROM tbl_department"); 
                        while ($department = mysqli_fetch_assoc($query)) {
                        ?>
                        <option value="<?php echo $department['department_code']; ?>" 
                            <?php if(isset($edit_department_code) && $edit_department_code == $department["department_code"]) { echo "selected"; } ?>>
                            <?php echo $department['department_code']; ?>
                        </option>
                        <?php } ?>
                    </select>
                    <br>

                    <label for="edit_password">New Password (Leave blank to keep current):</label>
                    <input type="password" name="edit_password" id="edit_password" placeholder="Enter new password">
                    <br>
                    
                    <input type="submit" name="edit_faculty" value="Update">
                </form>
            </div>
        </div>

    <?php } ?>
    </div>
</section>
</body>
</html>