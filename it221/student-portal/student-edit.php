<?php
    include("cn.php");
    if (isset($_GET['student_no'])) {
        $student_no = mysqli_real_escape_string($connection, $_GET['student_no']);
        $query = mysqli_query($connection, "SELECT * FROM tbl_student_info WHERE student_no = '$student_no'");
        $rows = mysqli_num_rows($query);
        if ($rows > 0) {
            $data = mysqli_fetch_assoc($query);
            $course_code = $data['course_code'];
        } else {
            echo "Student No. not found";
        }
    } else {
        header("location: student.php");
    }

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
            $sql = "UPDATE tbl_student_info SET last_name = '$l_name', first_name = '$f_name', middle_name = '$m_name', course_code = '$course_code', year_level = $year_level WHERE student_no = '$student_no'";
            if (mysqli_query($connection,$sql)) {
                header("location: student.php");
            } else {
                $display = "Failed to update records.";
            }
        } else {
            $display = "Student No. not found.";
        }
    } 
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Student</title>
    </head>
    <body>
        <?php if(isset($status)) {echo $status; } ?>
        <?php if(isset($display)) {echo $display; } ?>
        <form action="" method="POST">
            <label for="student_no">Student No.:</label>
            <input type="text" name="student_no" placeholder="Student no." required value="<?php if(isset($data['$student_no'])) { echo $data["student_no"];} ?>"> <br>

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
                $query = mysqli_query($connection, "SELECT * FROM tbl_course"); 
                $rows = mysqli_num_rows($query);
                while ($course = mysqli_fetch_assoc($query)) {
                ?>
                <option value="<?php echo $course['course_code']; ?>" <?php if($course_code == $course["course_code"]) {echo "selected"; }?>>

                <?php echo $course['course_code']; ?> </option>
                <?php } ?>
                ?>
            </select>
            <br>

            <label for="year_level">Year Level:</label>
            <input type="number" name="year_level" placeholder="Year level" min="1" max="4" required value="<?php if(isset($data['year_level'])) {echo $data["year_level"];} ?>"> <br>
            
            <input type="submit" name="" value="UPDATE">
        </form>
    </body>
</html>
