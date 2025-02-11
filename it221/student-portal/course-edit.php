<?php
    include("cn.php");
    if (isset($_GET['student_no'])) {
        $course_code = mysqli_real_escape_string($connection, $_GET['course_code']);
        $query = mysqli_query($connection, "SELECT * FROM tbl_course WHERE student_no = '$course_code'");
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

            <label for="l_name">Last Name:</label>
            <input type="text" name="l_name" placeholder="Last name" required value="<?php if(isset($data['last_name'])) {echo $data["last_name"];} ?>"> <br>

            <label for="f_name">First Name:</label>
            <input type="text" name="f_name" placeholder="First name" required value="<?php if(isset($data['first_name'])) {echo $data["first_name"];} ?>"> <br>

            <label for="m_name">Middle Name:</label>
            <input type="text" name="m_name" placeholder="Middle name" required value="<?php if(isset($data['middle_name'])) {echo $data["middle_name"];} ?>"> <br>

            <label for="course_code">Course:</label>
            <select name="course_code" id="">
                <option value="" disabled selected>Select a course</option>
                <?php
                $course_query = mysqli_query($connection, "SELECT * FROM tbl_course"); 
                while ($course_row = mysqli_fetch_assoc($course_query)) {
                    $selected = ($course_row['course_code'] == $data['course_code']) ? "selected" : "";
                    echo "<option value='{$course_row['course_code']}' $selected>{$course_row['course_code']}</option>";
                }
                ?>
            </select>
            <br>

            <label for="year_level">Year Level:</label>
            <input type="number" name="year_level" placeholder="Year level" min="1" max="4" required value="<?php if(isset($data['year_level'])) {echo $data["year_level"];} ?>"> <br>
            
            <input type="submit" name="" value="UPDATE">
        </form>
    </body>
</html>
