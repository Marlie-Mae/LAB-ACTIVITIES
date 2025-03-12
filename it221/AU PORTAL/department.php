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
        if (isset($_POST['add_department'])) {
            $department_code = mysqli_real_escape_string($connection, $_POST['department_code']);
            $department_name = mysqli_real_escape_string($connection, $_POST['department_name']);

            $check_department_code = mysqli_query($connection, "SELECT * FROM tbl_department WHERE department_code = '$department_code'");
            if (mysqli_num_rows($check_department_code) > 0) {
                $display = "<div class='message error'>Department code already exists.</div>";
                $modalOpen = true;
            } else {
                $insert_query = "INSERT INTO tbl_department (department_code, department_name) VALUES ('$department_code', '$department_name')";
                
                if (mysqli_query($connection, $insert_query)) {
                    $successMessage = "Department added successfully!";
                } else {
                    echo "<script>alert('Failed to add department.');</script>";
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
                    $successMessage = "Department updated successfully!";
                } else {
                    echo "<script>alert('Failed to update department.');</script>";
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
    <title>AU Portal | Department</title>
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
            <li><a href="department.php" class="active"><i class="fas fa-building"></i> Department</a></li>
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
        <h1 class="title">Department Information</h1>

        <button class="add-btn" onclick="openModal()"> <i class="fas fa-plus"></i> Add New Department</button>

        <?php if (isset($message)) echo $message; ?>

        <?php
            include("cn.php");
            $query = mysqli_query($connection, "SELECT * FROM tbl_department");
            $rows = mysqli_num_rows($query); 
            if ($rows > 0) {
        ?>

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
                            <button class="btn-edit" onclick="openEditModal('<?php echo $data['department_code']; ?>', '<?php echo $data['department_name']; ?>')"> <i class="fas fa-edit"></i> Edit</button>
                            <a href="javascript:void(0);" class="btn-delete" onclick="openDeleteModal('<?php echo $data['department_code']; ?>')"> <i class="fas fa-trash"></i> Delete</a>
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
                    <p>Do you really want to delete this department? This action cannot be undone.</p>
                    <input type="hidden" id="delete_department_code">
                    <button class="btn-confirm" onclick="confirmDelete()">Yes, Delete</button>
                    <button class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                </div>
            </div>

            <script>
                function openDeleteModal(department_code) {
                    document.getElementById("delete_department_code").value = department_code;
                    document.getElementById("deleteModal").style.display = "block";
                }

                function closeDeleteModal() {
                    document.getElementById("deleteModal").style.display = "none";
                }

                function confirmDelete() {
                    var department_code = document.getElementById("delete_department_code").value;
                    window.location.href = "department.php?delete=" + department_code;
                }
            </script>

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