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

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $course_code = mysqli_real_escape_string($connection, $_POST['course_code']);
        $course_description = mysqli_real_escape_string($connection, $_POST['course_description']);

        $check_course = mysqli_query($connection, "SELECT * FROM tbl_course WHERE course_code = '$course_code'");
        $rows = mysqli_num_rows($check_course);
        if ($rows == 1) {
            $sql = "UPDATE tbl_course SET course_description = '$course_description' WHERE course_code = '$course_code'";
            if (mysqli_query($connection,$sql)) {
                header("location: course.php");
            } else {
                $display = "Failed to update records.";
            }
        } else {
            $display = "Course Code not found.";
        }
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
        <?php if(isset($status)) {echo $status; } ?>
        <?php if(isset($display)) {echo $display; } ?>
        <form action="" method="POST">
            <label for="course_code">Course Code:</label>
            <input type="text" name="course_code" placeholder="Course code" required value="<?php if(isset($course_code)) { echo $course_code;} ?>"> <br>

            <label for="course_description">Course Description:</label>
            <input type="text" name="course_description" placeholder="Course Description" required value="<?php if(isset($data['course_description'])) {echo $data["course_description"];} ?>"> <br>

            <input type="submit" name="" value="UPDATE">
        </form>
    </body>
</html>
