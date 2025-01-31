<?php
    include("cn.php");
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $student_no = mysqli_real_escape_string($connection, $_POST['student_no']);
        $l_name = mysqli_real_escape_string($connection, $_POST['l_name']);
        $f_name = mysqli_real_escape_string($connection, $_POST['f_name']);
        $m_name = mysqli_real_escape_string($connection, $_POST['m_name']);
        $course_code = mysqli_real_escape_string($connection, $_POST['course_code']);
        $year_level = mysqli_real_escape_string($connection, $_POST['year_level']);

        $check_student = mysqli_query($connection, "SELECT * FROM tbl_student_info WHERE student_no = '$student_no'");
        $rows = mysqli_num_rows($check_student);
        if ($rows == 1) {
            $display = "Student No. already exist.";
        } else {
            $query = mysqli_query($connection, "INSERT INTO tbl_student_info VALUES ('$student_no', '$l_name', '$f_name', '$m_name', '$course_code', '$year_level')");
            $display = "Record was saved successfully.";
        } 
    } else {
        echo "NO";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Insert</title>
    </head>
    <body>
        <?php
            if(isset($display)) {
                echo $display;
            }
        ?>
        <form action="" method="POST">
            <input type="text" name="student_no" placeholder="Student no." required> <br>
            <input type="text" name="l_name" placeholder="Last name" required> <br>
            <input type="text" name="f_name" placeholder="First name" required> <br>
            <input type="text" name="m_name" placeholder="Middle name" required> <br>
            <input type="text" name="course_code" placeholder="Course" required> <br>
            <input type="text" name="year_level" placeholder="Year level" min="1" max="4" required> <br>
            <input type="submit" name="" value="INSERT">
        </form>
    </body>
</html>