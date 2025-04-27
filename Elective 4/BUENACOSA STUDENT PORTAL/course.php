
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal | Courses</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="main-con">
        <div class="left-con">
            <div class="user-con">
                <div class="img-con"><img src="images/monkey.avif" alt="User Image"></div>
                <div class="user-info">Admin<br>Buenacosa, Genesis A.</div>
            </div>
            <div class="menu-con">
                <a href="school_year.php">SCHOOL YEAR</a>
                <a href="department.php">DEPARTMENTS</a>
                <a href="subject.php">SUBJECTS</a>
                <a href="faculty.php">FACULTY</a>
                <a href="students.php">STUDENTS</a>
                <a href="course.php" style="background-color: lightblue; border-radius: 7px; color: darkslategray;">COURSES</a>
                <a href="user.php">USERS</a>
                <a href="logout.php">LOGOUT</a>
            </div>
        </div>
        <div class="right-con">
            <div class="top-nav">
                <div class="brand">COURSE PORTAL</div>
            </div>
            <div class="body">
                <div class="content-title">
                    <h1>COURSES</h1>
                </div>
                <div class="content">
                    <a id="addCourseBtn" class="action-button">+ Add New</a>
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

                        // Fetch courses from the database
                        $query = mysqli_query($connection, "SELECT * FROM tbl_course");
                        $rows = mysqli_num_rows($query);
                        if ($rows > 0) {
                    ?>
                    <table id="course_info" class="display">
                        <thead>
                            <tr>
                                <th>Course Code</th>
                                <th>Course Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            while ($data = mysqli_fetch_assoc($query)) {
                        ?>
                        <tr>
                            <td><?php echo $data['course_code']; ?></td>
                            <td><?php echo $data['course_description']; ?></td>
                            <td>
                                <a href="#" class="edit-course" data-id="<?php echo htmlspecialchars($data['course_code']); ?>">Edit</a>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('#course_info').DataTable();
                        });
                    </script>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding/Editing Course -->
    <div id="courseModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Add Course</h2>
            <form id="courseForm">
                <input type="hidden" id="edit_mode" name="edit_mode" value="false">
                <label>Course Code</label>
                <input type="text" id="course_code" name="course_code" required>

                <label>Course Description</label>
                <input type="text" id="course_description" name="course_description" required>

                <button type="submit" class="save-btn">Save</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Add Course Button click
            $("#addCourseBtn").click(function() {
                $("#modalTitle").text("Add Course");
                $("#courseForm")[0].reset();
                $("#course_code").prop('readonly', false); // Allow editing the Course Code in Add mode
                $("#edit_mode").val("false"); // Set edit mode flag to false
                $("#courseModal").show();
            });

            // Edit Course Button click
            $(document).on("click", ".edit-course", function(e) {
                e.preventDefault();
                var course_code = $(this).data("id");

                $.ajax({
                    url: "fetch_course.php",
                    type: "POST",
                    data: { course_code: course_code },
                    dataType: "json",
                    success: function(data) {
                        if (!data) {
                            alert("No data found!");
                            return;
                        }
                        $("#modalTitle").text("Edit Course");
                        $("#course_code").val(data.course_code);
                        $("#course_description").val(data.course_description);
                        $("#course_code").prop('readonly', true); // Make course_code readonly in edit mode
                        $("#edit_mode").val("true"); // Set edit mode flag to true
                        $("#courseModal").show();
                    },
                    error: function() {
                        alert("Error fetching details.");
                    }
                });
            });

            // Close Modal
            $(".close").click(function() {
                $("#courseModal").hide();
            });

            // Handle Course Form Submit (Add/Edit)
            $("#courseForm").submit(function(e) {
                e.preventDefault();

                // Always send the form data to save_course.php
                $.ajax({
                    url: "save_course.php", // Action URL for both adding and editing
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response);
                        $("#courseModal").hide();
                        location.reload(); // Reload the page to reflect the changes
                    }
                });
            });

            // Close Modal when clicked outside the modal
            $(window).click(function(event) {
                if (event.target.id === "courseModal") {
                    $("#courseModal").hide();
                }
            });
        });
    </script>
</body>
</html>
