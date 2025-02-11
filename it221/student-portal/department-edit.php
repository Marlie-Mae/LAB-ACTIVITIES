<?php
    include("cn.php");
    if (isset($_GET['department_code'])) {
        $department_code = mysqli_real_escape_string($connection, $_GET['department_code']);
        $query = mysqli_query($connection, "SELECT * FROM tbl_department WHERE department_code = '$department_code'");
        $rows = mysqli_num_rows($query);
        if ($rows > 0) {
            $data = mysqli_fetch_assoc($query);
        } else {
            echo "Department Code not found";
        }
    } else {
        header("location: department.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Edit Department</title>
    </head>
    <body>
        <form action="" method="POST">
            <label for="department_code">Department Code:</label>
            <input type="text" name="department_code" placeholder="department_code" required value="<?php if(isset($department_code)) { echo $department_code;} ?>"> <br>

            <label for="department_name">Department Name:</label>
            <input type="text" name="department_name" placeholder="Department name" required value="<?php if(isset($data['department_name'])) {echo $data["department_name"];} ?>"> <br>

            <input type="submit" name="" value="UPDATE">
        </form>
    </body>
</html>
