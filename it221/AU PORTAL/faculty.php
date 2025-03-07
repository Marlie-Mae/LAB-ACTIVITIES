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
        // ADD FACULTY FUNCTION
        if (isset($_POST['add_faculty'])) {
            $faculty_code = mysqli_real_escape_string($connection, $_POST['faculty_code']);
            $faculty_name = mysqli_real_escape_string($connection, $_POST['faculty_name']);
            $department_code = mysqli_real_escape_string($connection, $_POST['department_code']);
            $password = mysqli_real_escape_string($connection, $_POST['password']);
            $hashed_password = md5($password);
    
            $check_faculty = mysqli_query($connection, "SELECT * FROM tbl_faculty WHERE faculty_code = '$faculty_code'");
            if (mysqli_num_rows($check_faculty) > 0) {
                $display = "<div class='message error'>Faculty code already exists.</div>";
                $modalOpen = true;
            } else {
                if (mysqli_query($connection, "INSERT INTO tbl_faculty (faculty_code, faculty_name, department_code, password) VALUES ('$faculty_code', '$faculty_name', '$department_code', '$hashed_password')")) {
                    header("Location: faculty.php?success=Faculty added successfully");
                    exit();
                } else {
                    $display = "<div class='message error'>Failed to add faculty.</div>";
                    $modalOpen = true;
                }
            }
        }
    
        // EDIT FACULTY FUNCTION
        if (isset($_POST['edit_faculty'])) {
            $edit_code = mysqli_real_escape_string($connection, $_POST['edit_code']);
            $edit_name = mysqli_real_escape_string($connection, $_POST['edit_name']);
            $edit_department_code = mysqli_real_escape_string($connection, $_POST['edit_department_code']);
    
            // Debugging: Check if data is received
            if (empty($edit_code) || empty($edit_name) || empty($edit_department_code)) {
                die("<div class='message error'>Error: Missing data. Please fill all fields.</div>");
            }
    
            // Check if faculty exists
            $check_faculty = mysqli_query($connection, "SELECT * FROM tbl_faculty WHERE faculty_code = '$edit_code'");
            if (mysqli_num_rows($check_faculty) == 0) {
                $display = "<div class='message error'>Faculty code does not exist.</div>";
            } else {
                // Update faculty details
                $update_query = "UPDATE tbl_faculty 
                                 SET faculty_name = '$edit_name', department_code = '$edit_department_code' 
                                 WHERE faculty_code = '$edit_code'";
    
                if (mysqli_query($connection, $update_query)) {
                    header("Location: faculty.php?success=Faculty updated successfully");
                    exit();
                } else {
                    die("<div class='message error'>Failed to update faculty: " . mysqli_error($connection) . "</div>");
                }
            }
        }
    }
    

    // Handle department Deletion
    if (isset($_GET["delete"])) {
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
        <title>Faculty Table</title>
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
        <button class="add-btn" onclick="openModal()">Add New Faculty</button>

        <?php if (isset($message)) echo $message; ?>

        <?php
            include("cn.php");
            $query = mysqli_query($connection, "SELECT * FROM tbl_faculty");
            $rows = mysqli_num_rows($query); 
            if ($rows > 0) {
        ?>

        <h1 class="title">Faculty Information</h1>

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
                            <button class="btn-edit" onclick="openEditModal('<?php echo $data['faculty_code']; ?>', '<?php echo $data['faculty_name']; ?>', '<?php echo $data['department_code']; ?>')">Edit</button>
                            <a href="faculty.php?delete=<?php echo $data['faculty_code']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this faculty?');">Delete</a>
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
                    <input type="hidden" name="edit_code" id="edit_code">
                    
                    <label for="faculty_name">Faculty Name</label>
                    <input type="text" name="edit_name" id="edit_name" required> <br>

                    <label for="department_code">Department Code</label>
                    <select name="edit_department_code" id="edit_department_code">
                        <option value="" disabled selected>Select a department</option>
                        <?php
                        include('cn.php'); // Ensure your DB connection is included
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
                    
                    <input type="submit" name="edit_faculty" value="Update">
                </form>
            </div>
        </div>

    <?php } ?>
    </div>
</section>
</body>
</html>
