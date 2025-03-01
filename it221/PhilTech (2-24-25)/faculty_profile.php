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
                <a href="school-year.php" class="dropdown-toggle">School Year</a>
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