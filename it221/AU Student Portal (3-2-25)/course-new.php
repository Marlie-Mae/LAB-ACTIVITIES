<?php
    include("cn.php");
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $course_code = mysqli_real_escape_string($connection, $_POST['course_code']);
        $course_name = mysqli_real_escape_string($connection, $_POST['course_name']);
        
        $check_course_code = mysqli_query($connection, "SELECT * FROM tbl_course WHERE course_code = '$course_code'");
        $rows = mysqli_num_rows($check_course_code);
        if ($rows == 1) {
            $display = "<div class='message error'>Course Code already exists.</div>";
        } else {
            $query = mysqli_query($connection, "INSERT INTO tbl_course VALUES ('$course_code', '$course_name')");
            $display = "<div class='message success'>Record was saved successfully.</div>";
        } 
    } 
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style.css">
        <title>Add Course</title>
    </head>
    <body>
        <form action="" method="POST">
            <h1>Add New Course</h1>

            <?php
            if(isset($display)) {
                echo "<p class='message'>$display</p>";
            }
            ?>

            <label for="course_code">Course Code:</label>
            <input type="text" name="course_code" placeholder="Course code" required> <br>

            <label for="Course_name">Course Name:</label>
            <input type="text" name="course_name" placeholder="Course name" required> <br>
            
            <input type="submit" name="" value="Insert">
            <a href="course.php" class="back-btn">Back</a>
        </form>
    </body>
</html>