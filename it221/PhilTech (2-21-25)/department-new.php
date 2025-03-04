<?php
    include("cn.php");
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $department_code = mysqli_real_escape_string($connection, $_POST['department_code']);
        $department_name = mysqli_real_escape_string($connection, $_POST['department_name']);
        
        $check_department_code = mysqli_query($connection, "SELECT * FROM tbl_department WHERE department_code = '$department_code'");
        $rows = mysqli_num_rows($check_department_code);
        if ($rows == 1) {
            $display = "<div class='message error'>Department Code already exists.</div>";
        } else {
            $query = mysqli_query($connection, "INSERT INTO tbl_department VALUES ('$department_code', '$department_name')");
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
        <title>Add Department</title>
    </head>
    <body>
        <form action="" method="POST">
            <h1>Add New Department</h1>

            <?php
            if(isset($display)) {
                echo "<p class='message'>$display</p>";
            }
            ?>

            <label for="department_code">Department Code:</label>
            <input type="text" name="department_code" placeholder="Department code" required> <br>

            <label for="department_name">Department Name:</label>
            <input type="text" name="department_name" placeholder="Department name" required> <br>
            <input type="submit" name="" value="Insert">
            <a href="faculty_profile.php" class="back-btn">Back</a>
        </form>
    </body>
</html>