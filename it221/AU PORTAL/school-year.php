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

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
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
                if (mysqli_query($connection, "INSERT INTO tbl_school_year (school_year_code, school_year, semester, status) VALUES ('$school_year_code', '$school_year', '$semester', '$status')")) {
                    header("Location: school-year.php?success=School year added successfully");
                    exit();
                } else {
                    $display = "<div class='message error'>Failed to add school year.</div>";
                    $modalOpen = true;
                }
            }
        }

        // EDIT FUNCTION
        if (isset($_POST['edit_school_year'])) {
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
                    header("Location: school-year.php?success=School year updated successfully");
                    exit();
                } else {
                    die("<div class='message error'>Failed to update school year: " . mysqli_error($connection) . "</div>");
                }
            }
        }
    }
    

    // Handle department Deletion
    if (isset($_GET["delete"])) {
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
        <title>School Year Table</title>
        <link type="image/png" rel="icon" href="images/au_logo.png">
        <link rel="stylesheet" href="css/table.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    </head>
    <body>
        <!-- Sidebar Navigation -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <div class="user-con">
                <div class="img-con">
                    <img src="images/default.jpg" alt="Admin Image">
                </div>
                <div class="user-info">
                    Admin<br><?php echo $row["user_id"]; ?>
                </div>
            </div>
            <div class="close-icon" onclick="toggleSidebar()">&times;</div>
        </div>

        <ul class="nav-links">
            <li><a href="admin-profile.php">Profile</a></li>
            <li><a href="users.php">Users</a></li>
            <li><a href="school-year.php">School Year</a></li>
            <li><a href="department.php">Department</a></li>
            <li><a href="course.php">Course</a></li>
            <li><a href="subject.php">Subject</a></li>
            <li><a href="student.php">Student</a></li>
            <li><a href="faculty.php" class="active">Faculty</a></li>
            <li><a href="logout.php">Logout</a></li>
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
        <button class="add-btn" onclick="openModal()">Add New School Year</button>

        <?php
            include("cn.php");
            $query = mysqli_query($connection, "SELECT * FROM tbl_school_year");
            $rows = mysqli_num_rows($query); 
            if ($rows > 0) {
        ?>
        
        <h1 class="title">School Year Information</h1>

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
                            <button class="btn-edit" onclick="openEditModal('<?php echo $data['school_year_code']; ?>', '<?php echo $data['school_year']; ?>', '<?php echo $data['semester']; ?>', '<?php echo $data['status']; ?>')">Edit</button>
                            <a href="school-year.php?delete=<?php echo $data['school_year_code']; ?>" class="btn-delete" onclick="return confirm('Are you sure?');">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

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
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
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
                    <!-- Hidden field for school year code -->
                    <input type="hidden" name="edit_code" id="edit_code">

                    <label>School Year:</label>
                    <input type="text" name="edit_school_year_value" id="edit_school_year" required>

                    <label>Semester:</label>
                    <input type="text" name="edit_semester" id="edit_semester" required>

                    <label>Status:</label>
                    <select name="edit_status" id="edit_status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>

                    <input type="submit" name="edit_school_year" value="Update">
                </form>
            </div>
        </div>
        

        <?php } ?>
    </div>
    </section>
    </body>
</html>
