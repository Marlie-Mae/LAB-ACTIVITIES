<?php 
include("cn.php");
session_start(); // Start session

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit();
}

// Redirect regular users to profile.php if they try accessing other pages
if ($_SESSION['account_type'] === 'User' && basename($_SERVER['PHP_SELF']) !== 'profile.php') {
    header("location: profile.php");
    exit();
}

// Prevent admins from accessing profile.php
if ($_SESSION['account_type'] === 'Admin' && basename($_SERVER['PHP_SELF']) === 'profile.php') {
    header("location: user.php"); // Redirect admins elsewhere (e.g., users page)
    exit();
}
$query = mysqli_query($connection, "SELECT * FROM tbl_department");
$rows = mysqli_num_rows($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
</head>
<body>
<div class="main-con">
    <div class="left-con">
        <div class="user-con">
            <div class="img-con"><img src="images/monkey.avif"></div>
            <div class="user-info">Admin<br>Buenacosa, Genesis A.</div>
        </div>
        <div class="menu-con">
            <a href="school_year.php">SCHOOL YEAR</a>
            <a href="department.php" style="background-color: lightblue; border-radius: 7px; color: darkslategray;">DEPARTMENTS</a>
            <a href="subject.php">SUBJECTS</a>
            <a href="faculty.php">FACULTY</a>
            <a href="students.php">STUDENTS</a>
            <a href="course.php">Courses</a>
            <a href="user.php">USERS</a>
            <a href="logout.php">LOGOUT</a>
        </div>
    </div>

    <div class="right-con">
        <div class="top-nav">
            <div class="brand">DEPARTMENT PORTAL</div>
        </div>
        <div class="body">
            <div class="content-title"><h1>DEPARTMENTS</h1></div>
            <div class="content">
                <a id="addDepartmentBtn" class="action-button">+ Add New</a>

                <?php if ($rows > 0) { ?>
                <table id="department_info" class="display">
                    <thead>
                        <tr>
                            <th>Department Code</th>
                            <th>Department Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>        
                        <?php while ($data = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($data['department_code']); ?></td>
                            <td><?php echo htmlspecialchars($data['department_name']); ?></td>
                            <td><a href="#" class="edit-department" data-id="<?php echo htmlspecialchars($data['department_code']); ?>">Edit</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Adding/Editing Department -->
<!-- Add Department Modal -->
<div id="addDepartmentModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add Department</h2>
        <form id="addDepartmentForm">
            <label>Department Code</label>
            <input type="text" id="add_department_code" name="department_code" required>
            <label>Department Name</label>
            <input type="text" id="add_department_name" name="department_name" required>
            <button type="submit" class="save-btn">Save</button>
        </form>
    </div>
</div>

<!-- Edit Department Modal -->
<div id="editDepartmentModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Department</h2>
        <form id="editDepartmentForm">
            <input type="hidden" id="edit_department_code" name="department_code">
            <label>Department Name</label>
            <input type="text" id="edit_department_name" name="department_name" required>
            <button type="submit" class="save-btn">Update</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#department_info').DataTable();

        // Open Add Department Modal
        $("#addDepartmentBtn").click(function() {
            $("#addDepartmentForm")[0].reset();
            $("#addDepartmentModal").show();
        });

        // Open Edit Department Modal
        $(document).on("click", ".edit-department", function(e) {
            e.preventDefault();
            var department_code = $(this).data("id");

            $.ajax({
                url: "fetch_department.php",
                type: "POST",
                data: { department_code: department_code },
                dataType: "json",
                success: function(data) {
                    if (!data) {
                        alert("No department data found!");
                        return;
                    }
                    $("#edit_department_code").val(data.department_code);
                    $("#edit_department_name").val(data.department_name);
                    $("#editDepartmentModal").show();
                },
                error: function(xhr) {
                    console.log("AJAX Error:", xhr.responseText);
                    alert("Error fetching department details.");
                }
            });
        });

        // Close modals when clicking "X"
        $(".close").click(function() {
            $(".modal").hide();
        });

        // Handle Add Department Form Submission
        $("#addDepartmentForm").submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "save_department.php",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    alert(response);
                    $("#addDepartmentModal").hide();
                    location.reload();
                }
            });
        });

        // Handle Edit Department Form Submission
        $("#editDepartmentForm").submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "save_department.php",
                type: "POST",
                data: $(this).serialize() + "&edit_mode=true", // Pass edit_mode flag
                success: function(response) {
                    if (response.trim() === "success") {
                        alert("Department updated successfully!");
                        $("#editDepartmentModal").hide();
                        location.reload();
                    } else {
                        alert(response);
                    }
                },
                error: function() {
                    alert("Error updating department.");
                }
            });
        });

        // Close modals when clicking outside
        $(window).click(function(event) {
            if (event.target.id === "addDepartmentModal") {
                $("#addDepartmentModal").hide();
            } else if (event.target.id === "editDepartmentModal") {
                $("#editDepartmentModal").hide();
            }
        });
    });
</script>
</body>
</html>
