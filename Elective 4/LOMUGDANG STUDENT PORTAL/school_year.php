<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Portal | School Year</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="main-con">
        <div class="left-con">
            <div class="user-con">
                <div class="img-con"><img src="images/profile.png"></div>
                <div class="user-info">Admin<br>Lomugdang, Junalyn</div>
            </div>
            <div class="menu-con">
                <a href="school_year.php" style="background-color: lightblue; border-radius: 7px; color: darkslategray;">SCHOOL YEAR</a>
                <a href="department.php">DEPARTMENTS</a>
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
                <div class="brand">STUDENT PORTAL</div>
            </div>
            <div class="body">
                <div class="content-title"><h1>SCHOOL YEAR</h1></div>
                <div class="content">
                    <a id="addSchoolYearBtn" class="action-button">+ Add New</a>
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
                        $query = mysqli_query($connection, "SELECT * FROM tbl_school_year");
                        $rows = mysqli_num_rows($query);
                        if ($rows > 0) {
                    ?>
                    <table id="school_year_info" class="display">
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
                            <td><a href="#" class="edit-school_year" data-id="<?php echo htmlspecialchars($data['school_year_code']); ?>">Edit</a></td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('#school_year_info').DataTable();
                        });
                    </script>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding/Editing School Year -->
    <div id="schoolYearModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Add School Year</h2>
            <form id="schoolYearForm">
                <label>School Year Code</label>
                <input type="text" id="school_year_code" name="school_year_code" readonly>

                <label>School Year</label>
                <input type="text" id="school_year" name="school_year" required>

                <div class= school_year-container>
                    <div>
                <label>Semester</label>
                <select id="semester" name="semester" required>
                    <option></option>
                    <option value="1st">1st Semester</option>
                    <option value="2nd">2nd Semester</option>
                </select>
                </div>
                <div>
                <label>Status</label>
                <select id="status" name="status" required>
                    <option></option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
                </div>
                <button type="submit" class="save-btn">Save</button>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#addSchoolYearBtn").click(function() {
                $("#modalTitle").text("Add School Year");
                $("#schoolYearForm")[0].reset();
                $("#schoolYearModal").show();
            });

            $(document).on("click", ".edit-school_year", function(e) {
                e.preventDefault();
                var school_year_code = $(this).data("id");

                $.ajax({
                    url: "fetch_school_year.php",
                    type: "POST",
                    data: { school_year_code: school_year_code },
                    dataType: "json",
                    success: function(data) {
                        if (!data) {
                            alert("No data found!");
                            return;
                        }
                        $("#modalTitle").text("Edit School Year");
                        $("#school_year_code").val(data.school_year_code);
                        $("#school_year").val(data.school_year);
                        $("#semester").val(data.semester);
                        $("#status").val(data.status);
                        $("#schoolYearModal").show();
                    },
                    error: function() {
                        alert("Error fetching details.");
                    }
                });
            });

            $(".close").click(function() {
                $("#schoolYearModal").hide();
            });

            $("#schoolYearForm").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "save_school_year.php",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response);
                        $("#schoolYearModal").hide();
                        location.reload();
                    }
                });
            });

            $(window).click(function(event) {
                if (event.target.id === "schoolYearModal") {
                    $("#schoolYearModal").hide();
                }
            });
        });
    </script>
</body>
</html>
