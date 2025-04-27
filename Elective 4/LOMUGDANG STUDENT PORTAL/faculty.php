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

$query = mysqli_query($connection, "SELECT * FROM tbl_faculty");
$rows = mysqli_num_rows($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
</head>
<body>
<div class="main-con">
    <div class="left-con">
        <div class="user-con">
            <div class="img-con"><img src="images/profile.png" alt="User Image"></div>
            <div class="user-info"><?php echo $_SESSION['account_type']; ?><br>Lomugdang, Junalyn</div>
        </div>
        <div class="menu-con">
            <a href="school_year.php">SCHOOL YEAR</a>
            <a href="department.php">DEPARTMENTS</a>
            <a href="subject.php">SUBJECTS</a>
            <a href="faculty.php" style="background-color: lightblue; border-radius: 7px; color: darkslategray;">FACULTY</a>
            <a href="students.php">STUDENTS</a>
            <a href="course.php">Courses</a>
            <a href="user.php">USERS</a>
            <a href="logout.php">LOGOUT</a>
        </div>
    </div>

    <div class="right-con">
        <div class="top-nav">
            <div class="brand">FACULTY PORTAL</div>
        </div>
        <div class="body">
            <div class="content-title"><h1>FACULTY</h1></div>
            <div class="content">
                <a id="addFacultyBtn" class="action-button">+ Add New</a>

                <?php if ($rows > 0) { ?>
                <table id="faculty_info" class="display">
                    <thead>
                        <tr>
                            <th>Faculty Code</th>
                            <th>Faculty Name</th>
                            <th>Department Code</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>        
                        <?php while ($data = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?php echo $data['faculty_code']; ?></td>
                            <td><?php echo $data['faculty_name']; ?></td>
                            <td><?php echo $data['department_code']; ?></td>
                            <td><a href="#" class="edit-faculty" data-id="<?php echo htmlspecialchars($data['faculty_code']); ?>">Edit</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Adding/Editing Faculty -->
<!-- Modal for Adding Faculty -->
<div id="addFacultyModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add Faculty</h2>
        <form id="addFacultyForm" action="save_faculty.php" method="POST">
            <label>Faculty Code</label>
            <input type="text" id="faculty_code" name="faculty_code" required>
            
            <label>Faculty Name</label>
            <input type="text" id="faculty_name" name="faculty_name" required>
            
            <label>Password</label>
            <input type="password" id="password" name="password" required>
            
            <div class="department_code-container">
                <label>Department Code</label>
                <select id="department_code" name="department_code" required>
                    <option value="">Select Department</option>
                    <?php
                    $query = "SELECT department_code FROM tbl_department";
                    $result = mysqli_query($connection, $query);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['department_code'] . "'>" . $row['department_code'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Error loading departments</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="save-btn">Save</button>
        </form>
    </div>
</div>

<!-- Modal for Editing Faculty -->
<div id="editFacultyModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Faculty</h2>
        <form id="editFacultyForm" action="save_faculty.php" method="POST">
            <label>Faculty Code</label>
            <input type="text" id="edit_faculty_code" name="faculty_code" readonly required>
            
            <label>Faculty Name</label>
            <input type="text" id="edit_faculty_name" name="faculty_name" required>
            
            <div class="department_code-container">
                <label>Department Code</label>
                <select id="edit_department_code" name="department_code" required>
                    <option value="">Select Department</option>
                    <?php
                    $query = "SELECT department_code FROM tbl_department";
                    $result = mysqli_query($connection, $query);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row['department_code'] . "'>" . $row['department_code'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Error loading departments</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="save-btn">Save Changes</button>
        </form>
    </div>
</div>

<script>
  $(document).ready(function() {
    // Initialize DataTable
    $('#faculty_info').DataTable();

    // Open Add Faculty modal
    $(".action-button").click(function() {
        $("#addFacultyForm")[0].reset(); // Reset form fields for adding
        $("#addFacultyModal").show();  // Show Add Faculty modal
    });

    // Open Edit Faculty modal and fetch data for editing
    $(document).on("click", ".edit-faculty", function(e) {
        e.preventDefault();
        var faculty_code = $(this).data("id");

        $.ajax({
            url: "fetch_faculty.php",  // Fetch data from server for editing
            type: "POST",
            data: { faculty_code: faculty_code },
            dataType: "json",
            success: function(data) {
                if (!data) {
                    alert("No faculty data found!");
                    return;
                }
                // Fill Edit Faculty modal with existing data
                $("#edit_faculty_code").val(data.faculty_code);  // Read-only
                $("#edit_faculty_name").val(data.faculty_name);
                $("#edit_department_code").val(data.department_code);
                $("#editFacultyModal").show();  // Show Edit Faculty modal
            }
        });
    });

    // Close modals when 'x' is clicked
    $(".close").click(function() {
        $("#addFacultyModal").hide();
        $("#editFacultyModal").hide();
    });

    // Close modals when clicking outside of it
    $(window).click(function(event) {
        if (event.target.id === "addFacultyModal" || event.target.id === "editFacultyModal") {
            $("#addFacultyModal").hide();
            $("#editFacultyModal").hide();
        }
    });

    // Handle form submission for adding faculty
    $("#addFacultyForm").submit(function(e) {
        e.preventDefault();  // Prevent the default form submission

        $.ajax({
            url: "save_faculty.php",  // Server-side script for saving faculty
            type: "POST",
            data: $(this).serialize(),  // Send serialized form data
            success: function(response) {
                if (response.trim() === "success") {
                    alert("Faculty record added successfully.");
                    location.reload();  // Reload the page to update the table
                } else {
                    alert(response);  // Show error message
                }
                $("#addFacultyModal").hide();  // Close Add Faculty modal
            }
        });
    });

    // Handle form submission for editing faculty
    $("#editFacultyForm").submit(function(e) {
        e.preventDefault();  // Prevent the default form submission

        $.ajax({
            url: "save_faculty.php",  // Server-side script for updating faculty
            type: "POST",
            data: $(this).serialize(),  // Send serialized form data
            success: function(response) {
                if (response.trim() === "success") {
                    alert("Faculty record updated successfully.");
                    location.reload();  // Reload the page to reflect changes
                } else {
                    alert(response);  // Show error message
                }
                $("#editFacultyModal").hide();  // Close Edit Faculty modal
            }
        });
    });
});

</script>
</body>
</html>
