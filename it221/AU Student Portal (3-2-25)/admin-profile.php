<?php
    include("cn.php");
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("location: login.php");
        exit();
    }

    $user_id = mysqli_real_escape_string($connection, $_SESSION['user_id']);
    $query = mysqli_query($connection, "SELECT * FROM tbl_users WHERE user_id = '$user_id'");
    $row = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile | AU</title>
    <link rel="stylesheet" href="css/profile.css">
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
            <li><a href="admin-profile.php" class="active">Profile</a></li>
            <li class="dropdown">
                <a href="users.php" class="dropdown-toggle">Users</a>
            </li>
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

    <!-- Hamburger Icon for Mobile -->
    <div class="hamburger" onclick="toggleSidebar()">&#9776;</div>

    <!-- Main Content -->
    <section class="main-content">
        <header>
            <div class="welcome">
                <h1>Welcome back</h1>
                <p>Admin Dashboard</p>
            </div>
            <div class="user-profile">
                <img src="images/default.jpg" alt="User">
                <span><?php echo $row["user_id"]; ?></span>
            </div>
        </header>

        <div class="profile-info">
            <h1>Admin Details</h1>
            <div class="profile-card">
            <p><strong>User ID:</strong> <?php echo $row["user_id"]; ?></p>
            <p><strong>Account Type:</strong> <?php echo $row["account_type"]; ?></p>
            <p><strong>Status:</strong> <?php echo $row["status"]; ?></p>
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