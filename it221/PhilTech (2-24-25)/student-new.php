<?php
    include("cn.php");
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $student_no = mysqli_real_escape_string($connection, $_POST['student_no']);
        $l_name = mysqli_real_escape_string($connection, $_POST['l_name']);
        $f_name = mysqli_real_escape_string($connection, $_POST['f_name']);
        $m_name = mysqli_real_escape_string($connection, $_POST['m_name']);
        $course_code = mysqli_real_escape_string($connection, $_POST['course_code']);
        $year_level = mysqli_real_escape_string($connection, $_POST['year_level']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        $hashed_password = md5($password);

        $check_student = mysqli_query($connection, "SELECT * FROM tbl_student_info WHERE student_no = '$student_no'");
        $rows = mysqli_num_rows($check_student);
        if ($rows == 1) {
            $display = "<div class='message error'>Student No. already exists.</div>";
        } else {
            $query = mysqli_query($connection, "INSERT INTO tbl_student_info VALUES ('$student_no', '$l_name', '$f_name', '$m_name', '$course_code', '$year_level', '$hashed_password')");
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
        <title>Add Student</title>
    </head>
    <body>
        <form action="" method="POST">
            <h1>Add New Student</h1>

            <?php
            if(isset($display)) {
                echo "<p class='message'>$display</p>";
            }
            ?>

            <label for="student_no">Student No.:</label>
            <input type="text" name="student_no" placeholder="Student no." required> <br>

            <label for="l_name">Last Name:</label>
            <input type="text" name="l_name" placeholder="Last name" required> <br>

            <label for="f_name">First Name:</label>
            <input type="text" name="f_name" placeholder="First name" required> <br>

            <label for="m_name">Middle Name:</label>
            <input type="text" name="m_name" placeholder="Middle name"> <br>

            <label for="course_code">Course:</label>
            <select name="course_code" id="">
                <option value="" disabled selected>Select a course</option>
                <?php
                    $query = mysqli_query($connection, "SELECT * FROM tbl_course"); 
                    $rows = mysqli_num_rows($query);
                    if ($rows > 0) {
                        while ($data = mysqli_fetch_assoc($query)) {
                ?>
                            <option value="<?php echo $data['course_code']; ?>">
                                <?php echo $data['course_code']; ?>
                            </option>
                <?php  
                        }
                    }
                ?>
            </select>
            <br>

            <label for="year_level">Year Level:</label>
            <input type="number" name="year_level" placeholder="Year level" min="1" max="4" required> <br>

            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Password" required> <br>
            
            <input type="submit" name="" value="Insert">
            <a href="student.php" class="back-btn">Back</a>
        </form>
    </body>
</html>
