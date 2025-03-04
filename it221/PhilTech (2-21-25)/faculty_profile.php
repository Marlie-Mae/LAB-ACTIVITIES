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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Profile | PhilTech</title>
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>

    <!-- Sidebar Navigation -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <img src="images/pt_logo.png" alt="PhilTech Logo" class="logo">
            <h2>PhilTech</h2>
        </div>
        <ul class="nav-links">
            <li><a href="faculty_profile.php" class="active">Profile</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">School Year</a>
                <div class="dropdown-content">
                    <a href="school-year-new.php">Add School Year</a>
                    <a href="school-year.php">View Table</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">Department</a>
                <div class="dropdown-content">
                    <a href="department-new.php">Add Department</a>
                    <a href="department.php">View Table</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">Course</a>
                <div class="dropdown-content">
                    <a href="course-new.php">Add Course</a>
                    <a href="course.php">View Table</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">Subject</a>
                <div class="dropdown-content">
                    <a href="subject-new.php">Add Subject</a>
                    <a href="subject.php">View Table</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">Student</a>
                <div class="dropdown-content">
                    <a href="student-new.php">Add Student</a>
                    <a href="student.php">View Table</a>
                </div>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">Faculty</a>
                <div class="dropdown-content">
                    <a href="faculty-new.php">Add Faculty</a>
                    <a href="faculty.php">View Table</a>
                </div>
            </li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <section class="main-content">
        <header>
            <div class="welcome">
                <h1>Welcome back, <?php echo $row["faculty_name"]; ?>!</h1>
                <p>Faculty Profile Overview</p>
            </div>
            <div class="user-profile">
                <img src="images/default.jpg" alt="User">
                <span><?php echo $row["faculty_name"]; ?></span>
            </div>
        </header>

        <div class="profile-info">
            <h1>Faculty Details</h1>
            <div class="profile-card">
                <p><strong>Faculty Code:</strong> <?php echo $faculty_code; ?></p>
                <p><strong>Name:</strong> <?php echo $row["faculty_name"]; ?></p>
                <p><strong>Department:</strong> <?php echo $row["department_code"]; ?></p>
            </div>
        </div>
    </section>
    
</body>
</html>
