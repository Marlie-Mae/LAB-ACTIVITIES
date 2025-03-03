<?php
    include("cn.php");
    session_start();
    if (!isset($_SESSION['faculty_code'])) {
        header("location: faculty-login.php");
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
    <title>Faculty Profile | AU</title>
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