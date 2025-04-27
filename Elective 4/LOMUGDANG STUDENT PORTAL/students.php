<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal | Students</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="main-con">
        <div class="left-con">
            <div class="user-con">
                <div class="img-con"><img src="images/profile.png" alt="User Image"></div>
                <div class="user-info">Admin<br>Lomugdang, Junalyn</div>
            </div>
            <div class="menu-con">
                <a href="school_year.php">SCHOOL YEAR</a>
                <a href="department.php">DEPARTMENTS</a>
                <a href="subject.php">SUBJECTS</a>
                <a href="faculty.php">FACULTY</a>
                <a href="students.php" style="background-color: lightblue; border-radius: 7px; color: darkslategray;">STUDENTS</a>
                <a href="course.php">Courses</a>
                <a href="user.php">USERS</a>
                <a href="logout.php">LOGOUT</a>
            </div>
        </div>
        
        <div class="right-con">
            <div class="top-nav">
                <div class="brand">STUDENT PORTAL</div>
            </div>
            <div class="body">
                <div class="content-title">
                    <h1>STUDENTS</h1>
                </div>
                <div class="content">
                    <a id="addStudentBtn" class="action-button">+ Add New</a> 
                    <?php 
                        include("cn.php");
                        session_start();
                        if (!isset($_SESSION['user_id'])) {
                            header("location: login.php");
                            exit();
                        }
                        if ($_SESSION['account_type'] === 'User' && basename($_SERVER['PHP_SELF']) !== 'profile.php') {
                            header("location: profile.php");
                            exit();
                        }
                        if ($_SESSION['account_type'] === 'Admin' && basename($_SERVER['PHP_SELF']) === 'profile.php') {
                            header("location: user.php");
                            exit();
                        }
                        $query = mysqli_query($connection, "SELECT * FROM tbl_student_info");
                        $rows = mysqli_num_rows($query);
                        if ($rows > 0) {
                    ?>
                    <table id="student_info" class="display">
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
                        <?php 
                            while ($data = mysqli_fetch_assoc($query)) {
                        ?>
                        <tr>
                            <td><?php echo $data['student_no']; ?></td>
                            <td><?php echo $data['last_name']; ?></td>
                            <td><?php echo $data['first_name']; ?></td>
                            <td><?php echo $data['middle_name']; ?></td>
                            <td><?php echo $data['course_code']; ?></td>
                            <td><?php echo $data['year_level']; ?></td>
                            <td>
                                <a href="#" class="edit-student" data-id="<?php echo htmlspecialchars($data['student_no']); ?>">Edit</a>
                                <a href="#" class="student-change-password" data-id="<?php echo htmlspecialchars($data['student_no']); ?>">Change</a>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div id="changePasswordModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Change Password</h2>
        <form id="changePasswordForm">
            <input type="hidden" id="change-student_no" name="student_no">
            <label>New Password</label>
            <input type="password" id="new_password" name="new_password" required>
            <label>Re-enter New Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <button type="submit" class="save-btn">Change</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).on("click", ".student-change-password", function(e) {
            e.preventDefault();
            var student_no = $(this).data("id"); // Corrected data attribute retrieval
            $("#change-student_no").val(student_no); // Assign correct value
            $("#changePasswordModal").show();
        });

        $(".close").click(function() {
            $("#changePasswordModal").hide();
        });

        $("#changePasswordForm").submit(function(e) {
            e.preventDefault();
            var newPassword = $("#new_password").val();
            var confirmPassword = $("#confirm_password").val();

            if (newPassword !== confirmPassword) {
                alert("Passwords do not match!");
                return;
            }

            $.ajax({
                url: "student_change_password.php",
                type: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    alert(response);
                    $("#changePasswordModal").hide();
                    location.reload();
                }
            });
        });
    });
</script>

                    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('#student_info').DataTable();
                        });

                        // Open modal for "Add New"
                        $("#addStudentBtn").click(function() {
                            $("#addStudentModal").show();
                            $("#studentForm")[0].reset(); // Reset form
                            $("#student_no").val(""); // Clear student_no
                            $("#password").show(); // Show password field for adding
                        });

                        // Open modal for "Edit"
                        $(document).on("click", ".edit-student", function(e) {
                            e.preventDefault();
                            var student_no = $(this).data("id");

                            $.ajax({
                                url: "fetch_students.php",
                                type: "POST",
                                data: { student_no: student_no },
                                dataType: "json",
                                success: function(data) {
                                    if (!data) {
                                        alert("No student data found!");
                                        return;
                                    }
                                    // Open Edit Student Modal and populate fields
                                    $("#editStudentModal").show();
                                    $("#edit_student_no").val(data.student_no);
                                    $("#edit_last_name").val(data.last_name);
                                    $("#edit_first_name").val(data.first_name);
                                    $("#edit_middle_name").val(data.middle_name);
                                    $("#edit_course_code").val(data.course_code);
                                    $("#edit_year_level").val(data.year_level);
                                    $("#edit_password").hide(); // Hide password field when editing
                                },
                                error: function(xhr, status, error) {
                                    alert("Error fetching student details.");
                                }
                            });
                        });

                        $(".close").click(function() {
                            $(".modal").hide();
                        });

                        // Handle form submission for Add Student
                        $("#studentForm").submit(function(e) {
                            e.preventDefault();
                            $.ajax({
                                url: "save_students.php",
                                type: "POST",
                                data: $(this).serialize(),
                                success: function(response) {
                                    alert(response);
                                    $("#addStudentModal").hide();
                                    location.reload(); // Refresh DataTable
                                }
                            });
                        });

                        // Handle form submission for Edit Student
                        $("#editStudentForm").submit(function(e) {
                            e.preventDefault();
                            $.ajax({
                                url: "save_students.php",
                                type: "POST",
                                data: $(this).serialize(),
                                success: function(response) {
                                    alert(response);
                                    $("#editStudentModal").hide();
                                    location.reload(); // Refresh DataTable
                                }
                            });
                        });
                    </script>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Student Modal -->
    <div id="addStudentModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add Student</h2>
            <form id="studentForm">
                <label>Student No.</label>
                <input type="text" id="student_no" name="student_no" required>
                <label>Last Name</label>
                <input type="text" id="last_name" name="last_name" required>
                <label>First Name</label>
                <input type="text" id="first_name" name="first_name" required>
                <label>Middle Name</label>
                <input type="text" id="middle_name" name="middle_name">
                <label>Password</label>
                <input type="password" id="password" name="password">
                <div class="course-year-container">
                    <div>
                        <label for="course">Course</label>
                        <select id="course_code" name="course_code">
                            <option value=""></option>
                            <?php
                                $query = "SELECT course_code FROM tbl_course";
                                $result = mysqli_query($connection, $query);
                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<option value="' . $row["course_code"] . '">' . $row["course_code"] . '</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="year_level">Year Level</label>
                        <select id="year_level" name="year_level">
                            <option></option>
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                            <option value="4">4th Year</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="save-btn">Save</button>
            </form>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div id="editStudentModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Student</h2>
            <form id="editStudentForm">
                <input type="hidden" id="edit_student_no" name="student_no">
                <label>Last Name</label>
                <input type="text" id="edit_last_name" name="last_name" required>
                <label>First Name</label>
                <input type="text" id="edit_first_name" name="first_name" required>
                <label>Middle Name</label>
                <input type="text" id="edit_middle_name" name="middle_name">
                <div class="course-year-container">
                    <div>
                        <label for="edit_course_code">Course</label>
                        <select id="edit_course_code" name="course_code">
                            <option value=""></option>
                            <?php
                                $query = "SELECT course_code FROM tbl_course";
                                $result = mysqli_query($connection, $query);
                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<option value="' . $row["course_code"] . '">' . $row["course_code"] . '</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="edit_year_level">Year Level</label>
                        <select id="edit_year_level" name="year_level">
                            <option></option>
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                            <option value="4">4th Year</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="save-btn">Update</button>
            </form>
        </div>
    </div>
    <script>
       $(document).ready(function() {
    // Function for "Add New Student"
    $("#addStudentBtn").click(function() {
        $("#addStudentModal").show();
        $("#studentForm")[0].reset(); // Reset form
        $("#student_no").val(""); // Clear student_no
        $("#password").show(); // Show password field for adding
    });

    // Close Add Student Modal
    $(".close").click(function() {
        $(".modal").hide();
    });

    // Handle form submission for Add Student
    $("#studentForm").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: "save_students.php", // URL to save student
            type: "POST",
            data: $(this).serialize(), // Send form data
            success: function(response) {
                alert(response);
                $("#addStudentModal").hide(); // Close modal after saving
                location.reload(); // Refresh DataTable to show new data
            }
        });
    });

    // Function for "Edit Student"
    $(document).on("click", ".edit-student", function(e) {
        e.preventDefault();
        var student_no = $(this).data("id");

        $.ajax({
            url: "fetch_students.php", // URL to fetch student details
            type: "POST",
            data: { student_no: student_no },
            dataType: "json",
            success: function(data) {
                if (!data) {
                    alert("No student data found!");
                    return;
                }

                // Open Edit Student Modal and populate fields
                $("#editStudentModal").show();
                $("#edit_student_no").val(data.student_no); // Display student_no (read-only)
                $("#edit_last_name").val(data.last_name);
                $("#edit_first_name").val(data.first_name);
                $("#edit_middle_name").val(data.middle_name);
                $("#edit_course_code").val(data.course_code);
                $("#edit_year_level").val(data.year_level);
                $("#edit_password").hide(); // Hide password field when editing
            },
            error: function(xhr, status, error) {
                alert("Error fetching student details.");
            }
        });
    });

    // Handle form submission for Edit Student (no student_no check)
    $("#editStudentForm").submit(function(e) {
        e.preventDefault();
        
        // Send the form data for updating (student_no is part of the form but no validation)
        $.ajax({
            url: "save_students.php", // URL to save the updated student data
            type: "POST",
            data: $(this).serialize(), // Send form data (including student_no)
            success: function(response) {
                alert(response);
                $("#editStudentModal").hide(); // Close modal after updating
                location.reload(); // Refresh DataTable to show updated data
            }
        });
    });
});

    </script>
</body>
</html>
