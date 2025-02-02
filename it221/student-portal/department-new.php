<?php
    include("cn.php");
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $department_code = mysqli_real_escape_string($connection, $_POST['department_code']);
        $department_name = mysqli_real_escape_string($connection, $_POST['department_name']);
        
        $check_department_code = mysqli_query($connection, "SELECT * FROM tbl_department WHERE department_code = '$department_code'");
        $rows = mysqli_num_rows($check_department_code);
        if ($rows == 1) {
            $display = "Department already exist.";
        } else {
            $query = mysqli_query($connection, "INSERT INTO tbl_department VALUES ('$department_code', '$department_name')");
            $display = "Record was saved successfully.";
        } 
    } else {
        echo "Add New Department";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Add Department</title>
    </head>
    <body>
        <?php
            if(isset($display)) {
                echo $display;
            }
        ?>
        <form action="" method="POST">
            <input type="text" name="department_code" placeholder="Department code" required> <br>
            <input type="text" name="department_name" placeholder="Department name" required> <br>
            <input type="submit" name="" value="INSERT">
        </form>
    </body>
</html>