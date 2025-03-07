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
        if (isset($_POST['add_department'])) {
            $department_code = mysqli_real_escape_string($connection, $_POST['department_code']);
            $department_name = mysqli_real_escape_string($connection, $_POST['department_code']);

            $check_department_code = mysqli_query($connection, "SELECT * FROM tbl_department WHERE department_code = '$department_code'");
            if (mysqli_num_rows($check_department_code) > 0) {
                $display = "<div class='message error'>Department code already exists.</div>";
                $modalOpen = true;
            } else {
                if (mysqli_query($connection, "INSERT INTO tbl_department (department_code, department_name) VALUES ('$department_code', '$department_name')")) {
                    header("Location: department.php?success=Department added successfully");
                    exit();
                } else {
                    $display = "<div class='message error'>Failed to add department.</div>";
                    $modalOpen = true;
                }
            }
        }

        if (isset($_POST['edit_department'])) {
            $edit_code = mysqli_real_escape_string($connection, $_POST['edit_code']);
            $edit_name = mysqli_real_escape_string($connection, $_POST['edit_name']);

            // Check if department exists before updating
            $check_department = mysqli_query($connection, "SELECT * FROM tbl_department WHERE department_code = '$edit_code'");
            if (mysqli_num_rows($check_department) == 0) {
                $display = "<div class='message error'>Department code does not exist.</div>";
            } else {
                $update_query = "UPDATE tbl_department SET department_name = '$edit_name' WHERE department_code = '$edit_code'";
                if (mysqli_query($connection, $update_query)) {
                    header("Location: department.php?success=Department updated successfully");
                    exit();
                } else {
                    $display = "<div class='message error'>Failed to update department: " . mysqli_error($connection) . "</div>";
                }
            }
        }
    }

    // Handle department Deletion
    if (isset($_GET["delete"])) {
        $department_code = mysqli_real_escape_string($connection, $_GET["delete"]);
        $delete_query = "DELETE FROM tbl_department WHERE department_code = '$department_code'";

        if (mysqli_query($connection, $delete_query)) {
            header("Location: department.php?success=department deleted successfully");
            exit();
        } else {
            header("Location: department.php?error=Failed to delete department");
            exit();
        }
    }
    

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Department Table</title>
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
        <li><a href="department.php" class="active">Department</a></li>
        <li><a href="course.php">Course</a></li>
        <li><a href="subject.php">Subject</a></li>
        <li><a href="student.php">Student</a></li>
        <li><a href="faculty.php">Faculty</a></li>
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
        <button class="add-btn" onclick="openModal()">Add New Department</button>

        <?php if (isset($message)) echo $message; ?>

        <?php
            include("cn.php");
            $query = mysqli_query($connection, "SELECT * FROM tbl_department");
            $rows = mysqli_num_rows($query); 
            if ($rows > 0) {
        ?>

        <h1 class="title">Department Information</h1>

        <table id="department" class="styled-table">
            <thead>
                <tr>
                    <th>Department Code</th>
                    <th>Department Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $query = mysqli_query($connection, "SELECT * FROM tbl_department");
                    while ($data = mysqli_fetch_assoc($query)) {
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($data['department_code']); ?></td>
                    <td><?php echo htmlspecialchars($data['department_name']); ?></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-edit" onclick="openEditModal('<?php echo $data['department_code']; ?>', '<?php echo $data['department_name']; ?>')">Edit</button>
                            <a href="department.php?delete=<?php echo $data['department_code']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this department?');">Delete</a>
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
                $('#department').DataTable();

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
                document.getElementById("departmentModal").style.display = "block";
            }

            function closeModal() {
                document.getElementById("departmentModal").style.display = "none";
            }
            function openEditModal(code, name) {
                document.getElementById("edit_code").value = code;
                document.getElementById("edit_name").value = name;
                document.getElementById("editdepartmentModal").style.display = "block";
            }

            function closeEditModal() {
                document.getElementById("editdepartmentModal").style.display = "none";
            }
        </script>

        <!-- Add department Modal -->
        <div id="departmentModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h1>Add New Department</h1>

                <?php if (!empty($display)) echo $display; ?>

                <form action="" method="POST">
                    <input type="hidden" id="modal_status" value="<?php echo $modalOpen ? 'open' : 'closed'; ?>">

                    <label for="department_code">Department Code:</label>
                    <input type="text" name="department_code" placeholder="Department code" required> <br>

                    <label for="department_name">Department Name:</label>
                    <input type="text" name="department_name" placeholder="Department name" required> <br>

                    <input type="submit" name="add_department" value="Insert">
                </form>
            </div>
        </div>

        <!-- Edit department Modal -->
        <div id="editdepartmentModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeEditModal()">&times;</span>
                <h1>Edit Department</h1>
                <form method="POST">
                    <input type="hidden" name="edit_code" id="edit_code">
                    <label>Department Name:</label>
                    <input type="text" name="edit_name" id="edit_name" required>
                    <input type="submit" name="edit_department" value="Update">
                </form>
            </div>
        </div>

        <?php } ?>
    </div>

</section>
</body>
</html>
