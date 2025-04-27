<?php
include("./cn.php");
session_start();

if (!isset($_SESSION['student_no'])) {
    header("location: student_login.php");
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
            f.faculty_code,
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
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Portal | Schedule</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="main-con">
        <div class="left-con">
            <div class="user-con">
                <div class="img-con"><img src="images/profile.png" alt="Profile Picture"></div>
                <div class="user-info">Student<br>
                <?php echo htmlspecialchars($row['last_name'] ?? '') . ", " . htmlspecialchars($row['first_name'] ?? ''); ?>
                </div>
            </div>
            <div class="menu-con">
                <a href="profile.php">PROFILE</a>
                <a href="schedule.php" style="background-color: lightblue; border-radius: 7px; color: darkslategray;">SCHEDULE</a>
                <a href="grades.php">GRADES</a>
                <a href="logout.php">LOGOUT</a>
            </div>
        </div>
        <div class="right-con">
            <div class="top-nav">
                <div class="brand">SCHEDULE</div>
            </div>
            <div class="body">
                <table id="schedule_info" class="display">
                    <thead>
                        <tr>
                            <th>Subject Code</th>
                <th>Subject Name</th>
                <th>Days</th>
                <th>Time</th>
                <th>Room</th>
                <th>Faculty Name</th>
                <th>School Year</th>
                <th>Semester</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($data = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $data['subject_code']; ?></td>
                    <td><?php echo $data['subject_name']; ?></td>
                    <td><?php echo $data['days']; ?></td>
                    <td><?php echo $data['time']; ?></td>
                    <td><?php echo $data['room']; ?></td>
                    <td><?php echo $data['faculty_name']; ?></td>
                    <td><?php echo $data['school_year']; ?></td>
                    <td><?php echo $data['semester']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
                <script>
                    $(document).ready(function() {
                        $('#schedule_info').DataTable();
                    });
                </script>
            </div>
        </div>
    </div>
</body>
</html>
