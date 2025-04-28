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
        WHERE cl.student_no = '$student_no'
        AND g.student_no = '$student_no'
        AND sc.school_year = '$school_year' 
        AND sc.semester = '$semester'";

$result = mysqli_query($connection, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Grades</title>
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
        <a href="schedule.php"><i class="fas fa-calendar-alt"></i> Schedule</a>
        <a href="grades.php" class="active"><i class="fas fa-graduation-cap"></i> Grades</a>
        <a href="logout.php" class="btn btn-danger w-100 mt-3">Logout</a>
    </div>
</div>

<div class="content">
    <div class="header">
        <h1>Grades</h1>
    </div>
    <div class="table-container">
        <table id="gradesTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Description</th>
                    <th>Prelim</th>
                    <th>Midterm</th>
                    <th>Semi-Finals</th>
                    <th>Finals</th>
                    <th>Final Grade</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($grade_row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$grade_row['subject_code']}</td>
                                <td>{$grade_row['subject_name']}</td>
                                <td>{$grade_row['prelim']}</td>
                                <td>{$grade_row['midterm']}</td>
                                <td>{$grade_row['semi_finals']}</td>
                                <td>{$grade_row['finals']}</td>
                                <td>{$grade_row['final_grade']}</td>
                                <td>{$grade_row['remarks']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' style='text-align:center;'>No grades available.</td></tr>";
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
        $('#gradesTable').DataTable();
    });
</script>

</body>
</html>
