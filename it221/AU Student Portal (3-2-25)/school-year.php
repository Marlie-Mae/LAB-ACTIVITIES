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
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>School Year Table</title>
        <link rel="stylesheet" href="css/table.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    </head>
    <body>

    <!-- Sidebar Navigation -->
   <nav class="sidebar">
        <div class="sidebar-header">
            <img src="images/au_logo.png" alt="Arellano University Logo" class="logo">
            <h2>Arellano University</h2>
            <div class="close-icon" onclick="toggleSidebar()">&times;</div>
        </div>
        <ul class="nav-links">
            <li><a href="admin-profile.php" class="dropdown-toggle">Profile</a></li>
            <li class="dropdown">
                <a href="users.php" class="dropdown-toggle">Users</a>
            </li>
            <li class="dropdown">
                <a href="school-year.php" class="active">School Year</a>
            </li>
            <li class="dropdown">
                <a href="department.php" class="dropdown-toggle">Department</a>
            </li>
            <li class="dropdown">
                <a href="course.php" class="dropdown-toggle">Course</a>
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

    <!-- Hamburger Icon for Mobile -->
    <div class="hamburger" onclick="toggleSidebar()">&#9776;</div>

    <!-- Main Content -->
    <section class="main-content">

    <div class="table-container">

    <a href="school-year-new.php" class="add-btn">Add New School Year</a>

        <?php
            include("cn.php");
            $query = mysqli_query($connection, "SELECT * FROM tbl_school_year");
            $rows = mysqli_num_rows($query); 
            if ($rows > 0) {
        ?>
        
        <h1 class="title">School Year Information</h1>

        <table id="school_year" class="styled-table">
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
                    <td>
                        <a href="school-year-edit.php?school_year_code=<?php echo $data['school_year_code']; ?>" class="btn-edit">Edit</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

        <script>
            $(document).ready(function() {
                $('#school_year').DataTable();
            });
        </script>
        <?php } ?>

        </div>
        </section>

        <script>
            function toggleSidebar() {
        var sidebar = document.querySelector('.sidebar');
        var hamburger = document.querySelector('.hamburger');
        var closeIcon = document.querySelector('.close-icon');

        sidebar.classList.toggle('active');

        // Hide hamburger when sidebar is open on mobile
        if (sidebar.classList.contains('active')) {
            hamburger.style.display = "none";
            closeIcon.style.display = "block";
        } else {
            hamburger.style.display = "block";
            closeIcon.style.display = "none";
        }
    }
    </script>
    
    </body>
</html>