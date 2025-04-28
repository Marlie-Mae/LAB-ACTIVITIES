<?php
include("cn.php");
session_start();

if (!isset($_SESSION['student_no'])) {
    header("location: student-login.php");
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Schedule</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
            background: #eaf6fb;
        }
        .sidebar {
            width: 400px;
            background: #2aa198;
            padding: 26px;
            display: flex;
            flex-direction: column;
            align-items: center;
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }
        .profile {
            text-align: center;
            margin-bottom: 26px;
        }
        .profile img {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            border: 4px solid white;
            margin-bottom: 13px;
            object-fit: cover;
        }
        .profile h5 {
            font-size: 1.7rem;
        }
        .profile p {
            font-size: 1.2rem;
            color: #e4f5f4;
        }
        .nav-links {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .nav-links a {
            display: block;
            padding: 16px 20px;
            font-size: 1.3rem;
            background: #3b8070;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .nav-links a:hover,
        .nav-links a.active {
            background: #1e6a5e;
        }
        .btn-danger {
            font-size: 1.3rem;
            padding: 14px;
        }
        .content {
            margin-left: 450px;
            padding: 40px;
            background: #eaf6fb;
            width: calc(97% - 420px);
            height: 100vh;
            overflow-y: auto;
        }
        .header {
            background: #dfeef4;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 1.8rem;
            color: #2c3e50;
        }
        .table-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
        }
        table.dataTable thead {
            background-color: #2aa198;
            color: white;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="profile">
            <img src="images/picture.png" alt="Profile Picture">
            <h5><?php echo htmlspecialchars($row['first_name']); ?></h5>
            <p><?php echo htmlspecialchars($student_no); ?></p>
        </div>
        <div class="nav-links">
            <a href="student-home.php"><i class="fas fa-user"></i> Profile</a>
            <a href="schedule.php" class="active"><i class="fas fa-calendar-alt"></i> Schedule</a>
            <a href="grades.php"><i class="fas fa-graduation-cap"></i> Grades</a>
            <a href="logout.php" class="btn btn-danger w-100 mt-3">Logout</a>
        </div>
    </div>

    <div class="content">
        <div class="header">
            <h1>Schedule</h1>
        </div>
        <div class="table-container">
            <table id="scheduleTable" class="table table-striped">
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
                        while ($row_sched = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>{$row_sched['days']}</td>
                                    <td>{$row_sched['time']}</td>
                                    <td>{$row_sched['room']}</td>
                                    <td>{$row_sched['subject_code']}</td>
                                    <td>{$row_sched['subject_name']}</td>
                                    <td>{$row_sched['faculty_name']}</td>
                                    <td>{$row_sched['school_year']}</td>
                                    <td>{$row_sched['semester']}</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' style='text-align:center;'>No schedule available.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- JQuery and DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#scheduleTable').DataTable();
        });
    </script>
</body>
</html>
