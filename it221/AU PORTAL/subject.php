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

    $display = ""; // Store messages for success or errors
    $modalOpen = false;

    $successMessage = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // ADD SUBJECT FUNCTION
        if (isset($_POST['add_subject'])) {
            $subject_code = mysqli_real_escape_string($connection, $_POST['subject_code']);
            $subject_name = mysqli_real_escape_string($connection, $_POST['subject_name']);
            $department_code = mysqli_real_escape_string($connection, $_POST['department_code']);
    
            $check_subject = mysqli_query($connection, "SELECT * FROM tbl_subject WHERE subject_code = '$subject_code'");
            if (mysqli_num_rows($check_subject) > 0) {
                $display = "<div class='message error'>Subject code already exists.</div>";
                $modalOpen = true;
            } else {
                $insert_query = "INSERT INTO tbl_subject (subject_code, subject_name, department_code) VALUES ('$subject_code', '$subject_name', '$department_code')";
                
                if (mysqli_query($connection, $insert_query)) {
                    $successMessage = "Subject added successfully!";
                } else {
                    echo "<script>alert('Failed to add subject.');</script>";
                }
            }
        }
    
        // EDIT SUBJECT FUNCTION
        if (isset($_POST['edit_subject'])) {
            $edit_code = mysqli_real_escape_string($connection, $_POST['edit_subject_code']);
            $edit_name = mysqli_real_escape_string($connection, $_POST['edit_subject_name']);
            $edit_department_code = mysqli_real_escape_string($connection, $_POST['edit_department_code']);
        
            // Validate data
            if (empty($edit_code) || empty($edit_name) || empty($edit_department_code)) {
                die("<div class='message error'>Error: Missing data. Please fill all fields.</div>");
            }
        
            // Check if subject exists
            $check_subject = mysqli_query($connection, "SELECT * FROM tbl_subject WHERE subject_code = '$edit_code'");
            if (mysqli_num_rows($check_subject) == 0) {
                $display = "<div class='message error'>Subject code does not exist.</div>";
            } else {
                // Update subject details
                $update_query = "UPDATE tbl_subject 
                                 SET subject_name = '$edit_name', department_code = '$edit_department_code' 
                                 WHERE subject_code = '$edit_code'";
        
                if (mysqli_query($connection, $update_query)) {
                    $successMessage = "Subject updated successfully!";
                } else {
                    echo "<script>alert('Failed to update subject.');</script>";
                }
            }
        }        
    }
    

    // Handle Subject Deletion
    if (isset($_GET["delete"])) {
        $subject_code = mysqli_real_escape_string($connection, $_GET["delete"]);
        $delete_query = "DELETE FROM tbl_subject WHERE subject_code = '$subject_code'";

        if (mysqli_query($connection, $delete_query)) {
            header("Location: subject.php?success=Subject deleted successfully");
            exit();
        } else {
            header("Location: subject.php?error=Failed to delete subject");
            exit();
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AU Portal | Subject</title>
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
            <li><a href="users.php"><i class="fas fa-users"></i> Users</a></li>
            <li><a href="school-year.php"><i class="fas fa-calendar"></i> School Year</a></li>
            <li><a href="department.php"><i class="fas fa-building"></i> Department</a></li>
            <li><a href="course.php"><i class="fas fa-book"></i> Course</a></li>
            <li><a href="subject.php" class="active"><i class="fas fa-chalkboard-teacher"></i> Subject</a></li>
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
        <h1 class="title">Subject Information</h1>

        <button class="add-btn" onclick="openModal()"> <i class="fas fa-plus"></i> Add New Subject</button>

        <?php if (isset($message)) echo $message; ?>

        <?php
            include("cn.php");
            $query = mysqli_query($connection, "SELECT * FROM tbl_subject");
            $rows = mysqli_num_rows($query); 
            if ($rows > 0) {
        ?>

        <table id="subject" class="styled-table">
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Name</th>
                    <th>Deparment Code</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($data = mysqli_fetch_assoc($query)) {
                ?>
                <tr>
                    <td><?php echo $data['subject_code']; ?></td>
                    <td><?php echo $data['subject_name']; ?></td>
                    <td><?php echo $data['department_code']; ?></td>
                    <td>
                        <button onclick="openEditModal('<?php echo $data['subject_code']; ?>', '<?php echo $data['subject_name']; ?>', '<?php echo $data['department_code']; ?>')" class="btn-edit"> <i class="fas fa-edit"></i> Edit</button>
                        <a href="javascript:void(0);" class="btn-delete" onclick="openDeleteModal('<?php echo $data['subject_code']; ?>')"> <i class="fas fa-trash"></i> Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="delete-modal">
                <div class="delete-modal-content">
                    <h2>Are you sure?</h2>
                    <p>Do you really want to delete this subject? This action cannot be undone.</p>
                    <input type="hidden" id="delete_subject_code">
                    <button class="btn-confirm" onclick="confirmDelete()">Yes, Delete</button>
                    <button class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                </div>
            </div>

            <script>
                function openDeleteModal(subject_code) {
                    document.getElementById("delete_subject_code").value = subject_code;
                    document.getElementById("deleteModal").style.display = "block";
                }

                function closeDeleteModal() {
                    document.getElementById("deleteModal").style.display = "none";
                }

                function confirmDelete() {
                    var subject_code = document.getElementById("delete_subject_code").value;
                    window.location.href = "subject.php?delete=" + subject_code;
                }
            </script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                $('#subject').DataTable();

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
                document.getElementById("subjectModal").style.display = "block";
            }

            function closeModal() {
                document.getElementById("subjectModal").style.display = "none";
            }

            function openEditModal(code, name, department) {
                document.getElementById("edit_subject_code").value = code;
                document.getElementById("edit_subject_name").value = name;
                document.getElementById("edit_department_code").value = department;
                // Ensure modal is displayed
                document.getElementById("editSubjectModal").style.display = "block";
            }

            // Close modal function
            function closeEditModal() {
                document.getElementById("editSubjectModal").style.display = "none";
            }

        </script>

        <!-- Add Modal -->
        <div id="subjectModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h1>Add New Subject</h1>

                <?php if (!empty($display)) echo $display; ?>

                <form action="" method="POST">
                    <input type="hidden" id="modal_status" value="<?php echo $modalOpen ? 'open' : 'closed'; ?>">

                    <label for="subject_code">Subject Code:</label>
                    <input type="text" name="subject_code" placeholder="Subject code"required>

                    <label for="subject_name">Subject Name:</label>
                    <input type="text" name="subject_name" placeholder="Subject name" required>

                    <label for="department_code">Department Code:</label>
                    <select name="department_code">
                        <option value="" disabled selected>Select a department</option>
                        <?php
                            $dept_query = mysqli_query($connection, "SELECT * FROM tbl_department"); 
                            while ($department = mysqli_fetch_assoc($dept_query)) {
                                echo "<option value='{$department['department_code']}'>{$department['department_code']}</option>";
                            }
                        ?>
                    </select>

                    <input type="submit" name="add_subject" value="Insert">
                </form>
            </div>
        </div>

        <!-- Edit Modal -->
        <div id="editSubjectModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeEditModal()">&times;</span>
                <h1>Edit Subject</h1>
                <form method="POST">
                    <label for="edit_subject_code">Subject Code:</label>
                    <input type="text" name="edit_subject_code" id="edit_subject_code" readonly> 
                    <br>
          
                    <label for="edit_subject_name">Subject Name:</label>
                    <input type="text" name="edit_subject_name" id="edit_subject_name" required>

                    <label for="edit_department_code">Department Code:</label>
                    <select name="edit_department_code" id="edit_department_code">
                        <option value="" disabled selected>Select a department</option>
                        <?php
                            $dept_query = mysqli_query($connection, "SELECT * FROM tbl_department"); 
                            while ($department = mysqli_fetch_assoc($dept_query)) {
                                echo '<option value="'.$department['department_code'].'">'.$department['department_code'].'</option>';
                            }
                        ?>
                    </select>

                    <input type="submit" name="edit_subject" value="Update">
                </form>
            </div>
        </div>

        <?php } ?>
        </div>
    </section>
    </body>
</html>