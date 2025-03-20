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

    $display = ""; 
    $modalOpen = false;

    $successMessage = "";

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // ADD STUDENT FUNCTION
        if (isset($_POST['add_student'])) {
            $student_no = mysqli_real_escape_string($connection, $_POST['student_no']);
            $first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
            $last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
            $middle_name = mysqli_real_escape_string($connection, $_POST['middle_name']);
            $course_code = mysqli_real_escape_string($connection, $_POST['course_code']);
            $year_level = mysqli_real_escape_string($connection, $_POST['year_level']);
            $password = mysqli_real_escape_string($connection, $_POST['password']);
            $hashed_password = md5($password);
    
            $check_student = mysqli_query($connection, "SELECT * FROM tbl_student_info WHERE student_no = '$student_no'");
            if (mysqli_num_rows($check_student) > 0) {
                $display = "<div class='message error'>Student no. already exists.</div>";
                $modalOpen = true;
            } else {
                $insert_query = "INSERT INTO tbl_student_info (student_no, first_name, last_name, middle_name, course_code, year_level, password) 
                                 VALUES ('$student_no', '$first_name', '$last_name', '$middle_name', '$course_code', '$year_level', '$hashed_password')";
                
                if (mysqli_query($connection, $insert_query)) {
                    $successMessage = "Student added successfully!";
                } else {
                    echo "<script>alert('Failed to add student.');</script>";
                }
            }
        }
    
        // EDIT STUDENT FUNCTION
        if (isset($_POST['edit_student'])) {
            $edit_student_no = mysqli_real_escape_string($connection, $_POST['edit_student_no']);
            $edit_first_name = mysqli_real_escape_string($connection, $_POST['edit_first_name']);
            $edit_last_name = mysqli_real_escape_string($connection, $_POST['edit_last_name']);
            $edit_middle_name = mysqli_real_escape_string($connection, $_POST['edit_middle_name']);
            $edit_course_code = mysqli_real_escape_string($connection, $_POST['edit_course_code']);
            $edit_year_level = mysqli_real_escape_string($connection, $_POST['edit_year_level']);
            $edit_password = mysqli_real_escape_string($connection, $_POST['edit_password']);
        
            if (!empty($edit_password)) {
                $hashed_password = md5($edit_password);
                $update_query = "UPDATE tbl_student_info 
                                 SET first_name = '$edit_first_name', last_name = '$edit_last_name', 
                                     middle_name = '$edit_middle_name', course_code = '$edit_course_code', 
                                     year_level = '$edit_year_level', password = '$hashed_password' 
                                 WHERE student_no = '$edit_student_no'";
            } else {
                $update_query = "UPDATE tbl_student_info 
                                 SET first_name = '$edit_first_name', last_name = '$edit_last_name', 
                                     middle_name = '$edit_middle_name', course_code = '$edit_course_code', 
                                     year_level = '$edit_year_level' 
                                 WHERE student_no = '$edit_student_no'";
            }
        
            if (mysqli_query($connection, $update_query)) {
                $successMessage = "Student updated successfully!";
            } else {
                echo "<script>alert('Failed to update student.');</script>";
            }
        }        
    }
    
    // Handle Student Deletion
    if (isset($_GET["delete"])) {
        $student_no = mysqli_real_escape_string($connection, $_GET["delete"]);
        $delete_query = "DELETE FROM tbl_student_info WHERE student_no = '$student_no'";

        if (mysqli_query($connection, $delete_query)) {
            header("Location: student.php?success=Student deleted successfully");
            exit();
        } else {
            header("Location: student.php?error=Failed to delete student");
            exit();
        }
    }
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AU Portal | Student</title>
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
            <li><a href="subject.php"><i class="fas fa-chalkboard-teacher"></i> Subject</a></li>
            <li><a href="student.php" class="active"><i class="fas fa-user-graduate"></i> Student</a></li>
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

        <h1 class="title">Student Information</h1>
    
        <button class="add-btn" onclick="openModal()"> <i class="fas fa-plus"></i> Add New Student</button>

        <?php
            include("cn.php");
            $query = mysqli_query($connection, "SELECT * FROM tbl_student_info");
            $rows = mysqli_num_rows($query); 
            if ($rows > 0) {
        ?>
        
            <table id="student_info" class="styled-table">
                <thead>
                    <tr>
                        <th>Student No.</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Course</th>
                        <th>Year Level</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($data = mysqli_fetch_assoc($query)) { ?>
                    <tr>
                        <td><?php echo $data['student_no']; ?></td>
                        <td><?php echo $data['last_name']; ?></td>
                        <td><?php echo $data['first_name']; ?></td>
                        <td><?php echo $data['middle_name']; ?></td>
                        <td><?php echo $data['course_code']; ?></td>
                        <td><?php echo $data['year_level']; ?></td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-edit" onclick="openEditModal('<?php echo $data['student_no']; ?>', '<?php echo $data['first_name']; ?>', '<?php echo $data['last_name']; ?>', '<?php echo $data['middle_name']; ?>', '<?php echo $data['course_code']; ?>', '<?php echo $data['year_level']; ?>')"> <i class="fas fa-edit"></i> Edit</button>
                                <a href="javascript:void(0);" class="btn-delete" onclick="openDeleteModal('<?php echo $data['student_no']; ?>')"> <i class="fas fa-trash"></i> Delete</a>
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
                    <p>Do you really want to delete this student? This action cannot be undone.</p>
                    <input type="hidden" id="delete_student_no">
                    <button class="btn-confirm" onclick="confirmDelete()">Yes, Delete</button>
                    <button class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                </div>
            </div>

            <script>
                function openDeleteModal(student_no) {
                    document.getElementById("delete_student_no").value = student_no;
                    document.getElementById("deleteModal").style.display = "block";
                }

                function closeDeleteModal() {
                    document.getElementById("deleteModal").style.display = "none";
                }

                function confirmDelete() {
                    var student_no = document.getElementById("delete_student_no").value;
                    window.location.href = "student.php?delete=" + student_no;
                }
            </script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                $('#student_info').DataTable();

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
                document.getElementById("studentModal").style.display = "block";
            }

            function closeModal() {
                document.getElementById("studentModal").style.display = "none";
            }

            function openEditModal(student_no, first_name, last_name, middle_name, course_code, year_level) {
                document.getElementById("edit_student_no").value = student_no;
                document.getElementById("edit_first_name").value = first_name;
                document.getElementById("edit_last_name").value = last_name;
                document.getElementById("edit_middle_name").value = middle_name;
                document.getElementById("edit_course_code").value = course_code;
                document.getElementById("edit_year_level").value = year_level;
                document.getElementById("editStudentModal").style.display = "block";
            }

            function closeEditModal() {
                document.getElementById("editStudentModal").style.display = "none";
            }
        </script>

        <!-- Add Student Modal -->
        <div id="studentModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h1>Add New Student</h1>

                <?php if (!empty($display)) echo $display; ?>

                <form action="" method="POST">
                    <input type="hidden" id="modal_status" value="<?php echo $modalOpen ? 'open' : 'closed'; ?>">

                    <label for="student_no">Student No.:</label>
                    <input type="text" name="student_no" placeholder="Student No." required> <br>

                    <label for="last_name">Last Name:</label>
                    <input type="text" name="last_name" placeholder="Last Name" required> <br>

                    <label for="first_name">First Name:</label>
                    <input type="text" name="first_name" placeholder="First Name" required> <br>

                    <label for="middle_name">Middle Name:</label>
                    <input type="text" name="middle_name" placeholder="Middle Name"> <br>

                    <label for="course_code">Course:</label>
                    <select name="course_code">
                        <option value="" disabled selected>Select a course</option>
                        <?php
                            $query = mysqli_query($connection, "SELECT * FROM tbl_course"); 
                            while ($data = mysqli_fetch_assoc($query)) {
                                echo "<option value='{$data['course_code']}'>{$data['course_code']}</option>";
                            }
                        ?>
                    </select> <br>

                    <label for="year_level">Year Level:</label>
                    <input type="number" name="year_level" placeholder="Year Level" min="1" max="4" required> <br>

                    <label for="password">Password:</label>
                    <input type="password" name="password" placeholder="Password" required> <br>

                    <input type="submit" name="add_student" value="Insert">
                </form>
            </div>
        </div>

        <!-- Edit Student Modal -->
        <div id="editStudentModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeEditModal()">&times;</span>
                <h1>Edit Student</h1>
                <form method="POST">
                    <label for="edit_student_no">Student No.:</label>
                    <input type="text" name="edit_student_no" id="edit_student_no" readonly> 
                    <br>

                    <label for="edit_last_name">Last Name:</label>
                    <input type="text" name="edit_last_name" id="edit_last_name" placeholder="Last Name" required> <br>

                    <label for="edit_first_name">First Name:</label>
                    <input type="text" name="edit_first_name" id="edit_first_name" placeholder="First Name" required> <br>

                    <label for="edit_middle_name">Middle Name:</label>
                    <input type="text" name="edit_middle_name" id="edit_middle_name" placeholder="Middle Name"> <br>

                    <label for="edit_course_code">Course:</label>
                    <select name="edit_course_code" id="edit_course_code">
                        <option value="" disabled selected>Select a course</option>
                        <?php
                            $query = mysqli_query($connection, "SELECT * FROM tbl_course"); 
                            while ($course = mysqli_fetch_assoc($query)) {
                                echo "<option value='{$course['course_code']}'>{$course['course_code']}</option>";
                            }
                        ?>
                    </select> <br>

                    <label for="edit_year_level">Year Level:</label>
                    <input type="number" name="edit_year_level" id="edit_year_level" placeholder="Year Level" min="1" max="4" required> <br>

                    <label for="edit_password">New Password (Leave blank to keep current):</label>
                    <input type="password" name="edit_password" id="edit_password" placeholder="Enter new password">
                    <br>

                    <input type="submit" name="edit_student" value="Update">
                </form>
            </div>
        </div>

        <?php } ?>
    </div>
    </section>
</body>
</html>
