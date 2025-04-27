
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
                <div class="user-info">USER<br>
            </div>
            </div>
            <div class="menu-con">
                <a href="school_year.php">SCHOOL YEAR</a>
                <a href="department.php">DEPARTMENTS</a>
                <a href="subject.php">SUBJECTS</a>
                <a href="faculty.php">FACULTY</a>
                <a href="students.php">STUDENTS</a>
                <a href="course.php" style="background-color: lightblue; border-radius: 7px; color: darkslategray;">COURSES</a>
                <a href="users.php">USERS</a>
                <a href="../logout.php">LOGOUT</a>

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
                    <?php 
                        include("cn.php");
                        session_start(); // Start session

                        // Check if user is not logged in
                        if (!isset($_SESSION['user_id'])) {
    header("location: ../login.php");
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
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            while ($data = mysqli_fetch_assoc($query)) {
                        ?>
                        <tr>
                            <td><?php echo $data['course_code']; ?></td>
                            <td><?php echo $data['course_description']; ?></td>
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
</body>
</html>
