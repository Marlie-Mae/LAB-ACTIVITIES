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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            height: 100vh;
            background: #2aa198;
            color: white;
            padding: 26px;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: fixed;
            left: 0;
            top: 0;
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
            margin-bottom: 6px;
        }
        .profile p {
            font-size: 1.3rem;
            color: #e4f5f4;
        }
        .nav-links a {
            display: block;
            padding: 16px 20px;
            font-size: 1.3rem;
            background: #3b8070;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            text-align: left;
            transition: all 0.3s ease;
            margin-bottom: 0;
        }
        .nav-links {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .nav-links a:hover,
        .nav-links a.active {
            background: #1e6a5e;
            color: white;
        }
        .btn-danger {
            font-size: 1.3rem;
            padding: 14px;
        }
        .content {
            margin-left: 420px;
            padding: 40px;
            background: #eaf6fb;
            width: calc(100% - 420px);
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
        .student-info {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .student-info h3 {
            font-size: 1.5rem;
            color: #34495E;
            margin-bottom: 15px;
        }
        .student-info p {
            font-size: 1rem;
            margin-bottom: 10px;
            color: #2C3E50;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="profile">
            <img src="images/picture.png" alt="Profile Picture">
            <h5><?php echo htmlspecialchars($row['first_name']); ?></h5>
            <p>Student</p>
        </div>
        <div class="nav-links">
            <a href="#" class="nav-item active" data-page="profile">Profile</a>
            <a href="#" class="nav-item" data-page="schedule.php">Schedule</a>
            <a href="#" class="nav-item" data-page="grades.php">Grades</a>
            <a href="logout.php" class="btn btn-danger w-100 mt-3">Logout</a>
        </div>
    </div>

    <div class="content">
        <div id="content-area">
            <div class="student-info">
                <h3>Student Profile</h3>
                <p><strong>Student No.:</strong> <?php echo htmlspecialchars($student_no); ?></p>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($row["last_name"] . ", " . $row["first_name"] . " " . $row["middle_name"]); ?></p>
                <p><strong>Course and Year Level:</strong> <?php echo htmlspecialchars($row["course_code"] . " - " . $row["year_level"]); ?></p>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.nav-item').click(function(e) {
                e.preventDefault();
                $('.nav-item').removeClass('active');
                $(this).addClass('active');

                let page = $(this).data('page');

                if (page === "profile") {
                    $('#content-area').html(`
                        <div class="student-info">
                            <h3>Student Profile</h3>
                            <p><strong>Student No.:</strong> <?php echo htmlspecialchars($student_no); ?></p>
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($row["last_name"] . ", " . $row["first_name"] . " " . $row["middle_name"]); ?></p>
                            <p><strong>Course and Year Level:</strong> <?php echo htmlspecialchars($row["course_code"] . " - " . $row["year_level"]); ?></p>
                        </div>
                    `);
                } else {
                    $('#content-area').load(page);
                }
            });
        });
    </script>
</body>
</html>
