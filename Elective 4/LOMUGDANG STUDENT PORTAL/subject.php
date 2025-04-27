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
$query = mysqli_query($connection, "SELECT * FROM tbl_subject");
$rows = mysqli_num_rows($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
</head>
<body>
<div class="main-con">
    <div class="left-con">
        <div class="user-con">
            <div class="img-con"><img src="images/profile.png"></div>
            <div class="user-info">Admin<br>Lomugdang, Junalyn</div>
        </div>
        <div class="menu-con">
            <a href="school_year.php">SCHOOL YEAR</a>
            <a href="department.php">DEPARTMENTS</a>
            <a href="subject.php" style="background-color: lightblue; border-radius: 7px; color: darkslategray;">SUBJECTS</a>
            <a href="faculty.php">FACULTY</a>
            <a href="students.php">STUDENTS</a>
            <a href="course.php">Courses</a>
            <a href="user.php">USERS</a>
            <a href="logout.php">LOGOUT</a>
        </div>
    </div>

    <div class="right-con">
        <div class="top-nav">
            <div class="brand">SUBJECT PORTAL</div>
        </div>
        <div class="body">
            <div class="content-title"><h1>SUBJECTS</h1></div>
            <div class="content">
                <a id="addSubjectBtn" class="action-button">+ Add New</a>

                <?php if ($rows > 0) { ?>
                <table id="subject_info" class="display">
                    <thead>
                        <tr>
                            <th>Subject Code</th>
                            <th>Subject Name</th>
                            <th>Department Code</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>        
                        <?php while ($data = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?php echo $data['subject_code']; ?></td>
                            <td><?php echo $data['subject_name']; ?></td>
                            <td><?php echo $data['department_code']; ?></td>
                            <td><a href="#" class="edit-subject" data-id="<?php echo htmlspecialchars($data['subject_code']); ?>">Edit</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Adding/Editing Subject -->
<div id="subjectModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 id="modalTitle">Add Subject</h2>
        <form id="subjectForm">
            <input type="hidden" id="edit_mode" name="edit_mode" value="false">
            
            <label>Subject Code</label>
            <input type="text" id="subject_code" name="subject_code" required>
            
            <label>Subject Name</label>
            <input type="text" id="subject_name" name="subject_name" required>

           <div class="subject-container" style="margin-bottom: 20px; max-width: 400px;">
    <label>Department Code</label>
    <select id="department_code" name="department_code" required 
        style="width: 100%; height: 45px; font-size: 18px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; background-color: #fff; cursor: pointer;">
        <option value="">Select Department</option>
        <?php
        include("cn.php");
        $query = "SELECT department_code FROM tbl_department";
        $result = mysqli_query($connection, $query);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['department_code'] . "'>" . $row['department_code'] . "</option>";
            }
        } else {
            echo "<option value=''>Error loading departments</option>";
        }
        mysqli_close($connection);
        ?>
    </select>
</div>


            <button type="submit" class="save-btn">Save</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#subject_info').DataTable();

        $(".action-button").click(function() {
            $("#modalTitle").text("Add Subject");
            $("#subjectForm")[0].reset();
            $("#edit_mode").val("false");
            $("#subject_code").prop("readonly", false);
            $("#subjectModal").show();
        });

        $(document).on("click", ".edit-subject", function(e) {
            e.preventDefault();
            var subject_code = $(this).data("id");

            $.ajax({
                url: "fetch_subject.php",
                type: "POST",
                data: { subject_code: subject_code },
                dataType: "json",
                success: function(data) {
                    if (!data) {
                        alert("No subject data found!");
                        return;
                    }
                    $("#modalTitle").text("Edit Subject");
                    $("#edit_mode").val("true");
                    $("#subject_code").val(data.subject_code).prop("readonly", true);
                    $("#subject_name").val(data.subject_name);
                    $("#department_code").val(data.department_code);
                    $("#subjectModal").show();
                },
                error: function(xhr) {
                    console.log("AJAX Error:", xhr.responseText);
                    alert("Error fetching subject details.");
                }
            });
        });

        $(".close").click(function() {
            $("#subjectModal").hide();
        });

        $("#subjectForm").submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "save_subject.php",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    alert(response);
                    $("#subjectModal").hide();
                    location.reload();
                }
            });
        });

        $(window).click(function(event) {
            if (event.target.id === "subjectModal") {
                $("#subjectModal").hide();
            }
        });
    });
</script>


</body>
</html>