<?php
    include("cn.php");
    session_start();
    if (!isset($_SESSION['faculty_code'])) {
        header("location: faculty_login.php");
        exit();
    }

    $faculty_code = mysqli_real_escape_string($connection, $_SESSION['faculty_code']);
    $query = mysqli_query($connection, "SELECT * FROM tbl_faculty WHERE faculty_code = '$faculty_code'");
    $row = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Course Table</title>
        <link rel="stylesheet" href="css/table.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    </head>
    <body>

   <!-- Sidebar Navigation -->
   <nav class="sidebar">
        <div class="sidebar-header">
            <img src="images/pt_logo.png" alt="PhilTech Logo" class="logo">
            <h2>PhilTech</h2>
        </div>
        <ul class="nav-links">
            <li><a href="faculty_profile.php" class="dropdown-toggle">Profile</a></li>
            <li class="dropdown">
                <a href="school-year.php" class="dropdown-toggle">School Year</a>
            </li>
            <li class="dropdown">
                <a href="department.php" class="dropdown-toggle">Department</a>
            </li>
            <li class="dropdown">
                <a href="course.php" class="active">Course</a>
            </li>
            <li class="dropdown">
                <a href="subject.php" class="dropdown-toggle">Subject</a>
            </li>
            <li class="dropdown">
                <a href="student.php" class="dropdown-toggle">Student</a>
            </li>
            <li class="dropdown">
                <a href="faculty.php" class="dropdown-toggle">Faculty</a>
            </li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    
     <!-- Main Content -->
     <section class="main-content">

        <div class="table-container">

        <a href="course-new.php" class="add-btn">Add New Course</a>

        <?php
            include("cn.php");
            $query = mysqli_query($connection, "SELECT * FROM tbl_course");
            $rows = mysqli_num_rows($query); 
            if ($rows > 0) {
        ?>

        <h1 class="title">Course Information</h1>

        <table id="course" class="styled-table">
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
                        <a href="course-edit.php?course_code=<?php echo $data['course_code']; ?>" class="btn-edit">Edit</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

        <script>
            $(document).ready(function() {
                $('#course').DataTable();
            });
        </script>
        <?php } ?>
        </div>
    </section>
    </body>
</html>