<?php
    include("cn.php");
    if (isset($_GET['course_code'])) {
        $course_code = mysqli_real_escape_string($connection, $_GET['course_code']);
        $query = mysqli_query($connection, "SELECT * FROM tbl_course WHERE course_code = '$course_code'");
        $rows = mysqli_num_rows($query);
        if ($rows > 0) {
            $data = mysqli_fetch_assoc($query);
        } else {
            echo "Course Code not found";
        }
    } else {
        header("location: course.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Course</title>
    </head>
    <body>
        <form action="" method="POST">
            <label for="course_code">Course Code:</label>
            <input type="text" name="course_code" placeholder="course_code" required value="<?php if(isset($course_code)) { echo $course_code;} ?>"> <br>

            <label for="course_description">Course Description:</label>
            <input type="text" name="course_description" placeholder="Course description" required value="<?php if(isset($data['course_description'])) {echo $data["course_description"];} ?>"> <br>

            <input type="submit" name="" value="UPDATE">
        </form>
    </body>
</html>
