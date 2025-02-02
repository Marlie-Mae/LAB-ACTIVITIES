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
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Profile</title>
</head>
<body>
    Student No.: <?php echo $student_no; ?> <br>
    Name: <?php echo $row["last_name"] . ", " . $row["first_name"] . " " . $row["middle_name"]; ?> <br>
    Course and Year Level: <?php echo $row["course_code"] . " - " . $row["year_level"]; ?>

    <p><a href="logout.php">LOG OUT</a></p>
</body>
</html>