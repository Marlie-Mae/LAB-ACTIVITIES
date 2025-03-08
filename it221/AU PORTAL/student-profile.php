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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AU Portal | Student Profile | AU</title>
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
    <!-- Sidebar Navigation -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <img src="images/au_logo.png" alt="Arellano University Logo" class="logo">
            <h2>Arellano University</h2>
        </div>
        <ul class="nav-links">
            <li><a href="faculty_profile.php" class="active">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Main Content -->
    <section class="main-content">
        <header>
            <div class="welcome">
                <h1>Welcome back, <?php echo $row["first_name"]; ?>!</h1>
                <p>Student Profile Overview</p>
            </div>
            <div class="user-profile">
                <img src="images/default.jpg" alt="User">
                <span><?php echo $row["first_name"]; ?></span>
            </div>
        </header>

        <div class="profile-info">
        <h1>Student Profile</h1>
        <div class="profile-card">
            <p><strong>Student No.:</strong> <?php echo $student_no; ?></p>
            <p><strong>Name:</strong> <?php echo $row["last_name"] . ", " . $row["first_name"] . " " . $row["middle_name"]; ?></p>
            <p><strong>Course and Year Level:</strong> <?php echo $row["course_code"] . " - " . $row["year_level"]; ?></p>
        </div>
        </div>
    </section>

</body>
</html>
