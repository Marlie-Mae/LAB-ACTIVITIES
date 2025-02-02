<?php
    include("cn.php");
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $faculty_code = mysqli_real_escape_string($connection, $_POST['faculty_code']);
        $faculty_name = mysqli_real_escape_string($connection, $_POST['faculty_name']);
        $department_code = mysqli_real_escape_string($connection, $_POST['department_code']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);
        $hashed_password = md5($password);

        $check_faculty = mysqli_query($connection, "SELECT * FROM tbl_faculty WHERE faculty_code = '$faculty_code'");
        $rows = mysqli_num_rows($check_faculty);
        if ($rows == 1) {
            $display = "Faculty already exist.";
        } else {
            $query = mysqli_query($connection, "INSERT INTO tbl_faculty VALUES ('$faculty_code', '$faculty_name', '$department_code', '$hashed_password')");
            $display = "Record was saved successfully.";
        } 
    } else {
        echo "Add Faculty";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Add Faculty</title>
    </head>
    <body>
        <?php
            if(isset($display)) {
                echo $display;
            }
        ?>
        <form action="" method="POST">
            <input type="text" name="faculty_code" placeholder="Faculty code" required> <br>
            <input type="text" name="faculty_name" placeholder="Faculty name" required> <br>
            <input type="text" name="department_code" placeholder="Department code" required> <br>
            <input type="password" name="password" required> <br>
            <input type="submit" name="" value="INSERT">
        </form>
    </body>
</html>