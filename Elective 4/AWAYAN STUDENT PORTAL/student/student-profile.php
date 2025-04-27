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
    <title>AU Portal | Student Profile</title>
    <link type="image/png" rel="icon" href="images/au_logo.png">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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
            <li><a href="student-profile.php" class="active"><i class="fas fa-user"></i> Profile</a></li>
            <li><a href="schedule.php"><i class="fas fa-calendar-alt"></i> Schedule</a></li>
            <li><a href="grades.php"><i class="fas fa-graduation-cap"></i> Grades</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
        </ul>
    </nav>

    <!-- Hamburger Icon for Mobile -->
    <div class="hamburger" onclick="toggleSidebar()">&#9776;</div>

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
