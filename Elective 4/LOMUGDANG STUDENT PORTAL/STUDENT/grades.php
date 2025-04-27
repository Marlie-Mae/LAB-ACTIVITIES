<?php
include("cn.php");
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
            subj.subject_code, 
            subj.subject_name, 
            g.prelim, 
            g.midterm, 
            g.semi_finals, 
            g.finals, 
            g.final_grade, 
            g.remarks
        FROM tbl_grades g
        INNER JOIN tbl_schedule sc ON g.class_code = sc.class_code
        INNER JOIN tbl_subject subj ON sc.subject_code = subj.subject_code
        INNER JOIN tbl_class_list cl ON sc.class_code = cl.class_code
        WHERE g.student_no = '$student_no'
        AND cl.student_no = '$student_no'
        AND sc.school_year = '$school_year' 
        AND sc.semester = '$semester'";

$result = mysqli_query($connection, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Portal | Grades</title>
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
                <a href="schedule.php">SCHEDULE</a>
                <a href="grades.php" style="background-color: lightblue; border-radius: 7px; color: darkslategray;">GRADES</a>
                <a href="logout.php">LOGOUT</a>
            </div>
        </div>
        <div class="right-con">
            <div class="top-nav">
                <div class="brand">GRADES</div>
            </div>
            <div class="body">
                <table id="schedule_info" class="display">
                    <thead>
                       <tr>
                        <th>Subject Code</th>
                        <th>Subject Name</th>
                        <th>Prelim</th>
                        <th>Midterm</th>
                        <th>Semi Final</th>
                        <th>Final</th>
                        <th>Final Grade</th>
                        <th>Remarks</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php while ($data = mysqli_fetch_assoc($result)) { ?>
                       <tr>
                            <td><?php echo $data['subject_code']; ?></td>
                            <td><?php echo $data['subject_name']; ?></td>
                            <td><?php echo $data['prelim']; ?></td>
                            <td><?php echo $data['midterm']; ?></td>
                            <td><?php echo $data['semi_finals']; ?></td>
                            <td><?php echo $data['finals']; ?></td>
                            <td><?php echo $data['final_grade']; ?></td>
                            <td><?php echo $data['remarks']; ?></td>
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
