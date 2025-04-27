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
        // ADD FUNCTION
        if (isset($_POST['add_school_year'])) {
            $school_year_code = mysqli_real_escape_string($connection, $_POST['school_year_code']);
            $school_year = mysqli_real_escape_string($connection, $_POST['school_year']);
            $semester = mysqli_real_escape_string($connection, $_POST['semester']);
            $status = mysqli_real_escape_string($connection, $_POST['status']);

            $check_school_year_code = mysqli_query($connection, "SELECT * FROM tbl_school_year WHERE school_year_code = '$school_year_code'");
            if (mysqli_num_rows($check_school_year_code) > 0) {
                $display = "<div class='message error'>School Year Code already exists.</div>";
                $modalOpen = true;
            } else {
                $insert_query = "INSERT INTO tbl_school_year (school_year_code, school_year, semester, status) VALUES ('$school_year_code', '$school_year', '$semester', '$status')";
                
                if (mysqli_query($connection, $insert_query)) {
                    $successMessage = "School year added successfully!";
                } else {
                    echo "<script>alert('Failed to add school year.');</script>";
                }
            }
        }

        // EDIT FUNCTION
        if (isset($_POST['edit_school_year']) && !$isUser) {
            $edit_code = mysqli_real_escape_string($connection, $_POST['edit_code']);
            $edit_year = mysqli_real_escape_string($connection, $_POST['edit_school_year_value']);
            $edit_semester = mysqli_real_escape_string($connection, $_POST['edit_semester']);
            $edit_status = mysqli_real_escape_string($connection, $_POST['edit_status']);

            if (empty($edit_code) || empty($edit_year) || empty($edit_semester) || empty($edit_status)) {
                die("<div class='message error'>Error: Missing data. Please fill all fields.</div>");
            }

            $check_school_year = mysqli_query($connection, "SELECT * FROM tbl_school_year WHERE school_year_code = '$edit_code'");
            if (mysqli_num_rows($check_school_year) == 0) {
                $display = "<div class='message error'>School year code does not exist.</div>";
            } else {
                $update_query = "UPDATE tbl_school_year 
                                 SET school_year = '$edit_year', semester = '$edit_semester', status = '$edit_status' 
                                 WHERE school_year_code = '$edit_code'";

                if (mysqli_query($connection, $update_query)) {
                    $successMessage = "School year updated successfully!";
                } else {
                    echo "<script>alert('Failed to update school year.');</script>";
                }
            }
        }
    }
    
    if (isset($_GET["delete"]) && !$isUser) {
        $school_year_code = mysqli_real_escape_string($connection, $_GET["delete"]);
        $delete_query = "DELETE FROM tbl_school_year WHERE school_year_code = '$school_year_code'";

        if (mysqli_query($connection, $delete_query)) {
            header("Location: school-year.php?success=school year deleted successfully");
            exit();
        } else {
            header("Location: school-year.php?error=Failed to delete school year");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AU Portal | School Year</title>
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
                    <strong><?php echo strtoupper($row["account_type"]); ?></strong><br><?php echo $row["user_id"]; ?>
                </div>
            </div>
            <div class="close-icon" onclick="toggleSidebar()">&times;</div>
        </div>

        <ul class="nav-links">
            <li><a href="admin-profile.php"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="users.php"><i class="fas fa-users"></i> Users</a></li>
            <li><a href="school-year.php" class="active"><i class="fas fa-calendar"></i> School Year</a></li>
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
        <h1 class="title">School Year Information</h1>
        
        <button class="add-btn disabled-link" <?php if ($isUser) echo 'disabled'; else echo 'onclick="openModal()"'; ?>> <i class="fas fa-plus"></i> Add New Faculty</button>

        <?php
            include("cn.php");
            $query = mysqli_query($connection, "SELECT * FROM tbl_school_year");
            $rows = mysqli_num_rows($query); 
            if ($rows > 0) {
        ?>
        
        <table id="school_year" class="styled-table">
            <thead>
                <tr>
                    <th>School Year Code</th>
                    <th>School Year</th>
                    <th>Semester</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($data = mysqli_fetch_assoc($query)) {
                ?>
                <tr>
                    <td><?php echo $data['school_year_code']; ?></td>
                    <td><?php echo $data['school_year']; ?></td>
                    <td><?php echo $data['semester']; ?></td>
                    <td><?php echo $data['status']; ?></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-edit disabled-link" <?php if ($isUser) echo 'disabled'; else echo 'onclick="openEditModal(\'' . $data['school_year_code'] . '\', \'' . $data['school_year'] . '\', \'' . $data['semester'] . '\', \'' . $data['status'] . '\')"'; ?>> <i class="fas fa-edit"></i> Edit</button>
                            <?php if ($isUser): ?>
                                <span class="btn-delete disabled-link"> <i class="fas fa-trash"></i> Delete</span>
                            <?php else: ?>
                                <a href="javascript:void(0);" class="btn-delete" onclick="openDeleteModal('<?php echo $data['school_year_code']; ?>')"> <i class="fas fa-trash"></i> Delete</a>
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
                    <p>Do you really want to delete this school year? This action cannot be undone.</p>
                    <input type="hidden" id="delete_school_year_code">
                    <button class="btn-confirm" onclick="confirmDelete()">Yes, Delete</button>
                    <button class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                </div>
            </div>

            <script>
                function openDeleteModal(school_year_code) {
                    document.getElementById("delete_school_year_code").value = school_year_code;
                    document.getElementById("deleteModal").style.display = "block";
                }

                function closeDeleteModal() {
                    document.getElementById("deleteModal").style.display = "none";
                }

                function confirmDelete() {
                    var school_year_code = document.getElementById("delete_school_year_code").value;
                    window.location.href = "school-year.php?delete=" + school_year_code;
                }
            </script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                $('#school_year').DataTable();

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
                document.getElementById("schoolyearModal").style.display = "block";
            }

            function closeModal() {
                document.getElementById("schoolyearModal").style.display = "none";
            }

            function openEditModal(code, year, semester, status) {
                document.getElementById("edit_code").value = code;
                document.getElementById("edit_school_year").value = year;
                document.getElementById("edit_semester").value = semester;
                document.getElementById("edit_status").value = status;
                document.getElementById("editSchoolYearModal").style.display = "block";
            }

            function closeEditModal() {
                document.getElementById("editSchoolYearModal").style.display = "none";
            }
        </script>

        <!-- Add Modal -->
        <div id="schoolyearModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h1>Add New School Year</h1>

                <?php if (!empty($display)) echo $display; ?>

                <form action="" method="POST">
                    <input type="hidden" id="modal_status" value="<?php echo $modalOpen ? 'open' : 'closed'; ?>">

                    <label for="school_year_code">School Year Code:</label>
                    <input type="text" name="school_year_code" placeholder="School year code" required> <br>

                    <label for="school_year">School Year:</label>
                    <input type="text" name="school_year" placeholder="School year" required> <br>

                    <label for="semester">Semester:</label>
                    <input type="text" name="semester" placeholder="Semester" required> <br>

                    <label for="status">Status:</label>
                    <select name="status" required>
                        <option value="" disabled selected>Select Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select> <br>

                    <input type="submit" name="add_school_year" value="Insert">
                </form>
            </div>
        </div>

        <!-- Edit Modal -->
        <div id="editSchoolYearModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeEditModal()">&times;</span>
                <h1>Edit School Year</h1>
                <form method="POST">
                    <label for="edit_code">School Year Code:</label>
                    <input type="text" name="edit_code" id="edit_code" readonly> 
                    <br>

                    <label>School Year:</label>
                    <input type="text" name="edit_school_year_value" id="edit_school_year" required>

                    <label>Semester:</label>
                    <input type="text" name="edit_semester" id="edit_semester" required>

                    <label for="edit_status">Status:</label>
                    <select name="edit_status" id="edit_status" required> <!-- FIXED -->
                        <option value="" disabled selected>Select Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select> 
                    <br>

                    <input type="submit" name="edit_school_year" value="Update">
                </form>
            </div>
        </div>
        

        <?php } ?>
    </div>
    </section>
    </body>
</html>