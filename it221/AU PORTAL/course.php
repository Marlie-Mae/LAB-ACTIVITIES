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
        if (isset($_POST['add_course'])) {
            $course_code = mysqli_real_escape_string($connection, $_POST['course_code']);
            $course_name = mysqli_real_escape_string($connection, $_POST['course_name']);
    
            $check_course_code = mysqli_query($connection, "SELECT * FROM tbl_course WHERE course_code = '$course_code'");
            if (mysqli_num_rows($check_course_code) > 0) {
                $display = "<div class='message error'>Course code already exists.</div>";
                $modalOpen = true;
            } else {
                $insert_query = "INSERT INTO tbl_course (course_code, course_description) VALUES ('$course_code', '$course_name')";
                
                if (mysqli_query($connection, $insert_query)) {
                    $successMessage = "Course added successfully!";
                } else {
                    echo "<script>alert('Failed to add course.');</script>";
                }
            }
        }

        if (isset($_POST['edit_course'])) {
            $edit_code = mysqli_real_escape_string($connection, $_POST['edit_code']);
            $edit_name = mysqli_real_escape_string($connection, $_POST['edit_name']);

            // Check if course exists before updating
            $check_course = mysqli_query($connection, "SELECT * FROM tbl_course WHERE course_code = '$edit_code'");
            if (mysqli_num_rows($check_course) == 0) {
                $display = "<div class='message error'>Course code does not exist.</div>";
            } else {
                $update_query = "UPDATE tbl_course SET course_description = '$edit_name' WHERE course_code = '$edit_code'";
                if (mysqli_query($connection, $update_query)) {
                    $successMessage = "Course updated successfully!";
                } else {
                    echo "<script>alert('Failed to update course.');</script>";
                }
            }
        }
    }

    // Handle Course Deletion
    if (isset($_GET["delete"])) {
        $course_code = mysqli_real_escape_string($connection, $_GET["delete"]);
        $delete_query = "DELETE FROM tbl_course WHERE course_code = '$course_code'";

        if (mysqli_query($connection, $delete_query)) {
            header("Location: course.php?success=Course deleted successfully");
            exit();
        } else {
            header("Location: course.php?error=Failed to delete course");
            exit();
        }
    }
    

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AU Portal | Course</title>
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
            <li><a href="course.php" class="active"><i class="fas fa-book"></i> Course</a></li>
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

        <h1 class="title">Course Information</h1>

        <button class="add-btn" onclick="openModal()"> <i class="fas fa-plus"></i> Add New Course</button>

        <?php if (isset($message)) echo $message; ?>

        <?php
            include("cn.php");
            $query = mysqli_query($connection, "SELECT * FROM tbl_course");
            $rows = mysqli_num_rows($query); 
            if ($rows > 0) {
        ?>

        <table id="course" class="styled-table">
            <thead>
                <tr>
                    <th>Course Code</th>
                    <th>Course Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $query = mysqli_query($connection, "SELECT * FROM tbl_course");
                    while ($data = mysqli_fetch_assoc($query)) {
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($data['course_code']); ?></td>
                    <td><?php echo htmlspecialchars($data['course_description']); ?></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-edit" onclick="openEditModal('<?php echo $data['course_code']; ?>', '<?php echo $data['course_description']; ?>')"> <i class="fas fa-edit"></i> Edit</button>
                            <a href="javascript:void(0);" class="btn-delete" onclick="openDeleteModal('<?php echo $data['course_code']; ?>')"> <i class="fas fa-trash"></i> Delete</a>
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
                    <p>Do you really want to delete this course? This action cannot be undone.</p>
                    <input type="hidden" id="delete_course_code">
                    <button class="btn-confirm" onclick="confirmDelete()">Yes, Delete</button>
                    <button class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                </div>
            </div>

            <script>
                function openDeleteModal(course_code) {
                    document.getElementById("delete_course_code").value = course_code;
                    document.getElementById("deleteModal").style.display = "block";
                }

                function closeDeleteModal() {
                    document.getElementById("deleteModal").style.display = "none";
                }

                function confirmDelete() {
                    var course_code = document.getElementById("delete_course_code").value;
                    window.location.href = "course.php?delete=" + course_code;
                }
            </script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
        <script>
                $(document).ready(function() {
                $('#course').DataTable();

                // Check if modal should be open
                if (document.getElementById("modal_status").value === "open") {
                    openModal();
                }
            });

            function toggleSidebar() {
                var sidebar = document.querySelector('.sidebar');
                var hamburger = document.querySelector('.hamburger');
                var closeIcon = document.querySelector('.close-icon');

                sidebar.classList.toggle('active');

                if (sidebar.classList.contains('active')) {
                    hamburger.style.display = "none";
                    closeIcon.style.display = "block";
                } else {
                    hamburger.style.display = "block";
                    closeIcon.style.display = "none";
                }
            }

            function openModal() {
                document.getElementById("courseModal").style.display = "block";
            }

            function closeModal() {
                document.getElementById("courseModal").style.display = "none";
            }
            function openEditModal(code, name) {
                document.getElementById("edit_code").value = code;
                document.getElementById("edit_name").value = name;
                document.getElementById("editCourseModal").style.display = "block";
            }

            function closeEditModal() {
                document.getElementById("editCourseModal").style.display = "none";
            }
        </script>

        <!-- Add Course Modal -->
        <div id="courseModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h1>Add New Course</h1>

                <?php if (!empty($display)) echo $display; ?>

                <form action="" method="POST">
                    <input type="hidden" id="modal_status" value="<?php echo $modalOpen ? 'open' : 'closed'; ?>">

                    <label for="course_code">Course Code:</label>
                    <input type="text" name="course_code" placeholder="Course code" required> <br>

                    <label for="course_name">Course Name:</label>
                    <input type="text" name="course_name" placeholder="Course name" required> <br>

                    <input type="submit" name="add_course" value="Insert">
                </form>
            </div>
        </div>

        <!-- Edit Course Modal -->
        <div id="editCourseModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeEditModal()">&times;</span>
                <h1>Edit Course</h1>
                <form method="POST">
                    <input type="hidden" name="edit_code" id="edit_code">
                    <label>Course Name:</label>
                    <input type="text" name="edit_name" id="edit_name" required>
                    <input type="submit" name="edit_course" value="Update">
                </form>
            </div>
        </div>

        <?php } ?>
    </div>

</section>
</body>
</html>