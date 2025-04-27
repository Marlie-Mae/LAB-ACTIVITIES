<?php
include("cn.php");
session_start();

if (!isset($_SESSION['student_no'])) {
    header("location: login.php");
    exit();
}

$student_no = mysqli_real_escape_string($connection, $_SESSION['student_no']);

$query = mysqli_query($connection, "SELECT * FROM tbl_student_info WHERE student_no = '$student_no'");
$row = mysqli_fetch_assoc($query);

$school_year = "2024-2025"; 
$semester = "2"; 

$sql = "SELECT
            sc.days,
            sc.time,
            sc.room,
            sc.subject_code,
            subj.subject_name,
            f.faculty_name,
            sc.school_year,
            sc.semester
        FROM tbl_student_info s
        INNER JOIN tbl_class_list cl ON s.student_no = cl.student_no
        INNER JOIN tbl_schedule sc ON cl.class_code = sc.class_code
        INNER JOIN tbl_subject subj ON sc.subject_code = subj.subject_code
        INNER JOIN tbl_faculty f ON sc.faculty_code = f.faculty_code
        WHERE sc.school_year = '$school_year' 
        AND sc.semester = '$semester'
        AND cl.student_no = '$student_no'";

$result = mysqli_query($connection, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AU Portal | Schedule</title>
    <link type="image/png" rel="icon" href="images/au_logo.png">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

<!-- Sidebar Navigation -->
<nav class="sidebar">
    <div class="sidebar-header">
        <div class="user-con">
            <div class="img-con">
                <img src="images/default.jpg" alt="Student Image">
            </div>
            <div class="user-info">
                <p><strong><?php echo $student_no; ?> </strong></p>
                <p><?php echo $row["last_name"] . ", " . $row["first_name"] . " " . $row["middle_name"]; ?></p>
            </div>
        </div>
        <div class="close-icon" onclick="toggleSidebar()">&times;</div>
    </div>

    <ul class="nav-links">
        <li><a href="student-profile.php"><i class="fas fa-user"></i> Profile</a></li>
        <li><a href="schedule.php" class="active"><i class="fas fa-calendar-alt"></i> Schedule</a></li>
        <li><a href="grades.php"><i class="fas fa-graduation-cap"></i> Grades</a></li>
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
        <h1 class="title">Schedule</h1>

        <!-- Schedule Table -->
        <table id="scheduleTable" class="styled-table">
            <thead>
                <tr>
                    <th>Days</th>
                    <th>Time</th>
                    <th>Room</th>
                    <th>Subject Code</th>
                    <th>Subject Description</th>
                    <th>Faculty Name</th>
                    <th>School Year</th>
                    <th>Semester</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$row['days']}</td>
                                <td>{$row['time']}</td>
                                <td>{$row['room']}</td>
                                <td>{$row['subject_code']}</td>
                                <td>{$row['subject_name']}</td>
                                <td>{$row['faculty_name']}</td>
                                <td>{$row['school_year']}</td>
                                <td>{$row['semester']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' style='text-align:center;'>No schedule available</td></tr>";
                }
                ?>
            </tbody>
        </table>

    </div>
</section>

<!-- DataTables Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#scheduleTable').DataTable();
    });
</script>
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
