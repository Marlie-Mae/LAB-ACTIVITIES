<?php 
include("cn.php"); 
session_start(); 

if (!isset($_SESSION['student_no'])) {
    header("location: student_login.php");
    exit();
}

$student_no = $_SESSION['student_no'];

$query = mysqli_query($connection, "SELECT student_no, first_name, last_name FROM tbl_student_info WHERE student_no = '$student_no'");
$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body {
            margin: 0;
        }

        * {
            font-family: "Segoe UI", "Open Sans", sans-serif;
        }

        .main-con {
            display: flex;
            height: 100vh;
            background-color: lightblue;
        }

        .left-con {
            width: 20%;
            height: 100vh;
            background-color: lightseagreen;
        }

        .user-con {
            background-color: lightpink;
            padding: 30px;
        }

        .img-con img {
            width: 100%;
            border-radius: 50%; 
            object-fit: cover;
        }

        .user-info {
            margin-top: 10px;
            font-size: 24px;
            text-align: center;
            font-weight: 400;
            color: darkslategray;
        }

        .menu-con {
            padding: 40px 20px;
        }

        .menu-con a {
            padding: 20px 40px;
            color: ghostwhite;
            text-decoration: none;
            display: block;
            letter-spacing: 1px;
        }

        .menu-con a:hover {
            background-color: lightblue;
            border-radius: 7px;
            color: darkslategray;
        }

        .right-con {
            padding: 30px;
            width: 80%;
        }

        .top-nav {
            display: flex;
            background-color: rgba(248, 248, 255, .5);
            height: 70px;
            width: 100%;
            border-radius: 10px;
        }

        .brand {
            height: 70px;
            font-size: 24px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-left: 20px;
        }

        .body {
            padding: 20px 40px;
        }
        
        .box-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 600px;
            margin: 40px auto;
            text-align: center;
        }

        .content-title h1 {
            margin-bottom: 20px;
            color: darkslategray;
        }

        .info-box p {
            font-size: 18px;
            color: #333;
            padding: 8px 0;
        }

    </style>
</head>
<body>
<div class="main-con">
    <div class="left-con">
        <div class="user-con">
            <div class="img-con"><img src="images/monkey.avif"></div>
            <div class="user-info">Student<br>
                <?php echo htmlspecialchars($user['last_name'] ?? '') . ", " . htmlspecialchars($user['first_name'] ?? ''); ?>
            </div>
        </div>
        <div class="menu-con">
            <a href="profile.php" style="background-color: lightblue; border-radius: 7px; color: darkslategray;">PROFILE</a>
            <a href="schedule.php">SCHEDULE</a>
            <a href="grades.php">GRADES</a>
            <a href="logout.php">LOGOUT</a>
        </div>
    </div>

    <div class="right-con">
        <div class="top-nav">
            <div class="brand">STUDENT PROFILE</div>
        </div>
    
        <div class="content-box">
            <div class="box-container">
                <div class="body">
                    <div class="content-title">
                        <h1>Profile</h1>
                    </div>
                    <div class="info-box">
    <p><strong>Student No. :</strong> <?php echo htmlspecialchars($user['student_no'] ?? 'Not Found'); ?></p>
    <p><strong>Full Name :</strong> <?php echo htmlspecialchars($user['first_name'] ?? '') . ' ' . htmlspecialchars($user['last_name'] ?? ''); ?></p>
</div>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
